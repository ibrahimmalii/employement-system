<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Couchbase\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(): View
    {
        $users = User::with(['department', 'manager'])->latest()->paginate(5);
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

        $validatedUser['manager_id'] = auth()->id();
        User::create($validatedUser);

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

    public function search(Request $request): View|Application|RedirectResponse|Redirector
    {
        $query = $request->input('query');

        if(!$query) {
            return redirect()->route('users.index');
        }

        $users = User::with(['department', 'manager'])
            ->where('first_name', 'like', '%' . $query . '%')
            ->orWhere('last_name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%')
            ->orWhere('salary', 'like', '%' . $query . '%')
            ->orWhereHas('department', fn ($q) => $q->where('name', 'like', '%' . $query . '%'))
            ->latest()->paginate(5);

        return view('users.index', compact('users', 'query'));
    }

    public function destroy(User $user): Redirector|Application|RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

}
