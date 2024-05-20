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
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Professional
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Vendor Details
                </li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('vendor-filter') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-md-1 text-end" style="margin-left: 10px; margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('vendor-show') }}"
                                            style="background-color:#033496;font-size:15px;">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customerTable" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S no.</th>
                                                <th class="text-center">Registration Date</th>
                                                <th class="text-center">Vendor Id</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Whatsapp number</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Action</th>
                                                {{-- <th>Remark</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vendor as $vendors)
                                                <tr data-vendor-id="{{ $vendors->id }}">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ date('d-m-Y', strtotime($vendors->created_at)) }}</td>
                                                    <td class="text-center">{{ $vendors->vendor_id }}</td>
                                                    <td class="text-center">{{ $vendors->name }}</td>
                                                    <td class="text-center">{{ $vendors->whatsapp_number }}</td>
                                                    <td class="text-center">{{ $vendors->email }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex">
                                                            <button class="btn btn-info view-details"
                                                                data-vendor-id="{{ $vendors->id }}"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <input type="checkbox" class="vendor-status-switch"
                                                                {{ $vendors->account_status == '1' ? 'checked' : '' }}
                                                                data-vendor-id="{{ $vendors->id }}">
                                                        </div>
                                                    </td>
                                                    {{-- <td>{{ $vendors->deactivation_remark ?? '--' }}</td> --}}
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
    </section>
    <div class="modal fade" id="vendorDetailsModal" tabindex="-1" aria-labelledby="vendorDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorDetailsModalLabel">Vendor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Toggle switch change event with SweetAlert2
            $('.vendor-status-switch').on('change', function() {
                var vendorID = $(this).data('vendor-id');
                var isChecked = $(this).is(':checked');
                var status = isChecked ? '1' : '0';

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change status this vendor.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var remark = '';
                        if (!isChecked) {
                            remark = Swal.fire({
                                title: 'Enter the reason for deactivation',
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Submit',
                                showLoaderOnConfirm: true,
                            }).then(inputResult => {
                                if (inputResult.isConfirmed) {
                                    changeVendorStatus(vendorID, isChecked, inputResult
                                        .value);
                                } else {
                                    $(this).prop('checked', !isChecked); // Reset the toggle
                                }
                            });
                        } else {
                            changeVendorStatus(vendorID, isChecked, remark);
                        }
                    } else {
                        $(this).prop('checked', !isChecked); // Reset the toggle
                    }
                });
            });

            function changeVendorStatus(vendorID, newStatus, remark) {
                $.ajax({
                    url: "{{ route('change.vendor.account.status') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        vendor_id: vendorID,
                        new_status: newStatus,
                        remark: remark,
                    },
                    success: function(response) {
                        Swal.fire('Updated!', 'The vendor status has been updated.', 'success');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Failed!', 'There was a problem changing the status.', 'error');
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.view-details');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var vendorId = this.getAttribute('data-vendor-id');
                    var url = `{{ url('api/get-vendor-details') }}/${vendorId}`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            var profilePicture = "{{ asset('') }}" + data.profile_picture;
                            var coverPicture = "{{ asset('') }}" + data.cover_picture;
                            var content = `
                                <p><strong>Vendor ID:</strong> ${data.vendor_id}</p>
                                <p><strong>Name:</strong> ${data.name}</p>
                                <p><strong>Highest Qualification:</strong> ${data.highest_qualification?data.highest_qualification:'N/A'}</p>
                                <p><strong>Designation:</strong> ${data.designation?data.designation:'N/A'}</p>
                                <p><strong>Area of Interest:</strong> ${data.area_of_interest?data.area_of_interest:'N/A'}</p>
                                <p><strong>WhatsApp Number:</strong> ${data.whatsapp_number}</p>
                                <p><strong>Gender:</strong> ${data.gender}</p>
                                <p><strong>Email:</strong> ${data.email?data.email:"N/A"}</p>
                                <p><strong>Experience:</strong> ${data.experience?data.experience:'N/A'}</p>
                                <p><strong>Current Job:</strong> ${data.current_job? data.current_job : 'N/A'}</p>
                                <p><strong>Charge Per Minute for Audio Call:</strong> ${data.charge_per_minute_for_audio_call?data.charge_per_minute_for_audio_call:'N/A'}</p>
                                <p><strong>Charge Per Minute for Video Call:</strong> ${data.charge_per_minute_for_video_call?data.charge_per_minute_for_video_call:"N/A"}</p>
                                <p><strong>Charge Per Minute for Chat:</strong> ${data.charge_per_minute_for_chat?data.charge_per_minute_for_chat:'N/A'}</p>
                                <p><strong>Aadhar Number:</strong> ${data.adhar_number?data.adhar_number:"N/A"}</p>
                                <p><strong>PAN Number:</strong> ${data.pancard? data.pancard : 'N/A'}</p>
                                <p><strong>About:</strong> ${data.about?data.about:'N/A'}</p>
                                <p><strong>City:</strong> ${data.city ? data.city : 'N/A'}</p>
                                <p><strong>State:</strong> ${data.state? data.state : 'N/A'}</p>
                                <p><strong>Address:</strong> ${data.address? data.address : 'N/A'}</p>
                                <p><strong>Status:</strong> ${data.status ? 'Active' : 'Inactive'}</p>
                                <p><strong>Profile Picture:</strong><br><img src="${profilePicture}" width="100px" height="100px"></p>
                                <p><strong>Cover Picture:</strong><br><img src="${coverPicture}" width="100px" height="100px"></p>
                                <p><strong>Account Status:</strong> ${data.account_status ? 'Active' : 'Inactive'}</p>
                                <p><strong>Deactivated At:</strong> ${data.deactivated_at ? data.deactivated_at : 'N/A'}</p>
                                <p><strong>Deactivation Remark:</strong> ${data.deactivation_remark ? data.deactivation_remark : 'N/A'}</p>
                            `;

                            document.querySelector('#vendorDetailsModal .modal-body')
                                .innerHTML = content;
                            var vendorDetailsModal = new bootstrap.Modal(document
                                .getElementById('vendorDetailsModal'));
                            vendorDetailsModal.show();
                        })
                        .catch(error => {
                            console.error('Error loading details:', error);
                        });
                });
            });
        });
    </script>
@endsection
