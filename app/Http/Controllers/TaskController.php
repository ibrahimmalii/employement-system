<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Enums\TaskStatusEnum;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }


    public function index(): View
    {
        $status = TaskStatusEnum::getStatuses();

        $tasks = Task::with('employee');

        if (auth()->user()->role == RolesEnum::ADMIN->value) {
            $tasks->whereHas('employee', function ($query) {
                $query->where('manager_id', auth()->id());
            });
        } else {
            $tasks->where('employee_id', auth()->id());
        }

        $tasks = $tasks->latest()->paginate(5);

        return view('tasks.index', compact('tasks', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $employees = User::where('manager_id', auth()->id())->get();
        $status = TaskStatusEnum::getStatuses();
        return view('tasks.create', compact('employees', 'status'));
    }


    public function store(TaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }


    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::enum(TaskStatusEnum::class)],
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
