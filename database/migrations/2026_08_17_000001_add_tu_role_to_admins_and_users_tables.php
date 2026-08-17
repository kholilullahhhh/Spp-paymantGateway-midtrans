<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perluasan role untuk mendukung modul Rekapitulasi Dana & Laporan SPP.
     * Project hanya memiliki role 'admin' dan 'siswa'; fitur laporan ditujukan
     * untuk Admin dan Tata Usaha (TU), sehingga nilai 'tu' ditambahkan ke enum.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa', 'tu'])->default('siswa')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa', 'tu'])->default('siswa')->change();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->change();
        });
    }
};
