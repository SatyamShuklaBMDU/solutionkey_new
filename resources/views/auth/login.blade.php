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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body
    style="background-image: url({{ asset('img/background-image.jpg') }});background-position: center center;
background-repeat:  no-repeat;
background-attachment: fixed;
background-size:  cover;">
    <div style="background:rgba(0, 0, 0, 0.3);width: 100%;height: 100%;">
        <div class="container" style="padding: 3.95%;">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg p-4">
                        <div class="my-2 pt-5">
                            <div class="wrapper text-center mb-2">
                                <img src="{{ asset('img/logo.png') }}" class="wrapper mt-4 mb-2"alt=""
                                    style="width: 180px;height: 50px;">
                            </div>
                            @if (Session::has('logout_message'))
                                <div id="logoutMessage" class="alert alert-success">
                                    {{ Session::get('logout_message') }}
                                </div>
                            @endif
                            <h5 class="text-center mt-5">Sign in your account</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('login') }}" method="post">
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
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control py-4"
                                        placeholder="Enter your email" style="border-radius: 15px;"required>
                                </div>
                                <div class="form-group my-3">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control py-4"placeholder="Enter your password" required
                                        style="border-radius: 15px;">
                                </div>
                                <div class="form-group my-4 ms-3">
                                    <input type="checkbox" class="form-check-input"id="basic_checkbox_1"
                                        style="margin-left:5px">
                                    <label class="form-check-label" for="basic_checkbox_1"
                                        style="padding-left: 30px;">Remember My Preference</label>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-block py-2 shadow-sm"style="border-radius: 15px; background-color:#1271B7">Sign
                                    in</button>
                            </form>
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
