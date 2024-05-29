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

        /* For datepicker */
        .ui-datepicker {
            font-size: 15px;
        }

        /* For input placeholder */
        ::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            font-size: 15px;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            font-size: 15px;
        }

        :-ms-input-placeholder {
            /* IE 10+ */
            font-size: 15px;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            font-size: 15px;
        }
    </style>
@endsection
@section('content-area')
    <section class="main_content dashboard_part">
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Customer
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">All Family</li>
            </ol>
        </nav>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('family-filter',encrypt($Did)) }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('customer-family',encrypt($Did)) }}"
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
                                                <th style="text-align: center;">S No.</th>
                                                <th style="text-align: center;">Customer ID</th>
                                                <th style="text-align: center;">Customer Name</th>
                                                <th style="text-align: center;">Family Name</th>
                                                <th style="text-align: center;">Phone Number</th>
                                                <th style="text-align: center;">Email</th>
                                                <th style="text-align: center;">Actions</th> <!-- Add actions column -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_families as $family)
                                                <tr class="odd" data-user-id="{{ $family->id }}">
                                                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                    <td style="text-align:center;">{{ $family->customer->customers_id }}</td>
                                                    <td style="text-align:center;">{{ $family->customer->name }}</td>
                                                    <td style="text-align:center;">{{ $family->name }}</td>
                                                    <td style="text-align:center;">{{ $family->phone_number }}</td>
                                                    <td style="text-align:center;">{{ $family->email }}</td>
                                                    <td style="text-align: center;">
                                                        <button
                                                            onclick="showCustomerDetails('{{ url('family-details/' . $family->id) }}')"
                                                            class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>
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
    </section>

    <!-- Modal -->
    <!-- Customer Details Modal -->
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Customer Family Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Gender:</strong> <span id="modalCustomerGender"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="modalCustomerDob"></span></p>
                    <p><strong>Phone Number:</strong> <span id="modalCustomerPhoneNumber"></span></p>
                    <p><strong>Email:</strong> <span id="modalCustomerEmail"></span></p>
                    <p><strong>Marital Status:</strong> <span id="modalCustomerMaritalStatus"></span></p>
                    <p><strong>Address:</strong> <span id="modalCustomerAddress"></span></p>
                    <p><strong>City:</strong> <span id="modalCustomerCity"></span></p>
                    <p><strong>State:</strong> <span id="modalCustomerState"></span></p>
                    <p><strong>Deactivation Remark:</strong> <span id="modalCustomerDeactivationRemark"></span></p>
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
        function showCustomerDetails(fullUrl) {
            fetch(fullUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const details = data.data;
                        document.getElementById('modalCustomerName').innerText = details.name || 'N/A';
                        document.getElementById('modalCustomerGender').innerText = details.gender || 'N/A';
                        document.getElementById('modalCustomerDob').innerText = details.dob || 'N/A';
                        document.getElementById('modalCustomerPhoneNumber').innerText = details.phone_number || 'N/A';
                        document.getElementById('modalCustomerEmail').innerText = details.email || 'N/A';
                        document.getElementById('modalCustomerMaritalStatus').innerText = details.marital_status ||
                            'N/A';
                        document.getElementById('modalCustomerAddress').innerText = details.address || 'N/A';
                        document.getElementById('modalCustomerCity').innerText = details.city || 'N/A';
                        document.getElementById('modalCustomerState').innerText = details.state || 'N/A';
                        document.getElementById('modalCustomerDeactivationRemark').innerText = details
                            .deactivation_remark || 'N/A';

                        var customerDetailsModal = new bootstrap.Modal(document.getElementById(
                            'customerDetailsModal'), {
                            keyboard: false
                        });
                        customerDetailsModal.show();
                    } else {
                        alert('Customer family details not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching customer family details:', error);
                });
        }
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function() {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
