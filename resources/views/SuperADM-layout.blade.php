<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/dashboard/logout.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <div class="container-fluid d-flex pb-3 pt-3" id="SuperADM-display-usuario">
        <div>
            <h4 class="text-white fs-2">
                @if (Session::has('user-id') && Session::has('username') && Session::has('SuperADM'))
                    Olá, {{ Session::get('username') }}
                @endif
            </h4>
        </div>
        <div class="dropdown ms-2">
                <input type="button" class="btn btn-info dropdwon-toggle" id="SuperADM-menu-btn" data-bs-toggle="dropdown" value="Menu">
                    <ul class="dropdown-menu p-4">
                        <li><a class="dropdown-item" href="#" onclick="addSuperADM()">Adicionar SuperADM</a></li>
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
    @yield('conteudo')
    </main>

    <footer>
    @yield('footer')
    <div id="SuperADM-footer-desenvolvido-por" class="p-1 container-fluid text-center text-white fixed-bottom">
        <span class="desenvolvido-por"></span><img class="logo-branco" src="" alt="" width="30"><span class="versao-codigo" style="position: relative; float: right;"></span>
        </div>
    </footer>
</body>
</html>