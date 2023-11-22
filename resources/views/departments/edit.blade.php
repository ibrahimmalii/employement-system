@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Departments') }}</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('departments.update', $department->id) }}">
                            @csrf
                            @method('put')
                            <h1>Update department</h1>

                            <div>
                                <label>Name
                                <input class="form-control" type="text" name="name" value="{{ $department->name }}">
                                </label>
                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="description">Description:
                                    <textarea class="form-control" name="description" cols="200">{{ $department->description }}</textarea>
                                </label>
                                @error('description')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <button class="btn btn-success" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
