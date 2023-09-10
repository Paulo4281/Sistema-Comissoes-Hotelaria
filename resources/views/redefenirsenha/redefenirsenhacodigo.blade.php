@extends('HTMLlayout')

@section('title', 'Redefenir Senha - Código')

@section('scripts')
<script src="{{ asset('js/login/codigoconfirmacaoredefenirsenha.js') }}" defer></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/login/redefenirsenhacodigo.css') }}">
@endsection

@section('conteudo')
    <form method="post">
    @csrf
    <div class="wrapper">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
        <p>Certo {{ Session::get('username') }}, agora só basta digitar o código de confirmação que você recebeu em seu email.</p>
        <div class="text-center fs-6 mb-2" id="erros">
            <span class="error">Código incorreto</span>
        </div>
        <div class="form-field d-flex align-items-center">
            <input class="text-center" id="input-codigo" type="number" min="0" max="999999" required>
        </div>
            <input class="btn mt-3 mb-3" type="button" id="redefenir-senha-button" value="Confirmar Codigo" onclick="return verificarCodigo()">
        </form>
    </div>
@endsection
