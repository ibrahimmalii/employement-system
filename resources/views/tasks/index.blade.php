@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tasks') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h2>Tasks</h2>
                        <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add new task</a>
                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Employee Name</th>
                                <th>Employee Email</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->employee->fullName }}</td>
                                    <td>{{ $task->employee->email }}</td>
                                    <td>
                                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select class="form-select" name="status">
                                                @foreach($status as $st)
                                                    <option value="{{ $st }}" {{ $task->status == $st->value ? 'selected' : '' }}>{{ $st->value }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="submit">Update</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
