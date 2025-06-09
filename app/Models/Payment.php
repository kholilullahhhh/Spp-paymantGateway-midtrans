<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'spp_id',
        'paid_at',
        'order_id',
        'month',
        'year',
        'amount',
        'status'
        
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class,'siswa_id','id');
    }

    public function spp()
    {
        return $this->belongsTo(SppPlan::class, 'spp_id', 'id');
    }


}
