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
        .statusSwitch {
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

        .statusSwitch:before {
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

        .statusSwitch:checked {
            background-color: #85ff7a;
        }

        .statusSwitch:checked:before {
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
                        style="text-decoration: none;color:#0d9603 !important;font-weight:600;font-size:20px;">Customer
                        Management</a></li>
                <li class="breadcrumb-item active" aria-current="page"
                    style="text-decoration: none;color:#033496 !important;font-weight:600;font-size:18px;">Customer Details
                </li>
            </ol>
        </nav>
        <div class="main_content_iner">
            <div class="container-fluid plr_30 body_white_bg pt_30">
                <div class="row justify-content-center">
                    <div class="col-lg-12 ">
                        <div class="row mb" style="margin-bottom: 50px; margin-left: 5px;">
                            <form action="{{ route('customer-filters') }}" method="post">
                                @csrf
                                <div class="row">
                                    @include('admin.date')
                                    <div class="col-sm-1" style="margin-left: 10px; margin-top: 40px;">
                                        <a class="btn text-white shadow-lg" href="{{ route('customer-show') }}"
                                            style="background-color:#033496;">Reset</a>
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
                                                <th style="text-align: center;">S no.</th>
                                                <th style="text-align: center;">Registration Date</th>
                                                <th style="text-align: center;">Customer ID</th>
                                                <th style="text-align: center;">Name</th>
                                                <th style="text-align: center;">Phone number</th>
                                                <th style="text-align: center;">Email</th>
                                                <th style="text-align: center;">Action</th>
                                                <th style="text-align: center;">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer as $customers)
                                                <tr data-customer-id="{{ $customers->id }}">
                                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                    <td style="text-align: center;">
                                                        {{ date('d-m-Y', strtotime($customers->created_at)) }}</td>
                                                    <td style="text-align: center;">{{ $customers->customers_id }}</td>
                                                    <td style="text-align: center;">{{ $customers->name }}</td>
                                                    <td style="text-align: center;">{{ $customers->phone_number }}</td>
                                                    <td style="text-align: center;">{{ $customers->email }}</td>
                                                    <td style="text-align: center;">
                                                        <div class="d-flex">
                                                            <input type="checkbox"
                                                                {{ $customers->account_status == 1 ? 'checked' : '' }}
                                                                class="statusSwitch">
                                                            <i class="fa fa-eye"
                                                                style="top: 10px;position: relative;cursor: pointer;"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $customers->deactivation_remark ?? '--' }}</td>
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
    <div class="modal fade" id="customerDetailModal" tabindex="-1" aria-labelledby="customerDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="customerProfilePic" src="" alt="Profile Picture"
                            class="img-fluid rounded-circle mb-3" style="display: none; max-width: 150px;">
                    </div>
                    <p><strong>ID:</strong> <span id="customerId"></span></p>
                    <p><strong>Name:</strong> <span id="customerName"></span></p>
                    <p><strong>Gender:</strong> <span id="customerGender"></span></p>
                    <p><strong>Phone Number:</strong> <span id="customerPhone"></span></p>
                    <p><strong>Email:</strong> <span id="customerEmail"></span></p>
                    <p><strong>Marital Status:</strong> <span id="customerMaritalStatus"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="customerDob"></span></p>
                    <p><strong>City:</strong> <span id="customerCity"></span></p>
                    <p><strong>State:</strong> <span id="customerState"></span></p>
                    <p><strong>Address:</strong> <span id="customerAddress"></span></p>
                    <p><strong>Registration Date:</strong> <span id="customerRegistrationDate"></span></p>
                    <p><strong>Status:</strong> <span id="customerStatus"></span></p>
                    <p><strong>Remark:</strong> <span id="customerRemark"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-area')
    <!-- Existing scripts -->
    <script>
        $(document).ready(function() {
            $('.statusSwitch').change(function() {
                var customerId = $(this).closest('tr').data('customer-id');
                var newStatus = $(this).is(':checked') ? 1 : 0;
                var checkbox = $(this);

                if (newStatus == 0) {
                    Swal.fire({
                        title: 'Reason for Deactivation',
                        input: 'text',
                        inputLabel: 'Please enter the reason for deactivation:',
                        inputPlaceholder: 'Enter reason',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to provide a reason!'
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/change-customer-status') }}",
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    customer_id: customerId,
                                    new_status: newStatus,
                                    remark: result.value,
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Account status changed successfully!',
                                    }).then(function() {
                                        location.reload();
                                    });
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'There was an error changing the account status.',
                                    });
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            checkbox.prop('checked',
                                true); // Recheck the checkbox if the user cancels
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ url('/change-customer-status') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            customer_id: customerId,
                            new_status: newStatus,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Account status changed successfully!',
                            }).then(function() {
                                location.reload();
                            });
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error changing the account status.',
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script>
        // Helper function to format date
        function formatDate(dateString) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const date = new Date(dateString);
            return date.toLocaleDateString(undefined, options);
        }

        // Function to fetch and display customer details
        function showCustomerDetails(customerId) {
            fetch("{{ url('/get-customer-details') }}/" + customerId)
                .then(response => response.json())
                .then(response => {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error,
                        });
                        return;
                    }

                    document.getElementById('customerId').textContent = response.id;
                    document.getElementById('customerName').textContent = response.name;
                    document.getElementById('customerGender').textContent = response.gender;
                    document.getElementById('customerPhone').textContent = response.phone_number;
                    document.getElementById('customerEmail').textContent = response.email;
                    document.getElementById('customerMaritalStatus').textContent = response.marital_status;
                    document.getElementById('customerDob').textContent = formatDate(response.dob);
                    document.getElementById('customerCity').textContent = response.city;
                    document.getElementById('customerState').textContent = response.state;
                    document.getElementById('customerAddress').textContent = response.address;
                    document.getElementById('customerRegistrationDate').textContent = formatDate(response.created_at);
                    document.getElementById('customerStatus').textContent = response.account_status == 1 ? 'Active' :
                        'Inactive';
                    document.getElementById('customerRemark').textContent = response.deactivation_remark || '--';

                    const profilePic = document.getElementById('customerProfilePic');
                    if (response.profile_pic) {
                        profilePic.src = response.profile_pic;
                        profilePic.style.display = 'block';
                    } else {
                        profilePic.style.display = 'none';
                    }

                    const modal = new bootstrap.Modal(document.getElementById('customerDetailModal'));
                    modal.show();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error fetching the customer details.',
                    });
                    console.error(error);
                });
        }

        // Add event listener to all .fa-eye icons
        document.querySelectorAll('.fa-eye').forEach(icon => {
            icon.addEventListener('click', function() {
                const customerId = this.closest('tr').dataset.customerId;
                showCustomerDetails(customerId);
            });
        });
    </script>
@endsection
