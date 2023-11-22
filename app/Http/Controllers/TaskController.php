<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Enums\TaskStatusEnum;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = TaskStatusEnum::getStatuses();
        if(auth()->user()->role == RolesEnum::ADMIN->value) {
            $tasks = Task::with(['employee' => function($query) {
                $query->where('manager_id', auth()->id());
            }])->latest()->paginate(5);
        } else {
            $tasks = Task::with('employee')->where('employee_id', auth()->id())
                ->latest()->paginate(10);
        }
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::enum(TaskStatusEnum::class)],
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
