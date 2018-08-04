<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - 行動掛號</title>
        <link rel="stylesheet" href="/assets/jquery-ui/jquery-ui.css">
        <link rel="stylesheet" href="/assets/css/bootstrap.css">
        <script src="/assets/js/jquery-2.2.4.min.js" defer></script>
        <script src="/assets/js/bootstrap.js" defer></script>
        <script src="/assets/jquery-ui/jquery-ui.min.js" defer></script>
        <script src="/assets/js/js.cookie.js" defer></script>
        @yield('script')


        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/reg_laravel.css">

    </head>
    <body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">行動掛號</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-right">
                    <li class="@yield('regNavActive')"><a href="/"> 掛號 </a></li>
                    <li class="@yield('inqNavActive')" id="inqNavBar"><a href="/inquire"> 查詢/取消 </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    </body>
</html>