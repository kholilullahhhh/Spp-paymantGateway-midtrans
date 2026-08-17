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
        'paid_month',
        'paid_year',
        'amount',
        'status',
        'snap_token',

    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id', 'id');
    }

    public function spp()
    {
        return $this->belongsTo(SppPlan::class, 'spp_id', 'id');
    }

    public const STATUS_LUNAS = 'paid';

    public function getLunasAttribute(): bool
    {
        return $this->status === self::STATUS_LUNAS;
    }

    public function getDibayarAttribute(): float
    {
        return $this->lunas ? (float) $this->amount : 0.0;
    }

    public function getTunggakanAttribute(): float
    {
        return max((float) ($this->spp->nominal ?? 0) - $this->dibayar, 0.0);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'Lunas',
            'pending' => 'Menunggu Pembayaran',
            'unpaid' => 'Belum Bayar',
            'denied' => 'Ditolak',
            'expired' => 'Kadaluarsa',
            'canceled' => 'Dibatalkan',
            'challenge' => 'Challenge',
            default => ucfirst($this->status),
        };
    }

    public function getStatusMidtransAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'settlement',
            'pending' => 'pending',
            'denied' => 'deny',
            'expired' => 'expire',
            'canceled' => 'cancel',
            'challenge' => 'challenge',
            default => '-',
        };
    }

    public function getBulanLabelAttribute(): string
    {
        return \Carbon\Carbon::create()->month($this->paid_month)->translatedFormat('F');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->order_id)) {
                $model->order_id = 'PYMT-'.time().'-'.rand(1000, 9999);
            }
        });
    }
}
