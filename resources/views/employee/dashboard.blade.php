@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 bg-primary text-white text-center p-3">
            <h6 class="mb-0">Total Tasks</h6>
            <h2 class="mb-0 fw-bold">{{ $tasks->count() }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-warning text-dark text-center p-3">
            <h6 class="mb-0">Pending</h6>
            <h2 class="mb-0 fw-bold">{{ $tasks->where('status', 'Pending')->count() }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-info text-white text-center p-3">
            <h6 class="mb-0">In Review</h6>
            <h2 class="mb-0 fw-bold">{{ $tasks->where('status', 'In Review')->count() }}</h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-success text-white text-center p-3">
            <h6 class="mb-0">Approved</h6>
            <h2 class="mb-0 fw-bold">{{ $tasks->where('status', 'Approved')->count() }}</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">Create New Task</div>
            <div class="card-body">
                <form id="create-task-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="e.g. Bug fix in login repo">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label small fw-bold">Priority</label>
                            <select class="form-select form-select-sm" id="priority" name="priority" required>
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label small fw-bold">Category</label>
                            <select class="form-select form-select-sm" id="category" name="category" required>
                                <option value="Bug">Bug</option>
                                <option value="Feature">Feature</option>
                                <option value="Support">Support</option>
                                <option value="General" selected>General</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label small fw-bold">Due Date</label>
                        <input type="date" class="form-control form-control-sm" id="due_date" name="due_date">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Description</label>
                        <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="Provide details about the task..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment (Optional)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        <div class="form-text">PDF, Doc, or Image (Max 5MB)</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="submit-task-btn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3 d-flex justify-content-between align-items-center">
                <span>Task Queue</span>
                <div class="d-flex gap-2">
                    <select id="filter-priority" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">All Priorities</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    <div class="input-group input-group-sm w-50">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="task-search" class="form-control bg-light border-start-0" placeholder="Search tasks...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Task Details</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="task-list">
                            @forelse($tasks as $task)
                            <tr id="task-{{ $task->id }}">
                                <td>
                                    <div class="fw-bold">{{ $task->title }}</div>
                                    <div class="small text-muted mb-1">{{ Str::limit($task->description, 60) }}</div>
                                    @if($task->attachment_path)
                                        <a href="{{ Storage::url($task->attachment_path) }}" target="_blank" class="small text-decoration-none">
                                            <i class="bi bi-paperclip"></i> Attachment
                                        </a>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $task->category }}</span></td>
                                <td class="priority-cell">
                                    @php
                                        $pClass = $task->priority == 'High' ? 'danger' : ($task->priority == 'Medium' ? 'warning' : 'info');
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $pClass }} text-dark">{{ $task->priority }}</span>
                                </td>
                                <td>
                                    @if($task->due_date)
                                        @php $isOverdue = $task->due_date < now()->toDateString() && $task->status !== 'Approved'; @endphp
                                        <span class="small {{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                            @if($isOverdue) <i class="bi bi-exclamation-triangle"></i> @endif
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $sClass = match($task->status) {
                                            'Pending' => 'secondary',
                                            'In Review' => 'info',
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            default => 'dark'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $sClass }}">{{ $task->status }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger delete-task" data-id="{{ $task->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted border-0">No tasks created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('activity_feed')
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white fw-bold border-0 pt-3">System Activity Feed</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @forelse($activities as $activity)
                <div class="list-group-item px-0 border-0 mb-2">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <span class="fw-bold text-dark small">
                            <i class="bi bi-person-circle text-primary me-1"></i> {{ $activity->user->name }}
                        </span>
                        <span class="text-muted" style="font-size: 0.7rem;">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="ps-4">
                        <span class="small text-secondary">{{ $activity->description }}</span>
                        @if($activity->task)
                            <span class="badge bg-light text-muted border-0 small ms-1">#{{ $activity->task->id }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-3 text-muted small">No recent activity detected.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#task-search, #filter-priority').on('keyup change', function() {
        var searchValue = $('#task-search').val().toLowerCase();
        var priorityValue = $('#filter-priority').val();

        $("#task-list tr").filter(function() {
            var textMatch = $(this).text().toLowerCase().indexOf(searchValue) > -1;
            var priorityMatch = priorityValue === "" || $(this).find('.priority-cell').text().trim() === priorityValue;
            $(this).toggle(textMatch && priorityMatch);
        });
    });

    $('#create-task-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = $('#submit-task-btn');
        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        $.ajax({
            url: "/api/tasks",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showMessage(response.message);
                location.reload(); 
            },
            error: function(xhr) {
                btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
                var errors = xhr.responseJSON.errors;
                var errMsg = xhr.responseJSON.message;
                if(errors) {
                    errMsg = Object.values(errors).flat().join('<br>');
                }
                showMessage(errMsg, 'danger');
            }
        });
    });

    $(document).on('click', '.delete-task', function() {
        if(!confirm('Permanently delete this task?')) return;
        var id = $(this).data('id');
        $.ajax({
            url: "/api/tasks/" + id,
            type: "DELETE",
            success: function(response) {
                showMessage(response.message);
                $('#task-' + id).fadeOut(function() { $(this).remove(); });
            }
        });
    });
});
</script>
@endsection
