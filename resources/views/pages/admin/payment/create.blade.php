@extends('layouts.app', ['title' => 'Tambah Data Pembayaran'])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Pembayaran</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('payment.index') }}">Data Pembayaran</a></div>
                    <div class="breadcrumb-item active">Tambah Pembayaran</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Data Pembayaran</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('payment.store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <!-- Siswa Information -->
                                            <div class="form-group">
                                                <label>NISN <span class="text-danger">*</span></label>
                                                <select class="form-control" name="siswa_id" id="nisn-select" required>
                                                    <option value="">==Pilih NISN==</option>
                                                    @foreach ($siswa as $student)
                                                        <option value="{{ $student->id }}" 
                                                            data-nama="{{ $student->name }}"
                                                            {{ old('siswa_id') == $student->id ? 'selected' : '' }}>
                                                            {{ $student->nisn }} - {{ $student->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Payment Information -->
                                            <div class="form-group">
                                                <label>Spp Plan <span class="text-danger">*</span></label>
                                                <select class="form-control" name="spp_id" id="spp-select" required>
                                                    <option value="">==Pilih Spp Plan==</option>
                                                    @foreach ($spp as $plan)
                                                        <option value="{{ $plan->id }}" 
                                                            data-nominal="{{ $plan->nominal }}"
                                                            data-tahun="{{ $plan->tahun }}"
                                                            data-semester="{{ $plan->semester }}"
                                                            {{ old('spp_id') == $plan->id ? 'selected' : '' }}>
                                                            {{ $plan->name }} - Rp{{ number_format($plan->nominal, 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Bulan <span class="text-danger">*</span></label>
                                                <select name="month" class="form-control" required>
                                                    <option value="">==Pilih Bulan==</option>
                                                    <option value="January" {{ old('month') == 'January' ? 'selected' : '' }}>
                                                        Januari</option>
                                                    <option value="February" {{ old('month') == 'February' ? 'selected' : '' }}>Februari</option>
                                                    <option value="March" {{ old('month') == 'March' ? 'selected' : '' }}>
                                                        Maret</option>
                                                    <option value="April" {{ old('month') == 'April' ? 'selected' : '' }} >
                                                        April</option>
                                                    <option value="May" {{ old('month') == 'May' ? 'selected' : '' }}>Mei</option>
                                                    <option value="June" {{ old('month') == 'June' ? 'selected' : '' }}>Juni</option>
                                                    <option value="July" {{ old('month') == 'July' ? 'selected' : '' }}>Juli</option>
                                                    <option value="August" {{ old('month') == 'August' ? 'selected' : '' }}>
                                                        Agustus</option>
                                                    <option value="September" {{ old('month') == 'September' ? 'selected' : '' }}>September</option>
                                                    <option value="October" {{ old('month') == 'October' ? 'selected' : '' }}>
                                                        Oktober</option>
                                                    <option value="November" {{ old('month') == 'November' ? 'selected' : '' }}>November</option>
                                                    <option value="December" {{ old('month') == 'December' ? 'selected' : '' }}>Desember</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Siswa <span class="text-danger">*</span></label>
                                                <input type="text" id="nama-siswa" class="form-control" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Jumlah Pembayaran <span class="text-danger">*</span></label>
                                                <input type="number" name="amount" id="amount-input" class="form-control" value="{{ old('amount') }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Tahun <span class="text-danger">*</span></label>
                                                <input type="text" name="year" id="year-input" class="form-control" value="{{ old('year') }}" required>
                                            </div>


                                            <div class="form-group">
                                                <label>Semester</label>
                                                <input type="text" id="semester-input" class="form-control" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Status Pembayaran <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>
                                                        Belum Dibayar</option>
                                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Sudah
                                                        Dibayar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-save mr-2"></i> Simpan Data
                                        </button>
                                        <a href="{{ route('payment.index') }}" class="btn btn-secondary btn-lg px-5 ml-2">
                                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // When NISN is selected, auto-fill the student name
            $('#nisn-select').change(function() {
                var selectedOption = $(this).find('option:selected');
                var studentName = selectedOption.data('nama');
                $('#nama-siswa').val(studentName);
            });

            // When SPP Plan is selected, auto-fill amount, year, and semester
            $('#spp-select').change(function() {
                var selectedOption = $(this).find('option:selected');
                $('#amount-input').val(selectedOption.data('nominal'));
                $('#year-input').val(selectedOption.data('year'));
                $('#semester-input').val(selectedOption.data('semester'));
            });

            // Trigger change events if there are old values
            @if(old('siswa_id'))
                $('#nisn-select').trigger('change');
            @endif
            
            @if(old('spp_id'))
                $('#spp-select').trigger('change');
            @endif
        });
    </script>
@endpush
