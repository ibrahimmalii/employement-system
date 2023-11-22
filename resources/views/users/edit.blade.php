@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                        <h1>Update Employee</h1>

                        @if(session('errors'))
                            @foreach(session('errors') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="input-group d-flex mt-3">
                                <label class="flex-grow-1" for="first_name">First Name:
                                    <input class="form-control" type="text" name="first_name" value="{{ $user->first_name }}" required>
                                    @error('first_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                                <label class="flex-grow-1" for="last_name">Last Name:
                                    <input class="form-control" type="text" name="last_name" value="{{ $user->last_name }}">
                                    @error('last_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                                <label class="flex-grow-1" for="email">Email:
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                                    @error('email')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                            </div>
                            <div class="input-group d-flex mt-3">
                                <label class="flex-grow-1" for="phone">Phone:
                                    <input class="form-control" type="text" name="phone" value="{{ $user->phone }}" required>
                                    @error('phone')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                                <label class="flex-grow-1" for="salary">Salary:
                                    <input class="form-control" type="number" name="salary" value="{{ $user->salary }}" required>
                                    @error('salary')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                            </div>

                            <div class="input-group d-flex mt-3">
                                <label class="flex-grow-1" for="department_id">Department:
                                    <select class="form-select" name="department_id" required>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>
                            </div>

                            <div class="text-center">
                                <img alt="employee_img"
                                     onclick="imgInput.click()" class="mb-3"
                                     style="border-radius: 50%; width: 120px; height: 120px"
                                     src="{{ asset($user->image ? 'storage/' . $user->image : 'storage/images/default.png') }}"
                                >
                                @error('image')
                                <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                                <input id="imgInput" class="form-control d-none" value="{{ $user->image }}" type="file" name="image">
                            </div>

                            <div class="input-group d-flex mt-3">
                                <label class="flex-grow-1" for="password">Password:
                                    <input class="form-control" type="password" name="password" required>
                                    @error('password')
                                    <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                </label>

                                <label class="flex-grow-1" for="password_confirmation">Confirm Password:
                                    <input class="form-control" type="password" name="password_confirmation" required>
                                </label>

                            </div>

                            <button class="btn btn-primary mt-3" type="submit">update employee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
