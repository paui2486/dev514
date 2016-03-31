<nav class="header navbar page-navbar">
    <div class="navbar-container">
            <!-- Collapsed Hamburger -->
        <button type="button"
                class="navbar-toggle page-navbar-toggle collapsed"
                data-toggle="collapse"
                data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-list"></span>
        </button>
            <!-- Branding Image -->
            <div class="navbar-brand page-navbar-brand">
                <a  href="{{ url('/') }}">
                    <img src="/img/pics/514logobrown.png">
                </a>
            </div>

        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-right nav navbar-nav page-navbar-right">
                <!-- Authentication Links -->
<!--                <li><a href="{{ url('blog') }}">部落格</a></li>-->
                <li class="navbar-host page-navbar-host"><a href="{{ url('dashboard/activity/create') }}">辦活動</a></li>

                @if (Auth::guest())
                <li><a href="{{ url('login') }}">登入</a></li>
                <li><a href="{{ url('register') }}">註冊</a></li>
                @else
                <li class="dropdown">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-expanded="true">
                         會員中心<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('dashboard/profile') }}">個人資料</a></li>
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
    <div class="navbar-mb-container">
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

        <!-- Right Slidebar start -->
        <div class="sb-slidebar sb-right sb-style-overlay">
            <img src="/img/pics/fairelavie.png">
            <ul class="side-list">
                @foreach( $slideCategory as $cat )
                <a href="#">
                    <li class="slidebar-category">       
                       {{ $cat->name }}
                    </li>
                </a>
                @endforeach
            </ul>
        </div>
        <!-- Left Slidebar start -->
        <div class="sb-slidebar sb-left sb-style-overlay">
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
</nav>
