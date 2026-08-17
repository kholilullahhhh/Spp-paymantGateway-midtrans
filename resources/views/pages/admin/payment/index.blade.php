@extends('layouts.app', ['title' => 'Data Transaksi Pembayaran'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <style>
                    .card-header-action {
                        gap: 15px;
                    }
                    .filter-container {
                        display: flex;
                        gap: 15px;
                        flex-wrap: wrap;
                        align-items: center;
                    }
                    .filter-group {
                        min-width: 200px;
                    }
                    .status-badge {
                        font-size: 0.8rem;
                        padding: 5px 10px;
                        border-radius: 20px;
                    }
                    .badge-paid {
                        background-color: #28a745;
                        color: white;
                    }
                    .badge-pending {
                        background-color: #ffc107;
                        color: #212529;
                    }
                    .badge-failed {
                        background-color: #dc3545;
                        color: white;
                    }
                    .action-buttons {
                        display: flex;
                        gap: 8px;
                    }
                    .btn-icon {
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 0;
                    }
                    .table-responsive {
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 0 10px rgba(0,0,0,0.05);
                    }
                    .table th {
                        background-color: #f8f9fa;
                        font-weight: 600;
                        color: #495057;
                    }
                    .export-section {
                        background: #f8f9fa;
                        padding: 15px;
                        border-radius: 8px;
                        margin-bottom: 20px;
                    }
                    .export-title {
                        font-size: 1rem;
                        font-weight: 600;
                        margin-bottom: 10px;
                        color: #495057;
                    }
                    @media (max-width: 768px) {
                        .card-header-action {
                            flex-direction: column;
                            align-items: flex-start;
                        }
                        .filter-container {
                            width: 100%;
                            margin-bottom: 15px;
                        }
                        .filter-group {
                            width: 100%;
                        }
                    }
                </style>
    @endpush

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Data Pembayaran</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                        <div class="breadcrumb-item">Pembayaran</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="mb-0">Daftar Pembayaran</h4>
                                    <div class="card-header-action d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="filter-container">
                                            <div class="filter-group">
                                                <select class="form-control select2" id="month-filter">
                                                    <option value="">Semua Bulan</option>
                                                    @foreach(range(1, 12) as $month)
                                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                           {{ \Carbon\Carbon::createFromFormat('!m', $month)->translatedFormat('F') }}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('payment.create') }}" class="btn btn-primary ">
                                                <i class="fas fa-plus"></i> Tambah Pembayaran
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="export-section">
                                        <div class="export-title">Export Data PDF</div>
                                        <form action="{{ route('payment.export.pdf') }}" method="POST" target="_blank" class="form-inline">
                                            @csrf
                                            <div class="form-group mr-2 mb-2">
                                                <select name="kelas" class="form-control select2" required style="min-width: 180px;">
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach($kelasList as $kelas)
                                                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mr-2 mb-2">
                                                <select name="jurusan" class="form-control select2" required style="min-width: 180px;">
                                                    <option value="">Pilih Jurusan</option>
                                                    @foreach($jurusanList as $jurusan)
                                                        <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-danger mb-2">
                                                <i class="fas fa-file-pdf mr-1"></i> Export PDF
                                            </button>
                                        </form>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table-pembayaran">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>NISN</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Bulan</th>
                                                    <th>Semester</th>
                                                    <th>Tahun</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal Bayar</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $payment)
                                                    <tr>
                                                        <td>{{ $payment->order_id }}</td>
                                                        <td>{{ $payment->siswa->nisn }}</td>
                                                        <td>{{ $payment->siswa->name }}</td>
                                                        <td>{{ \Carbon\Carbon::create()->month($payment->paid_month)->translatedFormat('F') }}</td>
                                                        <td>{{ $payment->spp->semester }}</td>
                                                        <td>{{ $payment->paid_year }}</td>
                                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if($payment->paid_at)
                                                                {{ \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d F Y') }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($payment->status == 'paid')
                                                                <span class="status-badge badge-paid">Lunas</span>
                                                            @elseif ($payment->status == 'pending')
                                                                <span class="status-badge badge-pending">Menunggu</span>
                                                           @elseif ($payment->status == 'unpaid')
                                                                <span class="status-badge badge-failed">Belum</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                @if ($payment->status == 'pending')
                                                                    <form action="{{ route('konfirmasi.pembayaran', $payment->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-primary btn-icon" title="Konfirmasi" data-toggle="tooltip">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif

                                                                <form action="{{ route('payment.hapus', $payment->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-icon delete-btn" title="Hapus" data-toggle="tooltip">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @push('scripts')
            <!-- SweetAlert2 from CDN -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
            <!-- Other scripts -->
            <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

            <script>
                $(document).ready(function () {
                    // Initialize Select2
                    $('.select2').select2();

                    // Initialize DataTable with better options
                    var table = $('#table-pembayaran').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                        },
                        "columnDefs": [
                            { "orderable": false, "targets": [9] },
                            { "searchable": false, "targets": [9] }
                        ],
                        "responsive": true,
                        "autoWidth": false,
                        "order": [[7, "desc"]]
                    });

                    // Month filter handler
                    $('#month-filter').change(function () {
                        var month = $(this).val();
                        if (month) {
                            window.location.href = "{{ route('payment.index') }}?month=" + month;
                        } else {
                            window.location.href = "{{ route('payment.index') }}";
                        }
                    });

                    // SweetAlert for delete confirmation
                    $(document).on('click', '.delete-btn', function (e) {
                        e.preventDefault();
                        var form = $(this).closest('form');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data pembayaran ini akan dihapus secara permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            customClass: {
                                confirmButton: 'mr-2',
                                cancelButton: 'ml-2'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });

                    // Initialize tooltips
                    $('[data-toggle="tooltip"]').tooltip();

                    // Show success message if exists
                    @if(session('message'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: '{{ session('message') }}',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    @endif

                    // Show error message if exists
                    @if(session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ session('error') }}',
                            showConfirmButton: true,
                            confirmButtonColor: '#3085d6'
                        });
                    @endif
                });
            </script>
        @endpush
@endsection
