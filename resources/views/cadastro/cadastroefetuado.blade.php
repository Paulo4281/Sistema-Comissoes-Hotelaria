@extends('HTMLlayout')

@section('titulo', 'Cadastro Efetuado')

@section('scripts')
<script src="{{ asset('js/cadastro/codigoconfirmacao.js') }}"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('css/cadastro/cadastroefetuado.css') }}">
@endsection

@section('conteudo')
<form id='formulario-cadastro-efetuado-container'>
    @csrf
    <div class="wrapper p-4">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
    <div id='agradecimento-cadastro'>
        <h2>
            @if (Session::has('username'))
                Parabéns, {{ Session::get('username') }}! estamos quase lá.
            @endif
        </h2>
        <p>Agora verifique em seu email o código de confirmação, após isso você já poderá registar suas reservas e ganhar comissão!</p>
    </div>
        <div class="text-center fs-6 mb-2">
            <span class='error'>Código incorreto</span>
        </div>
        <div class="form-field d-flex align-items-center">
            <input class="text-center" type='number' id='input-codigo' min="0" max="999999" required>
        </div>
        <div class="d-flex align-items-center">
            <input class="btn mb-3" type='button' id='input-codigo-btn' value="Verificar Código" onclick="return verificarCodigo()">
        </div>
</form>
@endsection