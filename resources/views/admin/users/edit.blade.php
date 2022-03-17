@extends('layouts.app')

@section('title')
    My Profile
@endsection


@section('activeUsers')
    active border-2 border-bottom border-primary
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-header bg-transparent border-0 fs-2 text-primary lead">{{ __('My Profile') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <input id="name" type="text"
                                        class="form-control shadow-none rounded-0 @error('name') is-invalid @enderror"
                                        name="name" value="{{ $user->name }}" required autocomplete="name" autofocus
                                        placeholder="Name ...">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <input id="email" type="email"
                                        class="form-control  shadow-none rounded-0 @error('email') is-invalid @enderror"
                                        name="email" value="{{ $user->email }}" required autocomplete="email"
                                        placeholder="Email Address...">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <input id="password" type="password"
                                        class="form-control shadow-none rounded-0 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password" placeholder="Password ...">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <input id="password-confirm" type="password" class="form-control shadow-none rounded-0 "
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <select name="role" id="role"
                                        class="form-control shadow-none rounded-0 @error('role') is-invalid @enderror">
                                        <option value="Administrator" @if ($user->role == 'Administrator') selected @endif >Administrator</option>
                                        <option value="Teacher" @if ($user->role == 'Teacher') selected @endif >Teacher</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary rounded-0 shadow-none">
                                        <span class="me-2"><i class="fa-solid fa-floppy-disk"></i></span>
                                        {{ __('Save Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
