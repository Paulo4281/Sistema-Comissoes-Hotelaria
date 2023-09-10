@extends('SuperADM-HTML-layout')

@section('titulo', 'SuperADM Login')

@section('scripts')
<script src="{{ asset('js/SuperADM/SuperADM-login.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/SuperADM/SuperADM-login.css') }}">
@endsection

@section('header')

@endsection

@section('conteudo')
<form class="form" method="post">
    @csrf
    <div class="wrapper">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
        <div class="text-center fs-6 mb-2" id="erros">
            <span class="error" id="error-span-emailousenha">Usuário não encontrado</span>
            <span class="error" id="error-span-camposvazios">Preencha os dados de login</span>
            <span class="error" id="error-span-limite-tentativas">Limite de tentativas excedido, tente mais tarde.</span>
        </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" id="input-email" placeholder="E-mail">
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="password" id="input-senha" placeholder="Senha">
                </div>
                <input type="button" class="btn mt-3" id="login-button" value="Login" onclick="verificarLogin()">
        </div>
</form>
@endsection

@section('footer')

@endsection