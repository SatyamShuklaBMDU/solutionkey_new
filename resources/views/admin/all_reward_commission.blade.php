@extends('include.master')

@section('style-area')
    <style>
        .main_content {
            padding-left: 283px;
            padding-bottom: 0% !important;
            margin: 0px !important;
        }

        .breadcrumb {
            font-size: 18px !important;
            background-color: transparent;
            margin-bottom: 0;
            padding: 10px 0;
        }

        .notification-form {
            padding: 12px;
            margin: 14px 0px 40px 0px;
        }

        .Modules {
            flex-wrap: wrap;
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
            /* Adjust the font size as needed */
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
    </style>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Reward &
                        Commission </a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496;font-weight:600;font-size:18px;">All Reward & Commission</li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('reward-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('reward-commission') }}"
                                            style="background-color:#033496;">Reset</a>
                                    </div>
                                    <div class="col-sm-3 text-end" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('reward-create') }}"
                                            style="background-color:#033496;">Create New Reward</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="customerTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S No.</th>
                                            <th class="text-center"> Date</th>
                                            <th class="text-center">Reward Type</th>
                                            <th class="text-center">Reward Amount</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reward_commissions as $reward)
                                            <tr class="odd" data-reward-id="{{ $reward->id }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($reward->created_at)->format('d M,Y') }}</td>
                                                <td class="text-center">{{ $reward->reward_type }}</td>
                                                <td class="text-center">{{ $reward->reward_amount }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger delete-reward"
                                                        data-reward-id="{{ $reward->id }}">
                                                        <i class="fa fa-trash-o"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger edit-reward"
                                                        data-reward-id="{{ $reward->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editRewardModal">
                                                        <i class="fa fa-pencil"
                                                            style="padding-right: -10px;font-size: 17px;"></i>
                                                    </button>
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
        <!-- Edit Reward Modal -->
        <div class="modal fade" id="editRewardModal" tabindex="-1" aria-labelledby="editRewardModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRewardModalLabel">Edit Reward</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editRewardForm" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="reward_id" id="editRewardId">
                            <div class="mb-3">
                                <label for="editRewardType" class="form-label">Reward Type</label>
                                <input type="text" class="form-control" readonly id="editRewardType" name="reward_type" required>
                            </div>
                            <div class="mb-3">
                                <label for="editRewardAmount" class="form-label">Reward Amount</label>
                                <input type="number" class="form-control" id="editRewardAmount" name="reward_amount"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('script-area')
        <script>
            $(document).ready(function() {
                $('#customerTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
                @if (session()->has('success'))
                    toastr.success('{{ session('success') }}');
                @endif
                $('.edit-reward').click(function() {
                    var rewardId = $(this).data('reward-id');
                    var rewardType = $(this).closest('tr').find('td:eq(2)').text();
                    var rewardAmount = $(this).closest('tr').find('td:eq(3)').text();
                    $('#editRewardId').val(rewardId);
                    $('#editRewardType').val(rewardType);
                    $('#editRewardAmount').val(rewardAmount);
                    $('#editRewardForm').attr('action', '{{ url('reward-update') }}/' + rewardId);
                });
                $('.delete-reward').click(function(event) {
                    event.preventDefault();
                    var rewardId = $(this).data('reward-id');
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
                                url: '{{ route('delete-reward', '') }}' + '/' + rewardId,
                                type: 'GET',
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Reward has been deleted.',
                                        'success'
                                    );
                                    location.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the reward.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
