@extends('layouts.app')


@section('title')
    Students
@endsection


@section('activeStudents')
    active border-2 border-bottom border-primary
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Students') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#StudentAddModal">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add New Student') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="StudentAddModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="StudentAddModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="StudentAddModalLabel">Student Info</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input class="id form-control" type="hidden" id="id" name="id">
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="studentName" type="text"
                                                            class="studentName form-control shadow-none rounded-0" name="studentName"
                                                            value="{{ old('studentName') }}" required autocomplete="studentName"
                                                            autofocus placeholder="Name ...">
                                                        <small class="studentName_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="studentId" type="text"
                                                            class="studentId form-control shadow-none rounded-0"
                                                            name="studentId" value="{{ old('studentId') }}" required
                                                            autocomplete="studentId" autofocus placeholder="student Id ...">
                                                        <small class="studentId_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="nationalId" type="text"
                                                            class="nationalId form-control shadow-none rounded-0"
                                                            name="nationalId" value="{{ old('nationalId') }}" required
                                                            autocomplete="nationalId" autofocus
                                                            placeholder="National Id ...">
                                                        <small class="nationalId_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="phone" type="tel"
                                                            class="phone form-control shadow-none rounded-0" name="phone"
                                                            value="{{ old('phone') }}" required autocomplete="phone"
                                                            autofocus placeholder="phone ...">
                                                        <small class="phone_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="email" type="email"
                                                            class="email form-control shadow-none rounded-0" name="email"
                                                            value="{{ old('email') }}" required autocomplete="email"
                                                            autofocus placeholder="E-mail ...">
                                                        <small class="email_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="address" type="text"
                                                            class="address form-control shadow-none rounded-0"
                                                            name="address" value="{{ old('address') }}" required
                                                            autocomplete="address" autofocus placeholder="Address ...">
                                                        <small class="address_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <select name="gender" id="gender" size="2"
                                                            class="gender form-control shadow-none rounded-0">
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <small class="gender_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="age" type="date"
                                                            class="age form-control shadow-none rounded-0" name="age"
                                                            value="{{ old('age') }}" required autocomplete="age"
                                                            autofocus placeholder="age ...">
                                                        <small class="age_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <select name="degree" id="degree" size="3"
                                                            class="degree form-control shadow-none rounded-0">
                                                            <option value="Bachelor">Bachelor</option>
                                                            <option value="Master">Master</option>
                                                            <option value="Doctoral">Doctoral</option>
                                                        </select>
                                                        <small class="degree_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="rounded-0 shadow-none btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="addStudent rounded-0 shadow-none btn btn-primary">{{ __('Add New Student') }}</button>
                                            <button type="button"
                                                class="updateStudent rounded-0 shadow-none btn btn-info">{{ __('Update Student') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="collegesTable">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="row">Name</th>
                                        <th scope="row">Student</th>
                                        <th scope="row">National</th>
                                        <th scope="row">Phone</th>
                                        <th scope="row">E-mail</th>
                                        <th scope="row">Address</th>
                                        <th scope="row">Gender</th>
                                        <th scope="row">Age</th>
                                        <th scope="row">Degree</th>
                                        <th scope="row" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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

            function getAge(dateString) {
                var today = new Date();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }
            fetch();

            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "/admin/students/getStudents",
                    dataType: "json",
                    success: function(response) {
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.students.data, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.studentName +
                                '</td><td>' +
                                item.studentId +
                                '</td><td>' +
                                item.nationalId +
                                '</td><td>' +
                                item.phone +
                                '</td><td>' +
                                item.email +
                                '</td><td>' +
                                item.address +
                                '</td><td>' +
                                item.gender +
                                '</td><td>' +
                                getAge(item.age) +
                                '</td><td>' +
                                item.degree +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '" class="student-edit btn btn-outline-info mx-1 shadow-none"> <i class="fa-solid fa-pen-to-square"></i></button><button type="button" value="' +
                                item.id +
                                '"class="student-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button></td></tr>'
                            );

                        });
                    }
                });
            }
            $(document).on('click', '.addStudent', function(e) {
                e.preventDefault(e);
                var data = {
                    'studentName': $('.studentName').val(),
                    'studentId': $('.studentId').val(),
                    'nationalId': $('.nationalId').val(),
                    'phone': $('.phone').val(),
                    'email': $('.email').val(),
                    'address': $('.address').val(),
                    'gender': $('.gender').val(),
                    'age': $('.age').val(),
                    'degree': $('.degree').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/admin/students/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.studentName').removeClass('is-invalid');
                        $('.studentId').removeClass('is-invalid');
                        $('.nationalId').removeClass('is-invalid');
                        $('.phone').removeClass('is-invalid');
                        $('.email').removeClass('is-invalid');
                        $('.address').removeClass('is-invalid');
                        $('.gender').removeClass('is-invalid');
                        $('.age').removeClass('is-invalid');
                        $('.degree').removeClass('is-invalid');

                        $('.studentName_error').empty();
                        $('.studentId_error').empty();
                        $('.nationalId_error').empty();
                        $('.phone_error').empty();
                        $('.email_error').empty();
                        $('.address_error').empty();
                        $('.gender_error').empty();
                        $('.age_error').empty();
                        $('.degree_error').empty();

                        if (response.status == false) {
                            if (response.errors['studentName'] != null) {
                                $('.studentName').addClass('is-invalid');
                                $('.studentName_error').append(response.errors['studentName']);
                            }
                            if (response.errors['studentId'] != null) {
                                $('.studentId').addClass('is-invalid');
                                $('.studentId_error').append(response.errors['studentId']);
                            }
                            if (response.errors['nationalId'] != null) {
                                $('.nationalId').addClass('is-invalid');
                                $('.nationalId_error').append(response.errors['nationalId']);
                            }
                            if (response.errors['phone'] != null) {
                                $('.phone').addClass('is-invalid');
                                $('.phone_error').append(response.errors['phone']);
                            }
                            if (response.errors['email'] != null) {
                                $('.email').addClass('is-invalid');
                                $('.email_error').append(response.errors['email']);
                            }
                            if (response.errors['address'] != null) {
                                $('.address').addClass('is-invalid');
                                $('.address_error').append(response.errors['address']);
                            }
                            if (response.errors['gender'] != null) {
                                $('.gender').addClass('is-invalid');
                                $('.gender_error').append(response.errors['gender']);
                            }
                            if (response.errors['age'] != null) {
                                $('.age').addClass('is-invalid');
                                $('.age_error').append(response.errors['age']);
                            }
                            if (response.errors['degree'] != null) {
                                $('.degree').addClass('is-invalid');
                                $('.degree_error').append(response.errors['degree']);
                            }
                        } else {
                            fetch();
                            toastr.success(response.success);
                        }

                    }
                });
            });

            $(document).on('click', '.student-edit', function(e) {
                e.preventDefault(e);
                var studentId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: `/admin/students/edit/${studentId}`,
                    dataType: "json",
                    success: function(response) {
                        $('#id').val(response.student.id);
                        $('#studentName').val(response.student.studentName);
                        $('#studentId').val(response.student.studentId);
                        $('#nationalId').val(response.student.nationalId);
                        $('#phone').val(response.student.phone);
                        $('#email').val(response.student.email);
                        $('#address').val(response.student.address);
                        $('#gender').val(response.student.gender);
                        $('#age').val(response.student.age);
                        $('#degree').val(response.student.degree);
                        $('#StudentAddModal').modal('show');
                    }
                });
            });
            $(document).on('click', '.updateStudent', function(e) {
                e.preventDefault(e);
                var data = {
                    'id': $('.id').val(),
                    'studentName': $('.studentName').val(),
                    'studentId': $('.studentId').val(),
                    'nationalId': $('.nationalId').val(),
                    'phone': $('.phone').val(),
                    'email': $('.email').val(),
                    'address': $('.address').val(),
                    'gender': $('.gender').val(),
                    'age': $('.age').val(),
                    'degree': $('.degree').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/admin/students/update",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.studentName').removeClass('is-invalid');
                        $('.studentId').removeClass('is-invalid');
                        $('.nationalId').removeClass('is-invalid');
                        $('.phone').removeClass('is-invalid');
                        $('.email').removeClass('is-invalid');
                        $('.address').removeClass('is-invalid');
                        $('.gender').removeClass('is-invalid');
                        $('.age').removeClass('is-invalid');
                        $('.degree').removeClass('is-invalid');

                        $('.studentName_error').empty();
                        $('.studentId_error').empty();
                        $('.nationalId_error').empty();
                        $('.phone_error').empty();
                        $('.email_error').empty();
                        $('.address_error').empty();
                        $('.gender_error').empty();
                        $('.age_error').empty();
                        $('.degree_error').empty();

                        // console.log(response);
                        if (response.status == false) {
                            if (response.errors['studentName'] != null) {
                                $('.studentName').addClass('is-invalid');
                                $('.studentName_error').append(response.errors['studentName']);
                            }
                            if (response.errors['studentId'] != null) {
                                $('.studentId').addClass('is-invalid');
                                $('.studentId_error').append(response.errors['studentId']);
                            }
                            if (response.errors['nationalId'] != null) {
                                $('.nationalId').addClass('is-invalid');
                                $('.nationalId_error').append(response.errors['nationalId']);
                            }
                            if (response.errors['phone'] != null) {
                                $('.phone').addClass('is-invalid');
                                $('.phone_error').append(response.errors['phone']);
                            }
                            if (response.errors['email'] != null) {
                                $('.email').addClass('is-invalid');
                                $('.email_error').append(response.errors['email']);
                            }
                            if (response.errors['address'] != null) {
                                $('.address').addClass('is-invalid');
                                $('.address_error').append(response.errors['address']);
                            }
                            if (response.errors['gender'] != null) {
                                $('.gender').addClass('is-invalid');
                                $('.gender_error').append(response.errors['gender']);
                            }
                            if (response.errors['age'] != null) {
                                $('.age').addClass('is-invalid');
                                $('.age_error').append(response.errors['age']);
                            }
                            if (response.errors['degree'] != null) {
                                $('.degree').addClass('is-invalid');
                                $('.degree_error').append(response.errors['degree']);
                            }
                        } else {
                            // console.log(response);
                            fetch();
                            toastr.success(response.success);
                        }

                    }
                });

                $(document).on('click', '.course-delete', function(e) {
                    e.preventDefault(e);
                    var courseId = $(this).val();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: `/admin/courses/destroy/${courseId}`,
                                dataType: "json",
                                success: function(response) {
                                    fetch();
                                    if (response.status == true) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success,
                                            'success'
                                        );
                                    }
                                }
                            });

                        }
                    })
                });
            });

            $(document).on('click', '.student-delete', function(e) {
                e.preventDefault(e);
                var studentId = $(this).val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: `/admin/students/destroy/${studentId}`,
                            dataType: "json",
                            success: function(response) {
                                fetch();
                                if (response.status == true) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.success,
                                        'success'
                                    );
                                }
                            }
                        });

                    }
                })
            });
        });
    </script>
@endsection
