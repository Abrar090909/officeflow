@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <h6 class="text-muted">Tasks Needing Review</h6>
            <h2 class="fw-bold mb-0">{{ $tasks->whereIn('status', ['Pending', 'In Review'])->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3 text-success">
            <h6 class="text-muted">Approved Today</h6>
            <h2 class="fw-bold mb-0">{{ $tasks->where('status', 'Approved')->where('updated_at', '>=', now()->startOfDay())->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3 text-danger">
            <h6 class="text-muted">High Priority Tasks</h6>
            <h2 class="fw-bold mb-0">{{ $tasks->where('priority', 'High')->count() }}</h2>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold border-0 pt-3 d-flex justify-content-between align-items-center">
        <span>Approval List</span>
        <div class="d-flex gap-2">
            <select id="filter-category" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Categories</option>
                <option value="Bug">Bug</option>
                <option value="Feature">Feature</option>
                <option value="Support">Support</option>
            </select>
            <div class="input-group input-group-sm w-50">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" id="manager-search" class="form-control bg-light border-start-0" placeholder="Search...">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 15%">Employee</th>
                        <th style="width: 40%">Task Details</th>
                        <th style="width: 10%">Category</th>
                        <th style="width: 10%">Priority</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td class="fw-bold text-primary">{{ $task->user->name }}</td>
                        <td>
                            <div class="fw-bold mb-1">{{ $task->title }}</div>
                            <div class="small text-muted">{{ Str::limit($task->description, 100) }}</div>
                            @if($task->due_date)
                                <div class="mt-1 small">
                                    <i class="bi bi-clock"></i> Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                </div>
                            @endif
                            @if($task->attachment_path)
                                <div class="mt-1">
                                    <a href="{{ Storage::url($task->attachment_path) }}" target="_blank" class="small text-decoration-none">
                                        <i class="bi bi-paperclip"></i> Attachment
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td class="category-cell"><span class="badge bg-light text-dark border">{{ $task->category }}</span></td>
                        <td>
                            @php $pClass = $task->priority == 'High' ? 'danger' : ($task->priority == 'Medium' ? 'warning' : 'info'); @endphp
                            <span class="badge rounded-pill bg-{{ $pClass }} text-dark">{{ $task->priority }}</span>
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
                            <span id="status-{{ $task->id }}" class="badge bg-{{ $sClass }}">{{ $task->status }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-success update-status" data-id="{{ $task->id }}" data-status="Approved">Approve</button>
                                    <button class="btn btn-danger update-status" data-id="{{ $task->id }}" data-status="Rejected">Reject</button>
                                </div>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control comment-input" placeholder="Feedback...">
                                    <button class="btn btn-primary add-comment" data-id="{{ $task->id }}">
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                        Send
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('activity_feed')
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white fw-bold border-0 pt-3 text-uppercase small letter-spacing-1">Activity Stream (Manager)</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @forelse($activities as $activity)
                <div class="list-group-item px-0 border-0 mb-2">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <span class="fw-bold text-dark small">
                            <i class="bi bi-lightning-fill text-warning me-1"></i> {{ $activity->user->name }}
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
                <div class="text-center py-3 text-muted small">All quiet across the system.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#manager-search, #filter-category').on('keyup change', function() {
        var searchValue = $('#manager-search').val().toLowerCase();
        var categoryValue = $('#filter-category').val();

        $("tbody tr").filter(function() {
            var textMatch = $(this).text().toLowerCase().indexOf(searchValue) > -1;
            var categoryMatch = categoryValue === "" || $(this).find('.category-cell').text().trim() === categoryValue;
            $(this).toggle(textMatch && categoryMatch);
        });
    });

    $('.update-status').click(function() {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var btn = $(this);
        
        $.ajax({
            url: "/api/tasks/" + id + "/status",
            type: "PUT",
            data: { status: status },
            success: function(response) {
                showMessage(response.message);
                var sClass = status == 'Approved' ? 'success' : 'danger';
                $('#status-' + id).text(status).attr('class', 'badge bg-' + sClass);
            }
        });
    });

    $('.add-comment').click(function() {
        var id = $(this).data('id');
        var btn = $(this);
        var input = btn.siblings('.comment-input');
        var content = input.val();
        if(!content) return;

        btn.prop('disabled', true).find('.spinner-border').removeClass('d-none');

        $.ajax({
            url: "/api/tasks/" + id + "/comments",
            type: "POST",
            data: { content: content },
            success: function(response) {
                btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
                showMessage(response.message);
                input.val('');
                location.reload(); 
            },
            error: function() {
                btn.prop('disabled', false).find('.spinner-border').addClass('d-none');
            }
        });
    });
});
</script>
@endsection
