@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4 d-flex justify-content-between align-items-center">
        <h3>Tijdlijn - {{ ucfirst($view) }} Overzicht</h3>
        <div>

            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => $view, 'startOfPeriod' => $previousPeriodStart->toDateString()]) }}" class="btn btn-primary">Vorige Periode</a>
           
            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => 'day', 'startOfView' => $startOfView->format('Y-m-d')]) }}" class="btn btn-outline-primary me-2">Dag</a>
            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => 'week', 'startOfView' => $startOfView->format('Y-m-d')]) }}" class="btn btn-outline-primary me-2">Week</a>
            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => 'month', 'startOfView' => $startOfView->format('Y-m-d')]) }}" class="btn btn-outline-primary">Maand</a>

            <a href="{{ route('scrumboard.tijdlijn', ['slug' => $scrumboard->title, 'id' => $scrumboard->id, 'view' => $view, 'startOfPeriod' => $nextPeriodStart->toDateString()]) }}" class="btn btn-primary">Volgende Periode</a>
        </div>
    </div>

    <div class="calendar px-3 py-4">
        @if($view == 'day')
            <!-- Dagweergave -->
            <div class="row calendar-day">
                <div class="col text-center font-weight-bold">{{ $calendarDays->first()->format('l, j F') }}</div>
            </div>
            <div class="row">
                <div class="col">
                    @foreach($sprintsByDate[$calendarDays->first()->format('Y-m-d')] ?? [] as $sprint)
                        <div class="calendar-sprint bg-light p-1 rounded my-1">
                            <strong>{{ $sprint->name }}</strong><br>
                            <small>{{ $sprint->planned_start_date->format('H:i') }} - {{ $sprint->planned_end_date->format('H:i') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif($view == 'week')
            <!-- Weekweergave -->
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
                                <small>{{ $sprint->planned_start_date->format('H:i') }} - {{ $sprint->planned_end_date->format('H:i') }}</small>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

        @elseif($view == 'month')
            <!-- Maandweergave -->
            <div class="calendar-header row">
                <div class="col-12 text-center">
                    <h4>{{ $startOfView->format('F Y') }}</h4>
                </div>
                @foreach(['Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za', 'Zo'] as $day)
                    <div class="col text-center font-weight-bold">{{ $day }}</div>
                @endforeach
            </div>

            <div class="calendar-month">
                @php
                    // Bepaal de eerste dag van de maand
                    $firstDayOfMonth = $startOfView->copy()->startOfMonth();
                    $firstDayOfWeek = $firstDayOfMonth->copy()->startOfWeek();  // Start van de week (maandag)
                    $daysFromPreviousMonth = collect();  // Lijst om de dagen van de vorige maand op te slaan

                    // Het aantal dagen dat we moeten terugkijken in de vorige maand (maximaal 6 dagen)
                    $daysFromPreviousMonthCount = 0;
                    $lastDayOfPreviousMonth = $firstDayOfWeek->copy()->subDay();  // Laatste dag van de vorige maand

                    // Voeg de dagen van de vorige maand toe, zolang we minder dan 6 dagen hebben toegevoegd
                    while ($lastDayOfPreviousMonth->month == $firstDayOfMonth->month - 1 && $daysFromPreviousMonthCount < 0) {
                        $daysFromPreviousMonth->push($lastDayOfPreviousMonth->copy()->format('Y-m-d'));
                        $lastDayOfPreviousMonth->subDay();
                        $daysFromPreviousMonthCount++;
                    }

                    // Verzamel de dagen van de huidige maand (november)
                    $daysOfCurrentMonth = collect();
                    $totalDays = 42;  // Maximaal aantal dagen in een maandweergave is 42 (6 weken)

                    // Voeg de dagen van de maand toe, na de dagen van oktober
                    for ($i = 0; $i < $totalDays - $daysFromPreviousMonthCount; $i++) {
                        $daysOfCurrentMonth->push($firstDayOfWeek->copy()->addDays($i)->format('Y-m-d'));
                    }
                @endphp

                <!-- Weergeven van de kalender -->
                @foreach($daysFromPreviousMonth->chunk(7)->toArray() as $week)
                    <div class="row">
                        @foreach($week as $day)
                            <div class="col border p-2">
                                @php
                                    $currentDay = \Carbon\Carbon::parse($day);
                                @endphp

                                <!-- Als het een dag van de vorige maand is, markeer dan met een andere kleur -->
                                <div class="calendar-day-header {{ $currentDay->month != $startOfView->month ? 'text-muted' : '' }}">
                                    {{ $currentDay->format('j') }}
                                </div>

                                @foreach($sprintsByDate[$day] ?? [] as $sprint)
                                    <div class="calendar-sprint bg-light p-1 rounded my-1">
                                        <strong>{{ $sprint->name }}</strong><br>
                                        <small>{{ $sprint->planned_start_date->format('H:i') }} - {{ $sprint->planned_end_date->format('H:i') }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <!-- Dagen van de huidige maand (november) -->
                @foreach($daysOfCurrentMonth->chunk(7)->toArray() as $week)
                    <div class="row">
                        @foreach($week as $day)
                            <div class="col border p-2">
                                @php
                                    $currentDay = \Carbon\Carbon::parse($day);
                                @endphp

                                <div class="calendar-day-header {{ $currentDay->month != $startOfView->month ? 'text-muted' : '' }}">
                                    {{ $currentDay->format('j') }}
                                </div>

                                @foreach($sprintsByDate[$day] ?? [] as $sprint)
                                    <div class="calendar-sprint bg-light p-1 rounded my-1">
                                        <strong>{{ $sprint->name }}</strong><br>
                                        <small>{{ $sprint->planned_start_date->format('H:i') }} - {{ $sprint->planned_end_date->format('H:i') }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
    .calendar-header{
        background-color: #007bff;
        color: white;
        padding: 8px 0;
    }

    .calendar-week .col, .calendar-month .col {
        min-height: 120px;
        position: relative;
    }

    .calendar-day-header {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .calendar-sprint {
        font-size: 0.9rem;
        background-color: #f8f9fa;
    }
</style>

@endsection
