@extends('SuperADM-layout')

@section('titulo', 'SuperADM Config')

@section('scripts')
<script src="{{ asset('js/SuperADM/SuperADM-carregar-superadm.js') }}"></script>
<script src="{{ asset('js/SuperADM/SuperADM-add-superadm.js') }}"></script>
@endsection

@section('header')

@endsection

@section('conteudo')

<div class="modal fade" style="z-index: 9999;" id="modal-error-dados">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center text-primary">
                    <span>Algo deu errado, confira os dados.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-superadm-cadastro-efetuado">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center text-primary">
                    <span>Novo administrador cadastrado com sucesso!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-superadm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Adicionar SuperADM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-md-none mb-3">
                    <span>Dados do adiministrador</span>
                </div>
                <div class="mb-3">
                    <input type="text" id="superadm-nome" class="form-control" placeholder="Nome">
                </div>
                <div class="mb-3">
                    <input type="text" id="superadm-sobrenome" class="form-control" placeholder="Sobrenome">
                </div>
                <div class="mb-3">
                    <input type="email" id="superadm-email" class="form-control" placeholder="E-mail">
                </div>
                <div class="mb-3">
                    <span class="error" id="error-senha-diferente">As senhas não conferem.</span>
                    <span class="error" id="error-senha-minimo-caracteres">A senha deve conter pelo menos 8 caractéres.</span>
                    <span class="error" id="error-senha-formato">A senha deve conter pelo menos 1 letra e 1 número.</span>
                    <input type="password" id="superadm-senha" class="form-control mb-3" placeholder="Senha">
                    <input type="password" id="superadm-senha-confirmada" class="form-control" placeholder="Confirmar senha">
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value="Efetuar cadastro" onclick="cadastrarSuperADM()">
            </div>
        </div>
    </div>
</div>

@csrf
    <div class="table-responsive">
        <table class="table table-bordered" id="table-superadm-cadastrados">
            <thead>
                <tr id="thead-superadm-cadastrados">
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data do cadastro</th>
                </tr>
            </thead>
            <tbody id="tbody-superadm-cadastrados">

            </tbody>
        </table>
    </div>
@endsection


@section('footer')

@endsection