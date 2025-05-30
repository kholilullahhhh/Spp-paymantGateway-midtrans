@extends('layouts.app', ['title' => 'Tambah Jadwal'])
@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
        }
        .fade-in {
            animation: fadeIn 0.7s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .input-group-text {
            background: #f1f1f1;
        }
    </style>
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Jadwal</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <form id="jadwalForm" action="{{ route('jadwal.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Jadwal</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger fade-in">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Nama Tema</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2 @error('tema_id') is-invalid @enderror" name="tema_id" required data-placeholder="Cari Tema...">
                                            <option value="">--- Pilih Tema ---</option>
                                            @foreach ($tema as $item)
                                                <option value="{{ $item->id }}" {{ old('tema_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tema_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Nama Modul</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2 @error('modul_id') is-invalid @enderror" name="modul_id" required data-placeholder="Cari Modul...">
                                            <option value="">--- Pilih Modul ---</option>
                                            @foreach ($modul as $item)
                                                <option value="{{ $item->id }}" {{ old('modul_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('modul_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Kelas</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2 @error('kelas_id') is-invalid @enderror" name="kelas_id" required data-placeholder="Cari Kelas...">
                                            <option value="">--- Pilih Kelas ---</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nm_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Guru</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2 @error('guru_id') is-invalid @enderror" name="guru_id" required data-placeholder="Cari Guru...">
                                            <option value="">--- Pilih Guru ---</option>
                                            @foreach ($guru as $item)
                                                <option value="{{ $item->id }}" {{ old('guru_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('guru_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Hari</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2 @error('hari') is-invalid @enderror" name="hari" required data-placeholder="Pilih Hari...">
                                            <option value="">--- Pilih Hari ---</option>
                                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                                <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Waktu Mulai</label>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                            </div>
                                            <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" required value="{{ old('jam_mulai') }}">
                                            @error('jam_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-3">Waktu Selesai</label>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                            </div>
                                            <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" required value="{{ old('jam_selesai') }}">
                                            @error('jam_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-7 offset-md-3">
                                        <button id="btnSubmit" class="btn btn-primary" type="submit">
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            Simpan
                                        </button>
                                        <a href="{{ route('jadwal.index') }}" class="btn btn-warning">Kembali</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                allowClear: true,
                placeholder: function(){
                    return $(this).data('placeholder');
                }
            });

            // Real-time validation feedback
            $('input, select').on('blur change', function() {
                if ($(this).prop('required') && !$(this).val()) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Spinner on submit
            $('#jadwalForm').on('submit', function() {
                $('#btnSubmit').attr('disabled', true);
                $('#btnSpinner').removeClass('d-none');
            });
        });
    </script>
@endpush
@endsection