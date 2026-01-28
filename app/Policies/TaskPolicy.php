<?php

namespace App\Http\Requests;

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->isManager() || $user->id === $task->user_id;
    }

    public function update(User $user, Task $task): bool
    {
        // Only the owner can edit task details (but manager can change status)
        return $user->id === $task->user_id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function changeStatus(User $user, Task $task): bool
    {
        return $user->isManager();
    }
}
