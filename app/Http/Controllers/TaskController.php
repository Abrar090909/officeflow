<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Activity;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = Auth::user()->tasks()
            ->with('comments.user')
            ->orderByRaw("CASE WHEN priority = 'High' THEN 1 WHEN priority = 'Medium' THEN 2 ELSE 3 END")
            ->latest()
            ->get();
            
        $activities = Activity::with('user', 'task')->latest()->take(10)->get();

        return view('employee.dashboard', compact('tasks', 'activities'));
    }

    public function indexApi()
    {
        $tasks = Auth::user()->tasks()
            ->with('comments.user')
            ->orderByRaw("CASE WHEN priority = 'High' THEN 1 WHEN priority = 'Medium' THEN 2 ELSE 3 END")
            ->latest()
            ->get();
            
        return response()->json($tasks);
    }

    public function managerIndex()
    {
        $tasks = Task::with(['user', 'comments.user'])
            ->orderByRaw("CASE WHEN priority = 'High' THEN 1 WHEN priority = 'Medium' THEN 2 ELSE 3 END")
            ->latest()
            ->get();
            
        $activities = Activity::with('user', 'task')->latest()->take(10)->get();

        return view('manager.dashboard', compact('tasks', 'activities'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully!',
                'task' => $task
            ]);
        }

        return back()->with('success', 'Task created successfully!');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task = $this->taskService->updateTask($task, $request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task
            ]);
        }

        return back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('changeStatus', $task);

        $request->validate([
            'status' => 'required|string',
        ]);

        $this->taskService->updateStatus($task, $request->status);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated to ' . $request->status,
            'task' => $task
        ]);
    }
}
