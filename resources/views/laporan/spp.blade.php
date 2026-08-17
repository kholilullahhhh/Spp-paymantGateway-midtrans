@extends('layouts.app', ['title' => 'Rekapitulasi Dana & Laporan SPP'])

@php
    $queryString = http_build_query(array_filter(request()->only(['month', 'year', 'status', 'class_id']), fn ($v) => $v !== null && $v !== ''));
@endphp

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <style>
            .summary-card .card-body { padding: 1.25rem; }
            .summary-card .summary-icon {
                width: 48px; height: 48px; border-radius: 50%;
                display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.25rem;
            }
            .summary-card .summary-label { font-size: 0.85rem; color: #6c757d; }
            .summary-card .summary-value { font-size: 1.35rem; font-weight: 700; }
            .filter-form .form-group { margin-bottom: 0; }
            @media (max-width: 767.98px) {
                .filter-form .form-group { margin-bottom: .75rem; }
            }
            .table th { background-color: #f8f9fa; font-weight: 600; color: #495057; }
            .status-badge { font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; }
            .badge-lunas { background-color: #28a745; color: #fff; }
            .badge-menunggak { background-color: #ffc107; color: #212529; }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekapitulasi Dana & Laporan SPP</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Laporan</div>
                    <div class="breadcrumb-item">Rekapitulasi SPP</div>
                </div>
            </div>

            <div class="section-body">
                {{-- Filter --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Laporan</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.spp') }}" class="filter-form">
                            <div class="row">
                                <div class="col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Periode Bulan</label>
                                        <select name="month" class="form-control select2">
                                            <option value="">Semua Bulan</option>
                                            @foreach (range(1, 12) as $m)
                                                <option value="{{ $m }}" {{ (int) request('month') === $m ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::createFromFormat('!m', $m)->translatedFormat('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select name="year" class="form-control select2">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($tahunList as $tahun)
                                                <option value="{{ $tahun }}" {{ (string) request('year') === (string) $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-2">
                                    <div class="form-group">
                                        <label>Status Pembayaran</label>
                                        <select name="status" class="form-control select2">
                                            <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="menunggak" {{ request('status') === 'menunggak' ? 'selected' : '' }}>Menunggak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Kelas / Jurusan</label>
                                        <select name="class_id" class="form-control select2">
                                            <option value="">Semua Kelas</option>
                                            @foreach ($kelasList as $kelas)
                                                <option value="{{ $kelas->id }}" {{ (string) request('class_id') === (string) $kelas->id ? 'selected' : '' }}>
                                                    {{ $kelas->name }}@if ($kelas->jurusan) - {{ $kelas->jurusan }}@endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 align-self-end">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Filter</button>
                                        <a href="{{ route('laporan.spp') }}" class="btn btn-secondary"><i class="fas fa-redo mr-1"></i>Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card summary-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="summary-icon bg-success mr-3"><i class="fas fa-money-bill-wave"></i></div>
                                <div>
                                    <div class="summary-label">Total Pemasukan Lunas</div>
                                    <div class="summary-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card summary-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="summary-icon bg-danger mr-3"><i class="fas fa-exclamation-triangle"></i></div>
                                <div>
                                    <div class="summary-label">Total Tunggakan</div>
                                    <div class="summary-value">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card summary-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="summary-icon bg-info mr-3"><i class="fas fa-user-check"></i></div>
                                <div>
                                    <div class="summary-label">Siswa Lunas</div>
                                    <div class="summary-value">{{ $jumlahLunas }} Siswa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card summary-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="summary-icon bg-warning mr-3"><i class="fas fa-user-clock"></i></div>
                                <div>
                                    <div class="summary-label">Siswa Belum Lunas</div>
                                    <div class="summary-value">{{ $jumlahBelumLunas }} Siswa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Export --}}
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <strong>Jumlah Transaksi Berhasil:</strong>
                                <span class="badge badge-success">{{ $jumlahTransaksi }} transaksi</span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('laporan.spp.excel') }}{{ $queryString ? '?' . $queryString : '' }}" class="btn btn-success">
                                    <i class="fas fa-file-excel mr-1"></i>Export Excel
                                </a>
                                <a href="{{ route('laporan.spp.pdf') }}{{ $queryString ? '?' . $queryString : '' }}" class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf mr-1"></i>Print PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Laporan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table-laporan-spp">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Bulan SPP</th>
                                        <th class="text-right">Nominal SPP</th>
                                        <th class="text-right">Nominal Dibayar</th>
                                        <th class="text-right">Tunggakan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Midtrans</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $i => $payment)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                @if ($payment->paid_at)
                                                    {{ \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d F Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->siswa->nisn ?? '-' }}</td>
                                            <td>{{ $payment->siswa->name ?? '-' }}</td>
                                            <td>{{ $payment->siswa->class->name ?? '-' }}@if ($payment->siswa->class && $payment->siswa->class->jurusan) ({{ $payment->siswa->class->jurusan }})@endif</td>
                                            <td>{{ $payment->bulan_label }} {{ $payment->paid_year }}</td>
                                            <td class="text-right">Rp {{ number_format($payment->spp->nominal ?? 0, 0, ',', '.') }}</td>
                                            <td class="text-right">Rp {{ number_format($payment->dibayar, 0, ',', '.') }}</td>
                                            <td class="text-right">Rp {{ number_format($payment->tunggakan, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($payment->lunas)
                                                    <span class="status-badge badge-lunas">Lunas</span>
                                                @else
                                                    <span class="status-badge badge-menunggak">{{ $payment->status_label }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->status_midtrans }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">Tidak ada data sesuai filter.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('.select2').select2();

                $('#table-laporan-spp').DataTable({
                    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json" },
                    "columnDefs": [
                        { "orderable": false, "targets": [0] }
                    ],
                    "responsive": true,
                    "autoWidth": false,
                    "order": [[1, "desc"]]
                });
            });
        </script>
    @endpush
@endsection