<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class JemaatDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluarga::with(['anggota']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_keluarga', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function($aq) use ($search) {
                      $aq->where('name', 'like', "%{$search}%")
                         ->orWhere('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        $keluargas = $query->orderBy('nama_keluarga')->paginate(8)->withQueryString();

        return view('jemaat.data-jemaat', compact('keluargas'));
    }
}
