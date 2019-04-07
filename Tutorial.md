
# Laravel - Introdução

##### Criar projeto:
```console
sudo apt install composer
sudo apt install php7.2-mbstring
composer create-project --prefer-dist laravel/laravel [MeuProjeto] "5.3.*"
```

##### Visualizar comandos disponíveis no _artisan_ (interface de linha de comando do Laravel):
```console
cd [MeuProjeto]
php artisan
```

##### Visualizar descrição de comando:
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
// -m pra criar a migration associada
```

##### Definir campos na migration associada:
_Migrations_ são a forma de controle de versão de banco de dados do Laravel.

Exemplo do método de criação de tabela na _migration_:
```php
public function up()
{
    Schema::create('nome_tabela', function (Blueprint $table) {
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
    - `as` é o alias para a url que será utilizado na aplicação.
    - `uses` é o `controller@metodo` a ser chamado.

##### Criar layouts com o _blade_:
_Blade_ é a engine de templates do Laravel.
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
Diretivas do _blade_:

 - `@yield` serão substituídas pelo valor passado por parâmetro pelas views que utilizarem este layout.
 - `@include` carrega as partes do layout (ajuda a modularizar).

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
- `{{ }}` imprimir uma variável.
- `@endforeach` e `@endsection` são diretivas de fechamento de bloco.

##### Carregando views (Ex. listagem de contatos):

O controller criado deve conter as funções/métodos especificados nas rotas.

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

Cria uma lista de contatos e carrega a view `index.blade.php` do diretório `contato`, passando os dados necessários com o método `compact`. O `$id` passado por parâmetro vem no url da rota, caso isso não ocorra terá valor `null`.

##### Enviando dados de um formulário:

Exemplo de formulário POST:

```php
<form action="contato" method="post">
    {{ csrf_field() }}
    <input type="text" name="nome">
    <input type="text" name="tel">
    <button type="submit">Enviar</button>
</form>
```

A diretiva `csrf_field` insere um input no form com um token de segurança para ser enviado. O `action` é uma rota definida na aplicação.

Recebendo o dados no controller:

```php
public function criar(Request $req){
    //dd($req);
    //dd($req['nome']);
    dd($req->all());
    return "controller contato criar";
}
```

Enviando imagens:
```html
<div>
    <span>Imagem</span>
    <input type="file" name="imagem">
</div>
```

Recebendo imagem no controller:
```php
$dados = $req->all();
if($req->hasFile('imagem')){ // verifica se foi enviada
    $imagem = $req->file('imagem'); // recupera a imagem
    $num = rand(1111,9999); // gera nome rand
    $dir = "img/cursos/"; // definir diretório
    $ex = $imagem->guessClientExtension(); // pega a extensão do arquivo
    $nomeImagem = "imagem_".$num.".".$ex; // monta o novo nome da imagem
    $imagem->move($dir,$nomeImagem); // salva no diretório e nome especificado
    $dados['imagem'] = $dir."/".$nomeImagem; // monta a string a ser salva no BD
}
```

Enviando checkbox:
```html
<p>
    <input type="checkbox" id="check1" name="publicado" checked value="true" />
    <label for="check1">Publicar?</label>
</p>
```

Recebendo checkbox no controller:
```php
$dados = $req->all();
if(isset($dados['publicado'])){
    $dados['publicado'] = 'sim';
}else{
    $dados['publicado'] = 'nao';
}
```

Método `dd` serve para mostrar variáveis. O método `all` retorna uma lista com os dados enviados na requisição.

##### Algumas funções úteis:

- Referenciar recurso local do projeto:
```php
<img src="{{ asset($registro->imagem) }}" alt="{{ $registro->titulo }}" />
```
- Referenciar rotas pelo alias:
```php
<a href="{{ route('admin.cursos.adicionar') }}">Adicionar</a>
```
- Referenciar rotas pelo alias enviando dados:
```php
<a href="{{ route('admin.cursos.editar', $registro->id) }}">Editar</a>
```
- Redirecionar para uma rota com alias:
```php
// no final de um controller por exemplo ...
return redirect()->route('admin.cursos');
```

##### Trabalhando com o banco de dados:

Para trabalhar com os dados em massa é preciso adicionar a variável `fillable` no model a ser tratado com os nomes do dados a serem salvos:

```php
class Curso extends Model{
    protected $fillable = [
        'titulo','descricao','valor','imagem','publicado'
    ];
}
```

A partir daí, basta chamar os métodos do _Eloquent_, que é o ORM do Laravel:

```php
$registros = Curso::all(); // busca todos os registros de cursos
$registro =  Curso::find($id); // busca o curso pelo id no BD

// os dados de uma requisição por exemplo ...
$dados = $req->all(); 

$registro = Curso::where('nome','=',$dados['nome'])->count(); // quantidade de curso com determinado nome
$registro = Curso::where('nome','=',$dados['nome'])->first(); // primeiro registro encontado

Curso::create($dados); // salvar os dados de um curso
Curso::find($id)->update($dados); // atualiza um curso
Curso::find($id)->delete(); // deleta um curso
```

##### Seeders

Mecanismo para criar registros em massa no banco de dados, como usuários de testes e admim.

Criando um _Seed_ para usuários:

```console
php artisan make:seed UsuarioSeeder
```
- Na arquivo criado em `database/seeds` defina os dados a serem salvos de acordo com o `fillable` de `User.php` da pasta `App` (lembre-se de importar com o `use`):
- Verificar, em seguida, se o usuário não existe para não duplicar os dados e ocorrerem erros.

```php
public function run(){
    $dados = [
        'name'=>"Wellyson",
        'email'=>"admin@mail.com",
        'password'=>bcrypt("123456"),
    ];
    if(User::where('email','=',$dados['email'])->count()){
        $usuario = User::where('email','=',$dados['email'])->first();
        $usuario->update($dados);
        echo "Usuario Alterado!";
    }else{
        User::create($dados);
        echo "Usuario Criado!";
    }
}
```

O método `bcrypt` serve para criptografar a senha antes de salvar no banco de dados.

- No arquivo `DatabaseSeeder.php` faça a chamada do _seed_ criado.

```php
public function run(){
    $this->call(UsuarioSeeder::class);
}
```

Executar os _seeders_:
```console
php artisan db:seed
```

Executar um _seed_ específico:
```console
php artisan db:seed --class=UsuarioSeeder
```

##### Sistema de login:
Pode-se criar um sitema de login com Bootstrap apenas com o comando:
```console
php artisan make:auth
```

De forma manual:

- Criar controller de login:
```console
php artisan make:controller Site/LoginController
```
- Definir rotas:
```php
Route::get('/login', ['as'=>'site.login', 'uses'=>'Site\LoginController@index']);
Route::post('/login/entrar', ['as'=>'site.login.entrar', 'uses'=>'Site\LoginController@entrar']);
Route::get('/login/sair', ['as'=>'site.login.sair', 'uses'=>'Site\LoginController@sair']);
```
- Criar métodos no controller:
```php
public function index(){
    return view('login.index');
}

public function entrar(Request $req){
    $dados = $req->all();
    if(Auth::attempt(['email'=>$dados['email'], 'password'=>$dados['senha']])){
        return redirect()->route('admin.cursos');
    }
    return redirect()->route('site.login');
}

public function sair(){
    Auth::logout();
    return redirect()->route('site.home');
}
```

O método `attempt` verifica se o usuário está cadastrado. Lembre-se de importar a classe `Auth`. Os dados passados para o `attempt` estão de acordo com o `fillable` do model `User.php`.

- Criar view `login/index.blade.php`:
```php
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
```
- Pode-se criar um barra de navegação no arquivo de _header_ do layout que está sendo usado:
```php
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
```
O método `guest` retorna _true_ se não estiver logado. Já o método `user` retorna as informações do usuário.

- Criar grupo de rotas _middleware_ para controlar quais as rotas podem ser acessadas quando estiver logado. No arquivo `Kernel.php` possui alguns _middleware_ configurados. Para login, pode-se utilizar o `auth`, que redireciona pra rota de `login` caso o usuário não esteja logado.

```php
Route::group(['middleware'=>'auth'], function(){
    Route::get('/admin/cursos', ['as'=>'admin.cursos', 'uses'=>'Admin\CursoController@index']);
    Route::get('/admin/cursos/adicionar', ['as'=>'admin.cursos.adicionar', 'uses'=>'Admin\CursoController@adicionar']);
    Route::post('/admin/cursos/salvar', ['as'=>'admin.cursos.salvar', 'uses'=>'Admin\CursoController@salvar']);
    Route::get('/admin/cursos/editar/{id}', ['as'=>'admin.cursos.editar', 'uses'=>'Admin\CursoController@editar']);
    Route::put('/admin/cursos/atualizar/{id}', ['as'=>'admin.cursos.atualizar', 'uses'=>'Admin\CursoController@atualizar']);
    Route::get('/admin/cursos/deletar/{id}', ['as'=>'admin.cursos.deletar', 'uses'=>'Admin\CursoController@deletar']);
});
```

##### Paginação de listas:
- Ao contrário de utilizar o método `all` utiliza-se `paginate`:
```php
$registros = Curso::paginate(3);
```
Especificando a quantidade de registros por página.

- Na view adicionar os links com:
```php
<div align="center">
    {{ $registros->links() }}
</div>
```