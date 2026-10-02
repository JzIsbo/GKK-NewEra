<?php

// Serverless initialization for Vercel
// Create ephemeral storage directories inside /tmp since Vercel Lambda filesystem is read-only
$directories = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Fallback SQLite initialization in /tmp if using SQLite and database file does not exist
$dbConnection = getenv('DB_CONNECTION') ?: 'sqlite';
if ($dbConnection === 'sqlite') {
    $dbPath = getenv('DB_DATABASE') ?: '/tmp/database.sqlite';
    if (!file_exists($dbPath) && str_starts_with($dbPath, '/tmp/')) {
        touch($dbPath);
    }
}

// Forward request to Laravel public front controller
require __DIR__ . '/../public/index.php';
