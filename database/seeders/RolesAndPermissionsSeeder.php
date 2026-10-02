<?php

namespace Database\Seeders;

use App\Enums\AppRole;
use App\Models\Kategori;
use App\Models\JadwalIbadah;
use App\Models\KehadiranIbadah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Roles Baru
        $roles = [
            AppRole::SEKRETARIS_MAJELIS,
            AppRole::BENDAHARA_MAJELIS,
            ...AppRole::KATEGORIAL,
        ];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // 2. Buat Permissions Baru
        Permission::firstOrCreate(['name' => 'manage-kehadiran', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view-kehadiran', 'guard_name' => 'web']);

        // 3. Assign Permissions ke Roles Baru
        $sekretaris = Role::findByName(AppRole::SEKRETARIS_MAJELIS);
        $sekretaris->syncPermissions([
            'approve-pendaftaran',
            'manage-jadwal',
            'manage-pengumuman',
            'manage-kegiatan',
            'manage-kehadiran',
            'view-kehadiran',
            'view-all-persembahan'
        ]);

        $bendahara = Role::findByName(AppRole::BENDAHARA_MAJELIS);
        $bendahara->syncPermissions([
            'view-laporan-keuangan',
            'export-laporan',
            'view-all-persembahan'
        ]);

        foreach (AppRole::KATEGORIAL as $kr) {
            $r = Role::findByName($kr);
            $r->syncPermissions([
                'manage-pengumuman',
                'manage-kegiatan',
                'manage-kehadiran',
                'view-kehadiran',
            ]);
        }

        // Tambah permissions kehadiran ke super_admin dan majelis
        $superAdmin = Role::findByName(AppRole::SUPER_ADMIN);
        $superAdmin->givePermissionTo(['manage-kehadiran', 'view-kehadiran']);

        $majelis = Role::findByName(AppRole::MAJELIS);
        $majelis->givePermissionTo(['manage-kehadiran', 'view-kehadiran']);

        // 4. Hubungkan Jadwal Ibadah dengan Kategori KPK
        $kategoriPemuda = Kategori::where('nama', 'Pemuda')->first();
        $kategoriAnak = Kategori::where('nama', 'Anak')->first();
        $kategoriBapak = Kategori::where('nama', 'Pria/Bapak')->first();
        $kategoriPerempuan = Kategori::where('nama', 'Perempuan')->first();
        $kategoriRemaja = Kategori::where('nama', 'Remaja')->first();

        // Update jadwal yang sudah ada
        JadwalIbadah::where('nama', 'Ibadah Pemuda')->update(['kategori_id' => $kategoriPemuda?->id, 'jenis' => 'kategorial']);
        JadwalIbadah::where('nama', 'Sekolah Minggu')->update(['kategori_id' => $kategoriAnak?->id, 'jenis' => 'kategorial']);

        // Buat jadwal baru untuk kategori lainnya jika belum ada
        if ($kategoriBapak) {
            JadwalIbadah::firstOrCreate(
                ['nama' => 'Persekutuan Pria/Bapak (KPB)'],
                [
                    'jenis' => 'kategorial',
                    'hari' => 'Jumat',
                    'waktu_mulai' => '19:00',
                    'waktu_selesai' => '20:30',
                    'lokasi' => 'Aula Gereja',
                    'aktif' => true,
                    'kategori_id' => $kategoriBapak->id
                ]
            );
        }

        if ($kategoriPerempuan) {
            JadwalIbadah::firstOrCreate(
                ['nama' => 'Persekutuan Perempuan (KPW)'],
                [
                    'jenis' => 'kategorial',
                    'hari' => 'Kamis',
                    'waktu_mulai' => '16:00',
                    'waktu_selesai' => '17:30',
                    'lokasi' => 'Gedung Utama',
                    'aktif' => true,
                    'kategori_id' => $kategoriPerempuan->id
                ]
            );
        }

        if ($kategoriRemaja) {
            JadwalIbadah::firstOrCreate(
                ['nama' => 'Persekutuan Remaja (KPR)'],
                [
                    'jenis' => 'kategorial',
                    'hari' => 'Sabtu',
                    'waktu_mulai' => '15:00',
                    'waktu_selesai' => '16:30',
                    'lokasi' => 'Ruang Remaja',
                    'aktif' => true,
                    'kategori_id' => $kategoriRemaja->id
                ]
            );
        }

        // 5. Buat User Dummy untuk Masing-masing Role Baru
        $dummyUsers = [
            [
                'name' => 'Sekretaris Majelis',
                'nama_lengkap' => 'Pnt. Sekretaris Majelis',
                'email' => 'sekretaris@gemindokawankasih.or.id',
                'role' => AppRole::SEKRETARIS_MAJELIS,
            ],
            [
                'name' => 'Bendahara Majelis',
                'nama_lengkap' => 'Pnt. Bendahara Majelis',
                'email' => 'bendahara@gemindokawankasih.or.id',
                'role' => AppRole::BENDAHARA_MAJELIS,
            ],
            [
                'name' => 'Pengurus KPB',
                'nama_lengkap' => 'Bpk. Pengurus KPB (Bapak)',
                'email' => 'pengurus.kpb@gemindokawankasih.or.id',
                'role' => AppRole::PENGURUS_KPB,
                'kategori_id' => $kategoriBapak?->id
            ],
            [
                'name' => 'Pengurus KPW',
                'nama_lengkap' => 'Ibu Pengurus KPW (Perempuan)',
                'email' => 'pengurus.kpw@gemindokawankasih.or.id',
                'role' => AppRole::PENGURUS_KPW,
                'kategori_id' => $kategoriPerempuan?->id
            ],
            [
                'name' => 'Pengurus KPP',
                'nama_lengkap' => 'Sdr. Pengurus KPP (Pemuda)',
                'email' => 'pengurus.kpp@gemindokawankasih.or.id',
                'role' => AppRole::PENGURUS_KPP,
                'kategori_id' => $kategoriPemuda?->id
            ],
            [
                'name' => 'Pengurus KPR',
                'nama_lengkap' => 'Sdr. Pengurus KPR (Remaja)',
                'email' => 'pengurus.kpr@gemindokawankasih.or.id',
                'role' => AppRole::PENGURUS_KPR,
                'kategori_id' => $kategoriRemaja?->id
            ],
            [
                'name' => 'Pengurus KPA',
                'nama_lengkap' => 'Kak Pengurus KPA (Sekolah Minggu)',
                'email' => 'pengurus.kpa@gemindokawankasih.or.id',
                'role' => AppRole::PENGURUS_KPA,
                'kategori_id' => $kategoriAnak?->id
            ],
        ];

        foreach ($dummyUsers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'nama_lengkap' => $data['nama_lengkap'],
                    'email' => $data['email'],
                    'password' => Hash::make('Secret@12345'),
                    'status_keanggotaan' => 'aktif',
                    'email_verified_at' => now(),
                    'approved_at' => now(),
                    'kategori_id' => $data['kategori_id'] ?? null
                ]
            );

            // Sync role saja agar tidak duplikat
            $user->syncRoles([$data['role']]);
        }

        // 6. Buat Data Dummy Kehadiran Ibadah
        $schedules = JadwalIbadah::all();
        foreach ($schedules as $sched) {
            // Seed 3 tanggal kehadiran terakhir
            for ($i = 0; $i < 3; $i++) {
                $daysAgo = ($i + 1) * 7;
                $date = now()->subDays($daysAgo)->format('Y-m-d');
                
                // Random count based on type
                if ($sched->kategori_id == $kategoriPemuda?->id) {
                    $pria = rand(15, 30);
                    $wanita = rand(20, 35);
                    $anak = 0;
                } elseif ($sched->kategori_id == $kategoriAnak?->id) {
                    $pria = rand(5, 10); // pembina
                    $wanita = rand(5, 10);
                    $anak = rand(40, 70);
                } else {
                    $pria = rand(20, 50);
                    $wanita = rand(25, 60);
                    $anak = rand(5, 20);
                }

                KehadiranIbadah::firstOrCreate(
                    [
                        'jadwal_ibadah_id' => $sched->id,
                        'tanggal' => $date,
                    ],
                    [
                        'jumlah_pria' => $pria,
                        'jumlah_wanita' => $wanita,
                        'jumlah_anak' => $anak,
                        'keterangan' => 'Ibadah berjalan dengan hikmat dan lancar.',
                    ]
                );
            }
        }
    }
}
