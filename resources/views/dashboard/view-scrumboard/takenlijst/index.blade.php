@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3>Takenlijst</h3>
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSprintModal">Nieuwe Sprint Aanmaken</a>

        <div id="sprintAccordion">
            @foreach($sprints as $index => $sprint)
                <div class="accordion-item card mb-5">
                    <h2 class="accordion-header card-header" id="heading-{{ $sprint->id }}">
                        <input type="hidden" name="scrumboard_id" value="{{ $scrumboard->id }}">
                        <input type="hidden" name="sprint_id" value="{{ $sprint->id }}">
                        <input type="hidden" name="scrumboard_title" value="{{ Str::slug($scrumboard->title) }}">
                        <div class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $sprint->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $sprint->id }}">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <h5 class="mb-0 font-weight-bold">{{ $sprint->name }}</h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($sprint->planned_start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($sprint->planned_end_date)->format('d M Y') }}</small>
                                </div>
                                <form action="{{ route('scrumboard.takenlijst.delete-sprint', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'sprintId' => $sprint->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm ms-3" onclick="return confirm('Weet je zeker dat je deze sprint wilt verwijderen?')">Verwijderen</button>
                                </form>
                            </div>
                        </div>
                    </h2>

                    <div id="collapse-{{ $sprint->id }}" class="accordion-collapse collapse show {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $sprint->id }}" style="padding: 1rem;">
                        <div class="accordion-body">
                            <div class="task-list sortable" id="sortable-{{ $sprint->id }}" data-sprint-slug="{{ Str::slug($scrumboard->title) }}" data-sprint-scrumbord-id="{{ $scrumboard->id }}" data-sprint-id="{{ $sprint->id }}">
                                @foreach($sprint->tasks as $task)
                                    <div class="card task-card mb-3 border-0 shadow-sm" data-id="{{ $task->id }}" draggable="true">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="card-title mb-1">{{ $task->title }}</h6>
                                                <span class="badge 
                                                    @if($task->status === 'todo') bg-danger 
                                                    @elseif($task->status === 'in_progress') bg-warning 
                                                    @else bg-success 
                                                    @endif
                                                    ">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </div>
                                            <p class="card-text text-muted">{{ $task->description }}</p>
                                            <a href="#" 
                                                class="btn text-primary edit-task-button" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#createTaskModal"
                                                data-sprint-slug="{{ Str::slug($scrumboard->title) }}"
                                                data-sprint-scrumbord-id="{{ $scrumboard->id }}"
                                                data-sprint-id="{{ $sprint->id }}"
                                                data-task-id="{{ $task->id }}"
                                                data-task-title="{{ $task->title }}"
                                                data-task-description="{{ $task->description }}"
                                                data-task-status="{{ $task->status }}">
                                                Bewerken
                                            </a>
                                            <form action="{{ route('scrumboard.takenlijst.delete-task', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'sprintId' => $sprint->id, 'taskId' => $task->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn text-danger" onclick="return confirm('Weet je zeker dat je deze taak wilt verwijderen?')">Verwijderen</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button class="btn btn-outline-primary mt-3 createTaskButton"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#createTaskModal" 
                                    data-sprint-slug="{{ Str::slug($scrumboard->title) }}"
                                    data-sprint-scrumbord-id="{{ $scrumboard->id }}"
                                    data-sprint-id="{{ $sprint->id }}">
                                <span>Taak Toevoegen</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sortable').forEach(sortableElement => {
            const srumboardSlug = sortableElement.getAttribute('data-sprint-slug');
            const scrumboardId = sortableElement.getAttribute('data-sprint-scrumbord-id');
            const sprintId = sortableElement.getAttribute('data-sprint-id');

            const actionUrl = `{{ route('scrumboard.takenlijst.update-task-order', ['slug' => '__SLUG__', 'id' => '__ID__', 'sprintId' => '__SPRINT_ID__']) }}`;
            const finalUrl = actionUrl.replace('__SLUG__', srumboardSlug)
                                        .replace('__ID__', scrumboardId)
                                        .replace('__SPRINT_ID__', sprintId);

            new Sortable(sortableElement, {
                animation: 150,
                onEnd: function () {
                    const orderedTaskIds = Array.from(sortableElement.children).map(item => item.getAttribute('data-id'));

                    fetch(finalUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            task_order: orderedTaskIds 
                        })
                    })
                    .then(response => {
                        return response.text().then(text => {
                            console.log("Response text:", text);
                            return JSON.parse(text);
                        });
                    })
                    .then(data => {
                        console.log('Order updated:', data);
                    })
                    .catch(error => console.error('Error updating order:', error));
                }
            });
        });
    });
