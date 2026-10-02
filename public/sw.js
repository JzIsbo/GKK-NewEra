const CACHE_NAME = 'gemindo-kk-v2';
const OFFLINE_URL = '/offline';

// Assets to cache immediately on install
const PRECACHE_ASSETS = [
    '/',
    '/login',
    '/manifest.json',
    '/favicon.ico',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/images/logo-gemindo.png',
];

// Install: cache core assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return Promise.allSettled(
                PRECACHE_ASSETS.map(url =>
                    cache.add(url).catch(e => console.warn('Pre-cache failed:', url, e))
                )
            );
        }).then(() => self.skipWaiting())
    );
});

// Activate: clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
            )
        ).then(() => self.clients.claim())
    );
});

// Fetch: Network-first for navigation, stale-while-revalidate for assets
self.addEventListener('fetch', event => {
    // Skip non-GET, browser-extension, and Midtrans/payment requests
    if (event.request.method !== 'GET') return;
    if (!event.request.url.startsWith(self.location.origin)) return;

    const url = new URL(event.request.url);

    // Skip API/webhook/admin paths from caching
    const skipPaths = ['/webhook', '/persembahan/callback', '/logout', '/admin/keuangan/export', '/majelis/laporan/export'];
    if (skipPaths.some(p => url.pathname.startsWith(p))) return;

    // For HTML navigation requests: Network-first with offline fallback
    if (event.request.headers.get('accept')?.includes('text/html')) {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Cache successful HTML responses
                    if (response.ok) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                    }
                    return response;
                })
                .catch(() => {
                    // Return cached version if available, else show offline page
                    return caches.match(event.request)
                        .then(cached => cached || caches.match('/login'));
                })
        );
        return;
    }

    // For static assets (images, icons, fonts): Cache-first
    if (
        url.pathname.startsWith('/icons/') ||
        url.pathname.startsWith('/images/') ||
        url.pathname.endsWith('.png') ||
        url.pathname.endsWith('.ico') ||
        url.pathname.endsWith('.json')
    ) {
        event.respondWith(
            caches.match(event.request).then(cached => {
                const networkFetch = fetch(event.request).then(response => {
                    if (response.ok) {
                        caches.open(CACHE_NAME).then(cache => cache.put(event.request, response.clone()));
                    }
                    return response;
                }).catch(() => cached);
                return cached || networkFetch;
            })
        );
        return;
    }
});
