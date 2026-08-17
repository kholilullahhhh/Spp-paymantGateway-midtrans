<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'X RPL', 'jurusan' => 'RPL'],
            ['name' => 'XI TKJ', 'jurusan' => 'TKJ'],
            ['name' => 'XII MM', 'jurusan' => 'MM'],
        ];

        foreach ($classes as $c) {
            Classes::updateOrCreate(
                ['name' => $c['name'], 'jurusan' => $c['jurusan']],
                ['name' => $c['name'], 'jurusan' => $c['jurusan']]
            );
        }
    }
}
