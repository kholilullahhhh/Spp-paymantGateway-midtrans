@extends('layouts.app', ['title' => 'Data Kelas'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kelas</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('kelas.create') }}" class="btn btn-primary my-4">
                                    <i class="fas fa-plus"></i> Tambah Data Kelas
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-kelas">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Kelas</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datas as $index => $kelas)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $kelas->name }}</td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('kelas.edit', $kelas->id) }}"
                                                            class="btn btn-warning btn-sm mr-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('kelas.hapus', $kelas    ->id) }}" method="POST"
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
                $('#table-kelas').DataTable();
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