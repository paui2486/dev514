<nav class="other-navbar">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="home-navbar-brand" href="{{ url('/') }}">
                    <img src="/img/pics/514logobrown.png">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav other-navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{{ url('blogs') }}">部落格</a></li>
                    <li><a href="{{ url('') }}">辦活動</a></li>

                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">登入</a></li>
                        <li><a href="{{ url('/register') }}">註冊</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('profile') }}"><i class="fa fa-user-md"></i>個人資料</a></li>
                                <li><a href="{{ url('follows') }}"><i class="fa fa-refresh fa-spin"></i>我的關注(0)</a></li>
                                <li><a href="{{ url('friends') }}"><i class="fa fa-refresh fa-spin"></i>我的朋友(0)</a></li>
                                <li><a href="{{ url('activitys') }}"><i class="fa fa-cog fa-spin"></i>我的活動</a></li>
                                <li><a href="{{ url('logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>