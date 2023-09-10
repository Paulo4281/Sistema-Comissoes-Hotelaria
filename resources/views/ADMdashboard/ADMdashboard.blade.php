@extends('ADMdashboard-layout')

@section('titulo', 'Dashboard')

@section('scripts')
<script>
    var config = @json(config('configuracoes'));
</script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/ADMdashboard/ADMdashboard.css') }}">
@endsection

@section('header')

@endsection

@section('conteudo')


    <!-- ÁREA DOS DADOS -->

            <form id="form-reservas-cadastradas">

            </form>

    <!-- ** -->

    <div class="modal fade" id="modal-meus-dados">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meus dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table-meus-dados">
                        <thead id="thead-meus-dados">
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data do Cadastro</th>
                        </thead>
                        <tbody id="tbody-meus-dados">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-procurar-agente">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consultar agente</h5>
                <h6 id="consultar-agente-valor-a-pagar"></h6>
                <h6 id="consultar-agente-valor-pago"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <select class="form-select text-center" id="select-consultar-agente">
                        <option value="">Selecione um agente</option>
                    </select>
                </div>
                        <div class="d-none" id="div-consultar-agente-info">
                        <table class="table" id="table-consultar-agente">
                            <thead id="thead-consultar-agente">
                                <th>Nome</th>
                                <th>Nascimento</th>
                                <th>Gênero</th>
                                <th>CPF</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                                <th>Pix</th>
                            </thead>
                            <tbody id="tbody-consultar-agente">

                            </tbody>
                        </table>
                        <table class="table" id="table-consultar-agente-agencia">
                            <thead id="thead-consultar-agente-agencia">
                                <th>Agência</th>
                                <th>Estado</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Rua</th>
                            </thead>
                            <tbody id="tbody-consultar-agente-agencia">

                            </tbody>
                        </table>
                        <table class="table" id="table-consultar-agente-reservas">
                            <thead id="thead-consultar-agente-reservas">
                                <th>Titular</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Roomnights</th>
                                <th>Aptos</th>
                                <th>Valor</th>
                                <th>Previsão de Pagamento</th>
                                <th>Efetuado por</th>
                                <th>Data do pagamento</th>
                            </thead>
                            <tbody id="tbody-consultar-agente-reservas">

                            </tbody>
                            <tbody id="tbody-consultar-agente-reservas-pagas">

                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
            <div id="form-check-consultar-agente-ver-pagas" class="form-check">
                <input type="checkbox" class="form-check-input" id="consultar-agente-ver-pagas">
                <label class="form-check-label" for="ver-pagas-relatorio-pelo-dashboard">Ver reservas pagas</label>
            </div>
                <input type="button" class="btn btn-success" id="consultar-agente-imprimir-relatorio" value="Imprimir">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-gerar-relatorio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Gerar Relatório</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span id="prev-pagamento-text">Previsão de pagamento:</span>
                </div>
                <div class="mb-3">
                    <input type="date" id="periodo-entre" class="form-control">
                </div>
                <div class="mb-3">
                    <input type="date" id="periodo-ate" class="form-control" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" value="Gerar" onclick="relatorio()">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error-data-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Insira datas válidas.
            </div>
          </div>
        </div>
</div>


<div class="modal fade" id="modal-visualizar-relatorio" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-relatorio"></h5>
                <button type="button" class="btn-close" id="btn-close-visualizar-relatorio" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-visualizar-relatorio">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-visualizar-relatorio">
                        <thead id="thead-visualizar-relatorio">
                            <th>Agente</th>
                            <th>Pix</th>
                            <th>Valor total</th>
                        </thead>
                        <tbody id="tbody-visualizar-relatorio">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" id="relatorio-imprimir-geral" value="Imprimir">
            </div>
        </div>
    </div>
