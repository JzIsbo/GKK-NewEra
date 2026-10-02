<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\JenisPersembahan;
use App\Models\JadwalIbadah;
use App\Models\PengaturanApp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\AppRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles — Role granular ada di RolesAndPermissionsSeeder.
        $roles = [AppRole::SUPER_ADMIN, AppRole::MAJELIS, AppRole::JEMAAT];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Permissions — termasuk yang dibutuhkan RolesAndPermissionsSeeder
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-settings',
            'manage-konten',
            'approve-pendaftaran',
            'view-laporan-keuangan',
            'export-laporan',
            'manage-jadwal',
            'manage-pengumuman',
            'manage-kategorial',
            'manage-kegiatan',
            'bayar-persembahan',
            'view-all-persembahan',
            // Permissions untuk role granular (RolesAndPermissionsSeeder)
            'manage-kehadiran',
            'view-kehadiran',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Assign permissions ke roles
        $superAdmin = Role::findByName(AppRole::SUPER_ADMIN);
        $superAdmin->givePermissionTo(Permission::all());

        $majelis = Role::findByName(AppRole::MAJELIS);
        $majelis->givePermissionTo([
            'approve-pendaftaran',
            'view-laporan-keuangan',
            'export-laporan',
            'manage-jadwal',
            'manage-pengumuman',
            'manage-kategorial',
            'manage-kegiatan',
            'bayar-persembahan',
            'view-all-persembahan',
        ]);

        // Role legacy 'pengurus_kategorial' TIDAK diberi permission di sini.
        // Permission untuk pengurus kategorial dikelola di RolesAndPermissionsSeeder
        // melalui role granular: kpb, kpw, kpp, kpr, kpa.

        $jemaatRole = Role::findByName('jemaat');
        $jemaatRole->givePermissionTo(['bayar-persembahan']);

        // Buat Super Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@gemindokawankasih.or.id'],
            [
                'name'              => 'Super Admin',
                'nama_lengkap'      => 'Super Administrator',
                'password'          => Hash::make('Admin@12345'),
                'status_keanggotaan'=> 'aktif',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super_admin');

        // Buat user contoh majelis
        $majelisUser = User::updateOrCreate(
            ['email' => 'majelis@gemindokawankasih.or.id'],
            [
                'name'              => 'Majelis Gereja',
                'nama_lengkap'      => 'Bpk. Majelis Gereja',
                'password'          => Hash::make('Majelis@12345'),
                'status_keanggotaan'=> 'aktif',
                'email_verified_at' => now(),
            ]
        );
        $majelisUser->assignRole('majelis');

        // Buat Kategori KPK
        $kategoris = [
            ['nama' => 'Pemuda', 'singkatan' => 'KPK Pemuda'],
            ['nama' => 'Perempuan', 'singkatan' => 'KPK Perempuan'],
            ['nama' => 'Pria/Bapak', 'singkatan' => 'KPK Pria'],
            ['nama' => 'Usia Lanjut', 'singkatan' => 'KPK Usia Lanjut'],
            ['nama' => 'Anak', 'singkatan' => 'Sekolah Minggu'],
            ['nama' => 'Remaja', 'singkatan' => 'KPK Remaja'],
        ];
        foreach ($kategoris as $kat) {
            \App\Models\Kategori::firstOrCreate(['nama' => $kat['nama']], $kat);
        }

        // Buat Jenis Persembahan
        $jenisPersembahans = [
            ['nama' => 'Persembahan Umum', 'deskripsi' => 'Persembahan reguler setiap ibadah'],
            ['nama' => 'Perpuluhan', 'deskripsi' => 'Persembahan perpuluhan (10%) dari penghasilan'],
            ['nama' => 'Pembangunan', 'deskripsi' => 'Persembahan untuk pembangunan dan renovasi gedung gereja'],
            ['nama' => 'Diakonia', 'deskripsi' => 'Persembahan kasih untuk membantu sesama yang membutuhkan'],
            ['nama' => 'Misi', 'deskripsi' => 'Persembahan untuk mendukung pelayanan misi'],
            ['nama' => 'Persembahan Khusus', 'deskripsi' => 'Persembahan untuk kegiatan khusus gereja'],
        ];
        foreach ($jenisPersembahans as $jp) {
            \App\Models\JenisPersembahan::firstOrCreate(['nama' => $jp['nama']], $jp);
        }

        // Buat Jadwal Ibadah
        $jadwals = [
            ['nama' => 'Ibadah Minggu', 'hari' => 'Minggu', 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00', 'lokasi' => 'Gedung Utama', 'jenis' => 'reguler'],
            ['nama' => 'Ibadah Pemuda', 'hari' => 'Sabtu', 'waktu_mulai' => '17:00', 'waktu_selesai' => '19:00', 'lokasi' => 'Aula Gereja', 'jenis' => 'reguler'],
            ['nama' => 'Ibadah Hari Rabu', 'hari' => 'Rabu', 'waktu_mulai' => '18:30', 'waktu_selesai' => '20:00', 'lokasi' => 'Gedung Utama', 'jenis' => 'reguler'],
            ['nama' => 'Sekolah Minggu', 'hari' => 'Minggu', 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00', 'lokasi' => 'Ruang Anak', 'jenis' => 'reguler'],
        ];
        foreach ($jadwals as $jadwal) {
            \App\Models\JadwalIbadah::firstOrCreate(['nama' => $jadwal['nama']], $jadwal);
        }

        // Buat Pengaturan App
        $settings = [
            ['key' => 'nama_gereja', 'value' => 'GEMINDO Kawan Kasih', 'label' => 'Nama Gereja'],
            ['key' => 'alamat_gereja', 'value' => 'Jl. Contoh No. 1, Kota, Provinsi', 'label' => 'Alamat Gereja'],
            ['key' => 'telepon_gereja', 'value' => '+62 21 XXXXXXXX', 'label' => 'Telepon Gereja'],
            ['key' => 'email_gereja', 'value' => 'info@gemindokawankasih.or.id', 'label' => 'Email Gereja'],
            ['key' => 'nama_pendeta', 'value' => 'Pdt. [Nama Pendeta]', 'label' => 'Nama Pendeta'],
            ['key' => 'qr_statis_gereja', 'value' => null, 'label' => 'QR QRIS Statis Gereja', 'tipe' => 'json'],
            ['key' => 'rekening_gereja', 'value' => 'BCA 1234567890 a.n GEMINDO Kawan Kasih', 'label' => 'No. Rekening'],
            ['key' => 'facebook_url', 'value' => '#', 'label' => 'Facebook URL'],
            ['key' => 'instagram_url', 'value' => '#', 'label' => 'Instagram URL'],
            ['key' => 'youtube_url', 'value' => '#', 'label' => 'YouTube URL'],
            ['key' => 'tentang_gereja', 'value' => 'GEMINDO Kawan Kasih adalah jemaat Kristen yang berdiri untuk melayani Tuhan dan masyarakat sekitar dengan penuh kasih.', 'label' => 'Tentang Gereja'],
        ];
        foreach ($settings as $setting) {
            \App\Models\PengaturanApp::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // Call KeluargaSeeder
        $this->call(KeluargaSeeder::class);

        // Call RolesAndPermissionsSeeder
        $this->call(RolesAndPermissionsSeeder::class);

        // Call DummyDataSeeder for menus that lack data
        $this->call(DummyDataSeeder::class);
    }
}
