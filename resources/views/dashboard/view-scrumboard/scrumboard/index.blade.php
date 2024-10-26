@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3 class="mb-4">{{ $scrumboard->title }} - Scrumboard</h3>

        <div class="row d-flex align-items-stretch">
            <div class="col">
                <h4 class="text-primary">Te doen</h4>
                <div class="task-list border rounded p-2" style="background-color: #f9f9f9; height: calc(100% - 2.5rem);">
                    @foreach($sprints as $sprint)
                        @foreach($sprint->tasks as $task)
                            @if($task->status === 'to_do')
                                <div class="task bg-light border rounded p-2 mb-2 shadow-sm hover-shadow">
                                    <div class="text-muted mb-1">
                                        <strong>{{ $sprint->name }}</strong>
                                    </div>
                                    <h6>{{ $task->title }}</h6>
                                    <p class="mb-0">{{ $task->description }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="col">
                <h4 class="text-warning">Mee bezig</h4>
                <div class="task-list border rounded p-2" style="background-color: #f9f9f9; height: calc(100% - 2.5rem);">
                    @foreach($sprints as $sprint)
                        @foreach($sprint->tasks as $task)
                            @if($task->status === 'in_progress')
                                <div class="task bg-light border rounded p-2 mb-2 shadow-sm hover-shadow">
                                    <div class="text-muted mb-1">
                                        <strong>{{ $sprint->name }}</strong>
                                    </div>
                                    <h6>{{ $task->title }}</h6>
                                    <p class="mb-0">{{ $task->description }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="col">
                <h4 class="text-success">Afgerond</h4>
                <div class="task-list border rounded p-2" style="background-color: #f9f9f9; height: calc(100% - 2.5rem);">
                    @foreach($sprints as $sprint)
                        @foreach($sprint->tasks as $task)
                            @if($task->status === 'done')
                                <div class="task bg-light border rounded p-2 mb-2 shadow-sm hover-shadow">
                                    <div class="text-muted mb-1">
                                        <strong>{{ $sprint->name }}</strong>
                                    </div>
                                    <h6>{{ $task->title }}</h6>
                                    <p class="mb-0">{{ $task->description }}</p>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
