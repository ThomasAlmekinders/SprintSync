
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
                            <div class="card task-card mb-3" data-id="{{ $task->id }}">
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
                        <textarea type="text" class="form-control" id="sprint-description" name="description"></textarea>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(function() {
    @foreach($sprints as $sprint)
        $("#sortable-{{ $sprint->id }}").sortable({
            update: function(event, ui) {
                let orderedIds = $(this).sortable('toArray');
                $.ajax({
                    url: '{{ route("scrumboard.takenlijst.update-task-order", ["slug" => Str::slug($scrumboard->title), "id" => $scrumboard->id, "taskId" => $task->id]) }}',
                    method: 'POST',
                    data: {
                        order: orderedIds,
                        sprint_id: {{ $sprint->id }},
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            }
        });
    @endforeach
});
</script>
@endsection
