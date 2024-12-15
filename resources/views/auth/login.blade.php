<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <div class="login-form">
        <form method="POST" action="{{ route('postlogin') }}">
            @csrf
            <div class="login-text">Đăng nhập</div>
            @if(\Session::has('message'))
                <span class="error">
                    {{ \Session::get('message') }}
                </span>
            @endif
            <label>Email</label>
            <input type="email" name="email">
            <span class="error">{{ $errors->first('email') }}</span>
            <label>Mật khẩu</label>
            <input type="password" name="password">
            <span class="error">{{ $errors->first('password') }}</span>
            <input type="submit" value="Đăng nhập">
        </form>
    </div>
</body>
</html>
