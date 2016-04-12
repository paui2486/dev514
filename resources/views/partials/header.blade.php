<nav class="header navbar">
    <div class="navbar-container">
        <button type="button" class="col-xs-2 navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-align-justify"></span>
        </button>
        <button type="button" class="col-xs-2 navbar-toggle-mobile collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-user"></span>
        </button>
        <div class="navbar-brand">
            <a href="{{ url('/') }}">
                <img src="/img/pics/logofin_white.png">
            </a>
        </div>
        <div class="col-xs-8 navbar-brand-mobile">
            <a href="{{ url('/') }}">
                <img src="/img/pics/514mobile-logo.png">
            </a>
        </div>

        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-right nav navbar-nav">
                <!-- Authentication Links -->
                <!--                <li><a href="{{ url('blog') }}">部落格</a></li>-->
                <li class="navbar-host"><a href="{{ url('dashboard/activity/create') }}">辦活動</a></li>
                @if (Auth::guest())
                <li><a href="{{ url('login') }}">登入</a></li>
                <li><a href="{{ url('register') }}">註冊</a></li>
                @else
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                         會員中心<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/member#tab-0') }}">個人設定</a></li>
                        <li><a href="{{ url('dashboard') }}">我的後台</a></li>
                        <li><a href="{{ url('dashboard/activity') }}">我的活動</a></li>
                        <li><a href="{{ url('logout') }}">登出</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="navbar-mb-container">
        <div class="navbar-brand-mobile">
            <a href="/">
                <img src="/img/pics/514mobile-logo.png">
            </a>
        </div>
        <div class="top-nav">
            <div class="sb-toggle-right">
                <i class="fa  fa-align-right"></i>
            </div>
        </div>

        <!-- Right Slidebar start -->
        <div class="sb-slidebar sb-right sb-style-overlay">
            <img src="/img/pics/fairelavie.png">
            <ul class="side-list">
                @if (Auth::guest())
                <a href="{{ url('login') }}"><li>登入</li></a>
                <a href="{{ url('register') }}"><li>加入會員</li></a>
                <a href="{{ url('dashboard/activity/create') }}"><li>辦活動</li></a>
                <a href="{{ url('login') }}"><li>514部落格</li></a>
                <a href="{{ url('#') }}"><li>關於我們</li></a>
                <a href="{{ url('#') }}"><li>隱私權與服務條款</li></a>
                @else
                <a href="{{ url('dashboard/activity/create') }}"> <li>辦活動</li></a>
                <a href="{{ url('dashboard/member#tab-0') }}"><li>個人設定</li></a>
                <a href="{{ url('dashboard') }}"><li>我的後台</li></a>
                <a href="{{ url('dashboard/activity') }}"><li>我的活動</li></a>
                <a href="{{ url('logout') }}"><li>登出</li></a>
                @endif
            </ul>
        </div>
    </div>
</nav>
