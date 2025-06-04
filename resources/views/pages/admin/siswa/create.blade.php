@extends('layouts.app', ['title' => 'Tambah Data Siswa'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Siswa</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Tambah Siswa</h4>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Nama</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="name" class="form-control"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <!-- Username -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Username</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="username" class="form-control"
                                                value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Password</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="password" class="form-control"
                                                value="{{ old('password') }}">
                                        </div>
                                    </div>

                                    <!-- Kelas (class_id) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Kelas</label>
                                        <div class="col-md-7">
                                            <select class="form-control selectric" name="class_id" required>
                                                <option value="">--- Pilih Kelas ---</option>
                                                @foreach ($kelas as $item)
                                                    <option value="{{ $item->id }}" {{ old('class_id') == $item->id ? 'selected' : '' }}>
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
                                                value="{{ old('nisn') }}">
                                        </div>
                                    </div>

                                    <!-- NIS -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">NIS</label>
                                        <div class="col-md-7">
                                            <input required type="text" name="nis" class="form-control"
                                                value="{{ old('nis') }}">
                                        </div>
                                    </div>

                                    <!-- Alamat (address) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Alamat</label>
                                        <div class="col-md-7">
                                            <textarea required name="address"
                                                class="form-control">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="role" value="{{ 'siswa' }}">

                                    <!-- No HP (no_hp) -->
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3">Nomor HP</label>
                                        <div class="col-md-7">
                                            <input type="number" name="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group row">
                                        <div class="col-md-7 offset-md-3">
                                            <button class="btn btn-primary">Simpan</button>
                                            <a href="{{ route('siswa.index') }}" class="btn btn-warning">Kembali</a>
                                        </div>
                                    </div>
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
        <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
        <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
        <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    @endpush
@endsection
