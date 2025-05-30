<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::insert([
            [
                'nama_lengkap' => 'Ahmad Zaki',
                'email' => 'ahmad.zaki@example.com',
                'no_ktp' => '3201123456789012',
                'nip' => '198001012022011001',
                'tempat_lahir' => 'Bandung',
                'tgl_lahir' => '1980-01-01',
                'gender' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat_rumah' => 'Jl. Merdeka No. 1, Bandung',
                'no_hp' => '081234567890',
                'pas_foto' => 'zaki.jpg',
            ],
            [
                'nama_lengkap' => 'Maria Theresia',
                'email' => 'maria.theresia@example.com',
                'no_ktp' => '3201123456789013',
                'nip' => '198105012022011002',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => '1981-05-01',
                'gender' => 'Perempuan',
                'agama' => 'Katolik',
                'alamat_rumah' => 'Jl. Sudirman No. 10, Jakarta',
                'no_hp' => '081234567891',
                'pas_foto' => 'maria.jpg',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'no_ktp' => '3201123456789014',
                'nip' => '198202012022011003',
                'tempat_lahir' => 'Surabaya',
                'tgl_lahir' => '1982-02-01',
                'gender' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat_rumah' => 'Jl. Diponegoro No. 5, Surabaya',
                'no_hp' => '081234567892',
                'pas_foto' => 'budi.jpg',
            ],
            [
                'nama_lengkap' => 'Siti Aminah',
                'email' => 'siti.aminah@example.com',
                'no_ktp' => '3201123456789015',
                'nip' => '198303012022011004',
                'tempat_lahir' => 'Yogyakarta',
                'tgl_lahir' => '1983-03-01',
                'gender' => 'Perempuan',
                'agama' => 'Islam',
                'alamat_rumah' => 'Jl. Malioboro No. 7, Yogyakarta',
                'no_hp' => '081234567893',
                'pas_foto' => 'aminah.jpg',
            ],
            [
                'nama_lengkap' => 'John Doe',
                'email' => 'john.doe@example.com',
                'no_ktp' => '3201123456789016',
                'nip' => '198404012022011005',
                'tempat_lahir' => 'Medan',
                'tgl_lahir' => '1984-04-01',
                'gender' => 'Laki-laki',
                'agama' => 'Kristen',
                'alamat_rumah' => 'Jl. Asia No. 20, Medan',
                'no_hp' => '081234567894',
                'pas_foto' => 'john.jpg',
            ],
        ]);
    }
}
