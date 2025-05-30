<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas_id');
            $table->string('guru_id');
            $table->string('gender');
            $table->string('agama');
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('wali'); //orangtua/wali
            $table->string('no_hp_wali'); //nomor hp orangtua/wali
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
