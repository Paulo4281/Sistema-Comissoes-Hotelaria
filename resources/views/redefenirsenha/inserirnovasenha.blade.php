@extends('HTMLlayout')

@section('titulo', 'Inserir nova senha')

@section('scripts')
<script src="{{ asset('js/redefenirsenha/verificarsenhas.js') }}" defer></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/login/inserirnovasenha.css') }}">
@endsection

@section('conteudo')
    <form method='post'>
        @csrf
        <div class="wrapper">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <img class="logo-cor" width="100" src="" alt="">
        </div>
            <div class="text-center fs-6 mb-2" id="erros">
                <span class="error" id="error-senha-diferente">As senhas não conferem.</span>
                <span class="error" id="error-senha-formato">A senha deve conter pelo menos 1 letra e 1 número.</span>
                <span class="error" id="error-senha-minimo-caracteres">A senha deve conter pelo menos 8 caractéres</span>
            </div>
            <div class="form-field d-flex align-items-center">
                <input type='password' id='input-senha' placeholder="Senha">
            </div>
            <div class="form-field d-flex align-items-center">
                <input type='password' id='input-senha-confirmada' placeholder="Confirmar senha">
            </div>
            <input class="btn mt-3 mb-3" type='button' id='input-confirmar-senhas' value='Redefenir Senha' onclick='return verificarSenhas()'>
        </div>
    </form>
@endsection