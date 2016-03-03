<nav class="navbar page-navbar">
    <div class="navbar-container">
            <!-- Collapsed Hamburger -->
            <button type="button" 
                    class="navbar-toggle page-navbar-toggle collapsed" 
                    data-toggle="collapse" 
                    data-target="#app-navbar-collapse">
                <span class="glyphicon glyphicon-list"></span>
            </button>
            <!-- Branding Image -->
            <div class="navbar-brand">
                <a  href="{{ url('/') }}">
                    <img src="/img/pics/514logobrown.png">
                </a>
            </div>
    
        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-right nav navbar-nav page-navbar-right">
                <!-- Authentication Links -->
                <li><a href="{{ url('blog') }}">部落格</a></li>
                <li class="navbar-host page-navbar-host"><a href="{{ url('') }}">辦活動</a></li>

                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">登入</a></li>
                <li><a href="{{ url('/register') }}">註冊</a></li>
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
    </div>
</nav>