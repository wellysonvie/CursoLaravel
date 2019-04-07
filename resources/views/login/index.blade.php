@extends('layout.site')

@section('titulo','Login')

@section('content')
  <div>
    <h3>Login</h3>
    <div>
      <form action="{{route('site.login.entrar')}}" method="post">
        {{ csrf_field() }}
        <input type="email" name="email" id="" placeholder="E-mail">
        <input type="password" name="senha" id="" placeholder="Senha">
        <button>Entrar</button>
      </form>
    </div>
  </div>
@endsection
