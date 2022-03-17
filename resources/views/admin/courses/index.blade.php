@extends('layouts.app')


@section('title')
    Courses
@endsection


@section('activeCourses')
    active border-2 border-bottom border-primary
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Courses') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#CoursesAddModal">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add New Courses') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="CoursesAddModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="CoursesAddModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="CoursesAddModalLabel">Courses Info</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input class="id form-control" type="hidden" id="id" name="id">
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="name" type="text"
                                                            class="name form-control shadow-none rounded-0" name="name"
                                                            value="{{ old('name') }}" required autocomplete="name"
                                                            autofocus placeholder="Name ...">
                                                        <small class="name_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="hours" type="text"
                                                            class="hours form-control shadow-none rounded-0" name="hours"
                                                            value="{{ old('hours') }}" required autocomplete="hours"
                                                            autofocus placeholder="hours ...">
                                                        <small class="hours_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="rounded-0 shadow-none btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="addCourse rounded-0 shadow-none btn btn-primary">{{ __('Add New Course') }}</button>
                                            <button type="button"
                                                class="updateCourse rounded-0 shadow-none btn btn-info">{{ __('Update Course') }}</button>
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
                                        <th scope="row">Hours</th>
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

            fetchColleges();

            function fetchColleges() {
                $.ajax({
                    type: "GET",
                    url: "/admin/courses/getCourse",
                    dataType: "json",
                    success: function(response) {
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.courses.data, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.name +
                                '</td><td>' +
                                item.hours +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '" class="course-edit btn btn-outline-info mx-1 shadow-none"> <i class="fa-solid fa-pen-to-square"></i></button><button type="button" value="' +
                                item.id +
                                '"class="course-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button></td></tr>'
                            );

                        });
                    }
                });
            }
            $(document).on('click', '.addCourse', function(e) {
                e.preventDefault(e);
                var data = {
                    'name': $('.name').val(),
                    'hours': $('.hours').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/admin/courses/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        $('.name').removeClass('is-invalid');
                        $('.name_error').empty();
                        $('.hours').removeClass('is-invalid');
                        $('.hours_error').empty();
                        if (response.status == false) {

                            if (response.errors['name'] != null) {
                                $('.name').addClass('is-invalid');
                                $('.name_error').append(response.errors['name']);
                            }
                            if (response.errors['hours'] != null) {
                                $('.hours').addClass('is-invalid');
                                $('.hours_error').append(response.errors['hours']);
                            }
                        } else {
                            fetchColleges();
                            toastr.success(response.success);
                        }

                    }
                });
            });

            $(document).on('click', '.course-edit', function(e) {
                e.preventDefault(e);
                var courseId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: `/admin/courses/edit/${courseId}`,
                    dataType: "json",
                    success: function(response) {

                        $('#id').val(response.course.id);
                        $('#name').val(response.course.name);
                        $('#hours').val(response.course.hours);
                        $('#CoursesAddModal').modal('show');
                    }
                });
                // console.log(courseId);
            });
            $(document).on('click', '.updateCourse', function(e) {
                e.preventDefault(e);
                var data = {
                    'id': $('.id').val(),
                    'name': $('.name').val(),
                    'hours': $('.hours').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/admin/courses/update",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.name').removeClass('is-invalid');
                        $('.name_error').empty();
                        $('.hours').removeClass('is-invalid');
                        $('.hours_error').empty();
                        if (response.info != null) {
                            toastr.info(response.info);
                        } else {
                            if (response.status == false) {
                                if (response.errors['name'] != null) {
                                    $('.name').addClass('is-invalid');
                                    $('.name_error').append(response.errors['name']);
                                }
                                if (response.errors['hours'] != null) {
                                    $('.hours').addClass('is-invalid');
                                    $('.hours_error').append(response.errors['hours']);
                                }
                            } else {
                                fetchColleges();
                                toastr.success(response.success);
                            }
                        }
                        // console.log(response.info);
                    }
                });
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
                                fetchColleges();
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