</script>
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        const editTaskButtons = document.querySelectorAll('.edit-task-button');

        editTaskButtons.forEach(button => {
            button.addEventListener('click', function() {
                openEditTaskModal(this);
            });
        });

        function openEditTaskModal(editTaskButton) {
            const sprintSlug = editTaskButton.getAttribute('data-sprint-slug');
            const scrumboardId = editTaskButton.getAttribute('data-sprint-scrumbord-id');
            const sprintId = editTaskButton.getAttribute('data-sprint-id');
            const taskId = editTaskButton.getAttribute('data-task-id');
            const taskTitle = editTaskButton.getAttribute('data-task-title');
            const taskDescription = editTaskButton.getAttribute('data-task-description');
            const taskStatus = editTaskButton.getAttribute('data-task-status');

            const actionUrl = `{{ route('scrumboard.takenlijst.edit-task', ['slug' => '__SLUG__', 'id' => '__ID__', 'sprintId' => '__SPRINT_ID__', 'taskId' => '__TASK_ID__']) }}`;
            const finalUrl = actionUrl.replace('__SLUG__', sprintSlug)
                                        .replace('__ID__', scrumboardId)
                                        .replace('__SPRINT_ID__', sprintId)
                                        .replace('__TASK_ID__', taskId);

            document.getElementById('createTaskForm').setAttribute('action', finalUrl);
            document.getElementById('createTaskHiddenId').setAttribute('value', sprintId);

            document.getElementById('createTask-title').setAttribute('value', taskTitle);
            document.getElementById('createTask-description').innerHTML = taskDescription;
            document.getElementById('createTask-status').setAttribute('value', taskStatus);
        }
    });
</script>
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        const createTaskButtons = document.querySelectorAll('.createTaskButton');

        createTaskButtons.forEach((button) => {
            button.addEventListener('click', function() {
                openCreateTaskModal(this);
            });
        });

        function openCreateTaskModal(createTaskButton) {
            const sprintSlug = createTaskButton.getAttribute('data-sprint-slug');
            const scrumboardId = createTaskButton.getAttribute('data-sprint-scrumbord-id');
            const sprintId = createTaskButton.getAttribute('data-sprint-id');

            const actionUrl = `{{ route('scrumboard.takenlijst.create-task', ['slug' => '__SLUG__', 'id' => '__ID__', 'sprintId' => '__SPRINT_ID__']) }}`;
            const finalUrl = actionUrl
                .replace('__SLUG__', sprintSlug)
                .replace('__ID__', scrumboardId)
                .replace('__SPRINT_ID__', sprintId);

            console.log("action url: ", finalUrl);

            document.getElementById('createTaskForm').setAttribute('action', finalUrl);
            document.getElementById('createTaskHiddenId').setAttribute('value', sprintId);

            document.getElementById('createTask-title').setAttribute('value', "");
            document.getElementById('createTask-description').setAttribute('value', "");
            document.getElementById('createTask-description').innerHTML = "";
            document.getElementById('createTask-status').setAttribute('value', "to_do");
        }
    });
</script>

<!-- Modal for adding a new task -->
<div class="modal fade" id="createTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="createTaskModalLabel">Nieuwe Taak Aanmaken</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <form id="createTaskForm" method="POST" action="">
                @csrf
                <input type="hidden" id='createTaskHiddenId' name="sprint_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createTask-title">Taak Titel *</label>
                        <input type="text" class="form-control" id="createTask-title" name="createTitle" required placeholder="Voer de taak titel in">
                    </div>
                    <div class="form-group">
                        <label for="createTask-description">Taak Beschrijving</label>
                        <textarea class="form-control" id="createTask-description" name="createDescription" rows="3" placeholder="Voer hier de taak beschrijving in"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="createTask-status">Status *</label>
                        <select class="form-control" id="createTask-status" name="createStatus" required>
                            <option value="" disabled selected>Kies een status</option>
                            <option value="to_do">Te Doen</option>
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



<!-- Modal for creating a new sprint -->
<div class="modal fade" id="createSprintModal" tabindex="-1" role="dialog" aria-labelledby="createSprintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="createSprintModalLabel">Nieuwe Sprint Aanmaken</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
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

<style>
    .accordion-header {
        transition: background-color 0.2s ease;
    }
    .accordion-header:hover {
        background-color: #e4e4e4;
    }

    .task-card.dragging {
        opacity: 0.5;
    }
</style>
@endsection
