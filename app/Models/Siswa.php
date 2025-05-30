<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kelas_id',
        'guru_id',
        'gender',
        'agama',
        'tgl_lahir',
        'alamat',
        'wali',
        'no_hp_wali',
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class,'guru_id','id');
    }
}
