<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::withCount('employees')->latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        Department::create($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department created successfully');
    }

    public function show(Department $department): View
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->employees->isEmpty()) {
            $department->delete();
            return redirect()->route('departments.index')->with('success', 'Department deleted successfully');
        }
        return redirect()->route('departments.index')->with('error', 'Cannot delete department with assigned employees');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if(!$query) {
            return redirect()->route('departments.index');
        }

        $departments = Department::withCount('employees')
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return view('departments.index', compact('departments', 'query'));
    }
}
