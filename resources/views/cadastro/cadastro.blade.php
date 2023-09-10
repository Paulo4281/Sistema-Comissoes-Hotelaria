@extends('HTMLlayout')

@section('titulo', 'Página de Cadastro')

@section('scripts')
    <script src="{{ asset('js/cadastro/cadastro.js') }}"></script>
    <script src="{{ asset('js/estados-cidades.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cadastro/cadastro.css') }}">
@endsection
    
@section('conteudo')

<div class="position-fixed top-0 start-0 w-100 h-100 overflow-hidden">
  <img class="w-100 h-100 cadastro-background" src="" alt="">
</div>

    <div class="modal fade" id="regulamento-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-left">
            <div class="modal-header">
              <h2 class="modal-title">Regulamento</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body regulamento-body">

            </div>
            <div class="d-flex justify-content-left align-items-left p-2 mb-2">
                <img class="w-25 logo-cor" src="" alt="">
            </div>
          </div>
        </div>
    </div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Algo deu errado, por favor verique os campos.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-email-invalido-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Por favor, insira um endereço de e-mail válido.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-cpf-invalido-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Por favor, insira um número de cpf válido.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-whatsapp-invalido-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Por favor, insira um número de whatsapp válido.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-idade-invalido-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Programa destinado somente a maiores de 18 anos.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-regulamento-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Por favor, aceite os termos.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-senha-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              As senhas digitadas não são iguais, confira.
            </div>
          </div>
        </div>
</div>

<div class="modal fade" id="error-email-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Os emails digitados não são iguais, confira.
            </div>
          </div>
        </div>
</div>

<div style="position: relative; z-index: 999;" class="mb-4" id="formulario-cadastro-container">
    <form class="form" id="formulario-cadastro" method="post">
        @csrf
        <div class="wrapper">
          <div class="mb-3 d-flex justify-content-center align-items-center">
            <img class="w-50 logo-cor" src="">
          </div>
          <hr>
                <div class="text-center mb-3">
                    <span class="info-span">Informações Pessoais</span>
                </div>

                <div class="form-field d-flex align-items-center">
                    <input type="text" name="nome" id="input-nome" placeholder="Nome" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="sobrenome" id="input-sobrenome" placeholder="Sobrenome" required>
                </div>
                <div class="form-field d-flex align-items-center" id="field-data-nascimento">
                    <label id="label-data-nascimento" for="input-data-nascimento">Data de Nascimento</label>
                    <input type="date" name="dataNascimento" id="input-data-nascimento" required>
                </div>
                <div class="form-field d-flex align-items-center" id="field-genero">
                    <label for="input-genero-r1">Homem</label>
                    <input type="radio" id="input-genero-r1" value="Homem" name="genero" checked>
                    <label for="input-genero-r2">Mulher</label>
                    <input type="radio" id="input-genero-r2" value="Mulher" name="genero">
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="cpf" id="input-cpf" placeholder="CPF" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="whatsapp" id="input-whatsapp" placeholder="Whatsapp" required>
                </div>

                <div class="text-center mb-3">
                    <span class="info-span">Informações de Login</span>
                </div>

                <div class="form-field d-flex align-items-center">
                    <input type="email" name="email" id="input-email" placeholder="E-mail Pessoal" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="email" name="emailConfirmado" id="input-email-confirmado" placeholder="Confirmar Email" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="password" name="senha" id="input-senha" placeholder="Senha" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="password" name="senhaConfirmada" id="input-senha-confirmada" placeholder="Confirmar Senha" required>
                </div>
                <div class="text-center text-danger mb-3">
                    <span class="error" id="error-senha-diferente">As senhas não conferem.</span>
                </div>
                <div class="text-center text-danger mb-3">
                    <span class="error" id="error-senha-formato">A senha deve conter pelo menos 1 letra e 1 número.</span>
                </div>
                <div class="text-center text-danger mb-3">
                    <span class="error" id="error-senha-minimo-caracteres">A senha deve conter pelo menos 8 caracteres</span>
                </div>

                <div class="text-center mb-3">
                    <span class="info-span">Informações da Agência</span>
                </div>

                <div class="form-field d-flex align-items-center">
                    <input type="text" name="pix" id="input-pix" placeholder="Chave Pix" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="agencia" id="input-agencia" placeholder="Agência" required>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <select name="estado" id="input-estado" required>
                        <option value="">Selecione um Estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <select name="cidade" id="input-cidade" required>
                        <option value="">Selecione um estado primeiro</option>
                    </select>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="bairro" id="input-bairro" placeholder="Bairro" required>
                </div>
                <div class="form-field d-flex align-items-center">
                    <input type="text" name="rua" id="input-rua" placeholder="Rua" required>
                </div>
                <div class="d-flex align-items-center">
                    <input type="checkbox" name="regulamento" class="inputs-checkbox m-2" id="input-checkbox-regulamento">
                    <label for="input-checkbox-regulamento">Li e concordo com o <a style="text-decoration: underline; cursor: pointer; color: orange;" id="regulamento-link" onclick="verRegulamento()">Regulamento</a></label>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn mt-3" id="cadastro-button" onclick="return verificarForm(event)" form="formulario-cadastro">
                        <span class="" id="cadastro-btn-load-gif"></span>
                        <span class="fs-6" id="cadastro-btn-text"><strong>Efetuar cadastro</strong></span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <input type="button" class="btn mt-3" id="login-button" value="Fazer Login" onclick="location.href='login'">
                </div>
        </div>
    </form>
</div>


                  <div id="regulamento_overlay"></div>
                  <div id="regulamento_output"></div>
@endsection