</div>


    <div class="modal" id="modal-visualizar-detalhes">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-detalhes"></h5>
                    <br>
                    <h6 id="valor-a-pagar"></h6>
                    <br>
                    <h6 id="valor-pago"></h6>
                </div>
                <div class="modal-body" id="modal-body-visualizar-detalhes">
                    <table class="table" id="table-visualizar-detalhes-agente">
                        <thead id="thead-visualizar-detalhes-agente">
                            <th>Nome</th>
                            <th>Nascimento</th>
                            <th>Gênero</th>
                            <th>CPF</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>Pix</th>
                        </thead>
                        <tbody id="tbody-visualizar-detalhes-agente">

                        </tbody>
                    </table>
                    <table class="table" id="table-visualizar-detalhes-agencia">
                        <thead id="thead-visualizar-detalhes-agencia">
                            <th>Agência</th>
                            <th>Estado</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th>Rua</th>
                        </thead>
                        <tbody id="tbody-visualizar-detalhes-agencia">

                        </tbody>
                    </table>
                    <table class="table" id="table-visualizar-detalhes-reservas">
                        <thead id="thead-visualizar-detalhes-reservas">
                            <th>Titular</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Roomnights</th>
                            <th>Aptos</th>
                            <th>Valor</th>
                            <th>Previsão de Pagamento</th>
                            <th>Data do pagamento</th>
                            <th>Efetuado por</th>
                        </thead>
                        <tbody id="tbody-visualizar-detalhes-reservas">

                        </tbody>
                        <tbody id="tbody-visualizar-detalhes-reservas-pagas">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <label for="modal-ver-pagas">Ver reservas pagas</label>
                    <input type="checkbox" id="modal-ver-pagas" value="Ver reservas pagas">
                    <input type="button" class="btn btn-primary" id="modal-voltar" value="Voltar">
                    <input type="button" class="btn btn-success" id="imprimir-relatorio-individual" value="Imprimir">
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="modal-visualizar-relatorio-pelo-dashboard" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-visualizar-relatorio-pelo-dashboard"></h5>
                <h6 id="valor-a-pagar-dashboard" class="m-3"></h6>
                <h6 id="valor-pago-dashboard" class="m-3"></h6>
                <input type="button" class="btn-close" id="btn-close-relatorio-pelo-dashboard" data-bs-dismiss="modal" aria-label="Close">
            </div>
            <div class="modal-body" id="modal-body-visualizar-relatorio-pelo-dashboard">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table-visualizar-relatorio-pelo-dashboard">
                        <thead>
                            <tr id="thead-visualizar-relatorio-pelo-dashboard-agente">
                                <th>Nome</th>
                                <th>Nascimento</th>
                                <th>Gênero</th>
                                <th>CPF</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                                <th>Pix</th>
                            </tr>
                            <tbody id="tbody-visualizar-relatorio-pelo-dashboard-agente">

                            </tbody>
                            <tr id="thead-visualizar-relatorio-pelo-dashboard-agencia">
                                <th>Agência</th>
                                <th>Estado</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Rua</th>
                            </tr>
                            <tbody id="tbody-visualizar-relatorio-pelo-dashboard-agencia">

                            </tbody>
                            <tr id="thead-visualizar-relatorio-pelo-dashboard-reservas">
                                <th>Titular</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Roomnights</th>
                                <th>Aptos</th>
                                <th>Valor</th>
                                <th>Previsão de Pagamento</th>
                                <th>Efetuado por</th>
                                <th>Data do pagamento</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-visualizar-relatorio-pelo-dashboard-reservas">
                            
                        </tbody>
                        <tbody id="tbody-visualizar-relatorio-pelo-dashboard-reservas-pagas">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
    <label for="data-entre-relatorio-pelo-dashboard">Previsão de pagamento</label>
    <input type="date" id="data-entre-relatorio-pelo-dashboard" class="form-control">
    <input type="date" id="data-ate-relatorio-pelo-dashboard" class="form-control">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="ver-pagas-relatorio-pelo-dashboard">
        <label class="form-check-label" for="ver-pagas-relatorio-pelo-dashboard">Ver reservas pagas</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="ver-fora-previsao-relatorio-pelo-dashboard">
        <label class="form-check-label" for="ver-fora-previsao-relatorio-pelo-dashboard">Ver reservas fora da previsão</label>
    </div>
    <input type="button" class="btn btn-primary" id="imprimir-relatorio-pelo-dashboard" value="Imprimir">
</div>

        </div>
    </div>
</div>

<!-- MODAL AUXILIARES -->

<div class="modal fade" id="error-previsao-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Não há previsão de pagamento para esse período.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="pagar-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Reserva paga com sucesso.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="desfazer-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Pagamento desfeito com sucesso.
            </div>
          </div>
        </div>
</div>

<!-- ** -->


    <!-- -->

@endsection

@section('footer')
    <hr>
    <div style="height: 120px"></div>
    <div style="background: #FF9400;" class="container-fluid mb-4 pb-3 pt-2 text-center fixed-bottom">
        <input type="text" style="background: #ff9d16; width: 12%;" class="p-2 fs-4 text-center text-white" id="input-valor-a-pagar" data-bs-toggle="tooltip" title="Valor a pagar" readonly>
        <input type="text" style="background: #AAEE9C; width: 12%;" class="p-2 fs-4 text-center" id="input-valor-pago" data-bs-toggle="tooltip" title="Valor pago" readonly>
        <input type="text" style="width: 5%; background: #AAEE9C;" class="text-center" id="input-qtde-reservas" data-bs-toggle="tooltip" title="Quantidade de reservas" readonly>
    </div>

@endsection