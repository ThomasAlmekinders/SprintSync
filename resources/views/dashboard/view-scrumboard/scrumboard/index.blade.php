@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3 class="mb-4">{{ $scrumboard->title }} - Scrumboard</h3>

        <div class="row d-flex align-items-stretch">
            @foreach (['to_do' => 'Te doen', 'in_progress' => 'Mee bezig', 'done' => 'Afgerond'] as $status => $label)
                <div class="col">
                    <h4 class="text-{{ $status === 'to_do' ? 'primary' : ($status === 'in_progress' ? 'warning' : 'success') }}">{{ $label }}</h4>
                    <div class="task-list border rounded p-2 sortable-list" id="list-{{ $status }}" style="background-color: #f9f9f9; height: calc(100% - 2.5rem);">
                        @foreach($sprints as $sprint)
                            @foreach($sprint->tasks as $task)
                                @if($task->status === $status)
                                    <div class="task bg-light border rounded p-2 mb-2 shadow-sm hover-shadow" data-task-id="{{ $task->id }}">
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
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sortable-list').forEach(sortableElement => {
            const scrumboardSlug = '{{ Str::slug($scrumboard->title) }}';
            const scrumboardId = '{{ $scrumboard->id }}';
            const sprintId = '{{ $sprint->id }}';

            const actionUrl = `{{ route('scrumboard.takenlijst.update-task-status', ['slug' => '__SLUG__', 'id' => '__ID__', 'sprintId' => '__SPRINT_ID__']) }}`;
            const finalUrl = actionUrl.replace('__SLUG__', scrumboardSlug)
                                       .replace('__ID__', scrumboardId)
                                       .replace('__SPRINT_ID__', sprintId);

            new Sortable(sortableElement, {
                group: 'tasks',
                animation: 150,
                onEnd: function (evt) {
                    const taskId = evt.item.getAttribute('data-task-id');
                    const newStatus = evt.to.id.replace('list-', '');

                    fetch(finalUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            task_id: taskId,
                            status: newStatus,
                        })
                    })
                    .then(response => response.json())
                    .catch(error => console.error('Error updating task:', error));
                }
            });
        });
    });
</script>


<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
