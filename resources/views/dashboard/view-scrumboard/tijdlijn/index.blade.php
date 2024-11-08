@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4 d-flex justify-content-between align-items-center flex-column">
        <h3 class="text-nowrap">Tijdlijn - {{ ucfirst($view) }} Overzicht</h3>
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto justify-content-between">
            <!-- Vorige Periode -->
            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => $view, 'startOfPeriod' => $previousPeriodStart->toDateString()]) }}" class="btn btn-primary w-100 w-sm-auto text-nowrap me-2">Vorige Periode</a>

            <!-- Weergave selecties: Dag, Week, Maand -->
            @foreach(['day', 'week', 'month'] as $period)
                <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => $period, 'startOfView' => $startOfView->format('Y-m-d')]) }}" class="btn btn-outline-primary {{ $view == $period ? 'active' : '' }} me-2 w-100 w-md-auto text-nowrap">{{ ucfirst($period) }}</a>
            @endforeach

            <!-- Volgende Periode -->
            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => $view, 'startOfPeriod' => $nextPeriodStart->toDateString()]) }}" class="btn btn-primary w-100 w-sm-auto text-nowrap">Volgende Periode</a>
        </div>
    </div>

    <div class="calendar px-3 py-4">
        @if($view == 'day')
            
            <div class="row calendar-day">
            @foreach($calendarDays as $day)
                <div class="col text-center font-weight-bold">{{ $day->format('l, j F') }}</div>
            @endforeach
        </div>
        <div class="row">
            @foreach($calendarDays as $day)
                <div class="col">
                    @foreach($sprintsByDate[$day->format('Y-m-d')] ?? [] as $sprint)
                        <div class="calendar-sprint bg-light p-1 rounded my-1">
                            <strong>{{ $sprint->name }}</strong><br>
                            <small>{{ $sprint->planned_start_date->format('d/m/y') }} - {{ $sprint->planned_end_date->format('d/m/y') }}</small>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        @elseif($view == 'week')
            <div class="row calendar-header">
                <div class="col-12 text-center">
                    <h4>{{ $startOfView->format('F Y') }}</h4>
                </div>
                @foreach(['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'] as $day)
                    <div class="col text-center font-weight-bold">{{ $day }}</div>
                @endforeach
            </div>

            <div class="row calendar-week">
                @foreach($calendarDays as $day)
                    <div class="col border p-2">
                        <div class="calendar-day-header">{{ $day->format('j') }}</div>
                        @foreach($sprintsByDate[$day->format('Y-m-d')] ?? [] as $sprint)
                            <div class="calendar-sprint bg-light p-1 rounded my-1">
                                <strong>{{ $sprint->name }}</strong><br>
                                <small>{{ $sprint->planned_start_date->format('d/m/y') }} - {{ $sprint->planned_end_date->format('d/m/y') }}</small>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

        @elseif($view == 'month')
            <div class="calendar-header row">
                <div class="col-12 text-center">
                    <h4>{{ $startOfView->format('F Y') }}</h4>
                </div>
                @foreach(['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'] as $day)
                    <div class="col text-center font-weight-bold">{{ $day }}</div>
                @endforeach
            </div>

            @php
                $firstDayOfMonth = $startOfView->copy()->startOfMonth();
                $startOfCalendar = $firstDayOfMonth->copy()->startOfWeek();

                $days = collect();
                for ($i = 0; $i < 42; $i++) {
                    $days->push($startOfCalendar->copy()->addDays($i));
                }
            @endphp

            @foreach($days->chunk(7) as $week)
                <div class="row calendar-month">
                    @foreach($week as $day)
                        <div class="col border p-2 {{ $day->month != $startOfView->month ? 'text-muted' : '' }}">
                            <div class="calendar-day-header">{{ $day->format('j') }}</div>
                            @foreach($sprintsByDate[$day->format('Y-m-d')] ?? [] as $sprint)
                                <div class="calendar-sprint bg-light p-1 rounded my-1">
                                    <strong>{{ $sprint->name }}</strong><br>
                                    <small>{{ $sprint->planned_start_date->format('d/m/y') }} - {{ $sprint->planned_end_date->format('d/m/y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>


<style>
    .calendar {
        font-family: 'Poppins', sans-serif;
        margin-top: 20px;
    }

    .calendar-header {
        margin-bottom: 10px;
        font-size: 1.1em;
    }

    .calendar-day-header {
        font-weight: bold;
        font-size: 1.2em;
        margin-bottom: 5px;
    }

    .calendar-month .col {
        padding: 10px;
        min-height: 120px;
        vertical-align: top;
        position: relative;
    }
    .calendar-month .col.text-muted {
        opacity: .5;
    }

    .calendar-sprint {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px;
        margin-top: 5px;
        font-size: 0.9em;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .calendar-sprint:hover {
        background-color: #ed6809;
        color: #1170fb;
        border-color: #ed6809;
        cursor: pointer;
    }

    .calendar-sprint strong {
        font-size: 1.1em;
        display: block;
    }

    .calendar-sprint small {
        color: #6c757d;
        display: block;
    }

    .btn-outline-primary, .btn-primary {
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-outline-primary:hover {
        background-color: #ed6809;
        color: white;
        border-color: #ed6809;
    }

    .btn-primary {
        background-color: #ed6809;
        border-color: #ed6809;
    }

    .btn-primary:hover {
        background-color: #e15d03;
        border-color: #e15d03;
    }

    @media (max-width: 991px) {
        .calendar-month .col {
            padding: 5px;
        }

        .calendar-header,
        .calendar-day-header {
            font-size: 1em;
        }

        .calendar-sprint {
            font-size: 0.8em;
        }

        .calendar-day {
            display: block !important;
        }
        .calendar-week, .calendar-month {
            display: block !important;
        }
        .calendar-week .col {
            display: block;
            width: 100%;
        }
    }
</style>

@endsection
