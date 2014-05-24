<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <!-- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8" />
        <title>
            @section('title')
            村里長選舉資訊平台
            @show
        </title>
        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS
        ================================================== -->
        {{ Basset::show('public.css') }}

        <style>
            @section('styles')
            @show
        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Favicons
        ================================================== -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
        <link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
        <link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
    </head>

    <body>
        <!-- To make sticky footer need to wrap in a div -->
        <div id="wrap">
            <!-- Navbar -->
            <div class="navbar navbar-default navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">導覽列</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                            <li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('/') }}}">首頁</a></li>
                            <li {{ (Request::is('blog') ? ' class="active"' : '') }}><a href="{{{ URL::to('blog') }}}">Blog</a></li>
                        </ul>

                        <ul class="nav navbar-nav pull-right">
                            @if (Auth::check())
                            @if (Auth::user()->hasRole('admin'))
                            <li><a href="{{{ URL::to('admin') }}}">管理介面</a></li>
                            @endif
                            <li><a href="{{{ URL::to('user') }}}">登入為 {{{ Auth::user()->username }}}</a></li>
                            <li><a href="{{{ URL::to('user/logout') }}}">登出</a></li>
                            @else
                            <?php /*
                              <li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">登入</a></li>
                              <li {{ (Request::is('user/register') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">註冊</a></li>
                             * 
                             */
                            ?>
                            @endif
                        </ul>
                        <!-- ./ nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- ./ navbar -->

            <!-- Container -->
            <div class="container">
                <!-- Notifications -->
                @include('notifications')
                <!-- ./ notifications -->

                <!-- Content -->
                @yield('content')
                <!-- ./ content -->
            </div>
            <!-- ./ container -->

            <!-- the following div is needed to make a sticky footer -->
            <div id="push"></div>
        </div>
        <!-- ./wrap -->


        <div id="footer">
            <div class="container">
                <p class="muted credit"><a href="http://k.olc.tw/" target="_blank">江明宗</a> 建置</p>
            </div>
        </div>

        <!-- Javascripts
        ================================================== -->
        <script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
        {{ Basset::show('public.js') }}
        <!-- page-script -->
        @yield('page-script')
        <!-- ./ page-script -->
    </body>
</html>