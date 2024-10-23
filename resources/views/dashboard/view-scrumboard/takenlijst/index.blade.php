@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3>Takenlijst</h3>

        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSprintModal">Nieuwe Sprint Aanmaken</a>

        @foreach($sprints as $sprint)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">{{ $sprint->name }}</h5>
                    <small>{{ \Carbon\Carbon::parse($sprint->planned_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($sprint->planned_end_date)->format('d M Y') }}</small>
                </div>
                <div class="card-body">
                    <div class="task-list" id="sortable-{{ $sprint->id }}">
                        @foreach($sprint->tasks as $task)
                            <div class="card task-card mb-3" data-id="{{ $task->id }}" draggable="true">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $task->title }}</h6>
                                    <p class="card-text">{{ $task->description }}</p>
                                    <p class="text-muted">Status: {{ $task->status }}</p>
                                    <a href="{{ route('scrumboard.takenlijst.edit-task', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'taskId' => $task->id]) }}">
                                        Bewerken
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-secondary mt-3 add-task-btn" data-bs-toggle="modal" data-bs-target="#addTaskModal-{{ $sprint->id }}" data-sprint-id="{{ $sprint->id }}">Taak Toevoegen</button>
                    
                    <!-- Modal for adding a new task -->
                    <div class="modal fade" id="addTaskModal-{{ $sprint->id }}" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTaskModalLabel">Nieuwe Taak Aanmaken</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addTaskForm-{{ $sprint->id }}" method="POST" action="{{ route('scrumboard.takenlijst.create-task', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'sprintId' => $sprint->id]) }}">
                                    @csrf
                                    <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="task-title">Taak Titel *</label>
                                            <input type="text" class="form-control" id="task-title" name="title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="task-description">Taak Beschrijving</label>
                                            <textarea class="form-control" id="task-description" name="description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="task-status">Status *</label>
                                            <select class="form-control" id="task-status" name="status" required>
                                                <option value="todo">Te Doen</option>
                                                <option value="in_progress">In Behandeling</option>
                                                <option value="done">Klaar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                        <button type="submit" class="btn btn-primary">Taak Aanmaken</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal for creating a new sprint -->
<div class="modal fade" id="createSprintModal" tabindex="-1" role="dialog" aria-labelledby="createSprintModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSprintModalLabel">Nieuwe Sprint Aanmaken</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createSprintForm" method="POST" action="{{ route('scrumboard.takenlijst.create-sprint', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sprint-name">Sprint Naam *</label>
                        <input type="text" class="form-control" id="sprint-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="sprint-description">Sprint beschrijving</label>
                        <textarea class="form-control" id="sprint-description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="planned-start-date">Geplande Startdatum *</label>
                        <input type="date" class="form-control" id="planned-start-date" name="planned_start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="planned-end-date">Geplande Einddatum *</label>
                        <input type="date" class="form-control" id="planned-end-date" name="planned_end_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-primary">Sprint Aanmaken</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
