<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        if ($status && !in_array($status, ['pending', 'in_progress', 'done'])) {
            return response()->json(['message' => 'Invalid status value'], 422);
        }

        $query = Task::orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 END")
            ->orderBy('due_date', 'asc');

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found', 'tasks' => []]);
        }

        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'count' => $tasks->count(),
            'tasks' => $tasks,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create(array_merge($request->validated(), ['status' => 'pending']));

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $transitions = [
            'pending' => 'in_progress',
            'in_progress' => 'done',
        ];

        if ($task->status === 'done') {
            return response()->json(['message' => 'Task is already completed'], 422);
        }

        $next = $transitions[$task->status] ?? null;

        if ($request->status !== $next) {
            return response()->json([
                'message' => 'Status can only move forward: pending to in_progress, then in_progress to done',
            ], 422);
        }

        $task->update(['status' => $request->status]);

        return response()->json([
            'message' => "Task status updated to {$request->status}",
            'task' => $task->fresh(),
        ]);
    }

    public function destroy(Task $task)
    {
        if ($task->status !== 'done') {
            return response()->json([
                'message' => 'Only completed tasks can be deleted',
                'status' => 'forbidden',
            ], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function report(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $date = $request->query('date');
        $tasks = Task::whereDate('due_date', $date)->get();

        $summary = [];
        foreach (['high', 'medium', 'low'] as $priority) {
            foreach (['pending', 'in_progress', 'done'] as $status) {
                $summary[$priority][$status] = 0;
            }
        }

        foreach ($tasks as $task) {
            $summary[$task->priority][$task->status]++;
        }

        return response()->json([
            'date' => $date,
            'summary' => $summary,
            'total_tasks' => $tasks->count(),
        ]);
    }
}
