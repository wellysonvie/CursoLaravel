@extends('layout.site')

@section('titulo','Cursos')

@section('content')
  <div>
    <h3>Adicionar Curso</h3>
    <div>
      <form class="" action="{{route('admin.cursos.salvar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('admin.cursos._form')
        <button>Salvar</button>
      </form>
    </div>
  </div>
@endsection
