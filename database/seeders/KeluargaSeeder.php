<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $families = [
            [
                'no_kk' => '3171012345670001',
                'nama_keluarga' => 'Keluarga Bpk. Anita Malonda',
                'alamat' => 'Jl. Kasih No. 12, Jakarta Timur',
                'no_telepon' => '081234567890',
                'members' => [
                    [
                        'name' => 'Anita Malonda',
                        'nama_lengkap' => 'Pdt. Anita Malonda',
                        'email' => 'anita.malonda@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1978-04-12',
                        'tempat_lahir' => 'Manado',
                        'pekerjaan' => 'Pendeta',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Maria Malonda',
                        'nama_lengkap' => 'Ibu Maria Malonda',
                        'email' => 'maria.malonda@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1982-08-15',
                        'tempat_lahir' => 'Tomohon',
                        'pekerjaan' => 'Ibu Rumah Tangga',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Gabriel Malonda',
                        'nama_lengkap' => 'Gabriel Malonda',
                        'email' => 'gabriel.malonda@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2005-10-20',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Mahasiswa',
                        'hubungan_keluarga' => 'Anak',
                    ],
                    [
                        'name' => 'Hanna Malonda',
                        'nama_lengkap' => 'Hanna Malonda',
                        'email' => 'hanna.malonda@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2010-12-05',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670002',
                'nama_keluarga' => 'Keluarga Bpk. Julius Wisnu',
                'alamat' => 'Jl. Damai No. 8, Jakarta Selatan',
                'no_telepon' => '081345678901',
                'members' => [
                    [
                        'name' => 'Julius Wisnu',
                        'nama_lengkap' => 'Bpk. Julius Wisnu',
                        'email' => 'julius.wisnu@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1980-05-18',
                        'tempat_lahir' => 'Solo',
                        'pekerjaan' => 'Karyawan Swasta',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Sartika Wisnu',
                        'nama_lengkap' => 'Ibu Sartika Wisnu',
                        'email' => 'sartika.wisnu@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1983-11-22',
                        'tempat_lahir' => 'Yogyakarta',
                        'pekerjaan' => 'Guru',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Andreas Wisnu',
                        'nama_lengkap' => 'Andreas Wisnu',
                        'email' => 'andreas.wisnu@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2008-03-14',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670003',
                'nama_keluarga' => 'Keluarga Bpk. Yohanes Siregar',
                'alamat' => 'Jl. Kebenaran No. 45, Jakarta Utara',
                'no_telepon' => '081456789012',
                'members' => [
                    [
                        'name' => 'Yohanes Siregar',
                        'nama_lengkap' => 'Bpk. Yohanes Siregar',
                        'email' => 'yohanes.siregar@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1975-01-25',
                        'tempat_lahir' => 'Medan',
                        'pekerjaan' => 'PNS',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Elisabeth Siregar',
                        'nama_lengkap' => 'Ibu Elisabeth Siregar',
                        'email' => 'elisabeth.siregar@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1978-06-30',
                        'tempat_lahir' => 'Tarutung',
                        'pekerjaan' => 'Dosen',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Samuel Siregar',
                        'nama_lengkap' => 'Samuel Siregar',
                        'email' => 'samuel.siregar@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2004-09-12',
                        'tempat_lahir' => 'Medan',
                        'pekerjaan' => 'Mahasiswa',
                        'hubungan_keluarga' => 'Anak',
                    ],
                    [
                        'name' => 'Sarah Siregar',
                        'nama_lengkap' => 'Sarah Siregar',
                        'email' => 'sarah.siregar@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2007-02-18',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670004',
                'nama_keluarga' => 'Keluarga Bpk. David Pardede',
                'alamat' => 'Jl. Sukacita No. 3, Jakarta Pusat',
                'no_telepon' => '081567890123',
                'members' => [
                    [
                        'name' => 'David Pardede',
                        'nama_lengkap' => 'Bpk. David Pardede',
                        'email' => 'david.pardede@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1985-09-08',
                        'tempat_lahir' => 'Balige',
                        'pekerjaan' => 'Wiraswasta',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Christina Pardede',
                        'nama_lengkap' => 'Ibu Christina Pardede',
                        'email' => 'christina.pardede@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1988-02-12',
                        'tempat_lahir' => 'Sibolga',
                        'pekerjaan' => 'Bidan',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Jonathan Pardede',
                        'nama_lengkap' => 'Jonathan Pardede',
                        'email' => 'jonathan.pardede@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2015-05-22',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670005',
                'nama_keluarga' => 'Keluarga Bpk. Markus Manurung',
                'alamat' => 'Jl. Harapan No. 101, Bekasi',
                'no_telepon' => '081678901234',
                'members' => [
                    [
                        'name' => 'Markus Manurung',
                        'nama_lengkap' => 'Bpk. Markus Manurung',
                        'email' => 'markus.manurung@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1972-11-30',
                        'tempat_lahir' => 'Pematangsiantar',
                        'pekerjaan' => 'Kontraktor',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Ruth Manurung',
                        'nama_lengkap' => 'Ibu Ruth Manurung',
                        'email' => 'ruth.manurung@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1976-05-14',
                        'tempat_lahir' => 'Medan',
                        'pekerjaan' => 'Ibu Rumah Tangga',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Daniel Manurung',
                        'nama_lengkap' => 'Daniel Manurung',
                        'email' => 'daniel.manurung@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2000-01-10',
                        'tempat_lahir' => 'Medan',
                        'pekerjaan' => 'Karyawan Swasta',
                        'hubungan_keluarga' => 'Anak',
                    ],
                    [
                        'name' => 'Debora Manurung',
                        'nama_lengkap' => 'Debora Manurung',
                        'email' => 'debora.manurung@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2003-08-25',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Mahasiswa',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670006',
                'nama_keluarga' => 'Keluarga Bpk. Petrus Ginting',
                'alamat' => 'Jl. Rukun No. 19, Depok',
                'no_telepon' => '081789012345',
                'members' => [
                    [
                        'name' => 'Petrus Ginting',
                        'nama_lengkap' => 'Bpk. Petrus Ginting',
                        'email' => 'petrus.ginting@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1982-03-03',
                        'tempat_lahir' => 'Kabanjahe',
                        'pekerjaan' => 'Arsitek',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Martha Ginting',
                        'nama_lengkap' => 'Ibu Martha Ginting',
                        'email' => 'martha.ginting@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1985-07-07',
                        'tempat_lahir' => 'Berastagi',
                        'pekerjaan' => 'Desainer',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Timothy Ginting',
                        'nama_lengkap' => 'Timothy Ginting',
                        'email' => 'timothy.ginting@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2012-11-11',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670007',
                'nama_keluarga' => 'Keluarga Bpk. Stefanus Sitorus',
                'alamat' => 'Jl. Setia No. 5, Tangerang',
                'no_telepon' => '081890123456',
                'members' => [
                    [
                        'name' => 'Stefanus Sitorus',
                        'nama_lengkap' => 'Bpk. Stefanus Sitorus',
                        'email' => 'stefanus.sitorus@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1970-07-20',
                        'tempat_lahir' => 'Porsea',
                        'pekerjaan' => 'Dokter',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Naomi Sitorus',
                        'nama_lengkap' => 'Ibu Naomi Sitorus',
                        'email' => 'naomi.sitorus@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1974-12-25',
                        'tempat_lahir' => 'Laguboti',
                        'pekerjaan' => 'Apoteker',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Rachel Sitorus',
                        'nama_lengkap' => 'Rachel Sitorus',
                        'email' => 'rachel.sitorus@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2001-04-16',
                        'tempat_lahir' => 'Medan',
                        'pekerjaan' => 'Mahasiswa',
                        'hubungan_keluarga' => 'Anak',
                    ],
                    [
                        'name' => 'Rebekah Sitorus',
                        'nama_lengkap' => 'Rebekah Sitorus',
                        'email' => 'rebekah.sitorus@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2004-11-02',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Mahasiswa',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670008',
                'nama_keluarga' => 'Keluarga Bpk. Lukas Simanjuntak',
                'alamat' => 'Jl. Damai Sejahtera No. 7, Jakarta Barat',
                'no_telepon' => '081901234567',
                'members' => [
                    [
                        'name' => 'Lukas Simanjuntak',
                        'nama_lengkap' => 'Bpk. Lukas Simanjuntak',
                        'email' => 'lukas.simanjuntak@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1988-10-10',
                        'tempat_lahir' => 'Samosir',
                        'pekerjaan' => 'Karyawan BUMN',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Tabita Simanjuntak',
                        'nama_lengkap' => 'Ibu Tabita Simanjuntak',
                        'email' => 'tabita.simanjuntak@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1991-03-03',
                        'tempat_lahir' => 'Tarutung',
                        'pekerjaan' => 'Perawat',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Paul Simanjuntak',
                        'nama_lengkap' => 'Paul Simanjuntak',
                        'email' => 'paul.simanjuntak@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2018-07-19',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Belum Sekolah',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670009',
                'nama_keluarga' => 'Keluarga Bpk. Matius Wibowo',
                'alamat' => 'Jl. Kasih Sayang No. 22, Tangerang Selatan',
                'no_telepon' => '081912345678',
                'members' => [
                    [
                        'name' => 'Matius Wibowo',
                        'nama_lengkap' => 'Bpk. Matius Wibowo',
                        'email' => 'matius.wibowo@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1977-12-12',
                        'tempat_lahir' => 'Semarang',
                        'pekerjaan' => 'Guru',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Lydia Wibowo',
                        'nama_lengkap' => 'Ibu Lydia Wibowo',
                        'email' => 'lydia.wibowo@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1980-04-04',
                        'tempat_lahir' => 'Surakarta',
                        'pekerjaan' => 'Ibu Rumah Tangga',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Philip Wibowo',
                        'nama_lengkap' => 'Philip Wibowo',
                        'email' => 'philip.wibowo@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2006-08-08',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                    [
                        'name' => 'Phoebe Wibowo',
                        'nama_lengkap' => 'Phoebe Wibowo',
                        'email' => 'phoebe.wibowo@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '2009-09-09',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ],
            [
                'no_kk' => '3171012345670010',
                'nama_keluarga' => 'Keluarga Bpk. Yohanes Christian',
                'alamat' => 'Jl. Immanuel No. 1, Jakarta Utara',
                'no_telepon' => '081923456789',
                'members' => [
                    [
                        'name' => 'Yohanes Christian',
                        'nama_lengkap' => 'Bpk. Yohanes Christian',
                        'email' => 'yohanes.christian@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '1981-06-06',
                        'tempat_lahir' => 'Ambon',
                        'pekerjaan' => 'Pemrogram',
                        'hubungan_keluarga' => 'Kepala Keluarga',
                    ],
                    [
                        'name' => 'Lois Christian',
                        'nama_lengkap' => 'Ibu Lois Christian',
                        'email' => 'lois.christian@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'perempuan',
                        'tanggal_lahir' => '1984-07-07',
                        'tempat_lahir' => 'Saparua',
                        'pekerjaan' => 'Penulis',
                        'hubungan_keluarga' => 'Istri',
                    ],
                    [
                        'name' => 'Silas Christian',
                        'nama_lengkap' => 'Silas Christian',
                        'email' => 'silas.christian@gemindokawankasih.or.id',
                        'jenis_kelamin' => 'laki-laki',
                        'tanggal_lahir' => '2011-08-08',
                        'tempat_lahir' => 'Jakarta',
                        'pekerjaan' => 'Pelajar',
                        'hubungan_keluarga' => 'Anak',
                    ],
                ]
            ]
        ];

        foreach ($families as $famData) {
            $keluarga = Keluarga::firstOrCreate(
                ['no_kk' => $famData['no_kk']],
                [
                    'nama_keluarga' => $famData['nama_keluarga'],
                    'alamat' => $famData['alamat'],
                    'no_telepon' => $famData['no_telepon'],
                ]
            );

            foreach ($famData['members'] as $member) {
                $user = User::where('email', $member['email'])->first();
                if (!$user) {
                    // Generate nomor jemaat otomatis
                    $nomorJemaat = User::generateNomorJemaat();

                    $user = User::create([
                        'name' => $member['name'],
                        'nama_lengkap' => $member['nama_lengkap'],
                        'email' => $member['email'],
                        'password' => Hash::make('Jemaat@12345'),
                        'jenis_kelamin' => $member['jenis_kelamin'],
                        'tanggal_lahir' => $member['tanggal_lahir'],
                        'tempat_lahir' => $member['tempat_lahir'],
                        'alamat' => $famData['alamat'],
                        'no_telepon' => $famData['no_telepon'],
                        'pekerjaan' => $member['pekerjaan'],
                        'nomor_jemaat' => $nomorJemaat,
                        'status_keanggotaan' => 'aktif',
                        'email_verified_at' => now(),
                        'approved_at' => now(),
                        'keluarga_id' => $keluarga->id,
                        'hubungan_keluarga' => $member['hubungan_keluarga'],
                    ]);

                    $user->assignRole('jemaat');
                }
            }
        }
    }
}
