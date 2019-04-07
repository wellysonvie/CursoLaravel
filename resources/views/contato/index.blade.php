
@extends('layout.site')

@section('title', 'Contatos')
    
@section('content')

    <h3>View de contatos</h3>

    @foreach($contatos as $contato)
        <p>{{ $contato->nome }}</p>
        <p>{{ $contato->tel }}</p>
    @endforeach

@endsection

