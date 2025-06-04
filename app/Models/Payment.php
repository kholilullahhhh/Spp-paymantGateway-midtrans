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
        'month',
        'payment_date',
        'amount_paid',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class);
    }

    public function spp()
    {
        return $this->belongsTo(SppPlan::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
