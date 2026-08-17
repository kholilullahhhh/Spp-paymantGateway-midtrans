<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\SppPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membuat siswa contoh untuk testing. Setiap siswa terhubung ke kelas dan
     * plan SPP (referensi plan bulan Januari 2026).
     */
    public function run(): void
    {
        $kelasX = Classes::where('name', 'X RPL')->firstOrFail();
        $kelasXI = Classes::where('name', 'XI TKJ')->firstOrFail();
        $kelasXII = Classes::where('name', 'XII MM')->firstOrFail();

        $planJanuari = SppPlan::where('year', '2026')->where('bulan', 1)->firstOrFail();

        $students = [
            ['name' => 'Ahmad Fauzan', 'username' => 'ahmad', 'nisn' => '0022010001', 'nis' => '202601', 'kelas' => $kelasX],
            ['name' => 'Budi Santoso', 'username' => 'budi', 'nisn' => '0022010002', 'nis' => '202602', 'kelas' => $kelasX],
            ['name' => 'Citra Ayu', 'username' => 'citra', 'nisn' => '0022010003', 'nis' => '202603', 'kelas' => $kelasX],
            ['name' => 'Dedi Kurniawan', 'username' => 'dedi', 'nisn' => '0022010004', 'nis' => '202604', 'kelas' => $kelasXI],
            ['name' => 'Eka Pratiwi', 'username' => 'eka', 'nisn' => '0022010005', 'nis' => '202605', 'kelas' => $kelasXI],
            ['name' => 'Fajar Ramadhan', 'username' => 'fajar', 'nisn' => '0022010006', 'nis' => '202606', 'kelas' => $kelasXI],
            ['name' => 'Gita Puspita', 'username' => 'gita', 'nisn' => '0022010007', 'nis' => '202607', 'kelas' => $kelasXII],
            ['name' => 'Hari Wibowo', 'username' => 'hari', 'nisn' => '0022010008', 'nis' => '202608', 'kelas' => $kelasXII],
        ];

        foreach ($students as $s) {
            User::updateOrCreate(
                ['nisn' => $s['nisn']],
                [
                    'name' => $s['name'],
                    'username' => $s['username'],
                    'password' => bcrypt('123456'),
                    'nisn' => $s['nisn'],
                    'nis' => $s['nis'],
                    'role' => 'siswa',
                    'class_id' => $s['kelas']->id,
                    'spp_id' => $planJanuari->id,
                ]
            );
        }
    }
}
