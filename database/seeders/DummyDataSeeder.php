<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ══════════════════════════════════════════════════
        // 1. PENGUMUMAN (Warta Jemaat)
        // Enum tipe: 'umum', 'penting', 'kegiatan'
        // ══════════════════════════════════════════════════
        DB::table('pengumuman')->delete();
        $pengumumanData = [
            [
                'judul'          => 'Ibadah Syukur & Perjamuan Kudus Awal Bulan',
                'isi'            => 'Diberitahukan kepada seluruh jemaat GEMINDO Kawan Kasih bahwa Ibadah Perjamuan Kudus akan dilaksanakan pada hari Minggu pertama bulan ini pukul 08.00 WIB. Seluruh jemaat diundang hadir dalam hadirat Tuhan dengan mempersiapkan hati dan pikiran yang kudus.',
                'gambar'         => null,
                'tipe'           => 'penting',
                'tanggal_mulai'  => $now->copy()->subDays(2)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(14)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 1,
                'created_at'     => $now->copy()->subDays(2),
                'updated_at'     => $now->copy()->subDays(2),
            ],
            [
                'judul'          => 'Retreat Pemuda & Remaja 2026: "Rooted in Christ"',
                'isi'            => 'Pendaftaran Retreat Pemuda & Remaja (KPK & KPR) dengan tema "Rooted in Christ, Shining in Love" resmi dibuka. Acara akan berlangsung di Wisma Kinasih, Bogor. Segera daftarkan diri Anda melalui pengurus komisi pemuda sebelum kuota terpenuhi.',
                'gambar'         => null,
                'tipe'           => 'kegiatan',
                'tanggal_mulai'  => $now->copy()->subDays(1)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(30)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 2,
                'created_at'     => $now->copy()->subDays(1),
                'updated_at'     => $now->copy()->subDays(1),
            ],
            [
                'judul'          => 'Aksi Sosial & Diakonia Kasih Peduli Sesama',
                'isi'            => 'Komisi Diakonia mengundang partisipasi jemaat dalam pengumpulan paket sembako dan pakaian layak pakai untuk panti asuhan serta warga sekitar yang membutuhkan. Bantuan dapat diserahkan ke posko diakonia di lobi gereja.',
                'gambar'         => null,
                'tipe'           => 'kegiatan',
                'tanggal_mulai'  => $now->copy()->subDays(3)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(20)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 2,
                'created_at'     => $now->copy()->subDays(3),
                'updated_at'     => $now->copy()->subDays(3),
            ],
            [
                'judul'          => 'Latihan Rutin Paduan Suara & Tim Musik Gereja',
                'isi'            => 'Latihan rutin tim Paduan Suara (Choir) dan Tim Musik Ibadah diadakan setiap hari Sabtu pukul 18.30 WIB di Ruang Musik Gereja. Bagi jemaat yang memiliki kerinduan melayani di bidang musik dan vokal dipersilakan bergabung.',
                'gambar'         => null,
                'tipe'           => 'umum',
                'tanggal_mulai'  => $now->copy()->subDays(5)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(60)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 2,
                'created_at'     => $now->copy()->subDays(5),
                'updated_at'     => $now->copy()->subDays(5),
            ],
            [
                'judul'          => 'Pembukaan Kelas Katekisasi Sidi Baru Periode 2026',
                'isi'            => 'Pendaftaran kelas Katekisasi Sidi bagi remaja dan dewasa yang rindu mengaku iman secara mandiri telah dibuka. Kelas dimulai hari Minggu kedua pukul 10.30 WIB. Formulir dapat diambil di sekretariat majelis gereja.',
                'gambar'         => null,
                'tipe'           => 'penting',
                'tanggal_mulai'  => $now->copy()->subDays(7)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(25)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 1,
                'created_at'     => $now->copy()->subDays(7),
                'updated_at'     => $now->copy()->subDays(7),
            ],
            [
                'judul'          => 'Layanan Konseling Pastoral & Pokok Doa Jemaat',
                'isi'            => 'Majelis Jemaat menyediakan ruang pelayanan doa bersama dan konseling pastoral secara privat bagi jemaat yang memerlukan bimbingan rohani. Silakan menghubungi Pendeta Jemaat atau nomor hotline sekretariat.',
                'gambar'         => null,
                'tipe'           => 'umum',
                'tanggal_mulai'  => $now->copy()->subDays(10)->format('Y-m-d'),
                'tanggal_selesai'=> $now->copy()->addDays(90)->format('Y-m-d'),
                'aktif'          => 1,
                'user_id'        => 2,
                'created_at'     => $now->copy()->subDays(10),
                'updated_at'     => $now->copy()->subDays(10),
            ],
        ];
        foreach ($pengumumanData as $row) {
            DB::table('pengumuman')->insert($row);
        }

        // ══════════════════════════════════════════════════
        // 2. KEGIATANS (Acara & Agenda Gereja)
        // ══════════════════════════════════════════════════
        DB::table('kegiatans')->delete();
        $kegiatanData = [
            [
                'nama'            => 'Seminar Keluarga Kristen: "Keluarga yang Berakar di Dalam Kasih"',
                'deskripsi'       => 'Seminar interaktif bagi pasangan suami-istri dan keluarga jemaat untuk membangun komunikasi yang harmonis, saling melayani, dan mewariskan nilai-nilai iman kepada generasi berikutnya.',
                'gambar'          => null,
                'lokasi'          => 'Auditorium Utama GEMINDO Kawan Kasih',
                'tanggal_mulai'   => $now->copy()->addDays(7)->setTime(9, 0, 0),
                'tanggal_selesai' => $now->copy()->addDays(7)->setTime(13, 0, 0),
                'kategori_id'     => 3, // Pria/Bapak
                'user_id'         => 1,
                'aktif'           => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'nama'            => 'Festival & Bazaar Ceria Sekolah Minggu',
                'deskripsi'       => 'Pesta iman anak-anak Sekolah Minggu berupa lomba mewarnai ayat hafalan, panggung boneka, games ketangkasan, dan stand bazaar karya kreatif anak.',
                'lokasi'          => 'Halaman Serbaguna GEMINDO',
                'tanggal_mulai'   => $now->copy()->addDays(14)->setTime(10, 0, 0),
                'tanggal_selesai' => $now->copy()->addDays(14)->setTime(14, 0, 0),
                'kategori_id'     => 5, // Anak
                'user_id'         => 2,
                'aktif'           => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'nama'            => 'Malam Pujian & Penyembahan Pemuda: "One Heart, One Praise"',
                'deskripsi'       => 'Malam kebangunan rohani komunal pemuda dan remaja yang diisi dengan pujian penyembahan, firman Tuhan, dan keakraban antar persekutuan jemaat.',
                'lokasi'          => 'Ruang Pemuda (Lantai 2)',
                'tanggal_mulai'   => $now->copy()->addDays(21)->setTime(18, 0, 0),
                'tanggal_selesai' => $now->copy()->addDays(21)->setTime(21, 0, 0),
                'kategori_id'     => 1, // Pemuda
                'user_id'         => 2,
                'aktif'           => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'nama'            => 'Pemeriksaan Kesehatan Gratis & Aksi Donor Darah Kasih',
                'deskripsi'       => 'Bakti sosial kesehatan cuma-cuma (cek gula darah, kolesterol, asam urat, tensi, dan konsultasi dokter) bekerja sama dengan PMI untuk jemaat dan warga sekitar.',
                'lokasi'          => 'Gedung Serbaguna GEMINDO',
                'tanggal_mulai'   => $now->copy()->addDays(28)->setTime(8, 30, 0),
                'tanggal_selesai' => $now->copy()->addDays(28)->setTime(12, 30, 0),
                'kategori_id'     => 4, // Usia Lanjut
                'user_id'         => 1,
                'aktif'           => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'nama'            => 'Persekutuan Doa Fajar Pagi: "Mencari Wajah Tuhan"',
                'deskripsi'       => 'Ibadah doa fajar bersama untuk mendoakan pergumulan jemaat, keluarga, pemulihan bangsa, dan kegerakan misi gereja.',
                'lokasi'          => 'Ruang Doa GEMINDO Kawan Kasih',
                'tanggal_mulai'   => $now->copy()->addDays(4)->setTime(5, 30, 0),
                'tanggal_selesai' => $now->copy()->addDays(4)->setTime(7, 0, 0),
                'kategori_id'     => 2, // Perempuan
                'user_id'         => 2,
                'aktif'           => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ];
        foreach ($kegiatanData as $row) {
            DB::table('kegiatans')->insert($row);
        }

        // ══════════════════════════════════════════════════
        // 3. PERSEMBAHANS (Riwayat Keuangan & Donasi)
        // Enum status: 'pending', 'success', 'failed', 'expired', 'cancel'
        // ══════════════════════════════════════════════════
        DB::table('persembahans')->delete();
        $persembahanData = [
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-001',
                'user_id'               => 7, // Julius Wisnu
                'nama_donatur'          => 'Julius Wisnu',
                'email_donatur'         => 'julius.wisnu@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 2, // Perpuluhan
                'nominal'               => 1500000,
                'metode_bayar'          => 'qris',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-1',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-001',
                'paid_at'               => $now->copy()->subDays(1)->setTime(10, 15, 0),
                'keterangan'            => 'Perpuluhan bulan ini, Soli Deo Gloria.',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(1),
                'updated_at'            => $now->copy()->subDays(1),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-002',
                'user_id'               => 7, // Julius Wisnu
                'nama_donatur'          => 'Julius Wisnu',
                'email_donatur'         => 'julius.wisnu@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 1, // Persembahan Umum
                'nominal'               => 200000,
                'metode_bayar'          => 'bca_va',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-2',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-002',
                'paid_at'               => $now->copy()->subDays(3)->setTime(8, 45, 0),
                'keterangan'            => 'Persembahan ibadah minggu',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(3),
                'updated_at'            => $now->copy()->subDays(3),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-003',
                'user_id'               => 3, // Anita Malonda
                'nama_donatur'          => 'Anita Malonda',
                'email_donatur'         => 'anita.malonda@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 3, // Pembangunan
                'nominal'               => 1000000,
                'metode_bayar'          => 'bank_transfer',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-3',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-003',
                'paid_at'               => $now->copy()->subDays(5)->setTime(14, 20, 0),
                'keterangan'            => 'Bantuan dana renovasi ruang ibadah anak',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(5),
                'updated_at'            => $now->copy()->subDays(5),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-004',
                'user_id'               => 4, // Maria Malonda
                'nama_donatur'          => 'Maria Malonda',
                'email_donatur'         => 'maria.malonda@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 4, // Diakonia
                'nominal'               => 500000,
                'metode_bayar'          => 'qris',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-4',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-004',
                'paid_at'               => $now->copy()->subDays(6)->setTime(9, 30, 0),
                'keterangan'            => 'Persembahan diakonia peduli sesama',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(6),
                'updated_at'            => $now->copy()->subDays(6),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-005',
                'user_id'               => 8, // Sartika Wisnu
                'nama_donatur'          => 'Sartika Wisnu',
                'email_donatur'         => 'sartika.wisnu@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 5, // Misi
                'nominal'               => 300000,
                'metode_bayar'          => 'qris',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-5',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-005',
                'paid_at'               => $now->copy()->subDays(8)->setTime(11, 0, 0),
                'keterangan'            => 'Dukungan dana misi pedalaman',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(8),
                'updated_at'            => $now->copy()->subDays(8),
            ],
            [
                'order_id'              => 'OFFLINE-GKK-' . $now->format('Ymd') . '-006',
                'user_id'               => null,
                'nama_donatur'          => 'Kotak Persembahan Ibadah Minggu',
                'email_donatur'         => null,
                'jenis_persembahan_id'  => 1, // Persembahan Umum
                'nominal'               => 2850000,
                'metode_bayar'          => 'tunai',
                'status'                => 'success',
                'snap_token'            => null,
                'payment_url'           => null,
                'midtrans_transaction_id'=> null,
                'paid_at'               => $now->copy()->subDays(7)->setTime(9, 30, 0),
                'keterangan'            => 'Pundi kantong persembahan ibadah minggu pagi',
                'source'                => 'offline',
                'created_at'            => $now->copy()->subDays(7),
                'updated_at'            => $now->copy()->subDays(7),
            ],
            [
                'order_id'              => 'OFFLINE-GKK-' . $now->format('Ymd') . '-007',
                'user_id'               => null,
                'nama_donatur'          => 'Persembahan Persekutuan Pemuda',
                'email_donatur'         => null,
                'jenis_persembahan_id'  => 1, // Persembahan Umum
                'nominal'               => 450000,
                'metode_bayar'          => 'tunai',
                'status'                => 'success',
                'snap_token'            => null,
                'payment_url'           => null,
                'midtrans_transaction_id'=> null,
                'paid_at'               => $now->copy()->subDays(6)->setTime(18, 45, 0),
                'keterangan'            => 'Kolekte ibadah pemuda sabtu sore',
                'source'                => 'offline',
                'created_at'            => $now->copy()->subDays(6),
                'updated_at'            => $now->copy()->subDays(6),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-008',
                'user_id'               => 10, // Yohanes Siregar
                'nama_donatur'          => 'Yohanes Siregar',
                'email_donatur'         => 'yohanes.siregar@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 6, // Persembahan Khusus
                'nominal'               => 750000,
                'metode_bayar'          => 'bca_va',
                'status'                => 'success',
                'snap_token'            => 'dummy-snap-token-8',
                'payment_url'           => null,
                'midtrans_transaction_id'=> 'midtrans-tx-008',
                'paid_at'               => $now->copy()->subDays(10)->setTime(15, 10, 0),
                'keterangan'            => 'Syukur ulang tahun pernikahan',
                'source'                => 'online',
                'created_at'            => $now->copy()->subDays(10),
                'updated_at'            => $now->copy()->subDays(10),
            ],
            [
                'order_id'              => 'ORDER-GKK-' . $now->format('Ymd') . '-009',
                'user_id'               => 7, // Julius Wisnu
                'nama_donatur'          => 'Julius Wisnu',
                'email_donatur'         => 'julius.wisnu@gemindokawankasih.or.id',
                'jenis_persembahan_id'  => 4, // Diakonia
                'nominal'               => 250000,
                'metode_bayar'          => 'qris',
                'status'                => 'pending',
                'snap_token'            => 'dummy-snap-token-9',
                'payment_url'           => null,
                'midtrans_transaction_id'=> null,
                'paid_at'               => null,
                'keterangan'            => 'Menunggu pembayaran QRIS',
                'source'                => 'online',
                'created_at'            => $now->copy()->subHours(2),
                'updated_at'            => $now->copy()->subHours(2),
            ],
        ];
        foreach ($persembahanData as $row) {
            DB::table('persembahans')->insert($row);
        }

        // ══════════════════════════════════════════════════
        // 4. PENDAFTARAN JEMAATS (Validasi Anggota Baru)
        // Enum status: 'pending', 'disetujui', 'ditolak'
        // ══════════════════════════════════════════════════
        DB::table('pendaftaran_jemaats')->delete();
        $pendaftaranData = [
            [
                'nama_lengkap'      => 'David Christian Simanjuntak',
                'email'             => 'david.simanjuntak@gmail.com',
                'no_telepon'        => '081289123456',
                'tanggal_lahir'     => '1996-04-12',
                'tempat_lahir'      => 'Medan',
                'jenis_kelamin'     => 'laki-laki',
                'alamat'            => 'Jl. Anggrek Cendrawasih No. 18, RT 05 / RW 03, Kemanggisan, Jakarta Barat',
                'asal_gereja'       => 'HKBP Medan Kota',
                'pekerjaan'         => 'Software Engineer',
                'alasan_bergabung'  => 'Pindah domisili kerja ke Jakarta dan rindu memiliki komunitas jemaat lokal untuk bertumbuh.',
                'status'            => 'pending',
                'catatan_admin'     => null,
                'approved_by'       => null,
                'approved_at'       => null,
                'user_id'           => null,
                'created_at'        => $now->copy()->subDays(1),
                'updated_at'        => $now->copy()->subDays(1),
            ],
            [
                'nama_lengkap'      => 'Priscillia Nathania Wijaya',
                'email'             => 'priscillia.wijaya@gmail.com',
                'no_telepon'        => '081377889900',
                'tanggal_lahir'     => '2000-09-24',
                'tempat_lahir'      => 'Surabaya',
                'jenis_kelamin'     => 'perempuan',
                'alamat'            => 'Apartemen Central Park Tower 2 Unit 12B, Jakarta Barat',
                'asal_gereja'       => 'GKI Pregolan Bunder Surabaya',
                'pekerjaan'         => 'Graphic Designer',
                'alasan_bergabung'  => 'Rindu melayani di komisi pemuda dan paduan suara GEMINDO Kawan Kasih.',
                'status'            => 'pending',
                'catatan_admin'     => null,
                'approved_by'       => null,
                'approved_at'       => null,
                'user_id'           => null,
                'created_at'        => $now->copy()->subDays(2),
                'updated_at'        => $now->copy()->subDays(2),
            ],
            [
                'nama_lengkap'      => 'Samuel Hendra Kurniawan',
                'email'             => 'samuel.hendra@gmail.com',
                'no_telepon'        => '085211223344',
                'tanggal_lahir'     => '1992-11-05',
                'tempat_lahir'      => 'Bandung',
                'jenis_kelamin'     => 'laki-laki',
                'alamat'            => 'Jl. Surya Kencana No. 5, Kebon Jeruk, Jakarta Barat',
                'asal_gereja'       => 'Gereja Kristen Protestan Indonesia',
                'pekerjaan'         => 'Akuntan Publik',
                'alasan_bergabung'  => 'Sudah beribadah rutin selama 6 bulan dan ingin menjadi anggota resmi jemaat.',
                'status'            => 'disetujui',
                'catatan_admin'     => 'Berkas surat baptis dan sidi lengkap. Disetujui majelis.',
                'approved_by'       => 1,
                'approved_at'       => $now->copy()->subDays(5),
                'user_id'           => 11,
                'created_at'        => $now->copy()->subDays(7),
                'updated_at'        => $now->copy()->subDays(5),
            ],
            [
                'nama_lengkap'      => 'Budi Hartono Santoso',
                'email'             => 'budi.test@example.com',
                'no_telepon'        => '081900001122',
                'tanggal_lahir'     => '1988-02-14',
                'tempat_lahir'      => 'Semarang',
                'jenis_kelamin'     => 'laki-laki',
                'alamat'            => 'Jl. Mangga Besar No. 99, Jakarta Barat',
                'asal_gereja'       => 'Non-denominasi',
                'pekerjaan'         => 'Wiraswasta',
                'alasan_bergabung'  => 'Mencari gereja terdekat',
                'status'            => 'ditolak',
                'catatan_admin'     => 'Data KTP tidak terlampir dan nomor telepon tidak dapat dihubungi. Silakan melakukan pendaftaran ulang dengan data valid.',
                'approved_by'       => 2,
                'approved_at'       => $now->copy()->subDays(6),
                'user_id'           => null,
                'created_at'        => $now->copy()->subDays(8),
                'updated_at'        => $now->copy()->subDays(6),
            ],
        ];
        foreach ($pendaftaranData as $row) {
            DB::table('pendaftaran_jemaats')->insert($row);
        }

        // ══════════════════════════════════════════════════
        // 5. KEHADIRAN IBADAHS (Presensi Ibadah Terkini)
        // ══════════════════════════════════════════════════
        $kehadiranData = [
            [
                'jadwal_ibadah_id' => 1, // Ibadah Minggu
                'tanggal'          => $now->copy()->subDays(7)->format('Y-m-d'),
                'jumlah_pria'      => 48,
                'jumlah_wanita'    => 65,
                'jumlah_anak'      => 24,
                'keterangan'       => 'Ibadah Minggu Pagi Minggu Lalu. Ibadah berjalan khidmat.',
                'created_at'       => $now->copy()->subDays(7),
                'updated_at'       => $now->copy()->subDays(7),
            ],
            [
                'jadwal_ibadah_id' => 2, // Ibadah Pemuda
                'tanggal'          => $now->copy()->subDays(6)->format('Y-m-d'),
                'jumlah_pria'      => 18,
                'jumlah_wanita'    => 22,
                'jumlah_anak'      => 0,
                'keterangan'       => 'Ibadah Pemuda Sabtu sore.',
                'created_at'       => $now->copy()->subDays(6),
                'updated_at'       => $now->copy()->subDays(6),
            ],
            [
                'jadwal_ibadah_id' => 4, // Sekolah Minggu
                'tanggal'          => $now->copy()->subDays(7)->format('Y-m-d'),
                'jumlah_pria'      => 14,
                'jumlah_wanita'    => 16,
                'jumlah_anak'      => 30,
                'keterangan'       => 'Sekolah Minggu tema: Kasih Tuhan Yesus.',
                'created_at'       => $now->copy()->subDays(7),
                'updated_at'       => $now->copy()->subDays(7),
            ],
            [
                'jadwal_ibadah_id' => 6, // Persekutuan Perempuan (KPW)
                'tanggal'          => $now->copy()->subDays(2)->format('Y-m-d'),
                'jumlah_pria'      => 0,
                'jumlah_wanita'    => 32,
                'jumlah_anak'      => 4,
                'keterangan'       => 'Ibadah KPW Kamis sore.',
                'created_at'       => $now->copy()->subDays(2),
                'updated_at'       => $now->copy()->subDays(2),
            ],
        ];
        foreach ($kehadiranData as $row) {
            DB::table('kehadiran_ibadahs')->insert($row);
        }
    }
}
