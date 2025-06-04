@extends('layouts.app', ['title' => 'Data Siswa'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Siswa</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('siswa.create') }}" class="btn btn-primary my-4">
                                    <i class="fas fa-plus"></i> Tambah Data Siswa
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-siswa">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Kelas</th>
                                                <th>NISN</th>
                                                <th>NIS</th>
                                                <th>Alamat</th>
                                                <th>No Handphone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $siswa)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $siswa->name }}</td>
                                                    <td>{{ $siswa->username }}</td>
                                                    <td>{{ $siswa->class->name ?? '-' }}</td>
                                                    <td>{{ $siswa->nisn }}</td>
                                                    <td>{{ $siswa->nis }}</td>
                                                    <td>{{ $siswa->address ?? '-' }}</td>
                                                    <td>{{ $siswa->no_hp ?? '-' }}</td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('siswa.edit', $siswa->id) }}"
                                                            class="btn btn-warning btn-sm mr-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('siswa.hapus', $siswa->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
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
                $('#table-siswa').DataTable();
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