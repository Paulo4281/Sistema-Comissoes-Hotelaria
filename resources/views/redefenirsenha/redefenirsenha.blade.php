@extends('HTMLlayout')

@section('titulo', 'Redefenir Senha')

@section('scripts')
<script src="{{ asset('js/redefenirsenha/redefenirsenha.js') }}" defer></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/login/redefenirsenha.css') }}">
@endsection

@section('conteudo')
<form method="post">
    @csrf
    <div class="wrapper">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
        <div class="text-center fs-6 mb-2" id="erros">
            <span class="error">Insira um email válido</span>
            <span class="error">Usuário não encontrado</span>
        </div>
            <div class="form-field d-flex align-items-center">
                <input type="email" id="input-email" placeholder="E-mail">
            </div>
            <button type="button" class="btn mt-3 mb-3" id="redefenir-senha-button" onclick="return verificarEmail()">
                <span class="" id="redefenir-senha-load-gif"></span>
                <span class="fs-6" id="redefenir-senha-btn-text"><strong>Redefenir senha</strong></span>
            </button>
            <input class="btn mt-3" type="button" id="login-button" value="Fazer Login" onclick="location.href='login'">
    </div>
</form>
@endsection