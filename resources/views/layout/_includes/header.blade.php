<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body>
<header>
    <ul>
        <li><a href="/">Home</a></li>
        @if(Auth::guest())
            <li><a href="{{route('site.login')}}">Login</a></li>
        @else
            <li><a href="{{route('admin.cursos')}}">Cursos</a></li>
            <li><a href="#">{{Auth::user()->name}}</a></li>
            <li><a href="{{ route('site.login.sair') }}">Sair</a></li>
        @endif
    </ul>
</header>
    
