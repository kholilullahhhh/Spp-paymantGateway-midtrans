<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('class_id')->nullable()->cascadeOnDelete();
            $table->string('spp_id')->nullable()->cascadeOnDelete();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('nisn')->unique()->nullable();
            $table->string('nis')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('no_hp')->nullable();
            $table->enum('role', ['admin', 'siswa'])->default('siswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
