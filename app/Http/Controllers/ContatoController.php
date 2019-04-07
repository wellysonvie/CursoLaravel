<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contato;

class ContatoController extends Controller
{
    public function index($id = null){

        $contato = new Contato();
        dd($contato->lista());
        //dd($contato->lista()->nome);

        $contatos = [
            (object) ['nome'=>'wellyson', 'tel'=>'123456'],
            (object) ['nome'=>'ana', 'tel'=>'432154354'],
            (object) ['nome'=>'weliton', 'tel'=>'97567543']
        ];
        return view('contato.index', compact('contatos'));
    }

    public function criar(Request $req){
        //dd($req);
        //dd($req['nome']);
        dd($req->all());
        return "controller contato criar";
    }
}
