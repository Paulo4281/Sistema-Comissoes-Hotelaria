<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/dashboard/logout.js') }}"></script>
    <script src="{{ asset('js/dashboard/meusdados.js') }}"></script>
    <script src="{{ asset('js/dashboard/ajuda.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4/dayjs.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global-style.css') }}">
    <script src="{{ asset('js/global-scripts.js') }}"></script>
    <script>
        var config = @json(config('configuracoes'));
    </script>
    <style>
        .form-switch {
            padding-left: 3.5rem;
        }
    </style>
    @yield('scripts')
</head>
@if (Session::has('tema-escuro'))
<body data-bs-theme="dark">
@endif

@if (Session::has('tema-claro'))
<body class="">
@endif
<header>

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

    <div class="modal fade" id="sobre-modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content text-left">
            <div class="modal-header">
              <h2 class="modal-title">Sobre</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body sobre-body">

            </div>
            <div class="d-flex justify-content-left align-items-left p-2 mb-2">
                <img class="w-25 logo-cor" src="" alt="">
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal-primeira-reserva">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-left mb-3">
                    <h2>Seja bem-vindo @php echo Session::get('username') @endphp!</h2>
                    <p>É um prazer ter você como parte da nossa equipe. Parabéns por se cadastrar em nossa plataforma.</p>
                    <p>A partir de agora, você está pronto para fazer a sua primeira reserva e começar a explorar todas as funcionalidades do nosso sistema.</p>
                    <p>Caso você precise de alguma ajuda durante o processo, fique à vontade para clicar no botão de ajuda ou entrar em contato com o nosso suporte.</p>
                    <p>Agradecemos por escolher trabalhar conosco e desejamos a você muito sucesso!</p>
                    <button type="button" class="btn btn-secondary" onclick="ajuda()">Preciso de ajuda</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Começar minha primeira reserva</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="modal-ajuda">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajuda</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="carousel slide" id="ajuda-carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active text-center">
                            <span class="" id="ajuda-desc">01. Para adicionar uma nova reserva, primeiramente informamos qual é a operadora.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-operadora.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">02. Logo em seguida, inserimos as informações do titular da reserva.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-titular.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">03. Devemos informar também o sobrenome do titular.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-sobrenome.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">04. Neste campo informamos qual será o dia do check-in.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-checkin.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">05. Agora informamos qual será o dia do check-out.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-checkout.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">06. Por último, informamos quantos apartamentos compõe essa reserva.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-aptos.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">07. Aqui veremos um resumo das infomações da nossa reserva. Poderemos ver também quanto ganharemos de comissão e qual será a previsão de pagamento da nossa comissão.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-resumoreserva.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">08. Aqui veremos todas as reservas que já cadastramos no sistema. Podemos editar a qualquer momento as reservas que ainda não foram pagas. Os campos editáveis são a operadora, titular, sobrenome, check-in, check-out e o número de apartamentos.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-camposeditaveis.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">09. Podemos excluir as reservas inseridas clicando no botão de excluir. Não é possível recuperá-las.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-excluir.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">10. Aqui temos o valor total que vamos receber somando todas as reservas que ainda não foram pagas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-valor-a-receber.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">11. Aqui temos o valor total que já recebemos somando todas as reservas que foram pagas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-valor-recebido.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">12. No menu principal podemos ir para o dashboard; conferir o regulamento novamente; averiguar nossos dados cadastrados; ver esse paínel de ajuda; podemos também ativar o tema escuro; e o botão de sair para fazer logout no sistema.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorial-agentes/tutorial-agentes-menu-principal.jpg') }}" alt="">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#ajuda-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#ajuda-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="container-fluid d-flex pt-3 pt-3" id="display-usuario">
            <div>
                <h4 class="text-white mt-3 fs-5">
                    @if (Session::has('user-id') && Session::has('username'))
                        Olá, {{ Session::get('username') }}
                    @endif
                </h4>
            </div>
            <div class="dropdown mt-2 ms-2">
                <input type="button" class="btn btn-info dropdwon-toggle" data-bs-toggle="dropdown" value="Menu">
                    <ul class="dropdown-menu p-4">
                        <li><a class="dropdown-item" href="dashboard">Dashboard</a></li>
                        <li><a class="dropdown-item" href="#" onclick="verRegulamento()">Regulamento</li></a>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="meusDados()">Meus dados</li></a>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="ajuda()">Ajuda</a></li>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="sobre()">Sobre</a></li>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="mySwitch">Tema escuro</label>
                            @if (!Session::has('tema-escuro') && !Session::has('tema-claro'))
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes" onclick="toggleTheme()">
                            @endif
                            @if (Session::has('tema-escuro'))
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes" onclick="toggleTheme()" checked>
                            @endif
                            @if (Session::has('tema-claro'))
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="darkmode" value="yes" onclick="toggleTheme()">
                            @endif
                        </div>
                        <li><input style="cursor: pointer;" class="dropdown-item" id="input-logout" value="Sair" onclick="return fazerLogout()"></li>
                    </ul>
            </div>
            <div id="container-logo-psp">
                <img width="100" src="{{ asset('img/logo_branco.png') }}">
            </div>
        </div>
        @yield('header')
    </header>
    <main>
        <!-- ÁREA DOS DADOS -->
        
        <form id="form-reservas-cadastradas">
            
        </form>
        
        @yield('conteudo')
    
    <!-- FIM ÁREA DOS DADOS -->
    </main>
    <footer>
        @yield('footer')
        <div class="p-1 container-fluid text-center text-white fixed-bottom" id="footer-desenvolvido-por">
        <span class="desenvolvido-por"></span><img class="logo-branco" src="" alt="" width="30"><span class="versao-codigo" style="position: relative; float: right;"></span>
        </div>
    </footer>
</body>
</html>