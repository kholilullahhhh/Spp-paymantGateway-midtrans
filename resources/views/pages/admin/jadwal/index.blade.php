@extends('layouts.app', ['title' => 'Data Jadwal'])

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Jadwal</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('jadwal.create') }}" class="btn btn-primary my-4">
                                <i class="fas fa-plus"></i> Tambah Data Jadwal
                            </a>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-jadwal">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kelas</th>
                                            <th>Guru</th>
                                            <th>Tema</th>
                                            <th>Modul</th>
                                            <th>Hari</th>
                                            <th>Ruangan</th>
                                            <th>Jam</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $index => $jadwal)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $jadwal->kelas->nm_kelas ?? '-' }}</td>
                                                <td>{{ $jadwal->guru->nama_lengkap ?? '-' }}</td>
                                                <td>{{ $jadwal->tema->nama ?? '-' }}</td>
                                                <td>{{ $jadwal->modul->judul ?? '-' }}</td>
                                                <td>{{ $jadwal->hari }}</td>
                                                <td>{{ $jadwal->kelas->ruangan ?? '-' }}</td>
                                                <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} WITA </td>
                                                <td class="d-flex">
                                                    <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                        class="btn btn-warning btn-sm mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="deleteData({{ $jadwal->id }}, 'jadwal')"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#table-jadwal').DataTable();
        });

        function deleteData(id, endpoint) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/${endpoint}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert('Data berhasil dihapus.');
                        location.reload();
                    },
                    error: function (error) {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        }
    </script>
@endpush
@endsection