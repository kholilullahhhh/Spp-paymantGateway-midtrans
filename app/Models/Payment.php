<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'spp_plan_id',
        'month',
        'payment_date',
        'amount_paid',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function sppPlan()
    {
        return $this->belongsTo(SppPlan::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
