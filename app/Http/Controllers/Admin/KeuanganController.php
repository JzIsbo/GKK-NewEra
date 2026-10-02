<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persembahan;
use App\Models\PengaturanApp;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?: now()->month;
        $tahun = $request->tahun ?: now()->year;

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->latest('paid_at')
            ->paginate(20)
            ->withQueryString();

        $totalSemua = Persembahan::where('status', 'success')->sum('nominal');
        $totalBulanIni = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->sum('nominal');
        $jumlahTransaksi = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->count();

        $perJenis = Persembahan::with('jenisPersembahan')
            ->where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->get()
            ->groupBy('jenis_persembahan_id')
            ->map(fn($g) => [
                'nama'  => $g->first()->jenisPersembahan->nama ?? '-',
                'total' => $g->sum('nominal'),
                'count' => $g->count(),
            ]);

        return view('admin.keuangan', compact(
            'persembahans', 'totalSemua', 'totalBulanIni',
            'jumlahTransaksi', 'perJenis', 'bulan', 'tahun'
        ));
    }

    public function export(Request $request)
    {
        $bulan = $request->bulan ?: now()->month;
        $tahun = $request->tahun ?: now()->year;

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->latest('paid_at')
            ->get();

        $totalBulanIni = $persembahans->sum('nominal');
        $namaGereja    = PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih');

        $pdf = Pdf::loadView('majelis.laporan-pdf', compact(
            'persembahans', 'totalBulanIni', 'namaGereja', 'bulan', 'tahun'
        ));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("laporan-keuangan-{$tahun}-{$bulan}.pdf");
    }
}
