@extends('HTMLlayout')

@section('titulo', 'Senha alterado com sucesso!')

@section('scripts')
<script src="{{ asset('js/redefenirsenha/finalizarredefenirsenha.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/login/senhaalterada.css') }}">
@endsection

@section('conteudo')
@csrf
<div class="wrapper">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
    <h2>Parabéns, {{ Session::get('username') }}, sua senha foi alterada com sucesso!</h2>
    <input class="btn mt-3 mb-3" type="button" id="input-finalizar-redefenir-senha" value="Fazer Login" onclick="return finalizarRedefenirSenha()">
</div>
@endsection