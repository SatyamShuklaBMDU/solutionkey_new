<style>
    .has-arrow+ul {
        display: none;
    }

    .show {
        display: block;
    }
   
/* nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline-block;
    margin-right: 10px;
    position: relative;
}

nav ul li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding-bottom: 5px; /* Space for the line */
    /* transition: color 0.3s ease;
} */
nav ul li a i{
    padding: 0 5px;
}
nav ul li a:hover {
    color: #cfe6ff; /* Change color on hover */
}

/* Line effect */
nav ul li a::after {
    content: '';
    position: absolute;
    width: 85%;
    height: 2px; /* Height of the line */
    background-color: #beddff; /* Color of the line */
    bottom: 0;
    left: 0;
    transform: scaleX(0); /* Initially scale down to 0 */
    transition: transform 0.3s ease;
}

nav ul li a:hover::after {
    transform: scaleX(1); /* Scale up on hover */
}
</style>

<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar" >
    <nav class="sidebar">
        <div class="d-flex justify-content-between" style="width: 200px;margin:10px;">
            <div class="space">
                <a href="#"><img src="{{ asset('img/logo.jpg') }}" class="img-fluid"></a>
            </div>
            <div class="sidebar_close_icon d-lg-none">
                <i class="ti-close"></i>
            </div>
        </div>
        <ul id="sidebar_menu">
            <li class="mm-active treeview">
                <a href="{{ route('dashboard') }}" style="text-decoration:none;">
                    <div class="icon">
                        <i class="fa fa-home" style="color:#fff;"></i>
                    </div>
                    <span style="font-size:14px;color:#fff;font-weight:700;">Dashboard</span>
                </a>
            </li>
            @if (auth()->check() && auth()->user()->hasPermission('servicemanagement'))
                {{--  <li>
                <a href="{{ route('service') }}" style="text-decoration:none;">
                    <i class="fa fa-exclamation" style="color: #fff;"></i>
                    <span style="font-size: 14px; color: #fff;font-weight:700;">Service Management</span>
                </a>
            </li>  --}}

                <li class="treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                        <i class="fa fa-folder-open" style="color: #fff;"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700">Service Management</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('service') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>All
                                    Services</span></a></li>
                        <li><a href="{{ route('service-create') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Add
                                    Services</span></a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('professionalmanagement'))
                <li class="treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                        <i class="fa fa-user-tie" style="color: #fff;"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700">Professional Management</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('vendor-show') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Professionals</span></a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('customermanagement'))
                <li class="treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                        <i class="fa fa-users" style="color: #fff;"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700">Customer Management</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('customer-shows') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Customer
                                    Details</span></a></li>
                        <li><a href="{{ route('customer-document') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Customer
                                    Documents</span></a></li>
                        <li><a href="{{ route('customer-family') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Customer Family
                                    Details</span></a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('booking'))
                <li class="treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                        <i class="fa fa-user-circle" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700">Booking & Scheduling</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('online-booking') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Online
                                    Bookings</span></a>
                        <li><a href="{{ route('physical-booking') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Physical
                                    Bookings</span></a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('payment'))
                <li class="mm-active treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                    <i class="fa fa-money text-white" aria-hidden="true"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700;">Payment & Invoicing</span>
                    </a>
                    <ul class="treeview-main">
                        <li><a href="#" style="color: #fff;text-decoration:none;font-weight:700;"><span>Payments</span></a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('blogmanagement'))
                <li class="mm-active treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                       <i class="fa fa-rss-square text-white" aria-hidden="true"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700;">Blog Management</span>
                    </a>
                    <ul class="treeview-main">
                        <li><a href="{{ route('blog-pending') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Blog
                                    Pending</span></a></li>
                        <li><a href="{{ route('blog-approved') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Blog
                                    Approved</span></a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('notifications'))
                <li class="mm-active treeview">
                    <a class="has-arrow" href="{{ route('notification') }}" aria-expanded="false"
                        style="text-decoration:none;">
                        <i class="fas fa-bell" style="color: #fff;"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700;">Notification</span>
                    </a>
                    <ul class="treeview-main">
                        <li><a href="{{ route('notification-create') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Add
                                    Notification</span></a></li>
                        <li><a href="{{ route('notification') }}"
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>All
                                    Notification</span></a></li>
                    </ul>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('feedback'))
                <li class="treeview">
                    <a href="{{ route('feedback') }}" style="text-decoration:none;">
                        <i class="fa fa-comments" style="color: #fff;"></i>
                        {{-- <i class="fa-sharp fa-solid fa-comments" style="color: #fff;"></i> --}}
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Feedbacks</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('review'))
                <li class="treeview">
                    <a href="{{ route('reviews-rating') }}" style="text-decoration: none;">
                        <i class="fa fa-star" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Reviews & Ratings</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('referral'))
                <li class="treeview">
                    <a href="{{ route('referral-earning') }}" style="text-decoration: none;">
                        <i class="fa fa-money-bill-alt" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Referral & Earning</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('complaint'))
                <li class="treeview">
                    <a href="{{ route('complaint') }}" style="text-decoration: none;">
                        <i class="fa fa-exclamation-triangle" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Complaints</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('reward'))
                <li class="treeview">
                    <a href="{{ route('reward-commission') }}" style="text-decoration: none;">
                        <i class="fa fa-gift" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Rewards & Commissions</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('analytic'))
                <li class="treeview">
                    <a href="#" style="text-decoration: none;">
                        <i class="fas fa-chart-line" style="color: #fff;"></i>
                        <span style="font-size: 14px;color: #fff;font-weight:700;">Analytics & Reporting</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->hasPermission('usermanagement'))
                <li class="treeview">
                    <a class="has-arrow" href="#" aria-expanded="false" style="text-decoration:none;">
                        <i class="fa fa-address-card" style=" color:#fff;"></i>
                        <span style="font-size: 14px; color: #fff;font-weight:700;">User Management</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('add-users') }} "
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>Add
                                    Accounts</span></a></li>
                        <li><a href="{{ route('all-users') }} "
                                style="color: #fff;text-decoration:none;font-weight:700;"><span>All
                                    Accounts</span></a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</ul>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var hasArrowLinks = document.querySelectorAll('.has-arrow');

    hasArrowLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior

            // Toggle the visibility of the submenu
            var submenu = link.nextElementSibling;
            submenu.classList.toggle('show');
        });
    });

    // JavaScript to activate the menu based on the URL
    var currentURL = window.location.href;
    var sidebarLinks = document.querySelectorAll(".sidebar_menu a");

    for (var i = 0; i < sidebarLinks.length; i++) {
        var link = sidebarLinks[i];

        if (link.href === currentURL) {
            // Add the "active" class to the link and its parent list item
            link.classList.add("active");
            link.parentElement.classList.add("active");

            // If you want to expand any parent treeviews, you can add this code
            var parentTreeview = link.closest(".treeview");
            if (parentTreeview) {
                parentTreeview.classList.add("active");
            }
        }
    }
});
</script>
