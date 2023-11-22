<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Couchbase\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('department')->latest()->paginate(5);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $managers = User::where('role', RolesEnum::ADMIN->value)->select('id', 'first_name', 'last_name', 'role')->get();
        $departments = Department::all('id', 'name');
        return view('users.create', compact('managers', 'departments'));
    }

    public function store(StoreUserRequest $request)
    {
        $validatedUser = $request->validated();
        if ($request->hasFile('image')) {
            $validatedUser['image'] = $request->file('image')->store('images', 'public');
        }

        auth()->user()->create($validatedUser);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $managers = User::where('role', RolesEnum::ADMIN)->get();
        $departments = Department::all('id', 'name');
        return view('users.edit', compact('user', 'managers', 'departments'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedUser = $request->validated();

        if ($request->hasFile('image')) {
            $validatedUser['image'] = $request->file('image')->store('images', 'public');
        }

        $user->update($validatedUser);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function search()
    {

    }

    public function destroy(User $user): Redirector|Application|RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

}
