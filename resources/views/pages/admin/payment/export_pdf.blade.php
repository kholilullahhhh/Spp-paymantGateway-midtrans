<!DOCTYPE html>
<html>

<head>
    <title>Data Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        h3 {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h2>Data Pembayaran - {{ $kelas }} {{ $jurusan }}</h2>

    <h3>Sudah Membayar</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Bulan Dibayar</th>
                <th>Tahun</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sudahBayar as $item)
                <tr>
                    <td>{{ $item->siswa->name }}</td>
                    <td>{{ $item->siswa->class->name ?? '-' }}</td>
                    <td>{{ $item->siswa->class->jurusan ?? '-' }}</td>
                    <td>{{ $item->paid_month }}</td>
                    <td>{{ $item->paid_year }}</td>
                    <td>
                        {{ $item->paid_at ? \Carbon\Carbon::parse($item->paid_at)->format('d-m-Y') : '-' }}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Belum Membayar</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($belumBayar as $item)
                <tr>
                    <td>{{ $item->siswa->name }}</td>
                    <td>{{ $item->siswa->class->name ?? '-' }}</td>
                    <td>{{ $item->siswa->class->jurusan ?? '-' }}</td>
                    <td>{{ $item->paid_month }}</td>
                    <td>{{ $item->paid_year }}</td>
                    <td>Belum Bayar</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>