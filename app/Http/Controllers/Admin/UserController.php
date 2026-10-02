<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranJemaat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('nomor_jemaat', 'like', "%{$request->search}%");
            });
        }

        if ($request->role) {
            $query->role($request->role);
        }

        if ($request->status) {
            $query->where('status_keanggotaan', $request->status);
        }

        $users = $query->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show(User $user)
    {
        $user->load('roles', 'kategori', 'persembahans.jenisPersembahan');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles     = Role::all();
        $kategoris = \App\Models\Kategori::where('aktif', true)->get();
        return view('admin.users.edit', compact('user', 'roles', 'kategoris'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap'       => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email', 'unique:users,email,' . $user->id],
            'no_telepon'         => ['nullable', 'string', 'max:20'],
            'status_keanggotaan' => ['required', 'in:pending,aktif,non-aktif'],
            'role'               => ['required', 'exists:roles,name'],
        ]);

        $user->update($request->except('role', 'password', '_token', '_method'));

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('super_admin')) {
            return back()->with('error', 'Super Admin tidak dapat dihapus.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // Approval pendaftaran jemaat
    public function pendaftaranIndex()
    {
        $pendaftarans = PendaftaranJemaat::latest()->paginate(15);
        return view('admin.users.pendaftaran', compact('pendaftarans'));
    }

    public function pendaftaranApprove(PendaftaranJemaat $pendaftaran)
    {
        // Buat akun user baru
        $password = \Illuminate\Support\Str::random(10);
        $user = User::create([
            'name'               => $pendaftaran->nama_lengkap,
            'nama_lengkap'       => $pendaftaran->nama_lengkap,
            'email'              => $pendaftaran->email,
            'no_telepon'         => $pendaftaran->no_telepon,
            'tanggal_lahir'      => $pendaftaran->tanggal_lahir,
            'tempat_lahir'       => $pendaftaran->tempat_lahir,
            'jenis_kelamin'      => $pendaftaran->jenis_kelamin,
            'alamat'             => $pendaftaran->alamat,
            'pekerjaan'          => $pendaftaran->pekerjaan,
            'password'           => Hash::make($password),
            'status_keanggotaan' => 'aktif',
            'nomor_jemaat'       => User::generateNomorJemaat(),
            'approved_at'        => now(),
            'email_verified_at'  => now(),
        ]);
        $user->assignRole('jemaat');

        $pendaftaran->update([
            'status'      => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // TODO: Kirim email dengan password ke jemaat baru

        return back()->with('success', "Pendaftaran disetujui. Nomor jemaat: {$user->nomor_jemaat}. Password sementara: {$password}");
    }

    public function pendaftaranReject(Request $request, PendaftaranJemaat $pendaftaran)
    {
        $pendaftaran->update([
            'status'         => 'ditolak',
            'catatan_admin'  => $request->catatan,
            'approved_by'    => auth()->id(),
            'approved_at'    => now(),
        ]);

        return back()->with('info', 'Pendaftaran telah ditolak.');
    }
}
