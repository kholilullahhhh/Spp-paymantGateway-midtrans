@extends('layouts.app', ['title' => 'Data Transaksi Pembayaran'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Pembayaran</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Daftar Pembayaran</h4>
                                <div class="card-header-action d-flex">
                                    <div class="mr-3">
                                        <select class="form-control select2" id="month-filter">
                                            <option value="">Pilih Bulan</option>
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <a href="{{ route('payment.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg"></i> Tambah Pembayaran
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-pembayaran">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NISN</th>
                                                <th>Nama Siswa</th>
                                                <th>Bulan</th>
                                                <th>Semester</th>
                                                <th>Tahun</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $payment)
                                                <tr>
                                                    <td>{{ $payment->order_id }}</td>
                                                    <td>{{ $payment->siswa->nisn }}</td>
                                                    <td>{{ $payment->siswa->name }}</td>
                                                    <td>
                                                        @if($payment->paid_month)
                                                            @php
                                                                $monthName = DateTime::createFromFormat('!m', $payment->paid_month);
                                                            @endphp
                                                            {{ $monthName ? $monthName->format('F') : '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $payment->spp->semester }}</td>
                                                    <td>{{ $payment->paid_year }}</td>
                                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($payment->paid_at)
                                                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payment->status == 'paid')
                                                            <span class="badge badge-success">{{ $payment->status }}</span>
                                                        @elseif ($payment->status == 'pending')
                                                            <span class="badge badge-warning">{{ $payment->status }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $payment->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if ($payment->status == 'pending')
                                                                <form action="{{ route('konfirmasi.pembayaran', $payment->id) }}" method="POST" class="mr-1">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="btn btn-primary btn-sm" title="Konfirmasi">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            
                                                            <form action="{{ route('payment.hapus', $payment->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm delete-btn" title="Hapus">
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
                
                // Initialize DataTable
                var table = $('#table-pembayaran').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                    }
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
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Show success message if exists
                @if(session('message'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('message') }}',
                        timer: 3000,
                        showConfirmButton: true
                    });
                @endif

                // Show error message if exists
                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                    });
                @endif
            });
        </script>
    @endpush
@endsection