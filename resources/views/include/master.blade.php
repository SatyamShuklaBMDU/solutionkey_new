<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <title>Solution Key</title>
    <style>
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            /* Change as needed */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add shadow */
        }

        /* Main menu items */
        .nav-item>.nav-link {
            color: #212529;
            /* Change as needed */
            padding: 12px 20px;
            font-size: 16px;
            text-decoration: none;
            position: relative;
            /* Ensure relative positioning for arrow */
        }

        /* Active menu item */
        .nav-item>.nav-link.active {
            background-color: #007bff;
            /* Change as needed */
            color: #fff;
        }

        /* Dropdown menus */
        .collapse {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .collapse.show {
            max-height: 1000px;
            /* Adjust to fit content */
        }

        /* Dropdown menu items */
        .collapse .nav-item .nav-link {
            padding-left: 40px;
            /* Indent dropdown items */
            transition: background-color 0.3s;
            /* Add smooth transition */
        }

        /* Hover effect on dropdown items */
        .collapse .nav-item .nav-link:hover {
            background-color: #ced4da;
            /* Change as needed */
        }

        /* Add arrow indicator to dropdowns */

        /* Rotate arrow when dropdown is active */

        .content-wrapper {
            width: 80%;
            float: right;
        }

        .header_iner {
            padding: 2px !important;
            margin-left: 19% !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .footer_part {
            padding-bottom: 0px !important;
            padding-top: 0px !important;
            position: relative !important;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: white;

        }

        .nav-item {
            width: 100%;
        }
    </style>
    <style>
        .dt-button {
            background-color: #033496 !important;
            color: white !important;
        }

        div.dt-container .dt-paging {
            margin-top: 0% !important;
            float: right !important;
        }

        div.dt-container .dt-search {
            float: right;
        }
    </style>
    @include('include.head')
    @yield('style-area')

<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('include.header')
        <div class="page-body-wrapper">
            @include('include.sidebar')
            <div class="page-body">
                @yield('content-area')
            </div>
        </div>
        @include('include.footer')
    </div>
    @include('include.foot')
    @yield('script-area')
</body>

</html>
