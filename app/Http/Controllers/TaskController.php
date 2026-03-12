<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $categories = $user->categories()->pluck('name', 'id');

        $status = $request->status;
        $categoryId = $request->category_id;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $query = $user->tasks()->with('category')
            ->when($request->status == 'completed', fn($query) => $query->whereNotNull('completed_at'))
            ->when($request->status === 'incomplete', fn($query) => $query->whereNull('completed_at'))
            ->when($request->filled('category_id'), fn($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('task_date', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('task_date', '<=', $request->date_to))
            ->latest();


        $tasks = $query->paginate();
        $categories = $user->categories()->orderBy('name')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'statusFilter' => $status,
            'categoryFilter' => $categoryId,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = $request->user()->categories()->orderBy('name')->get();
        return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTaskRequest $request
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        // ensure boolean
        $data['is_recurring'] = isset($data['is_recurring']) ? (bool) $data['is_recurring'] : false;
        $request->user()->tasks()->create($data);

        return to_route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task)
    {
        $categories = $request->user()->categories()->orderBy('name')->get();
        return view('tasks.edit', ['task' => $task, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $data['is_recurring'] = isset($data['is_recurring']) ? (bool) $data['is_recurring'] : false;
        $task->update($data);

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return to_route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle completion status of the task.
     */
    public function toggle(Task $task)
    {
        if ($task->completed_at) {
            $task->update(['completed_at' => null]);
            $message = 'Task marked as pending.';
        } else {
            $task->update(['completed_at' => now()]);
            $message = 'Task marked as completed.';
        }

        return back()->with('success', $message);
    }
}
