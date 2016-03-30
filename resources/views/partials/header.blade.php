<nav class="header navbar">
    <div class="navbar-container">
        <!-- Collapsed Hamburger -->
        <button type="button" class="col-xs-2 navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-align-justify"></span>
        </button>
        <button type="button" class="col-xs-2 navbar-toggle-mobile collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-user"></span>
        </button>
        <!-- Branding Image -->
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
                        <li><a href="{{ url('dashboard/profile') }}">個人設定</a></li>
                        <li><a href="{{ url('dashboard') }}">我的後台</a></li>
                        <li><a href="{{ url('dashboard/follows') }}">我的關注</a></li>
                        <li><a href="{{ url('dashboard/friends') }}">我的朋友</a></li>
                        <li><a href="{{ url('dashboard/activitys') }}">我的活動</a></li>
                        <li><a href="{{ url('logout') }}">登出</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="navbar-mb">
        <div class="top-nav top-nav-left">
            <div class="sb-toggle-left">
                <i class="fa  fa-user"></i>
            </div>
        </div>
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
</nav>
        <!-- Right Slidebar start -->
        <div class="sb-slidebar sb-right sb-style-overlay">
            <h5 class="side-title">514活動頻道</h5>
            <ul class="quick-chat-list">
                <li class="online">
                    <div class="slidebar-category">
                        <a href="#">
                            <strong>美食美酒</strong>
                        </a>
                    </div>
                    <!-- media -->
                </li>
                <li class="online">
                    <div class="slidebar-category">
                        <a href="#">
                            <strong>戶外活動</strong>
                        </a>
                    </div>
                    <!-- media -->
                </li>
            </ul>
</div>
        <!-- Left Slidebar start -->
        <div class="sb-slidebar sb-left sb-style-overlay">
<!--            <h5 class="side-title">514活動頻道</h5>-->
            <ul class="quick-chat-list">
                @if (Auth::guest())
                <a href="{{ url('login') }}"><li>登入</li></a>
                <a href="{{ url('register') }}"><li>加入會員</li></a>
                <a href="{{ url('dashboard/activity/create') }}"><li>辦活動</li></a>
                <a href="{{ url('login') }}"><li>514部落格</li></a>
                <a href="{{ url('login') }}"><li>關於我們</li></a>
                <a href="{{ url('login') }}"><li>隱私權與服務條款</li></a>
                @else
                <a href="{{ url('dashboard/activity/create') }}"> <li>辦活動</li></a>
                <a href="{{ url('dashboard/profile') }}"><li>個人設定</li></a>
                <a href="{{ url('dashboard') }}"><li>我的後台</li></a>
                <a href="{{ url('dashboard/follows') }}"><li>我的關注</li></a>
                <a href="{{ url('dashboard/friends') }}"><li>我的朋友</li></a>
                <a href="{{ url('dashboard/activitys') }}"><li>我的活動</li></a>
                <a href="{{ url('logout') }}"><li>登出</li></a>
                @endif
            </ul>
        </div>
    </div>