@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3>Takenlijst voor Scrumboard: {{ $scrumboard->title }}</h3>

        @if($sprints->isEmpty())
            <p>Er zijn momenteel geen sprints beschikbaar voor dit scrumboard.</p>
        @else
            @foreach($sprints as $sprint)
                <div class="mb-4">
                    <h4>{{ $sprint->name }}</h4>
                    <p>Gepland van {{ $sprint->planned_start_date->format('d-m-Y') }} tot {{ $sprint->planned_end_date->format('d-m-Y') }}</p>

                    @if($sprint->tasks->isEmpty())
                        <p>Geen taken in deze sprint.</p>
                    @else
                        <ul class="list-group">
                            @foreach($sprint->tasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $task->title }}</strong>
                                        <p class="mb-0">{{ $task->description }}</p>
                                    </div>
                                    <span class="badge {{ $task->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
