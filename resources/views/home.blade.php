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
          </tr>
        </thead>
        <tbody>
          @foreach($registros as $registro)
            <tr>
              <td>{{ $registro->id }}</td>
              <td>{{ $registro->titulo }}</td>
              <td>{{ $registro->descricao }}</td>
              <td><img width="120" src="{{asset($registro->imagem)}}" alt="{{ $registro->titulo }}" /></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div>
        {{ $registros->links() }}
      </div>
    </div>
  </div>

@endsection