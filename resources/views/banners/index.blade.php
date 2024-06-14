@extends('include.master')
@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
        }

        .breadcrumb {
            font-size: 18px !important;
            background-color: transparent;
            margin-bottom: 0;
            padding: 10px 0;
        }

        .breadcrumb-item a {
            color: #333 !important;
        }

        .breadcrumb-item.active {
            color: #007bff !important;
        }

        .main_content .main_content_iner {
            margin: 0px !important;
        }

        #customerTable {
            font-size: 16px;
            / Adjust the font size as needed /
        }

        .dt-button {
            background-color: #033496 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-size: 14px;
            padding: 5px 10px;
            white-space: nowrap;
        }

        #customerTable_previous {
            transform: translateX(-20px);
        }

        / For DataTable / #customerTable_wrapper,
        #customerTable th,
        #customerTable td {
            font-size: 15px;
        }

        / For datepicker / .ui-datepicker {
            font-size: 15px;
        }

        ::-webkit-input-placeholder {
            font-size: 15px;
        }

        ::-moz-placeholder {
            font-size: 15px;
        }

        :-ms-input-placeholder {
            font-size: 15px;
        }

        :-moz-placeholder {
            font-size: 15px;
        }

        .vendor-status-switch {
            --s: 18px;
            /* adjust this to control the size*/

            height: calc(var(--s) + var(--s)/5);
            width: auto;
            /* some browsers need this */
            aspect-ratio: 2.25;
            border-radius: var(--s);
            margin: calc(var(--s)/2);
            display: grid;
            cursor: pointer;
            background-color: #ff7a7a;
            box-sizing: content-box;
            overflow: hidden;
            transition: .3s .1s;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .vendor-status-switch:before {
            content: "";
            padding: calc(var(--s)/10);
            --_g: radial-gradient(circle closest-side at calc(100% - var(--s)/2) 50%, #000 96%, #0000);
            background:
                var(--_g) 0 /var(--_p, var(--s)) 100% no-repeat content-box,
                var(--_g) var(--_p, 0)/var(--s) 100% no-repeat content-box,
                #fff;
            mix-blend-mode: darken;
            filter: blur(calc(var(--s)/12)) contrast(11);
            transition: .4s, background-position .4s .1s,
                padding cubic-bezier(0, calc(var(--_i, -1)*200), 1, calc(var(--_i, -1)*200)) .25s .1s;
        }

        .vendor-status-switch:checked {
            background-color: #85ff7a;
        }

        .vendor-status-switch:checked:before {
            padding: calc(var(--s)/10 + .05px) calc(var(--s)/10);
            --_p: 100%;
            --_i: 1;
        }
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Banner
                        Management</a></li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-primary mb-3" id="createBannerBtn">Create New Banner</button>
                                <div class="table-responsive">
                                    <table id="customerTable" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S no.</th>
                                                <th class="text-center">Banner For</th>
                                                <th class="text-center">Banner Image</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($banners as $banner)
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $banner->for }}</td>
                                                <td class="text-center"><a href="{{ asset($banner->image) }}"
                                                        target="_blank" rel="noopener noreferrer"><img
                                                            src="{{ asset($banner->image) }}" width="50px" height="50px"
                                                            alt="No Image"></a></td>
                                                <td class="text-center"><input type="checkbox" class="vendor-status-switch"
                                                        {{ $banner->status == '1' ? 'checked' : '' }}
                                                        data-id="{{ $banner->id }}"></td>
                                                <td class="text-center">
                                                    <button class="btn btn-secondary editBannerBtn"
                                                        data-id="{{ $banner->id }}" data-for="{{ $banner->for }}"
                                                        data-image="{{ $banner->image }}"
                                                        data-status="{{ $banner->status }}">Edit</button>
                                                    <button class="btn btn-danger deleteBannerBtn"
                                                        data-id="{{ $banner->id }}">Delete</button>
                                                </td>
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
    </section>

    <!-- Modal -->
    <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bannerModalLabel">Create/Edit User Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bannerForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="bannerId" name="id">
                        <div class="mb-3">
                            <label for="for" class="form-label">For</label>
                            <input type="text" class="form-control" id="for" name="for">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary float-end" id="saveBannerBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-area')
    <script>
        $(document).ready(function() {
            $('#customerTable').DataTable();
            $('#createBannerBtn').click(function() {
                $('#bannerForm')[0].reset();
                $('#bannerId').val('');
                $('#bannerModalLabel').text('Create User Banner');
                $('#bannerModal').modal('show');
            });

            $(document).on('click', '.editBannerBtn', function() {
                var id = $(this).data('id');
                var forText = $(this).data('for');
                $('#bannerId').val(id);
                $('#for').val(forText);
                $('#bannerModalLabel').text('Edit User Banner');
                $('#bannerModal').modal('show');
            });

            $('#bannerForm').submit(function(event) {
                event.preventDefault();

                var id = $('#bannerId').val();
                var url = id ? '{{ url('user-banners') }}/' + id : '{{ route('user-banners.store') }}';
                var method = id ? 'POST' : 'POST';
                var formData = new FormData(this);

                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        location.reload()
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
            $(document).on('click', '.deleteBannerBtn', function() {
                var id = $(this).data('id');
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
                            url: '{{ url('user-banners') }}/' + id,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Banner has been deleted.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the banner!',
                                    'error'
                                );
                                console.log(response);
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.vendor-status-switch', function() {
                var id = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
                $.ajax({
                    url: '{{ url('user-banners/status') }}/' + id,
                    method: 'PUT',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Status has been updated successfully!',
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating the status!',
                        });
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection
