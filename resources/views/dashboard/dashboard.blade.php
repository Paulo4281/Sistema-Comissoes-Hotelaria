@extends('dashboard-layout')

@section('titulo', 'Dashboard')

@section('scripts')
<script src="{{ asset('js/dashboard/carregar-reservas.js') }}"></script>
<script src="{{ asset('js/dashboard/inserir-reserva.js') }}"></script>
<script src="{{ asset('js/dashboard/excluir-reserva.js') }}"></script>
<script src="{{ asset('js/dashboard/atualizar-reserva.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection

@section('header')

@endsection

@section('conteudo')

<div class="modal fade" id="modal-meus-dados">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meus dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table-meus-dados">
                        <thead id="thead-meus-dados">
                            <th>Nome</th>
                            <th>Nascimento</th>
                            <th>Gênero</th>
                            <th>CPF</th>
                            <th>E-mail</th>
                            <th>Whatsapp</th>
                            <th>Pix</th>
                            <th>Agência</th>
                            <th>Estado</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th>Rua</th>
                            <th>Data do Cadastro</th>
                        </thead>
                        <tbody id="tbody-meus-dados">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="modal-reservas-atualizadas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center text-primary">
                    <span>Reservas atualizadas com sucesso!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-reserva-inserida">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center text-primary">
                    <span>Reserva inserida com sucesso!</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-excluir-reserva">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span>Deseja realmente excluir essa reserva?</span>
                </div>
                <div class="mb-3">
                    <input class="btn btn-danger form-control text-center" type="button" id="excluir-reserva" value="Excluir reserva">
                </div>
                <div class="mb-3">
                    <input class="btn btn-secondary form-control text-center" type="button" id="cancelar-excluir-reserva" value="Cancelar">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-reserva-excluida">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span>Reserva excluída com sucesso.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-error-periodo-corte">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <span id="periodo-corte-text"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-resumo-reserva" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-no-fade">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalResumoLabel">Resumo da Reserva</h5>
      </div>
      <div class="modal-body">
        <p>Operadora: <span id="resumo-reserva-operadora"></span></p>
        <p>Titular: <span id="resumo-reserva-titular"></span></p>
        <p>Sobrenome: <span id="resumo-reserva-sobrenome"></span></p>
        <p>Check-in: <span id="resumo-reserva-check-in"></span></p>
        <p>Check-out: <span id="resumo-reserva-check-out"></span></p>
        <p>Apartamentos: <span id="resumo-reserva-aptos"></span></p>
        <p>Valor a Receber: <span id="resumo-reserva-valor"></span></p>
        <p>Previsão de pagamento: <span id="resumo-reserva-previsao"></span></p>
      </div>
      <div class="modal-footer">
          <input type="button" class="btn btn-secondary" id="resumo-reserva-cancelar" value="Cancelar">
        <input type="button" class="btn btn-success" id="resumo-reserva-confirmar" value="Confimar">
      </div>
    </div>
  </div>
</div>




        
    <!-- ÁREA DE INSERÇÃO DOS DADOS -->

    <form id="form-reservas-cadastradas">

    </form>

    <hr>
    <div style="height: 120px;"></div>
    <div style="background: #FF9400;" class="container-fluid mb-4 pb-2 pt-3 text-center fixed-bottom">
    <form class="d-inline-flex mb-3" id="form-nova-reserva">
    @csrf
    <div class="d-flex justify-content-between">
        <input type="text" id="input-operadora" class="form-control" data-bs-toggle="tooltip" title="Operadora" placeholder="Operadora" required>
        <input type="text" id="input-titular" class="form-control" data-bs-toggle="tooltip" title="Titular" placeholder="Titular" disabled required>
        <input type="text" id="input-sobrenome" class="form-control" data-bs-toggle="tooltip" title="Sobrenome" placeholder="Sobrenome" disabled required>
    </div>
    <div class="d-flex justify-content-between">
        <input type="date" id="input-check-in" class="form-control" data-bs-toggle="tooltip" title="Check-in" disabled required>
        <input type="date" id="input-check-out" class="form-control" data-bs-toggle="tooltip" title="Check-out" disabled required>
        <select id="input-numero-aptos" class="form-select" data-bs-toggle="tooltip" title="Apartamentos" disabled required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>
    <div class="d-flex justify-content-between">
        <input type="button" id="input-inserir-reserva" class="btn btn-secondary" value="Confirmar" onclick="return inserirReserva()" disabled>
        <input type="button" id="input-atualizar-reserva" class="btn btn-secondary" value="Atualizar" onclick="return atualizarReserva()" disabled>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <input style="background-color: #FFEACC;" type="text" id="input-valor-a-receber" class="form-control" data-bs-toggle="tooltip" title="Valor a receber" value="" readonly>
        <input style="background-color: #b1fab1;" type="text" id="input-valor-recebido" class="form-control" data-bs-toggle="tooltip" title="Valor recebido" value="" readonly>
    </div>
</form>
</div>



    <!-- FIM ÁREA DE INSERÇÃO DOS DADOS -->
    
    @endsection

    @section('footer')

    @endsection