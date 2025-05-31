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
                                        <label for="user_id">User ID</label>
                                        <input type="text" name="user_id" id="user_id" 
                                            value="{{ old('user_id', $data->user_id) }}"
                                            class="form-control @error('user_id') is-invalid @enderror">
                                        @error('user_id')
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
                                        <label for="nisn">NISN</label>
                                        <input type="text" name="nisn" id="nisn" 
                                            value="{{ old('nisn', $data->nisn) }}"
                                            class="form-control @error('nisn') is-invalid @enderror">
                                        @error('nisn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="text" name="nis" id="nis" 
                                            value="{{ old('nis', $data->nis) }}"
                                            class="form-control @error('nis') is-invalid @enderror">
                                        @error('nis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Alamat</label>
                                        <textarea name="address" id="address" 
                                            class="form-control @error('address') is-invalid @enderror"
                                            rows="3">{{ old('address', $data->address) }}</textarea>
                                        @error('address')
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
