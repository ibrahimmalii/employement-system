@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2>Tasks</h2>
                    <table class="table-hover" style="padding: 5px">
                        <thead>
                            <tr>
                                <th style="padding: 5px">Name</th>
                                <th style="padding: 5px">Description</th>
                                <th style="padding: 5px">Employee</th>
                                <th style="padding: 5px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td style="padding: 5px">{{ $task->name }}</td>
                                    <td style="padding: 5px">{{ $task->description }}</td>
                                    <td style="padding: 5px">{{ $task->employee->fullName }}</td>
                                    <td style="padding: 5px">
                                        <form method="post" action="{{ route('tasks.update', $task->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status">
                                                @foreach($status as $st)
                                                    <option value="{{ $st }}" {{ $task->status == $st->value ? 'selected' : '' }}>{{ $st->value }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit">Update</button>
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
