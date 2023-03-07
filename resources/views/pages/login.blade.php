<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Welcome</title>
<meta name="description" content="slick Login">
<meta name="author" content="Webdesigntuts+">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/login/style.css') }}" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
<script type="text/javascript" src="{{  asset('assets/login/placeholder.js')  }}"></script>
</head>
<body>
<form id="slick-login" action="{{ route('login.proses') }}" method="POST">
        @csrf
        <label for="username">Email</label><input type="text" name="email" class="placeholder" placeholder="me@tutsplus.com">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="password">Password</label><input type="password" name="password" class="placeholder" placeholder="password">
        @error('passowrd')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="submit">
</form>
</body>
</html>
