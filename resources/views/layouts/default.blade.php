<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    @include('layouts.header')

    @foreach($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach

    @if (Session::has('success'))
        <div class="success">
            {{ Session::get('success') }}
        </div>
    @endif

    @yield('content')
</body>

</html>