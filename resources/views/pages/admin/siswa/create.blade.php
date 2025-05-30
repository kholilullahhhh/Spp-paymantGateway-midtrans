@extends('layouts.app', ['title' => 'Data Siswa'])
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
                                    <label class="col-form-label col-md-3">Nama Lengkap</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="nama" class="form-control"
                                            value="{{ old('nama') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Kelas</label>
                                    <div class="col-md-7">
                                        <select class="form-control selectric" name="kelas_id" required>
                                            <option value="">--- Pilih Kelas ---</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nm_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Tempat Lahir</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="tempat_lahir" class="form-control"
                                            value="{{ old('tempat_lahir') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Tanggal Lahir</label>
                                    <div class="col-md-7">
                                        <input required type="date" name="tgl_lahir" class="form-control"
                                            value="{{ old('tgl_lahir') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Gender</label>
                                    <div class="col-md-7">
                                        <select class="form-control selectric" name="gender" required>
                                            <option value="">--- Pilih Gender ---</option>
                                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Agama</label>
                                    <div class="col-md-7">
                                        <select class="form-control selectric" name="agama" required>
                                            <option value="">--- Pilih Agama ---</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam
                                            </option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>
                                                Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>
                                                Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu
                                            </option>
                                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Alamat</label>
                                    <div class="col-md-7">
                                        <textarea required name="alamat"
                                            class="form-control">{{ old('alamat') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Nama Orang tua/ wali</label>
                                    <div class="col-md-7">
                                        <textarea required name="wali"
                                            class="form-control">{{ old('wali') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Nomor Handphone</label>
                                    <div class="col-md-7">
                                        <input required type="text" name="no_hp_wali" class="form-control"
                                            value="{{ old('no_hp_wali') }}">
                                    </div>
                                </div>

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