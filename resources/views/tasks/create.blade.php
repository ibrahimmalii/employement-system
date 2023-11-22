@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tasks') }}</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('tasks.store') }}">
                            @csrf
                            <h1>Add new task</h1>

                            <div class="d-flex">
                                <label class="flex-grow-1" for="name">Name:
                                    <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <strong>{{ $message }}</strong>
                                    @enderror
                                </label>
                            </div>
                            <div class="d-flex mt-3">
                                <label class="flex-grow-1" for="description">Description:
                                    <textarea class="form-control" name="description" cols="50">{{ old('description') }}</textarea>
                                    @error('description')
                                        <strong>{{ $message }}</strong>
                                    @enderror
                                </label>
                            </div>
                            <div class="d-flex mt-3">
                                <label class="flex-grow-1" for="employee">Employee:
                                    <select class="form-select" name="employee_id">
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="flex-grow-1" for="status">Status:
                                    <select class="form-select" name="status">
                                        @foreach($status as $st)
                                            <option value="{{ $st }}">{{ $st->value }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                            <button class="btn btn-primary mt-3" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
