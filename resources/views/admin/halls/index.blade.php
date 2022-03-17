@extends('layouts.app')


@section('title')
    Halls
@endsection


@section('activeHalls')
    active border-2 border-bottom border-primary
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Halls') }}</span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-0 shadow-none ms-auto"
                                data-bs-toggle="modal" data-bs-target="#HallsAddModal">
                                <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                {{ __('Add New Hall') }}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="HallsAddModal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="HallsAddModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="HallsAddModalLabel">Hall Info</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <input class="id form-control" type="hidden" id="id" name="id">
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="floorNo" type="text"
                                                            class="floorNo form-control shadow-none rounded-0"
                                                            name="floorNo" value="{{ old('floorNo') }}" required
                                                            autocomplete="floorNo" autofocus placeholder="Floor No ...">
                                                        <small class="floorNo_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-10 m-auto">
                                                        <input id="hallNo" type="text"
                                                            class="hallNo form-control shadow-none rounded-0"
                                                            name="hallNo" value="{{ old('hallNo') }}" required
                                                            autocomplete="hallNo" autofocus placeholder="Hall No ...">
                                                        <small class="hallNo_error fs-5 text-danger"></small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="rounded-0 shadow-none btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button"
                                                class="addHall rounded-0 shadow-none btn btn-primary">{{ __('Add New Hall') }}</button>
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
                    url: "/admin/halls/getHalls",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.halls.data, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.nameHall +
                                '</td><td class="text-center"><button type="button" value="' +
                                item.id +
                                '"class="hall-delete btn btn-outline-danger mx-1 shadow-none"><i class="fa-solid fa-trash"></i></button></td></tr>'
                            );

                        });
                    }
                });
            }
            $(document).on('click', '.addHall', function(e) {
                e.preventDefault(e);
                var data = {
                    'floorNo': $('.floorNo').val(),
                    'hallNo': $('.hallNo').val(),
                };


                $.ajax({
                    type: "POST",
                    url: "/admin/halls/store",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        $('.floorNo').removeClass('is-invalid');
                        $('.floorNo_error').empty();
                        $('.hallNo').removeClass('is-invalid');
                        $('.hallNo_error').empty();


                        if (response.status == false) {

                            if (response.errors['floorNo'] != null) {
                                $('.floorNo').addClass('is-invalid');
                                $('.floorNo_error').append(response.errors['floorNo']);
                            }
                            if (response.errors['hallNo'] != null) {
                                $('.hallNo').addClass('is-invalid');
                                $('.hallNo_error').append(response.errors['hallNo']);
                            }
                        } else {
                            fetch();
                            toastr.success(response.success);
                            // console.log(response.success);
                        }

                    }
                });
            });
            $(document).on('click', '.hall-delete', function(e) {
                e.preventDefault(e);
                var hallid = $(this).val();

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
                            url: `/admin/halls/destroy/${hallid}`,
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
