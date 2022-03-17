@extends('layouts.app')

@section('title')
    College
@endsection


@section('activeColleges')
    active border-2 border-bottom border-primary
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Colleges') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#CollegeAddModal">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add New College') }}
                            </button>
                        </div>

                        <!-- Modal CollegeAddModal -->
                        <div class="modal fade" id="CollegeAddModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="CollegeAddModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-0 shadow-lg">
                                    <div class="modal-header bg-transparent border-0">
                                        <h5 class="modal-title" id="CollegeAddModalLabel">Add New College</h5>
                                        <button type="button" class="btn shadow-none rounded-0 btn-danger"
                                            data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            @csrf
                                            <input type="hidden" name="id" id="id">
                                            <div class="row mb-3">
                                                <div class="col-md-10 m-auto">
                                                    <input id="name" type="text"
                                                        class="name form-control shadow-none rounded-0" name="name"
                                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                                        placeholder="Name ...">
                                                    <small class="name_error fs-5 text-danger"></small>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer bg-transparent border-0">
                                        <button type="submit" class="addCollege btn btn-primary rounded-0 shadow-none">
                                            {{ __('Add New College') }}
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal CollegeEditModal -->
                        <div class="modal fade" id="CollegeEditModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="CollegeEditModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-0 shadow-lg">
                                    <div class="modal-header bg-transparent border-0">
                                        <h5 class="modal-title" id="CollegeEditModalLabel">Edit College</h5>
                                        <button type="button" class="btn shadow-none rounded-0 btn-danger"
                                            data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            @csrf
                                            <input type="hidden" class="idEdit" name="idEdit" id="idEdit">
                                            <div class="row mb-3">
                                                <div class="col-md-10 m-auto">
                                                    <input id="nameEdit" type="text"
                                                        class="nameEdit form-control shadow-none rounded-0" name="nameEdit"
                                                        value="{{ old('nameEdit') }}" required autocomplete="nameEdit"
                                                        autofocus placeholder="nameEdit ...">
                                                    <small class="nameEdit_error fs-5 text-danger"></small>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer bg-transparent border-0">
                                        <button type="submit" class="editCollege btn btn-primary rounded-0 shadow-none">
                                            {{ __('Save Update College') }}
                                        </button>
                                        </form>
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
                    url: "/admin/colleges/getColleges",
                    dataType: "json",
                    success: function(response) {
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.colleges.data, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.name +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '" class="college-edit btn btn-outline-info mx-1 shadow-none"> <i class="fa-solid fa-pen-to-square"></i></button><button type="button" value="' +
                                item.id +
                                '"class="college-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button></td></tr>'
                            );

                        });
                        // console.log(response.colleges.data);
                    }
                });
            }


            $(document).on('click', '.addCollege', function(e) {

                e.preventDefault();
                var data = {
                    'name': $('.name').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/admin/colleges/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        if (response.status == false) {

                            $('.name').addClass('is-invalid');
                            $('.name_error').append(response.errors['name']);
                            // console.log(response.errors['name']);
                        } else {
                            $('.name').removeClass('is-invalid');
                            $('.name_error').remove();
                            fetchColleges();
                            toastr.success(response.success);
                        }

                    }
                });
                // console.log(response.success);
            });

            $(document).on('click', '.editCollege', function(e) {

                e.preventDefault();
                var data = {
                    'idEdit': $('.idEdit').val(),
                    'nameEdit': $('.nameEdit').val(),
                };

                $.ajax({
                    type: "POST",
                    url: "/admin/colleges/update",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status == false) {
                            toastr.info(response.info);
                            // console.log(response.errors['name']);
                        } else {
                            // console.log(response.errors);
                            if (response.statusUpdate == false) {
                                $('.nameEdit').addClass('is-invalid');
                                $('.nameEdit_error').append(response.errors['name']);
                            }
                            if (response.statusUpdate == true) {
                                $('.nameEdit').removeClass('is-invalid');
                                $('.nameEdit_error').remove();
                                fetchColleges();
                                toastr.success(response.success);
                            }

                        }
                    }
                });
                // console.log(response.success);
            });


            $(document).on('click', '.college-edit', function(e) {
                e.preventDefault(e);
                var collegeId = $(this).val();


                $.ajax({
                    type: "GET",
                    url: `/admin/colleges/edit/${collegeId}`,
                    dataType: "json",
                    success: function(response) {

                        $('#idEdit').val(response.college.id);
                        $('#nameEdit').val(response.college.name);
                        $('#CollegeEditModal').modal('show');

                        // console.log(response.college);
                    }
                });
                // console.log(collegeId);
            });
            $(document).on('click', '.college-delete', function(e) {
                e.preventDefault(e);
                var collegeId = $(this).val();

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
                            url: `/admin/colleges/destroy/${collegeId}`,
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
