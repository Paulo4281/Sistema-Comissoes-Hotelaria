<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/global-scripts.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global-style.css') }}">
    <script>
        var config = @json(config('configuracoes'));
    </script>
    @yield('scripts')
</head>
<body>
    <header>
        @yield('header')
    </header>
    <main>
        @yield('conteudo')
    </main>
    <footer>
        @yield('footer')
        <div id="SuperADM-footer-desenvolvido-por" class="p-1 container-fluid text-center text-white fixed-bottom">
        <span class="desenvolvido-por"></span><img class="logo-branco" src="" alt="" width="30">
        </div>
    </footer>
</body>
</html>