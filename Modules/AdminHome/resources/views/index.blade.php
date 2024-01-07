@extends('admintheme::layouts.master')
@section('header')
<link href="{{ asset('admin-assets/plugins/fullcalendar/css/main.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4 row-cols-xxl-4">
    <div class="col">
        <div class="card radius-10 border-0 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Đã phê duyệt</p>
                        <h4 class="mb-0 text-primary">{{ $count_approved }}</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-primary text-white">
                        <i class="bi bi-basket2-fill"></i>
                    </div>
                </div>
                <!-- <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Chưa phê duyệt</p>
                        <h4 class="mb-0 text-success">{{ $count_inapproved }}</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-success text-white">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
                <!-- <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Thiết bị mượn</p>
                        <h4 class="mb-0 text-danger">{{ $count_devides }}</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-danger text-white">
                        <i class="bi bi-graph-down-arrow"></i>
                    </div>
                </div>
                <!-- <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-0 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="">
                        <p class="mb-1">Phòng học mượn</p>
                        <h4 class="mb-0 text-warning">{{ $count_labs }}</h4>
                    </div>
                    <div class="ms-auto widget-icon bg-warning text-dark">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <!-- <div class="progress mt-3" style="height: 4.5px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%;" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<main class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('footer')
<script src="{{ asset('admin-assets/plugins/fullcalendar/js/main.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialView: 'dayGridMonth',
        initialDate: '2020-09-12',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        nowIndicator: true,
        dayMaxEvents: true, // allow "more" link when too many events
        editable: true,
        selectable: true,
        businessHours: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: [{
            title: 'All Day Event',
            start: '2020-09-01',
        }, {
            title: 'Long Event',
            start: '2020-09-07',
            end: '2020-09-10'
        }, {
            groupId: 999,
            title: 'Repeating Event',
            start: '2020-09-09T16:00:00'
        }, {
            groupId: 999,
            title: 'Repeating Event',
            start: '2020-09-16T16:00:00'
        }, {
            title: 'Conference',
            start: '2020-09-11',
            end: '2020-09-13'
        }, {
            title: 'Meeting',
            start: '2020-09-12T10:30:00',
            end: '2020-09-12T12:30:00'
        }, {
            title: 'Lunch',
            start: '2020-09-12T12:00:00'
        }, {
            title: 'Meeting',
            start: '2020-09-12T14:30:00'
        }, {
            title: 'Happy Hour',
            start: '2020-09-12T17:30:00'
        }, {
            title: 'Dinner',
            start: '2020-09-12T20:00:00'
        }, {
            title: 'Birthday Party',
            start: '2020-09-13T07:00:00'
        }, {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2020-09-28'
        }]
    });
    calendar.render();
});
</script>
@endsection