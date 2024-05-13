<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome In Solution Key </title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/colors/default.css') }}" id="colorSkinCSS">
    <link rel="stylesheet" href="{{ asset('css/bootstrap1.min.css') }}" />
    <style>
        .mt-80 {
    margin: 80px 0px 0px 0px;
}
    </style>
</head>

<body style="background-image:url(public/images/services/business-people-working-together.jpg); background-size:cover; box-shadow:inset 0 0 0 2000px rgb(0 0 0 / 44%); height:100vh;background-position: center center;">
    <div class="main_content_iner ">
        <div class="container-fluid plr_30  pt_30 ">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class=" mb_30 mt-80">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="modal-content cs_modal">
                                    <div class="modal-header mx-auto mt-0 pb-0">
                                        @if (Session::has('logout_message'))
                                            <div id="logoutMessage" class="alert alert-success">
                                                {{ Session::get('logout_message') }}
                                            </div>
                                        @endif
                                        <h3 class="modal-title">Sign In To Your Account</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('mylogin') }}" method="POST">
                                            {{ csrf_field() }}
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter your email" name="email">
                                            </div>
                                            <div class>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password">
                                            </div>
                                            <button class="btn_1 full_width text-center" type="submit">Log in</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/jquery1-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/popper1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap1.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var logoutMessage = document.getElementById('logoutMessage');
        if (logoutMessage) {
            setTimeout(function() {
                logoutMessage.style.display = 'none';
            }, 3000);
        }
    });
</script>

</html>
