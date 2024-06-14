@if (!function_exists('isActiveMenu'))
    @php
        // Function to determine if a menu should be expanded
        function isActiveMenu($routes)
        {
            foreach ($routes as $route) {
                if (Route::currentRouteName() == $route) {
                    return true;
                }
            }
            return false;
        }
    @endphp
@endif

<div class="sidebar">
    <div class="d-flex justify-content-between" style="width: 200px; margin: 10px;">
        <div class="space mt-2">
            <span><img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="Logo"></span>
        </div>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page"
                href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        @if (auth()->check() && auth()->user()->hasPermission('servicemanagement'))
            @php
                $serviceRoutes = ['service', 'sub-service'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($serviceRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#servicemenu"
                    aria-expanded="{{ isActiveMenu($serviceRoutes) ? 'true' : 'false' }}"
                    aria-controls="servicemenu">Category Management <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav flex-column collapse {{ isActiveMenu($serviceRoutes) ? 'show' : '' }}" id="servicemenu">
                    <li class="nav-item"><a class="nav-link ps-5 {{ request()->routeIs('service') ? 'active' : '' }}"
                            href="{{ route('service') }}"style="padding-left:0px">All Category</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('sub-service') ? 'active' : '' }}"
                            href="{{ route('sub-service') }}"style="padding-left:0px">All Sub Category</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('customermanagement'))
            @php
                $customerRoutes = ['customer-show', 'customer-document', 'customer-family'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($customerRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#customerMenu"
                    aria-expanded="{{ isActiveMenu($customerRoutes) ? 'true' : 'false' }}"
                    aria-controls="customerMenu">Customer Management <span class="dropdown-toggle ps-1"></span></a>
                <ul class="nav collapse {{ isActiveMenu($customerRoutes) ? 'show' : '' }}" id="customerMenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('customer-show') ? 'active' : '' }}"
                            href="{{ route('customer-show') }}"style="padding-left:0px">Customer Details</a></li>
                    {{-- <li class="nav-item"><a class="nav-link ps-5 {{ request()->routeIs('customer-document') ? 'active' : '' }}" href="{{ route('customer-document') }}"style="padding-left:0px">Customer Documents</a></li>
                    <li class="nav-item"><a class="nav-link ps-5 {{ request()->routeIs('customer-family') ? 'active' : '' }}" href="{{ route('customer-family') }}"style="padding-left:0px">Customer Family Details</a></li> --}}
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('blogmanagement'))
            @php
                $blogRoutes = ['blog-pending', 'blog-approved'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($blogRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#blogmenu"
                    aria-expanded="{{ isActiveMenu($blogRoutes) ? 'true' : 'false' }}" aria-controls="blogmenu">Blog
                    Management <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($blogRoutes) ? 'show' : '' }}" id="blogmenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('blog-pending') ? 'active' : '' }}"
                            href="{{ route('blog-pending') }}"style="padding-left:0px">Blog Pending</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('blog-approved') ? 'active' : '' }}"
                            href="{{ route('blog-approved') }}"style="padding-left:0px">Blog Approved</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('professionalmanagement'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('vendor-show') ? 'active' : '' }}"
                    href="{{ route('vendor-show') }}">Professional Management</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('booking'))
            @php
                $bookingRoutes = ['online-booking', 'physical-booking'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($bookingRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#bookingmenu"
                    aria-expanded="{{ isActiveMenu($bookingRoutes) ? 'true' : 'false' }}"
                    aria-controls="bookingmenu">Booking & Scheduling <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($bookingRoutes) ? 'show' : '' }}" id="bookingmenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('online-booking') ? 'active' : '' }}"
                            href="{{ route('online-booking') }}"style="padding-left:0px">Online Bookings</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('physical-booking') ? 'active' : '' }}"
                            href="{{ route('physical-booking') }}"style="padding-left:0px">Physical Bookings</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('payment'))
            @php
                $paymentRoutes = ['payments'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($paymentRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#paymentmenu"
                    aria-expanded="{{ isActiveMenu($paymentRoutes) ? 'true' : 'false' }}"
                    aria-controls="paymentmenu">Payment & Invoicing <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($paymentRoutes) ? 'show' : '' }}" id="paymentmenu">
                    <li class="nav-item"><a class="nav-link ps-5 {{ request()->routeIs('payments') ? 'active' : '' }}"
                            style="padding-left:0px" href="#">Payments</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('notifications'))
            @php
                $notificationRoutes = ['notification-create', 'notification'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($notificationRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#notificationmenu"
                    aria-expanded="{{ isActiveMenu($notificationRoutes) ? 'true' : 'false' }}"
                    aria-controls="notificationmenu">Notification <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($notificationRoutes) ? 'show' : '' }}" id="notificationmenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('notification-create') ? 'active' : '' }}"
                            href="{{ route('notification-create') }}"style="padding-left:0px">Add Notification</a>
                    </li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('notification') ? 'active' : '' }}"
                            href="{{ route('notification') }}"style="padding-left:0px">All Notification</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('feedback'))
            @php
                $feedbackRoutes = ['feedback', 'vendor-feedback'];
            @endphp
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('feedback') ? 'active' : '' }}" href="{{ route('feedback') }}">Feedbacks</a>
                
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($feedbackRoutes) ? '' : 'collapsed' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#feedbackmenu"
                    aria-expanded="{{ isActiveMenu($feedbackRoutes) ? 'true' : 'false' }}"
                    aria-controls="feedbackmenu">Feedbacks<span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($feedbackRoutes) ? 'show' : '' }}" id="feedbackmenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('feedback') ? 'active' : '' }}"
                            href="{{ route('feedback') }}" style="padding-left:0px">Users Feedback</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('vendor-feedback') ? 'active' : '' }}"
                            href="{{ route('vendor-feedback') }}" style="padding-left:0px">Vendors Feedback</a></li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('review'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reviews-rating') ? 'active' : '' }}"
                    href="{{ route('reviews-rating') }}">Reviews & Ratings</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('referral'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('referral-earning') ? 'active' : '' }}"
                    href="{{ route('referral-earning') }}">Referral & Earning</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('complaint'))
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('complaint') ? 'active' : '' }}" href="{{ route('complaint') }}">Complaints</a>
            </li> --}}
            @php
                $complaintRoutes = ['complaint', 'vendor-complaint'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($complaintRoutes) ? '' : 'collapsed' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#complaintmenu"
                    aria-expanded="{{ isActiveMenu($complaintRoutes) ? 'true' : 'false' }}"
                    aria-controls="complaintmenu">Complaints<span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($complaintRoutes) ? 'show' : '' }}" id="complaintmenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('complaint') ? 'active' : '' }}"
                            href="{{ route('complaint') }}" style="padding-left:0px">Users Complaint</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('vendor-complaint') ? 'active' : '' }}"
                            href="{{ route('vendor-complaint') }}" style="padding-left:0px">Vendors Complaint</a>
                    </li>
                </ul>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('reward'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user-banners.index') ? 'active' : '' }}"
                    href="{{ route('user-banners.index') }}">Banner</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('reward'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reward-commission') ? 'active' : '' }}"
                    href="{{ route('reward-commission') }}">Rewards & Commissions</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('analytic'))
            <li class="nav-item">
                <a class="nav-link" href="#">Analytics & Reporting</a>
            </li>
        @endif
        @if (auth()->check() && auth()->user()->hasPermission('usermanagement'))
            @php
                $userManagementRoutes = ['add-users', 'all-users'];
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ isActiveMenu($userManagementRoutes) ? 'active' : '' }}" href="#"
                    data-bs-toggle="collapse" data-bs-target="#usermenu"
                    aria-expanded="{{ isActiveMenu($userManagementRoutes) ? 'true' : 'false' }}"
                    aria-controls="usermenu">User Management <span class="dropdown-toggle ps-2"></span></a>
                <ul class="nav collapse {{ isActiveMenu($userManagementRoutes) ? 'show' : '' }}" id="usermenu">
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('add-users') ? 'active' : '' }}"
                            href="{{ route('add-users') }}"style="padding-left:0px">Add Accounts</a></li>
                    <li class="nav-item"><a
                            class="nav-link ps-5 {{ request()->routeIs('all-users') ? 'active' : '' }}"
                            href="{{ route('all-users') }}"style="padding-left:0px">All Accounts</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
