<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/dashboard/logout.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ADMgerar-relatorio.js') }}"></script>
    <script src="{{ asset('js/global-scripts.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ADMcarregar-reservas.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ADMver-detalhes-dashboard.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ADMprocurar-agente.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ADMmeusdados.js') }}"></script>
    <script src="{{ asset('js/ADMdashboard/ajudaADM.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.4/dayjs.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global-style.css') }}">
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

    <div class="modal fade" id="modal-ajuda-ADM">
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
                            <span class="" id="ajuda-desc">01. Este é o seu paínel de controle. Aqui você encontra todas as reservas que ainda não foram pagas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM00-painel.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">02. Este é o valor total que ainda falta pagar somando todas as reservas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM01-valor-a-pagar.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">03. Este é o valor que já foi pago somando todas as reservas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM02-valor-pago.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">04. Esta é a quantidade de reservas que ainda não foram pagas.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM03-qtd-reservas.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">05. Podemos ver as informações detalhadas de cada agente clicando no botão "detalhes".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM04-botao-detalhes.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">06. Aqui você encontra todas as informações referente ao agente. Informações pessoais, agência e informações de todas as reservas cadastradas pelo agente no sistema.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM05-detalhes-dashboard.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">07. Ao clicar no botão "pagar" a reserva ficará com o status "pago", assim ela não irá mais aparecer no paínel de controle. É possível desfazer o pagamento.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM06-detalhes-dashboard-botao-pagar.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">08. Por padrão é exibido nos detalhes somente as reservas que ainda não foram pagas. Você pode ver as reservas pagas ativando o checkbox "ver reservas pagas".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM07-detalhes-dashboard-botao-ver-pagas.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">09. Uma vez que você escolheu um período específico para a previsão de pagamento, você pode conferir as reservas que estão fora desse perídodo ativando o checkbox "ver reservas fora da previsão".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM08-detalhes-dashboard-botao-ver-fora-previsao.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">10. Você pode imprimir as informações para o setor financeiro clicando no botão "imprimir".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM09-detalhes-dashboard-botao-imprimir.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">11. Você pode filtrar as reservas alterando a previsão de pagamento.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM10-detalhes-dashboard-alterar-previsao-pagamento.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">12. Podemos gerar um relatório geral.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM11-menu-principal-gerar-relatorio.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">13. Para gerar um relatório geral, apenas precisamos escolher qual o período de previsão de pagamento.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM12-gerar-relatorio-previsao-pagamento.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">14. Aqui podemos ver todos os agentes que possuem reservas nesse período de previsão de pagamento.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM13-gerar-relatorio-painel-resumo.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">15. Podemos novamente conferir os detalhes de cada agente ao clicar no botão "detalhes".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM14-gerar-relatorio-painel-resumo-botao-detalhes.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">16. Podemos também imprimir as informações para o setor financeiro de todos os agentes listados aqui de uma só vez ao clicar no botão "imprimir".</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM15-gerar-relatorio-painel-resumo-botao-imprimir.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">17. Aqui veremos as informações de todos os agentes cadastrados no sistema.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM16-menu-principal-agentes-cadastrados.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">18. Você pode conferir as informações pessoais e da agência do agente. Pode também ver a quantidade de agentes cadastrados no sistema.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM17-menu-principal-agentes-cadastrados-painel.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">19. Aqui podemos conferir informações detalhadas de um agente específico.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM18-menu-principal-consultar-agente.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">20. Para conferir as informações detalhadas de um agente específico, apenas precisamos escolher algum agente.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM19-menu-principal-consultar-agente-painel.jpg') }}" alt="">
                        </div>
                        <div class="carousel-item text-center">
                            <span class="" id="ajuda-desc">21. Aqui você obterá todas as informações pessoais, agência e reservas cadastradas pelo agente no sistema.</span>
                            <img class="d-block w-100 mt-3" src="{{ asset('img/tutorialADM/tutorial-agentes-ADM20-menu-principal-consultar-agente-informacoes.jpg') }}" alt="">
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

        <div class="container-fluid d-flex pb-3 pt-3" id="display-usuario">
            <div class="">
                <h4 class="text-white mt-3 fs-5">
                    @if (Session::has('user-id') && Session::has('username'))
                        Olá, {{ Session::get('username') }}
                    @endif
                </h4>
            </div>
            <div class="dropdown mt-2 ms-2">
                <input type="button" class="btn btn-info dropdwon-toggle" data-bs-toggle="dropdown" value="Menu">
                    <ul class="dropdown-menu p-4">
                        <li><a class="dropdown-item" href="ADMdashboard">Dashboard</a></li>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="ADMGerarRelatorio()">Gerar relatório</li></a>
                        <li><a class="dropdown-item" href="ADMagentes">Agentes cadastrados</a></li>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="consultarAgente()">Consultar agente</a></li>
                        <li><a class="dropdown-item" href="#" onclick="verRegulamento()">Regulamento</li></a>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="ADMmeusDados()">Meus dados</li></a>
                        <li><a style="cursor: pointer;" class="dropdown-item" onclick="ajudaADM()">Ajuda</li></a>
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
                        <!-- <li><a style="cursor: pointer;" id="themeToggleLink" class="dropdown-item" onclick="toggleTheme()"></a></li> -->
                        <li><input style="cursor: pointer;" class="dropdown-item" id="input-logout" value="Sair" onclick="return fazerLogout()"></li>
                    </ul>
            </div>
            <div id="container-logo-psp">
                <img class="" width="100" src="">
            </div>
        </div>
        @yield('header')
    </header>
    <main>
        @yield('conteudo')
    </main>
    <footer>
        @yield('footer')
        <div class="p-1 container-fluid text-center text-white fixed-bottom" id="footer-desenvolvido-por">
        <span class="desenvolvido-por"></span><img class="logo-branco" src="" alt="" width="30"><span class="versao-codigo" style="position: relative; float: right;"></span>
        </div>
    </footer>
</body>
</html>