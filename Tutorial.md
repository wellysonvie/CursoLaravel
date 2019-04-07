
# Laravel - Introdução

##### Criar projeto:
```console
sudo apt install composer
sudo apt install php7.2-mbstring
composer create-project --prefer-dist laravel/laravel [MeuProjeto] "5.3.*"
```

##### Visualizar comandos disponíveis:
```console
cd [MeuProjeto]
php artisan
```

##### Visualizar descrição comando (make:auth no caso):
```console
php artisan help [comando]
```

##### Inicializar servidor de testes:
```console
php artisan serve
```

##### Configurar conexão com MySQL
No arquivo `.env` altere os campos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[nome_do_banco_ja_criado]
DB_USERNAME=[usuario_do_baco]
DB_PASSWORD=[senha_do_usuario]
```

##### Criar models:
```console
php artisan make:model [NomeModelSingular] -m
// -m pra criar migration associada
```

##### Definir campos na migration associada:
```php
public function up()
{
    Schema::create('cursos', function (Blueprint $table) {
        $table->increments('id');
        //definir campos da migration aqui
        $table->timestamps();
    });
}
```

##### Exemplo de campos:
Tipos serão convertidos de acordo com o SGBD.
```php
$table->string('titulo');
$table->string('descricao');
$table->string('imagem');
$table->decimal('valor',5,2);
$table->enum('publicado',['sim', 'nao'])->default('nao');
```

##### Executar migrations:
```console
php artisan migrate
// nesse comando as tabelas definidas nas migrations serão criadas
```

##### Criar controllers:
```console
php artisan make:controller [subdiretorio]/[nomeController]
```

##### Definir rotas:
No arquivo `routes/web.php` se define as rotas para aplicações web.
```php
//Exemplo de rotas
Route::get('/admin/cursos', ['as'=>'admin.cursos', 'uses'=>'Admin\CursoController@index']);
Route::get('/admin/cursos/adicionar', ['as'=>'admin.cursos.adicionar', 'uses'=>'Admin\CursoController@adicionar']);
Route::post('/admin/cursos/salvar', ['as'=>'admin.cursos.salvar', 'uses'=>'Admin\CursoController@salvar']);
Route::get('/admin/cursos/editar/{id}', ['as'=>'admin.cursos.editar', 'uses'=>'Admin\CursoController@editar']);
Route::put('/admin/cursos/atualizar/{id}', ['as'=>'admin.cursos.atualizar', 'uses'=>'Admin\CursoController@atualizar']);
Route::get('/admin/cursos/deletar/{id}', ['as'=>'admin.cursos.deletar', 'uses'=>'Admin\CursoController@deletar']);
```
- Utiliza-se os métodos *GET, POST, PUT ou DELETE* do HTTP.
- O primeiro parâmetro é a url acessada.
    - pode ser usar `{param}` para passar algo por parâmetro.
    - ou `{param?}` caso o parâmetro não seja obrigatório.
- O segundo é uma lista com os atributos:
    - `as` é o alias para a url para ser usado na aplicação.
    - `uses` é o `controller@metodo` a ser chamado.

##### Criar layouts
No diretório `views` crie o subdiretório `layout`.
Arquivos que utilizem a sintaxe _blade_ devem conter a extensão `.blade.php`.
Exemplo de layout:

- Na pasta `layout`, crie um diretório `_includes`.
- Adicione os arquivos: `header.blade.php` e `footer.blade.php`.
- No pasta `layout`, crie o arquivo `site.blade.php`.

###### _header.blade.php_
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body>
```

###### _footer.blade.php_
```php
</body>
</html>
```
###### _site.blade.php_
```php
@include('layout._includes.header')
@yield('content')
@include('layout._includes.footer')
```

As diretivas `@yield` serão substituídas pelo valor passado por parâmetro pelas views que utilizarem este layout.

##### Utilizando o layout (Ex. listagem de contatos):

- Crie o arquivo `contato/index.blade.php`.
###### _index.blade.php_
```php
@extends('layout.site')
@section('title', 'Contatos')
@section('content')
    <h3>View de contatos</h3>
    @foreach($contatos as $contato)
        <p>{{ $contato->nome }}</p>
        <p>{{ $contato->tel }}</p>
    @endforeach
@endsection
```
Mais algumas diretivas do _blade_:

- `@extends` indica que a view utilizará o layout especificado.
- `@section` especifica o valor dos `@yield` do layout.
- `@foreach` percorre uma lista enviada pelo controller.
- `@endforeach` e `@endsection` são diretivas de fechamento de bloco.

##### Carregando views (Ex. listagem de contatos):

O controller criado deve conter as funções/métodos especificadas nas rotas.

No exemplo o controller `ContatoController` possui a seguinte função:
```php
public function index($id = null){
    $contatos = [
        (object) ['nome'=>'wellyson', 'tel'=>'123456'],
        (object) ['nome'=>'joão', 'tel'=>'432154354'],
        (object) ['nome'=>'maria', 'tel'=>'97567543']
    ];
    return view('contato.index', compact('contatos'));
}
```

Cria uma lista de contatos e carrega a view `index.blade.php` do diretório `contato`, passando os dados necessários com o método `compact`.

