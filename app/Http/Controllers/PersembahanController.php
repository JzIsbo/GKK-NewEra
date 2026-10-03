<?php

namespace App\Http\Controllers;

use App\Enums\AppRole;
use App\Models\JenisPersembahan;
use App\Models\Persembahan;
use App\Models\PengaturanApp;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PersembahanController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    public function index()
    {
        $jenisPersembahans = JenisPersembahan::where('aktif', true)->get();
        $qrisStatis        = PengaturanApp::get('qr_statis_gereja');
        $rekening          = PengaturanApp::get('rekening_gereja');
        $clientKey         = config('midtrans.client_key');
        $isProduction      = config('midtrans.is_production');

        $riwayat = null;
        if (Auth::check()) {
            $riwayat = Persembahan::where('user_id', Auth::id())
                ->with('jenisPersembahan')
                ->latest()
                ->take(10)
                ->get();
        }

        return view('persembahan.index', compact(
            'jenisPersembahans', 'qrisStatis', 'rekening',
            'clientKey', 'isProduction', 'riwayat'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_persembahan_id' => ['required', 'exists:jenis_persembahans,id'],
            'nominal'              => ['required', 'numeric', 'min:1000'],
            'nama_donatur'         => ['required_without:user_id', 'nullable', 'string', 'max:255'],
            'email_donatur'        => ['required_without:user_id', 'nullable', 'email'],
            'keterangan'           => ['nullable', 'string', 'max:500'],
        ], [
            'nominal.min' => 'Nominal minimum persembahan adalah Rp 1.000',
        ]);

        $persembahan = Persembahan::create([
            'order_id'             => Persembahan::generateOrderId(),
            'source'               => 'online',
            'user_id'              => Auth::id(),
            'nama_donatur'         => $request->nama_donatur ?: (Auth::check() ? (Auth::user()->nama_lengkap ?: Auth::user()->name) : null),
            'email_donatur'        => $request->email_donatur ?: (Auth::check() ? Auth::user()->email : null),
            'jenis_persembahan_id' => $request->jenis_persembahan_id,
            'nominal'              => $request->nominal,
            'keterangan'           => $request->keterangan,
            'status'               => 'pending',
        ]);

        try {
            $snapData = $this->midtrans->createSnapToken($persembahan);
            $persembahan->update([
                'snap_token'  => $snapData['snap_token'],
                'payment_url' => $snapData['payment_url'],
            ]);

            return response()->json([
                'success'     => true,
                'snap_token'  => $snapData['snap_token'],
                'order_id'    => $persembahan->order_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans error: ' . $e->getMessage());
            $persembahan->delete();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $data        = $this->midtrans->handleNotification();
            $persembahan = Persembahan::where('order_id', $data['order_id'])->firstOrFail();

            $persembahan->update([
                'status'                  => $data['status'],
                'metode_bayar'            => $data['payment_type'],
                'midtrans_transaction_id' => $data['midtrans_transaction_id'],
                'paid_at'                 => $data['status'] === 'success' ? now() : null,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(string $orderId)
    {
        $persembahan = Persembahan::where('order_id', $orderId)
            ->with('jenisPersembahan', 'user')
            ->firstOrFail();

        // Simpan hak akses download bukti ke session saat berhasil bayar
        session(['persembahan_order_' . $orderId => true, 'last_order_id' => $orderId]);

        return view('persembahan.success', compact('persembahan'));
    }

    public function buktiPdf(string $orderId)
    {
        $persembahan = Persembahan::where('order_id', $orderId)
            ->with('jenisPersembahan', 'user')
            ->firstOrFail();

        // Proteksi Otorisasi (Cegah IDOR):
        // Diizinkan jika:
        // 1. User login adalah donatur transaksi
        // 2. User login memiliki role super_admin / majelis / bendahara_majelis
        // 3. User memiliki session token transaksi saat ini (baru saja bayar sebagai guest)
        $isAuthorized = false;
        if (auth()->check()) {
            $user = auth()->user();
            if ($persembahan->user_id && $persembahan->user_id === $user->id) {
                $isAuthorized = true;
            } elseif ($user->hasAnyRole(AppRole::KEUANGAN)) {
                $isAuthorized = true;
            }
        }
        if (session('last_order_id') === $orderId || session('persembahan_order_' . $orderId)) {
            $isAuthorized = true;
        }

        if (!$isAuthorized && $persembahan->user_id !== null) {
            abort(403, 'Anda tidak memiliki hak untuk mengunduh bukti persembahan ini.');
        }

        // Generate QR Code via public API dengan timeout pendek (2 detik) agar tidak membekukan PDF
        $qrUrl    = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode(route('persembahan.success', $orderId));
        $qrBase64 = null;

        try {
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $qrImageData = @file_get_contents($qrUrl, false, $ctx);
            if ($qrImageData !== false) {
                $qrBase64 = base64_encode($qrImageData);
            }
        } catch (\Throwable $e) {
            // fallback: QR tidak merusak download PDF
        }

        $settings = [
            'nama_gereja'    => PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih'),
            'alamat_gereja'  => PengaturanApp::get('alamat_gereja'),
        ];

        $pdf = Pdf::loadView('persembahan.bukti-pdf', compact('persembahan', 'qrBase64', 'settings'));
        $pdf->setPaper('a5', 'portrait');

        return $pdf->download('bukti-persembahan-' . $orderId . '.pdf');
    }

    public function riwayat()
    {
        $persembahans = Persembahan::where('user_id', Auth::id())
            ->with('jenisPersembahan')
            ->latest()
            ->paginate(15);

        return view('jemaat.riwayat-persembahan', compact('persembahans'));
    }

    public function downloadQris()
    {
        $qrisStatis = PengaturanApp::get('qr_statis_gereja');
        if ($qrisStatis && file_exists(storage_path('app/public/' . $qrisStatis))) {
            $filePath = storage_path('app/public/' . $qrisStatis);
        } elseif ($qrisStatis && file_exists(public_path('storage/' . $qrisStatis))) {
            $filePath = public_path('storage/' . $qrisStatis);
        } else {
            $filePath = public_path('images/qris-persembahan.png');
        }

        if (!file_exists($filePath)) {
            abort(404, 'File barcode QRIS tidak ditemukan.');
        }

        return response()->download($filePath, 'QRIS-Persembahan-GEMINDO.png', [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-cache, private',
        ]);
    }
}
