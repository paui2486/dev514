<nav class="{{ Request::is('/') ? 'home-navbar' : 'other-navbar' }}">
    <div class="container-header">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="{{ Request::is('/') ? 'navbar-toggle' : 'other-navbar-toggle' }} collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="glyphicon glyphicon-list"></span>
                <span class="sr-only">選單</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="{{ Request::is('/') ? 'home-navbar-brand' : 'other-navbar-brand' }}" href="{{ url('/') }}">
                <img src="/img/pics/{{ Request::is('/') ? 'logofin_white.png' : '514logobrown.png' }}">
            </a>
        </div>

        <div class="{{ Request::is('/') ? 'navbar-collapse' : 'other-navbar-collapse' }} collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="{{ Request::is('/') ? 'navbar-right' : 'other-navbar-right' }} nav navbar-nav">
                <!-- Authentication Links -->
                <li><a href="{{ url('blog') }}">部落格</a></li>
                <li class="navbarr-host"><a href="{{ url('') }}">辦活動</a></li>

                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">登入</a></li>
                    <li><a href="{{ url('/register') }}">註冊</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                            會員中心 <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('profile') }}">個人資料</a></li>
                            <li><a href="{{ url('follows') }}">我的關注</a></li>
                            <li><a href="{{ url('friends') }}">我的朋友</a></li>
                            <li><a href="{{ url('activitys') }}">我的活動</a></li>
                            <li><a href="{{ url('logout') }}">登出</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <div class="sb-slidebar sb-right">
			<!-- Your right Slidebar content. -->
		</div>
    </div>
</nav>