<?php

namespace App\Http\Controllers;

use App\Models\JadwalIbadah;
use App\Models\PendaftaranJemaat;
use App\Models\Persembahan;
use App\Models\User;
use App\Services\PendaftaranService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MajelisController extends Controller
{
    public function __construct(private readonly PendaftaranService $pendaftaranService) {}
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
        $result = $this->pendaftaranService->approve($pendaftaran);

        return back()->with('success',
            "Pendaftaran disetujui. Nomor jemaat: {$result['user']->nomor_jemaat}. Password sementara: {$result['password']}"
        );
    }

    public function pendaftaranReject(Request $request, PendaftaranJemaat $pendaftaran)
    {
        $this->pendaftaranService->reject($pendaftaran, $request->catatan);

        return back()->with('info', 'Pendaftaran telah ditolak.');
    }

    public function laporan(Request $request)
    {
        $bulan = (int) ($request->bulan ?: now()->month);
        $tahun = (int) ($request->tahun ?: now()->year);

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->sukses()
            ->bulanTahun($bulan, $tahun)
            ->latest('paid_at')
            ->paginate(20)
            ->withQueryString();

        $totalPerJenis = Persembahan::rekapPerJenis($bulan, $tahun);
        $totalBulanIni = Persembahan::sukses()->bulanTahun($bulan, $tahun)->sum('nominal');

        return view('majelis.laporan', compact('persembahans', 'totalPerJenis', 'totalBulanIni', 'bulan', 'tahun'));
    }

    public function exportLaporan(Request $request)
    {
        $bulan = (int) ($request->bulan ?: now()->month);
        $tahun = (int) ($request->tahun ?: now()->year);

        $persembahans = Persembahan::with('jenisPersembahan', 'user')
            ->sukses()
            ->bulanTahun($bulan, $tahun)
            ->latest('paid_at')
            ->get();

        $totalBulanIni = $persembahans->sum('nominal');
        $namaGereja    = \App\Models\PengaturanApp::get('nama_gereja', 'GEMINDO Kawan Kasih');

        $pdf = Pdf::loadView('majelis.laporan-pdf', compact('persembahans', 'totalBulanIni', 'namaGereja', 'bulan', 'tahun'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("laporan-persembahan-{$tahun}-{$bulan}.pdf");
    }
}
