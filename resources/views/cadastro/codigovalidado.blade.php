@extends('HTMLlayout')

@section('title', 'Parabéns!')

@section('scripts')
<script src="{{ asset('js/cadastro/finalizarcadastro.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/cadastro/codigovalidado.css') }}">
@endsection

@section('conteudo')
    <div class="wrapper">
    <div class="d-flex justify-content-center align-items-center mb-2">
        <img class="logo-cor" width="100" src="" alt="">
    </div>
        <h2>Parabéns {{ Session::get('username') }}, agora você tem acesso ao seu dashboard.</h2>
        <input class="btn mt-3 mb-3" type="button" id="input-finalizar-cadastro" value="Fazer Login" onclick="return finalizarCadastro()">
    </div>
@endsection