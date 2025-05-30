<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use Carbon\Carbon; // Untuk manipulasi tanggal

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::insert([
            [
                'nama' => 'Ahmad Fauzi',
                'kelas_id' => 1,
                'guru_id' => 1,
                'gender' => 'L',
                'agama' => 'Islam',
                'tgl_lahir' => Carbon::parse('2008-05-12'),
                'alamat' => 'Jl. Merdeka No.1',
                'wali' => 'Bapak Fauzi',
                'no_hp_wali' => '081234567890',
            ],
            [
                'nama' => 'Siti Aminah',
                'kelas_id' => 2,
                'guru_id' => 2,
                'gender' => 'P',
                'agama' => 'Islam',
                'tgl_lahir' => Carbon::parse('2009-03-15'),
                'alamat' => 'Jl. Pahlawan No.2',
                'wali' => 'Ibu Aminah',
                'no_hp_wali' => '081234567891',
            ],
            [
                'nama' => 'Budi Santoso',
                'kelas_id' => 1,
                'guru_id' => 3,
                'gender' => 'L',
                'agama' => 'Kristen',
                'tgl_lahir' => Carbon::parse('2008-11-20'),
                'alamat' => 'Jl. Sudirman No.3',
                'wali' => 'Bapak Santoso',
                'no_hp_wali' => '081234567892',
            ],
            [
                'nama' => 'Ayu Lestari',
                'kelas_id' => 3,
                'guru_id' => 1,
                'gender' => 'P',
                'agama' => 'Hindu',
                'tgl_lahir' => Carbon::parse('2009-07-25'),
                'alamat' => 'Jl. Gajah Mada No.4',
                'wali' => 'Ibu Lestari',
                'no_hp_wali' => '081234567893',
            ],
            [
                'nama' => 'Indra Wijaya',
                'kelas_id' => 2,
                'guru_id' => 2,
                'gender' => 'L',
                'agama' => 'Islam',
                'tgl_lahir' => Carbon::parse('2008-10-10'),
                'alamat' => 'Jl. Diponegoro No.5',
                'wali' => 'Bapak Wijaya',
                'no_hp_wali' => '081234567894',
            ],
            [
                'nama' => 'Dewi Kusuma',
                'kelas_id' => 3,
                'guru_id' => 3,
                'gender' => 'P',
                'agama' => 'Buddha',
                'tgl_lahir' => Carbon::parse('2009-01-18'),
                'alamat' => 'Jl. Ahmad Yani No.6',
                'wali' => 'Ibu Kusuma',
                'no_hp_wali' => '081234567895',
            ],
            [
                'nama' => 'Rian Pratama',
                'kelas_id' => 1,
                'guru_id' => 1,
                'gender' => 'L',
                'agama' => 'Islam',
                'tgl_lahir' => Carbon::parse('2008-12-05'),
                'alamat' => 'Jl. Sutomo No.7',
                'wali' => 'Bapak Pratama',
                'no_hp_wali' => '081234567896',
            ],
            [
                'nama' => 'Lina Permata',
                'kelas_id' => 2,
                'guru_id' => 2,
                'gender' => 'P',
                'agama' => 'Kristen',
                'tgl_lahir' => Carbon::parse('2009-04-14'),
                'alamat' => 'Jl. Adisucipto No.8',
                'wali' => 'Ibu Permata',
                'no_hp_wali' => '081234567897',
            ],
            [
                'nama' => 'Andi Saputra',
                'kelas_id' => 3,
                'guru_id' => 3,
                'gender' => 'L',
                'agama' => 'Islam',
                'tgl_lahir' => Carbon::parse('2008-09-09'),
                'alamat' => 'Jl. Yos Sudarso No.9',
                'wali' => 'Bapak Saputra',
                'no_hp_wali' => '081234567898',
            ],
            [
                'nama' => 'Rosa Amalia',
                'kelas_id' => 1,
                'guru_id' => 1,
                'gender' => 'P',
                'agama' => 'Katolik',
                'tgl_lahir' => Carbon::parse('2009-06-11'),
                'alamat' => 'Jl. Imam Bonjol No.10',
                'wali' => 'Ibu Amalia',
                'no_hp_wali' => '081234567899',
            ],
        ]);
    }
}
