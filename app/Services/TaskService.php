<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity;

class TaskService
{
    public function createTask(array $data)
    {
        if (isset($data['attachment'])) {
            $data['attachment_path'] = $data['attachment']->store('task_attachments', 'public');
            unset($data['attachment']);
        }

        $task = Auth::user()->tasks()->create($data);

        Activity::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'type' => 'created',
            'description' => "created task: " . $task->title,
        ]);

        return $task;
    }

    public function updateTask(Task $task, array $data)
    {
        if (isset($data['attachment'])) {
            // Delete old attachment if exists
            if ($task->attachment_path) {
                Storage::disk('public')->delete($task->attachment_path);
            }
            $data['attachment_path'] = $data['attachment']->store('task_attachments', 'public');
            unset($data['attachment']);
        }

        // Log Activity if status changed
        if (isset($data['status']) && $data['status'] !== $task->status) {
            Activity::create([
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'type' => 'status_updated',
                'description' => "changed status to " . $data['status'] . " for: " . $task->title,
            ]);
        }

        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        if ($task->attachment_path) {
            Storage::disk('public')->delete($task->attachment_path);
        }
        return $task->delete();
    }

    public function updateStatus(Task $task, string $status)
    {
        Activity::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'type' => 'status_updated',
            'description' => "marked task as " . $status,
        ]);

        return $task->update(['status' => $status]);
    }
}
