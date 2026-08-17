<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanSppExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(private Builder $query) {}

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'NISN',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Jurusan',
            'Bulan SPP',
            'Tahun',
            'Nominal SPP',
            'Nominal Dibayar',
            'Tunggakan',
            'Status Pembayaran',
            'Status Midtrans',
        ];
    }

    public function map($payment): array
    {
        $payment->loadMissing('siswa.class', 'spp');

        return [
            $payment->id,
            $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d F Y') : '-',
            $payment->siswa->nisn ?? '-',
            $payment->siswa->nis ?? '-',
            $payment->siswa->name ?? '-',
            $payment->siswa->class->name ?? '-',
            $payment->siswa->class->jurusan ?? '-',
            $payment->bulan_label,
            $payment->paid_year,
            (float) ($payment->spp->nominal ?? 0),
            $payment->dibayar,
            $payment->tunggakan,
            $payment->status_label,
            $payment->status_midtrans,
        ];
    }
}
