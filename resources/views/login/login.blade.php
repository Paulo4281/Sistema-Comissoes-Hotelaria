@extends('HTMLlayout')
    
    @section('titulo', 'Login')

    @section('scripts')
    <script src="{{ asset('js/login/login.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login/login.css') }}">
    @endsection

    @section('header')

    @endsection

    @section('conteudo')
    <img class="w-100 login-background" style="object-fit: cover; height: 100vh;" src="" alt="">
    <div class="d-flex justify-content-center align-items-center">
        <img class="logo-branco" style="position: absolute; top: 10%; left: 50%; transform: translate(-50%, -50%);" width="150" src="" alt="">
    </div>
    <form class="form" method="post">
        @csrf
        <div class="wrapper">
        <div class="text-center fs-6 mb-2" id="erros">
            <span class="error" id="error-span-emailousenha">Usuário não encontrado</span>
            <span class="error" id="error-span-camposvazios">Preencha os dados de login</span>
            <span class="error" id="error-span-limite-tentativas">Limite de tentativas excedido, tente mais tarde.</span>
            <span class="error" id="error-span-alerta-limite-tentativas">Você tem mais duas tentativas até que sua conta seja temporariamente bloqueada.</span>
        </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" id="input-email" placeholder="E-mail">
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="password" id="input-senha" placeholder="Senha">
                </div>
                <input type="button" class="btn mt-3" id="login-button" value="Login" onclick="verificarLogin()">
            <div class="text-center fs-6 mt-4">
                <a class="fs-5" href="/redefenirsenha">Esqueceu a senha?</a>
                <br>ou<br>
                <a class="fs-5" href="/cadastro">Registre-se</a>
            </div>
        </div>
</form>

@endsection