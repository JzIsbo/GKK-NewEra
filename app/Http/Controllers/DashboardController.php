<?php

namespace App\Http\Controllers;

use App\Models\Persembahan;
use App\Models\PendaftaranJemaat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('majelis')) {
            return $this->majelisDashboard();
        } elseif ($user->hasRole('sekretaris_majelis')) {
            return $this->sekretarisDashboard();
        } elseif ($user->hasRole('bendahara_majelis')) {
            return $this->bendaharaDashboard();
        } elseif ($user->hasAnyRole([
            'pengurus_kategorial_kpb',
            'pengurus_kategorial_kpw',
            'pengurus_kategorial_kpp',
            'pengurus_kategorial_kpr',
            'pengurus_kategorial_kpa',
            'pengurus_kategorial', // legacy role fallback
        ])) {
            return $this->pengurusDashboard();
        } else {
            return $this->jemaatDashboard();
        }
    }

    private function jemaatDashboard()
    {
        $user               = Auth::user();
        $riwayatPersembahan = Persembahan::where('user_id', $user->id)->latest()->take(5)->get();
        $totalPersembahan   = Persembahan::where('user_id', $user->id)->where('status', 'success')->sum('nominal');

        return view('dashboard.jemaat', compact('user', 'riwayatPersembahan', 'totalPersembahan'));
    }

    private function sekretarisDashboard()
    {
        $pendingPendaftaran = PendaftaranJemaat::where('status', 'pending')->count();
        $totalJemaat        = User::role('jemaat')->count();
        $recentPendaftaran  = PendaftaranJemaat::latest()->take(5)->get();

        return view('dashboard.sekretaris', compact(
            'pendingPendaftaran', 'totalJemaat', 'recentPendaftaran'
        ));
    }

    private function bendaharaDashboard()
    {
        $totalPersembahan    = Persembahan::where('status', 'success')->sum('nominal');
        $persembahanBulanIni = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('nominal');
        $persembahanBulanLalu = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->whereYear('paid_at', now()->subMonth()->year)
            ->sum('nominal');
        $recentPersembahan   = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->latest('paid_at')
            ->take(10)
            ->get();

        return view('dashboard.bendahara', compact(
            'totalPersembahan', 'persembahanBulanIni', 'persembahanBulanLalu', 'recentPersembahan'
        ));
    }

    private function majelisDashboard()
    {
        $pendingPendaftaran = PendaftaranJemaat::where('status', 'pending')->count();
        $totalJemaat        = User::role('jemaat')->count();
        $totalPersembahan   = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->sum('nominal');
        $recentPersembahan  = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->latest('paid_at')
            ->take(10)
            ->get();

        return view('dashboard.majelis', compact(
            'pendingPendaftaran', 'totalJemaat', 'totalPersembahan', 'recentPersembahan'
        ));
    }

    private function pengurusDashboard()
    {
        $user     = Auth::user();
        $kategori = $user->kategori;

        return view('dashboard.pengurus', compact('user', 'kategori'));
    }

    private function adminDashboard()
    {
        $totalJemaat         = User::role('jemaat')->count();
        $totalPersembahan    = Persembahan::where('status', 'success')->sum('nominal');
        $pendingPendaftaran  = PendaftaranJemaat::where('status', 'pending')->count();
        $persembahanBulanIni = Persembahan::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('nominal');
        $recentPersembahan   = Persembahan::with('jenisPersembahan', 'user')
            ->where('status', 'success')
            ->latest('paid_at')
            ->take(10)
            ->get();
        $recentPendaftaran   = PendaftaranJemaat::latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalJemaat', 'totalPersembahan', 'pendingPendaftaran',
            'persembahanBulanIni', 'recentPersembahan', 'recentPendaftaran'
        ));
    }
}

