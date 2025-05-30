@extends('layouts.app', ['title' => 'Edit Jadwal'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Jadwal</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('jadwal.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="card">  
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        <select name="kelas_id" id="kelas"
                                            class="form-control select2 @error('kelas_id') is-invalid @enderror">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($kelas as $kls)
                                                <option value="{{ $kls->id }}" 
                                                    {{ old('kelas_id', $kls->kelas_id) == $kls->id ? 'selected' : '' }}>
                                                    {{ $kls->nm_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('guru_Id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="guru">Guru</label>
                                        <select name="guru_id" id="guru"
                                            class="form-control select2 @error('guru_id') is-invalid @enderror">
                                            <option value="">-- Pilih guru --</option>
                                            @foreach ($guru as $gr)
                                                <option value="{{ $gr->id }}" 
                                                    {{ old('guru_id', $gr->guru_id) == $gr->id ? 'selected' : '' }}>
                                                    {{ $gr->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('guru_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tema">Tema</label>
                                        <select name="tema_id" id="tema"
                                            class="form-control select2 @error('tema_id') is-invalid @enderror">
                                            <option value="">-- Pilih tema --</option>
                                            @foreach ($tema as $tm)
                                                <option value="{{ $tm->id }}" 
                                                    {{ old('tema_id', $tm->tema_id) == $tm->id ? 'selected' : '' }}>
                                                    {{ $tm->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tema_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="modul">Modul</label>
                                        <select name="modul_id" id="modul"
                                            class="form-control select2 @error('modul_id') is-invalid @enderror">
                                            <option value="">-- Pilih Modul --</option>
                                            @foreach ($modul as $mdl)
                                                <option value="{{ $mdl->id }}" 
                                                    {{ old('modul_id', $mdl->modul_id) == $mdl->id ? 'selected' : '' }}>
                                                    {{ $mdl->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('modul_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="hari">Hari</label>
                                        <select name="hari" id="hari"
                                            class="form-control select2 @error('hari') is-invalid @enderror">
                                            <option value="">-- Pilih Hari --</option>
                                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                                <option value="{{ $hari }}"
                                                    {{ old('hari', $data->hari) == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_mulai">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" 
                                            value="{{ old('jam_mulai', $data->jam_mulai) }}"
                                            class="form-control @error('jam_mulai') is-invalid @enderror">
                                        @error('jam_mulai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_selesai">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" 
                                            value="{{ old('jam_selesai', $data->jam_selesai) }}"
                                            class="form-control @error('jam_selesai') is-invalid @enderror">
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="ruangan">Ruangan</label>
                                        <select name="kelas_id" id="ruangan"
                                            class="form-control select2 @error('kelas_id') is-invalid @enderror">
                                            <option value="">-- Pilih Ruangan Kelas --</option>
                                            @foreach ($kelas as $kls)
                                                <option value="{{ $kls->id }}" 
                                                    {{ old('kelas_id', $kls->kelas_id) == $kls->id ? 'selected' : '' }}>
                                                    {{ $kls->ruangan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
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
