<?php

namespace App\Http\Controllers;

use App\Models\JadwalIbadah;
use App\Models\PendaftaranJemaat;
use App\Models\Persembahan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MajelisController extends Controller
{
    public function pendaftaranIndex(Request $request)
    {
        $query = PendaftaranJemaat::latest();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $pendaftarans = $query->paginate(15)->withQueryString();
        return view('majelis.pendaftaran', compact('pendaftarans'));
    }

    public function pendaftaranApprove(PendaftaranJemaat $pendaftaran)
    {
        // Delegasi ke UserController admin
        return app(\App\Http\Controllers\Admin\UserController::class)->pendaftaranApprove($pendaftaran);
    }

    public function pendaftaranReject(Request $request, PendaftaranJemaat $pendaftaran)
    {
        return app(\App\Http\Controllers\Admin\UserController::class)->pendaftaranReject($request, $pendaftaran);
    }

    public function laporan(Request $request)
    {
        $bulan  = $request->bulan ?: now()->month;
        $tahun  = $request->tahun ?: now()->year;

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->latest('paid_at')
            ->paginate(20)
            ->withQueryString();

        $totalPerJenis = Persembahan::with('jenisPersembahan')
            ->where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->get()
            ->groupBy('jenis_persembahan_id')
            ->map(fn($g) => ['nama' => $g->first()->jenisPersembahan->nama ?? '-', 'total' => $g->sum('nominal')]);

        $totalBulanIni = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', $bulan)
            ->whereYear('paid_at', $tahun)
            ->sum('nominal');

        return view('majelis.laporan', compact('persembahans', 'totalPerJenis', 'totalBulanIni', 'bulan', 'tahun'));
    }

    public function exportLaporan(Request $request)
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
        $namaGereja    = \App\Models\PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih');

        $pdf = Pdf::loadView('majelis.laporan-pdf', compact('persembahans', 'totalBulanIni', 'namaGereja', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("laporan-persembahan-{$tahun}-{$bulan}.pdf");
    }
}
