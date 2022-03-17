@extends('layouts.app')


@section('title')
    Student Exam
@endsection


@section('activeStudentExam')
    active border-2 border-bottom border-primary
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Exams Student Table') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#studentExams">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add Exams Student Table') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="studentExams" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="studentExamsLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="studentExamsLabel">Student Exam Info</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input class="id form-control" type="hidden" id="id" name="id">
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Student Name</small>
                                                        <select name="student_id" id="student_id" size="4"
                                                            class="student_id form-control shadow-none rounded-0">
                                                            @foreach ($students as $student)
                                                                <option value="{{ $student->id }}">
                                                                    {{ $student->studentName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="student_id_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <small class="fs-6 text-muted">Exame Name</small>
                                                        <select name="exam_id" id="exam_id" size="4"
                                                            class="exam_id form-control shadow-none rounded-0">
                                                            @foreach ($examsAll as $exam)
                                                                <option value="{{ $exam->id }}">{{ $exam->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <small class="exam_id_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="rounded-0 shadow-none btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="addExamStudent rounded-0 shadow-none btn btn-primary">{{ __('Add New student Exam') }}</button>
                                            <button type="button"
                                                class="updateExamStudent rounded-0 shadow-none btn btn-info">{{ __('Update student Exam') }}</button>
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
                                        <th scope="row">Student Name</th>
                                        <th scope="row">Course Name</th>
                                        <th scope="row">Hall</th>
                                        <th scope="row">Hours</th>
                                        <th scope="row">Day</th>
                                        <th scope="row">Start Time</th>
                                        <th scope="row">End Time</th>
                                        <th scope="row">Present</th>
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

            function isPresenCheckt(isPresent) {

                if (isPresent == 1) {
                    return `<span class="badge bg-success">Present</span>`;
                }else{
                    return `<span class="badge bg-danger">Absent</span>`;
                }
            }



            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "/teacher/studentExam/getStudentExam",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response.student_exams);
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.student_exams, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.studentName +
                                '</td><td>' +
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
                                '</td><td>' + isPresenCheckt(item.isPresent) +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '" class="studentExams-edit btn btn-outline-info mx-1 shadow-none"> <i class="fa-solid fa-pen-to-square"></i></button><button type="button" value="' +
                                item.id +
                                '"class="studentExams-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button></td></tr>'
                            );

                        });
                    }
                });
            }
            $(document).on('click', '.addExamStudent', function(e) {
                e.preventDefault(e);
                var data = {
                    'student_id': $('.student_id').val(),
                    'exam_id': $('.exam_id').val(),
                };
                $.ajax({
                    type: "POST",
                    url: "/teacher/studentExam/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.student_id').removeClass('is-invalid');
                        $('.exam_id').removeClass('is-invalid');

                        $('.student_id_error').empty();
                        $('.exam_id_error').empty();


                        if (response.status == false) {


                            if (response.errors['student_id'] != null) {
                                $('.student_id').addClass('is-invalid');
                                $('.student_id_error').append(response.errors['student_id']);
                            }
                            if (response.errors['exam_id'] != null) {
                                $('.exam_id').addClass('is-invalid');
                                $('.exam_id_error').append(response.errors['exam_id']);
                            }

                        } else {
                            fetch();
                            // console.log(response.success);
                            toastr.success(response.success);
                        }

                    }
                });
            });

            $(document).on('click', '.studentExams-edit', function(e) {
                e.preventDefault(e);
                // console.log('run');
                var examId = $(this).val();

                $.ajax({
                    type: "GET",
                    url: `/teacher/studentExam/edit/${examId}`,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $('#id').val(response.student_exam.id);
                        $('#exam_id').val(response.student_exam.exam_id);
                        $('#student_id').val(response.student_exam.student_id);
                        $('#studentExams').modal('show');
                    }
                });
            });
            $(document).on('click', '.updateExamStudent', function(e) {
                e.preventDefault(e);
                var data = {
                    'id': $('.id').val(),
                    'exam_id': $('.exam_id').val(),
                    'student_id': $('.student_id').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/teacher/studentExam/update",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $('.exam_id').removeClass('is-invalid');
                        $('.student_id').removeClass('is-invalid');

                        $('.exam_id_error').empty();
                        $('.student_id_error').empty();


                        // console.log(response);
                        if (response.status == false) {
                            if (response.errors['exam_id'] != null) {
                                $('.exam_id').addClass('is-invalid');
                                $('.exam_id_error').append(response.errors['exam_id']);
                            }
                            if (response.errors['student_id'] != null) {
                                $('.student_id').addClass('is-invalid');
                                $('.student_id_error').append(response.errors['student_id']);
                            }
                        } else {
                            fetch();
                            // console.log(response.success);
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

            $(document).on('click', '.studentExams-delete', function(e) {
                e.preventDefault(e);
                var Id = $(this).val();

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
                            url: `/teacher/studentExam/destroy/${Id}`,
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
