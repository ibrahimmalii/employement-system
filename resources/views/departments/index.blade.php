@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Departments') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <h1>Departments</h1>
                            <a class="btn btn-primary" href="{{ route('departments.create') }}">Add new departments</a>
                            <form class="mt-3" action="{{ route('departments.search') }}" method="get">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="query" value="{{ old('query') }}">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>
                            </form>
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
                                        <th>Name</th>
                                        <th>Employees Count</th>
                                        <th>Total salary</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departments as $department)
                                        <tr>
                                            <td>{{ $department->id }}</td>
                                            <td>{{ $department->name }}</td>
                                            <td>{{ $department->employees_count }}</td>
                                            <td>{{ $department->employees->sum('salary') }}</td>
                                            <td>
                                                <form action="{{ route('departments.destroy', $department->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a class="btn btn-secondary" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
