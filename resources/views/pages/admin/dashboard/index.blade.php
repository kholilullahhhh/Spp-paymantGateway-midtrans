@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons-wind.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Admin Dashboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Users</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>
                            <div class="card-footer">
                                <small>All registered users</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Guru</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalTeachers }}
                            </div>
                            <div class="card-footer">
                                <small>Teaching staff</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Siswa</h4>
                            </div>
                            <div class="card-body">
                                {{ $siswa }}
                            </div>
                            <div class="card-footer">
                                <small>All students</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Upcoming Events</h4>
                            </div>
                            <div class="card-body">
                                {{ $upcomingEvents }}
                            </div>
                            <div class="card-footer">
                                <small>Next 30 days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Calendar of Events</h4>
                            <div class="card-header-action">
                                <button class="btn btn-primary" id="addEventBtn">Add Event</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>User Statistics</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="userChart" height="158"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>User Distribution</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="userDistributionChart" height="158"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <div class="activities">
                                @foreach($recentActivities as $activity)
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-small text-muted">
                                                    - {{ \Carbon\Carbon::parse($activity->tgl_selesai)->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <p>{{ $activity->deskripsi_kegiatan }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Upcoming Events</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach($upcomingEventList as $event)
                                    <li class="media">
                                        <div class="media-icon bg-primary text-white">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title">{{ $event->title }}</div>
                                            <span class="text-small text-muted">
                                                {{ \Carbon\Carbon::parse($event->tgl_kegiatan)->format('M d, Y') }}
                                                @if($event->end_date)
                                                    - {{ \Carbon\Carbon::parse($event->tgl_selesai)->format('M d, Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



        </section>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="eventModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="eventForm" method="POST" action="{{ route('agenda.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Event Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
        <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/id.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            var ctx2 = document.getElementById('userDistributionChart').getContext('2d');
            var userDistributionChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Guru', 'Siswa', 'Admin'],
                    datasets: [{
                        data: [{{ $totalTeachers }}, {{ $siswa }}, {{ $totalUsers - $totalTeachers - $siswa }}],
                        backgroundColor: ['#fc544b', '#ffa426', '#63ed7a'],
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'bottom'
                    }
                }
            });

            $('#calendar').fullCalendar({
                locale: 'id',
                events: @json($events), // pastikan variabel ini disiapkan di controller
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function (event) {
                    Swal.fire({
                        title: event.title,
                        text: event.description ?? 'No Description',
                        icon: 'info',
                    }); '#'
                }
            });





            $(document).ready(function () {
                // User Statistics Chart
                var ctx = document.getElementById('userChart').getContext('2d');
                var userChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'New Users',
                            data: [{{ implode(',', $monthlyUsers) }}],
                            borderColor: '#6777ef',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            pointBackgroundColor: '#fff',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                },
                                gridLines: {
                                    drawBorder: false,
                                    color: '#f2f2f2',
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        }
                    }
                });

                // User Distribution Chart
                var ctx2 = document.getElementById('userDistributionChart').getContext('2d');
                var userDistributionChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Guru', 'Siswa'],
                        datasets: [{
                            data: [{{ $totalAdmin }}, {{ $totalTeachers }}, {{ $siswa }}],
                            backgroundColor: [
                                '#6777ef',
                                '#fc544b',
                                '#ffa426'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: 'bottom'
                        }
                    }
                });

                // Calendar Initialization
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['interaction', 'dayGrid', 'timeGrid'],
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    defaultView: 'dayGridMonth',
                    locale: 'id',
                    editable: true,
                    selectable: true,
                    eventLimit: true,
                    events: {!! json_encode($events) !!},
                    eventRender: function (info) {
                        $(info.el).tooltip({
                            title: info.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    },
                    eventClick: function (info) {
                        Swal.fire({
                            title: info.event.title,
                            html: `
                                    <p><strong>Start:</strong> ${moment(info.event.start).format('LLLL')}</p>
                                    ${info.event.end ? `<p><strong>End:</strong> ${moment(info.event.end).format('LLLL')}</p>` : ''}
                                    <p><strong>Description:</strong> ${info.event.extendedProps.description || 'No description'}</p>
                                `,
                            icon: 'info',
                            confirmButtonText: 'Close'
                        });
                    },
                    dateClick: function (info) {
                        $('#eventModal').modal('show');
                        $('input[name="start_date"]').val(info.dateStr + 'T00:00');
                    }
                });
                calendar.render();
            });
        </script>
    @endpush
@endsection