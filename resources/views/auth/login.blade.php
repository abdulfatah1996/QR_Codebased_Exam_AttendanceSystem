@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <div class="col-md-4">
                <div class="card bg-dark border-0 shadow-lg rounded-0">
                    <div class="card-header bg-transparent border-0">
                        <div class="col-md-8 m-auto text-center mt-3">
                            <img class="img-fluid" src="{{ asset('assets/img/authentication_re_svpt.svg') }}" alt=""
                                srcset="">
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-10 m-auto">
                                    <input id="email" type="email"
                                        class=" rounded-0 shadow-none form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email Address">

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
                                        class="form-control rounded-0 shadow-none  @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-10 m-auto">
                                    <button type="submit" class="m-auto d-block btn btn-primary shadow-none rounded-0">
                                        {{ __('Login System') }}
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
