@extends('layouts.app', ['title' => 'SPP Payment Dashboard'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.css">
        <style>
            :root {
                --primary: #4361ee;
                --primary-light: #eef2ff;
                --secondary: #3f37c9;
                --success: #28a745;
                --warning: #ffc107;
                --danger: #dc3545;
                --info: #17a2b8;
                --dark: #343a40;
                --light: #f8f9fa;
            }

            .dashboard-card {
                border: none;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: all 0.3s ease;
                overflow: hidden;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            .card-icon {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.75rem;
                color: white;
                margin-right: 1rem;
            }

            .card-value {
                font-size: 1.75rem;
                font-weight: 700;
                line-height: 1.2;
            }

            .card-label {
                font-size: 0.875rem;
                color: #6c757d;
            }

            .chart-container {
                position: relative;
                height: 300px;
            }

            .floating-card {
                position: absolute;
                right: 20px;
                top: 20px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(5px);
                border-radius: 0.5rem;
                padding: 0.5rem 1rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .status-badge {
                padding: 0.35rem 0.75rem;
                border-radius: 50rem;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .bg-paid {
                background-color: rgba(40, 167, 69, 0.1);
                color: var(--success);
            }

            .bg-pending {
                background-color: rgba(255, 193, 7, 0.1);
                color: var(--warning);
            }

            .bg-overdue {
                background-color: rgba(220, 53, 69, 0.1);
                color: var(--danger);
            }
        </style>
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>SPP Payment Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><i class="bi bi-house-door"></i> Dashboard</div>
                </div>
            </div>

            <div class="row">
                <!-- Summary Cards -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Pembayaran Bulan Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($currentMonthPayments, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-cash-stack fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pembayaran Lunas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidPayments }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pembayaran Tertunda</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPayments }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-exclamation-triangle fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="dashboard-card card border-left-dark h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Total Siswa</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStudents }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-person fa-2x text-dark"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Payment Statistics Chart -->
                <div class="col-lg-8 mb-4">
                    <div class="dashboard-card card shadow h-100">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Statistik Pembayaran SPP</h6>
                            <div class="dropdown no-arrow">
                                <select id="yearSelect" class="form-control form-control-sm">
                                    @foreach(range(date('Y') - 2, date('Y')) as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div id="paymentChart"></div>
                                <div class="floating-card">
                                    <div class="text-center">
                                        <div class="text-xs text-muted">Total Tahun Ini</div>
                                        <div class="h5 font-weight-bold">Rp
                                            {{ number_format($currentYearPayment, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Pie Chart -->
                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card card shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <div id="paymentStatusChart"></div>
                            <div class="mt-4 text-center small">
                                <span class="mr-3">
                                    <i class="fas fa-circle text-success"></i> Lunas ({{ $paidPayments }}%)
                                </span>
                                <span class="mr-3">
                                    <i class="fas fa-circle text-warning"></i> Tertunda ({{ $pendingPayments }}%)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Payments -->
                <div class="col-lg-6 mb-4">
                    <div class="dashboard-card card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Pembayaran Terbaru</h6>
                            <a href="{{ route('payment.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body recent-payments" style="max-height: 350px; overflow-y: auto;">
                            @foreach($recentPayments as $payment)
                                <div class="payment-item mb-3 p-3 rounded bg-{{ $payment->status }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="font-weight-bold mb-1">{{ $payment->siswa->name }}</h6>
                                            <small class="text-muted">
                                                {{ $payment->paid_month }} {{ $payment->paid_year }} •
                                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </small>
                                        </div>
                                        <div class="text-right">
                                            <span class="status-badge bg-{{ $payment->status }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- Class Payment Progress -->
<div class="col-lg-6 mb-4">
    <div class="dashboard-card card shadow h-100">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Progress Pembayaran per Kelas</h6>
        </div>
        <div class="card-body">
            @foreach($classProgress as $class)
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="font-weight-bold">{{ $class->name }}</span>
                        <span class="text-muted">{{ $class->paid_count }}/{{ $class->total_students }}</span>
                    </div>
                    <div class="progress progress-thin">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ $class->percentage }}%" aria-valuenow="{{ $class->percentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <small class="text-muted">{{ round($class->percentage) }}% complete</small>
                </div>
            @endforeach
        </div>
    </div>
</div>

            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Initialize charts with current data
            var paymentChart = new ApexCharts(document.querySelector("#paymentChart"), {
                series: [{
                    name: 'Pembayaran',
                    data: @json(array_values($monthlyPayments))
                }],
                chart: {
                    type: 'bar',
                    height: '100%',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ['#4361ee'],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            });
            paymentChart.render();

            var paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"), {
                series: [{{ $paidPayments }}, {{ $pendingPayments }}],
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: ['Lunas', 'Tertunda',],
                colors: ['#28a745', '#ffc107'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            });
            paymentStatusChart.render();

            // Handle year selection change
            $('#yearSelect').change(function () {
                const year = $(this).val();
                window.location.href = "{{ route('dashboard') }}?year=" + year;
            });
        </script>
    @endpush
@endsection