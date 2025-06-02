@extends('layouts.app', ['title' => 'Edit Data Siswa'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Data Siswa</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('siswa.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="card">
                                <div class="card-body">

                                <div class="form-group row">
                                        <label class="col-form-label col-md-3">Nama</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="name" class="form-control"
                                                value="{{ old('name', $data->name) }}">
                                        </div>
                                    </div>
                                    <!-- User ID (username) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Username</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="username" class="form-control"
                                                value="{{ old('username', $data->username) }}">
                                        </div>
                                    </div>

                                    <!-- Kelas (class_id) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Kelas</label>
                                        <div class="col-md-7">
                                            <select class="form-control selectric" name="class_id" required>
                                                <option value="">--- Pilih Kelas ---</option>
                                                @foreach ($kelas as $item)
                                                    <option value="{{ $item->id }}" 
                                                        {{ old('class_id', $data->class_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- NISN -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">NISN</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="nisn" class="form-control"
                                                value="{{ old('nisn', $data->nisn) }}">
                                        </div>
                                    </div>

                                    <!-- NIS -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">NIS</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="nis" class="form-control"
                                                value="{{ old('nis', $data->nis) }}">
                                        </div>
                                    </div>

                                    <!-- Alamat (address) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Alamat</label>
                                        <div class="col-md-7">
                                            <textarea required name="address"
                                                class="form-control">{{ old('address', $data->address) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- No HP (no_hp) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Nomor HP</label>
                                        <div class="col-md-7">
                                            <input type="number" name="no_hp" class="form-control"
                                                value="{{ old('no_hp', $data->no_hp) }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
    @endpush
@endsection
