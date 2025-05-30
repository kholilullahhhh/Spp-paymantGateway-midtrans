<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akun = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ],
            [
                'name' => 'siswa',
                'username' => 'siswa',
                'password' => bcrypt('siswa'),
                'role' => 'siswa',
            ],

        ];

        foreach ($akun as $key => $v) {
            Admin::create([
                'name' => $v['name'],
                'username' => $v['username'],
                'password' => $v['password'],
                'role' => $v['role'],
            ]);

            User::create([
                'name' => $v['name'],
                'username' => $v['username'],
                'password' => $v['password'],
                'role' => $v['role'],
            ]);
        }
    }
}
