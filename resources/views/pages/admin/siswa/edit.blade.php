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
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" 
                                            value="{{ old('nama', $data->nama) }}"
                                            class="form-control @error('nama') is-invalid @enderror">
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kelas_id">Kelas</label>
                                        <select name="kelas_id" id="kelas_id"
                                            class="form-control select2 @error('kelas_id') is-invalid @enderror">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach ($kelas as $k)
                                                <option value="{{ $k->id }}" 
                                                    {{ old('kelas_id', $data->kelas_id) == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nm_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kelas_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" id="tgl_lahir" 
                                            value="{{ old('tgl_lahir', $data->tgl_lahir) }}"
                                            class="form-control @error('tgl_lahir') is-invalid @enderror">
                                        @error('tgl_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" 
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            rows="3">{{ old('alamat', $data->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="wali">Wali</label>
                                        <input type="text" name="wali" id="wali" 
                                            value="{{ old('wali', $data->wali) }}"
                                            class="form-control @error('wali') is-invalid @enderror">
                                        @error('wali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="no_hp_wali">No. HP Wali</label>
                                        <input type="text" name="no_hp_wali" id="no_hp_wali" 
                                            value="{{ old('no_hp_wali', $data->no_hp_wali) }}"
                                            class="form-control @error('no_hp_wali') is-invalid @enderror">
                                        @error('no_hp_wali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
