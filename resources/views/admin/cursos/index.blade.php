
@extends('layout.site')

@section('title', 'Cursos')
    
@section('content')

<div>
    <h3>Lista de cursos</h3>
    <div>
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Imagem</th>
            <th>Publicado</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
          @foreach($registros as $registro)
            <tr>
              <td>{{ $registro->id }}</td>
              <td>{{ $registro->titulo }}</td>
              <td>{{ $registro->descricao }}</td>
              <td><img width="120" src="{{asset($registro->imagem)}}" alt="{{ $registro->titulo }}" /></td>
              <td>{{ $registro->publicado }}</td>
              <td>
                <a href="{{ route('admin.cursos.editar',$registro->id) }}">Editar</a>
                <a href="{{ route('admin.cursos.deletar',$registro->id) }}">Deletar</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div>
      <a href="{{ route('admin.cursos.adicionar') }}">Adicionar</a>
    </div>

  </div>

@endsection

