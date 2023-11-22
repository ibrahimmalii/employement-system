@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('Employees') }}</div>


                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h1>Employee</h1>
                            <form class="mt-3" action="{{ route('users.search') }}" method="get">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="query" value="{{ $query ?? '' }}">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>
                            </form>
                            @if(auth()->user()->isAdmin())
                                <a class="btn btn-primary mt-3" href="{{ route('users.create') }}">Add new employee</a>
                            @endif

                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Salary</th>
                                <th>Full Name</th>
                                <th>Manager</th>
                                @if(auth()->user()->isAdmin())
                                    <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <img style="width: 50px; height: 50px; border-radius: 50%" src="{{ asset($user->image ? 'storage/' . $user->image : 'storage/images/default.png') }}" alt="employee_img">
                                    </td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->salary }}</td>
                                    <td>{{ $user->fullName }}</td>
                                    <td>{{ $user->manager?->fullName ?? '' }}</td>
                                    @if(auth()->user()->isAdmin())
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="btn btn-secondary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                            {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
