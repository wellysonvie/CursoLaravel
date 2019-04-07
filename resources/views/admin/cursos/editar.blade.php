@extends('layout.site')

@section('titulo','Cursos')

@section('content')
  <div>
    <h3>Editar Curso</h3>
    <div>
      <form class="" action="{{route('admin.cursos.atualizar', $registro->id)}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="put">
        @include('admin.cursos._form')
        <button>Atualizar</button>
      </form>
    </div>
  </div>
@endsection
