<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Kelas::insert([
            [
                'nm_kelas' => 'Kelas 1A',
                'siswa_id' => 1,
                'ruangan' => 'Ruangan 101',
            ],
            [
                'nm_kelas' => 'Kelas 1B',
                'siswa_id' => 2,
                'ruangan' => 'Ruangan 102',
            ],
            [
                'nm_kelas' => 'Kelas 2A',
                'siswa_id' => 3,
                'ruangan' => 'Ruangan 201',
            ],
            [
                'nm_kelas' => 'Kelas 2B',
                'siswa_id' => 4,
                'ruangan' => 'Ruangan 202',
            ],
            [
                'nm_kelas' => 'Kelas 3A',
                'siswa_id' => 5,
                'ruangan' => 'Ruangan 301',
            ],
            [
                'nm_kelas' => 'Kelas 3B',
                'siswa_id' => 6,
                'ruangan' => 'Ruangan 302',
            ],
            [
                'nm_kelas' => 'Kelas 4A',
                'siswa_id' => 7,
                'ruangan' => 'Ruangan 401',
            ],
            [
                'nm_kelas' => 'Kelas 4B',
                'siswa_id' => 8,
                'ruangan' => 'Ruangan 402',
            ],
            [
                'nm_kelas' => 'Kelas 5A',
                'siswa_id' => 9,
                'ruangan' => 'Ruangan 501',
            ],
            [
                'nm_kelas' => 'Kelas 5B',
                'siswa_id' => 10,
                'ruangan' => 'Ruangan 502',
            ],
        ]);
    }
}
