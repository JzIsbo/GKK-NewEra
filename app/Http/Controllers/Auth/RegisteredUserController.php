<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $kategoris = Kategori::where('aktif', true)->get();
        return view('auth.register', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telepon'    => ['required', 'string', 'max:20'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'jenis_kelamin' => ['nullable', 'in:laki-laki,perempuan'],
            'alamat'        => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name'               => $request->nama_lengkap,
            'nama_lengkap'       => $request->nama_lengkap,
            'email'              => $request->email,
            'no_telepon'         => $request->no_telepon,
            'jenis_kelamin'      => $request->jenis_kelamin,
            'alamat'             => $request->alamat,
            'password'           => Hash::make($request->password),
            'status_keanggotaan' => 'aktif', // langsung aktif saat register mandiri
        ]);

        $user->assignRole('jemaat');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
