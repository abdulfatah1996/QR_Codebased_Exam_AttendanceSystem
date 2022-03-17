@extends('layouts.app')


@section('title')
    Exams
@endsection


@section('activeExams')
    active border-2 border-bottom border-primary
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Exams') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#ExamAddModal">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add New Exam') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="ExamAddModal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="ExamAddModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ExamAddModalLabel">Exam Info</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input class="id form-control" type="hidden" id="id" name="id">

                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Course Name</small>
                                                        <select name="course_id" id="course_id" size="4"
                                                            class="course_id form-control shadow-none rounded-0">
                                                            @foreach ($course as $cours)
                                                                <option value="{{ $cours->id }}">{{ $cours->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="course_id_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Hall Name</small>
                                                        <select name="hall_id" id="hall_id" size="4"
                                                            class="hall_id form-control shadow-none rounded-0">
                                                            @foreach ($halls as $hall)
                                                                <option value="{{ $hall->id }}">{{ $hall->nameHall }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="hall_id_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Day Exam</small>
                                                        <input id="day" type="date"
                                                            class="day form-control shadow-none rounded-0" name="day"
                                                            value="{{ old('day') }}" required autocomplete="day"
                                                            autofocus placeholder="Day ...">
                                                        <small class="day_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Start Time</small>
                                                        <input id="start" type="time"
                                                            class="start form-control shadow-none rounded-0" name="start"
                                                            value="{{ old('start') }}" required autocomplete="start"
                                                            autofocus>
                                                        <small class="start_error fs-6 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">End Time</small>
                                                        <input id="end" type="time"
                                                            class="end form-control shadow-none rounded-0" name="end"
                                                            value="{{ old('end') }}" required autocomplete="end"
                                                            autofocus>
                                                        <small class="end_error fs-6 text-danger"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="rounded-0 shadow-none btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="addExam rounded-0 shadow-none btn btn-primary">{{ __('Add New Student') }}</button>
                                            <button type="button"
                                                class="updateExam rounded-0 shadow-none btn btn-info">{{ __('Update Student') }}</button>
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
                                        <th scope="row">Course Name</th>
                                        <th scope="row">Hall</th>
                                        <th scope="row">Hours</th>
                                        <th scope="row">Day</th>
                                        <th scope="row">Start Time</th>
                                        <th scope="row">End Time</th>
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
            fetch();

            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "/teacher/exams/getExams",
                    dataType: "json",
                    success: function(response) {
                        var count = 1;
                        $('tbody').empty();
                        // count++
                        // console.log(response.exams);
                        $.each(response.exams, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.name +
                                '</td><td>' +
                                item.nameHall +
                                '</td><td>' +
                                item.hours +
                                '</td><td>' +
                                item.day +
                                '</td><td>' +
                                item.start +
                                '</td><td>' +
                                item.end +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '" class="exam-edit btn btn-outline-info mx-1 shadow-none"> <i class="fa-solid fa-pen-to-square"></i></button><button type="button" value="' +
                                item.id +
                                '"class="exam-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button><button type="button" value="' +
                                item.id +
                                '"class="exam-input btn btn-outline-dark mx-1 shadow-none"><i class="fa-solid fa-qrcode"></i></button></td></tr>'
                            );

                        });
                    }
                });
            }
            $(document).on('click', '.addExam', function(e) {
                e.preventDefault(e);
                var data = {
                    'hall_id': $('.hall_id').val(),
                    'course_id': $('.course_id').val(),
                    'day': $('.day').val(),
                    'start': $('.start').val(),
                    'end': $('.end').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/teacher/exams/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.hall_id').removeClass('is-invalid');
                        $('.course_id').removeClass('is-invalid');
                        $('.day').removeClass('is-invalid');
                        $('.start').removeClass('is-invalid');
                        $('.end').removeClass('is-invalid');

                        $('.hall_id_error').empty();
                        $('.course_id_error').empty();
                        $('.day_error').empty();
                        $('.start_error').empty();
                        $('.end_error').empty();

                        if (response.status == false) {


                            if (response.errors['hall_id'] != null) {
                                $('.hall_id').addClass('is-invalid');
                                $('.hall_id_error').append(response.errors['course_id']);
                            }
                            if (response.errors['course_id'] != null) {
                                $('.course_id').addClass('is-invalid');
                                $('.course_id_error').append(response.errors['course_id']);
                            }
                            if (response.errors['day'] != null) {
                                $('.day').addClass('is-invalid');
                                $('.day_error').append(response.errors['day']);
                            }
                            if (response.errors['start'] != null) {
                                $('.start').addClass('is-invalid');
                                $('.start_error').append(response.errors['start']);
                            }
                            if (response.errors['end'] != null) {
                                $('.end').addClass('is-invalid');
                                $('.end_error').append(response.errors['end']);
                            }
                        } else {
                            fetch();
                            toastr.success(response.success);
                        }

                    }
                });
            });

            $(document).on('click', '.exam-edit', function(e) {
                e.preventDefault(e);
                // console.log('run');
                var examId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: `/teacher/exams/edit/${examId}`,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $('#id').val(response.exam.id);
                        $('#course_id').val(response.exam.course_id);
                        $('#hall_id').val(response.exam.hall_id);
                        $('#day').val(response.exam.day);
                        $('#start').val(response.exam.start);
                        $('#end').val(response.exam.end);
                        $('#ExamAddModal').modal('show');
                    }
                });
            });
            $(document).on('click', '.updateExam', function(e) {
                e.preventDefault(e);
                // console.log('runn');
                var data = {
                    'id': $('.id').val(),
                    'course_id': $('.course_id').val(),
                    'hall_id': $('.hall_id').val(),
                    'day': $('.day').val(),
                    'start': $('.start').val(),
                    'end': $('.end').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/teacher/exams/update",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.course_id').removeClass('is-invalid');
                        $('.hall_id').removeClass('is-invalid');
                        $('.day').removeClass('is-invalid');
                        $('.start').removeClass('is-invalid');
                        $('.end').removeClass('is-invalid');


                        $('.course_id_error').empty();
                        $('.hall_id_error').empty();
                        $('.day_error').empty();
                        $('.start_error').empty();
                        $('.end_error').empty();


                        // console.log(response);
                        if (response.status == false) {
                            if (response.errors['course_id'] != null) {
                                $('.course_id').addClass('is-invalid');
                                $('.course_id_error').append(response.errors['course_id']);
                            }
                            if (response.errors['hall_id'] != null) {
                                $('.hall_id').addClass('is-invalid');
                                $('.hall_id_error').append(response.errors['hall_id']);
                            }
                            if (response.errors['day'] != null) {
                                $('.day').addClass('is-invalid');
                                $('.day_error').append(response.errors['day']);
                            }
                            if (response.errors['start'] != null) {
                                $('.start').addClass('is-invalid');
                                $('.start_error').append(response.errors['start']);
                            }
                            if (response.errors['end'] != null) {
                                $('.end').addClass('is-invalid');
                                $('.end_error').append(response.errors['end']);
                            }
                        } else {
                            fetch();
                            toastr.success(response.success);
                        }

                    }
                });

                $(document).on('click', '.exam-delete', function(e) {
                    e.preventDefault(e);
                    var examId = $(this).val();
                    console.log(examId);

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

            $(document).on('click', '.exam-delete', function(e) {
                e.preventDefault(e);
                var examId = $(this).val();
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
                            url: `/teacher/exams/destroy/${examId}`,
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


            $(document).on('click', '.exam-input', function(e) {
                e.preventDefault(e);
                var examId = $(this).val();
                // console.log(examId);
                window.location.href = `/teacher/exams/inputExam/${examId}`;
            });
        });
    </script>
@endsection
