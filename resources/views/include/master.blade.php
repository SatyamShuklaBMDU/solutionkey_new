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
            position: fixed !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
    @yield('script-area')
    @include('include.foot')
</body>
</html>
