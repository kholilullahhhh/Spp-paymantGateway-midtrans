<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Pembayaran SPP</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #212529;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header .sekolah { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .header .judul { font-size: 14px; font-weight: bold; margin-top: 4px; }
        .header .periode { font-size: 12px; margin-top: 4px; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .summary td {
            border: 1px solid #000;
            padding: 8px;
            width: 25%;
            text-align: center;
        }
        .summary .label { font-size: 9px; color: #555; text-transform: uppercase; }
        .summary .value { font-size: 13px; font-weight: bold; margin-top: 4px; }
        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.detail th, table.detail td {
            border: 1px solid #000;
            padding: 5px 6px;
            text-align: left;
            word-wrap: break-word;
        }
        table.detail th { background-color: #e9ecef; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 24px; }
        .footer .ttd {
            margin-top: 80px;
            display: flex;
            justify-content: flex-end;
        }
        .footer .ttd-inner { text-align: center; width: 220px; }
        .footer .ttd-inner .nama { font-weight: bold; text-decoration: underline; margin-top: 70px; }
        .no-wrap { white-space: nowrap; }
    </style>
</head>

<body>
    <div class="header">
        <div class="sekolah">SMK TRIDHARMA MAROS</div>
        <div class="judul">LAPORAN REKAPITULASI PEMBAYARAN SPP</div>
        <div class="periode">
            Periode:
            @if ($filters['month'])
                {{ \Carbon\Carbon::create()->month($filters['month'])->translatedFormat('F') }}
            @else
                Semua Bulan
            @endif
            @if ($filters['year'])
                {{ $filters['year'] }}
            @else
                / Semua Tahun
            @endif
            @if ($filters['class_id'] && $payments->first()?->siswa?->class)
                - {{ $payments->first()->siswa->class->name }}@if ($payments->first()->siswa->class->jurusan) ({{ $payments->first()->siswa->class->jurusan }})@endif
            @elseif ($filters['class_id'])
                - Kelas Terpilih
            @endif
        </div>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Pemasukan Lunas</div>
                <div class="value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Total Tunggakan</div>
                <div class="value">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Siswa Lunas</div>
                <div class="value">{{ $jumlahLunas }} Siswa</div>
            </td>
            <td>
                <div class="label">Siswa Belum Lunas</div>
                <div class="value">{{ $jumlahBelumLunas }} Siswa</div>
            </td>
        </tr>
    </table>

    <table class="detail">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:10%">Tanggal</th>
                <th style="width:8%">NISN</th>
                <th style="width:15%">Nama</th>
                <th style="width:10%">Kelas</th>
                <th style="width:8%">Bulan</th>
                <th class="text-right" style="width:11%">Nominal</th>
                <th class="text-right" style="width:11%">Dibayar</th>
                <th class="text-right" style="width:11%">Tunggakan</th>
                <th style="width:11%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $i => $payment)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="no-wrap">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d/m/Y') : '-' }}</td>
                    <td>{{ $payment->siswa->nisn ?? '-' }}</td>
                    <td>{{ $payment->siswa->name ?? '-' }}</td>
                    <td>{{ $payment->siswa->class->name ?? '-' }}</td>
                    <td>{{ $payment->bulan_label }}</td>
                    <td class="text-right">{{ number_format($payment->spp->nominal ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($payment->dibayar, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($payment->tunggakan, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $payment->lunas ? 'Lunas' : $payment->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div style="text-align:right;">
            Maros, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
        <div class="ttd">
            <div class="ttd-inner">
                <div>Petugas TU / Admin</div>
                <div class="nama">{{ $petugas ?? '-' }}</div>
            </div>
        </div>
    </div>
</body>

</html>