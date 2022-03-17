@extends('layouts.app')


@section('title')
    Input Exame
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <div class="input-group mb-3">
                                <input type="hidden" class="id" name="id" id="id" value="{{ $id }}">
                                <input id="exam_name" disabled type="text"
                                    class="exam_name form-control shadow-none rounded-0" name="exam_name"
                                    value="{{ $course->name }}" required autocomplete="exam_name" placeholder="exam name">
                            </div>
                            <div class="input-group mb-3">
                                <input id="Student_Number" disabled type="text" class="form-control shadow-none rounded-0"
                                    name="Student_Number" value="{{ old('Student_Number') }}" required
                                    autocomplete="Student_Number" placeholder="Student Number scan">
                            </div>
                        </div>
                        <div class="form-group mb-2 p-0">
                            <video id="preview" class="form-control p-0"></video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            user
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="StudentExamTable">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="row">Student Name</th>
                                        <th scope="row">Course Name</th>
                                        <th scope="row">Day</th>
                                        <th scope="row">Present</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($student_exams as $student_exam)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $student_exam->studentName }}</td>
                                            <td>{{ $student_exam->name }}</td>
                                            <td>{{ $student_exam->day }}</td>
                                            <td>
                                                @if ($student_exam->isPresent == 0)
                                                    <span class="badge bg-danger">Absent</span>
                                                @else
                                                    <span class="badge bg-success">Present</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
    <script type="text/javascript">
        var scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });

        scanner.addListener('scan', function(content) {
            // alert(content);
            document.getElementById('Student_Number').value = content;
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let StudentNumber = content;
                // console.log(StudentNumber);
                var data = {
                    'id': $('.id').val(),
                    'StudentNumber': StudentNumber,
                    'exam_name': $('.exam_name').val(),
                };
                $.ajax({
                    type: "POST",
                    url: `/teacher/studentExam/updateAtt`,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        $("#StudentExamTable").load(location.href + " #StudentExamTable");
                        toastr.success(response.success);
                    }
                });
            });
            //window.location.href=content;
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
                $('[name="options"]').on('change', function() {
                    if ($(this).val() == 1) {
                        if (cameras[0] != "") {
                            scanner.start(cameras[0]);
                        } else {
                            alert('No Front camera found!');
                        }
                    } else if ($(this).val() == 2) {
                        if (cameras[1] != "") {
                            scanner.start(cameras[1]);
                        } else {
                            alert('No Back camera found!');
                        }
                    }
                });
            } else {
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
            alert(e);
        });
    </script>
@endsection
