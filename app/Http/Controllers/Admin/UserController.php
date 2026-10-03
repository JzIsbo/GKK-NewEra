<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranJemaat;
use App\Models\User;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private readonly PendaftaranService $pendaftaranService) {}
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

        // Jumlah user yang sudah di-soft delete (untuk info admin)
        $trashedCount = User::onlyTrashed()->count();

        return view('admin.users.index', compact('users', 'roles', 'trashedCount'));
    }

    public function create()
    {
        $roles     = Role::all();
        $kategoris = \App\Models\Kategori::where('aktif', true)->get();
        return view('admin.users.create', compact('roles', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'       => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email', 'unique:users,email'],
            'password'           => ['required', 'string', 'min:8'],
            'no_telepon'         => ['nullable', 'string', 'max:20'],
            'status_keanggotaan' => ['required', 'in:pending,aktif,non-aktif'],
            'role'               => ['required', 'exists:roles,name'],
            'kategori_id'        => ['nullable', 'exists:kategoris,id'],
        ]);

        $userData = $request->except('role', 'password', '_token');
        $userData['password'] = Hash::make($request->password);
        $userData['nomor_jemaat'] = User::generateNomorJemaat();
        $userData['name'] = $request->nama_lengkap;

        $user = User::create($userData);
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$user->nama_display} berhasil ditambahkan dengan Nomor Jemaat: {$user->nomor_jemaat}.");
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
            'kategori_id'        => ['nullable', 'exists:kategoris,id'],
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

        // SoftDeletes: $user->delete() hanya set deleted_at, data tidak hilang.
        // User yang di-soft-delete tidak bisa login (getAuthPassword() return '').
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->nama_display} berhasil dinonaktifkan. Data masih tersimpan dan dapat dipulihkan.");
    }

    /**
     * Pulihkan user yang sudah di-soft delete.
     */
    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->nama_display} berhasil dipulihkan.");
    }

    // Approval pendaftaran jemaat
    public function pendaftaranIndex()
    {
        $pendaftarans = PendaftaranJemaat::latest()->paginate(15);
        return view('admin.users.pendaftaran', compact('pendaftarans'));
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
}
