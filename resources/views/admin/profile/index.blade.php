@extends('layouts.app')

@section('title')
    My Profile
@endsection


@section('activeProfile')
    active border-2 border-bottom border-primary
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-primary bg-transparent">
                        <h2 class="lead fs-3 fw-bolder text-primary">Personal Information</h2>
                    </div>
                    <div class="card-body col-10 m-auto">
                        <div class="col-md-12 m-auto mb-3">
                            <input type="text" id="name" id="name" class="name form-control shadow-none rounded-0"
                                placeholder="Name" value="{{ Auth::user()->name }}" />
                            <small class="name_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <input type="email" class="email form-control shadow-none rounded-0" placeholder="Email"
                                value="{{ Auth::user()->email }}" />
                            <small class="email_error fs-5 text-danger"></small>
                        </div>
                        <div class="input-group mb-3 text-center">
                            <button type="button" class="savePersonalInformation btn btn-primary rounded-0 shadow-none">
                                <span> <i class="fa-solid fa-floppy-disk mx-2"></i>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-primary bg-transparent">
                        <h2 class="lead fs-3 fw-bolder text-primary">Password Change</h2>
                    </div>
                    <div class="card-body col-10 m-auto">
                        <div class="col-md-12 m-auto mb-3">
                            <input id="password" type="password" class="password form-control shadow-none rounded-0"
                                name="Password" required autocomplete="new-password" placeholder="password">
                            <small class="password_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <input id="password-confirm" type="password"
                                class="password-confirm form-control shadow-none rounded-0" name="password_confirmation"
                                required autocomplete="new-password" placeholder="Password Confirm">
                        </div>
                        <div class="input-group mb-3 text-center">
                            <button type="button" class="PasswordUpdate btn btn-primary rounded-0 shadow-none">
                                <span> <i class="fa-solid fa-floppy-disk mx-2"></i>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-primary bg-transparent">
                        <h2 class="lead fs-3 fw-bolder text-primary">Profile Info</h2>
                    </div>
                    <div class="card-body col-10 m-auto">
                        <div class="col-md-12 m-auto mb-3">
                            <input id="phone" type="text" class="phone form-control shadow-none rounded-0" name="phone"
                                value="{{ $profile->phone }}" placeholder="phone">
                            <small class="phone_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <input id="address" type="text" class="address form-control shadow-none rounded-0"
                                name="address" value="{{ $profile->address }}" placeholder="address">
                            <small class="address_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <input id="age" type="date" class="age form-control shadow-none rounded-0" name="age"
                                value="{{ $profile->age }}">
                            <small class="age_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <select name="college_id" id="college_id" size="4"
                                class="college_id form-control shadow-none rounded-0">
                                @foreach ($colleges as $college)
                                    <option value="{{ $college->id }}" @if ($college->id == $profile->college_id) selected @endif>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="college_id_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <select name="degree" id="degree" size="3" class="degree form-control shadow-none rounded-0">
                                <option value="Bachelor" @if ('Bachelor' == $profile->degree) selected @endif>Bachelor</option>
                                <option value="Master" @if ('Master' == $profile->degree) selected @endif>Master</option>
                                <option value="Doctoral" @if ('Doctoral' == $profile->degree) selected @endif>Doctoral</option>
                            </select>
                            <small class="degree_error fs-5 text-danger"></small>
                        </div>
                        <div class="col-md-12 m-auto mb-3">
                            <select name="gender" id="gender" size="2" class="gender form-control shadow-none rounded-0">
                                <option value="Male" @if ('Male' == $profile->gender) selected @endif>Male</option>
                                <option value="Female" @if ('Female' == $profile->gender) selected @endif>Female</option>
                            </select>
                            <small class="gender_error fs-5 text-danger"></small>
                        </div>
                        <div class="input-group mb-3 text-center">
                            <button type="button" class="ProfileInfoUpdate btn btn-primary rounded-0 shadow-none">
                                <span> <i class="fa-solid fa-floppy-disk mx-2"></i>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @if (session()->has('success'))
        <script>
            toastr.success('{{ session()->get('success') }}');
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr.error('{{ session()->get('error') }}');
        </script>
    @endif

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.savePersonalInformation', function(e) {
                e.preventDefault(e);
                var data = {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                };
                $.ajax({
                    type: "POST",
                    url: "/profile/PlInfoUpdate",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.name').removeClass('is-invalid');
                        $('.email').removeClass('is-invalid');

                        $('.name_error').empty();
                        $('.email_error').empty();

                        if (response.status == 200) {
                            toastr.info(response.info);
                        }

                        if (response.status == false) {
                            if (response.errors['name'] != null) {
                                $('.name').addClass('is-invalid');
                                $('.name_error').append(response.errors['name']);
                            }
                            if (response.errors['email'] != null) {
                                $('.email').addClass('is-invalid');
                                $('.email_error').append(response.errors['email']);
                            }
                        }
                        if (response.status == true) {
                            toastr.success(response.success);
                            // console.log(response);
                        }


                    }
                });
            });
            $(document).on('click', '.PasswordUpdate', function(e) {
                e.preventDefault(e);
                var data = {
                    'password': $('.password').val(),
                    'password-confirm': $('.password-confirm').val(),
                };
                $.ajax({
                    type: "POST",
                    url: "/profile/PasswordUpdate",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.password').removeClass('is-invalid');
                        $('.password_error').empty();
                        if (response.status == 200) {
                            toastr.info(response.info);
                        }

                        if (response.status == false) {
                            if (response.errors['password'] != null) {
                                $('.password').addClass('is-invalid');
                                $('.password_error').append(response.errors['password']);
                            }
                        }
                        if (response.status == true) {
                            toastr.success(response.success);
                            // console.log(response);
                            $('body').load(location.href);
                        }


                    }
                });
            });


            $(document).on('click', '.ProfileInfoUpdate', function(e) {
                e.preventDefault(e);
                var data = {
                    'phone': $('.phone').val(),
                    'address': $('.address').val(),
                    'age': $('.age').val(),
                    'college_id': $('.college_id').val(),
                    'degree': $('.degree').val(),
                    'gender': $('.gender').val(),
                };
                $.ajax({
                    type: "POST",
                    url: "/profile/ProfileInfoUpdate",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.phone').removeClass('is-invalid');
                        $('.address').removeClass('is-invalid');
                        $('.age').removeClass('is-invalid');
                        $('.college_id').removeClass('is-invalid');
                        $('.degree').removeClass('is-invalid');
                        $('.gender').removeClass('is-invalid');


                        $('.phone_error').empty();
                        $('.address_error').empty();
                        $('.age_error').empty();
                        $('.college_id_error').empty();
                        $('.degree_error').empty();
                        $('.gender_error').empty();
                        if (response.status == false) {
                            if (response.errors['phone'] != null) {
                                $('.phone').addClass('is-invalid');
                                $('.phone_error').append(response.errors['phone']);
                            }
                            if (response.errors['address'] != null) {
                                $('.address').addClass('is-invalid');
                                $('.address_error').append(response.errors['address']);
                            }
                            if (response.errors['age'] != null) {
                                $('.age').addClass('is-invalid');
                                $('.age_error').append(response.errors['age']);
                            }
                            if (response.errors['college_id'] != null) {
                                $('.college_id').addClass('is-invalid');
                                $('.college_id_error').append(response.errors['college_id']);
                            }
                            if (response.errors['degree'] != null) {
                                $('.degree').addClass('is-invalid');
                                $('.degree_error').append(response.errors['degree']);
                            }
                            if (response.errors['gender'] != null) {
                                $('.gender').addClass('is-invalid');
                                $('.gender_error').append(response.errors['gender']);
                            }
                        } else {
                            // console.log(response);
                            toastr.success(response.success);
                        }
                    }
                });
            });
        });
    </script>
@endsection
