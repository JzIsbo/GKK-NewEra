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
        $bulan = (int) ($request->bulan ?: now()->month);
        $tahun = (int) ($request->tahun ?: now()->year);

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->sukses()
            ->bulanTahun($bulan, $tahun)
            ->latest('paid_at')
            ->paginate(20)
            ->withQueryString();

        $totalSemua      = Persembahan::sukses()->sum('nominal');
        $totalBulanIni   = Persembahan::sukses()->bulanTahun($bulan, $tahun)->sum('nominal');
        $jumlahTransaksi = Persembahan::sukses()->bulanTahun($bulan, $tahun)->count();

        // DB-level aggregation — tidak load semua row ke PHP memory
        $perJenis = Persembahan::rekapPerJenis($bulan, $tahun);

        return view('admin.keuangan', compact(
            'persembahans', 'totalSemua', 'totalBulanIni',
            'jumlahTransaksi', 'perJenis', 'bulan', 'tahun'
        ));
    }

    public function export(Request $request)
    {
        $bulan = (int) ($request->bulan ?: now()->month);
        $tahun = (int) ($request->tahun ?: now()->year);

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->sukses()
            ->bulanTahun($bulan, $tahun)
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
