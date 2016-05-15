<div class="Navbar">
    <div class="navbar-brand">
        <a href="{{ url('/') }}">
            <img src="/img/pics/logofin_white.png">
        </a>
    </div>
    <div class="col-xs-8 navbar-mb-brand">
        <a href="{{ url('/') }}">
            <img src="/img/pics/514mobile-logo.png">
        </a>
    </div>
    <div class="navigation">
        <nav>
            <a href="javascript:void(0)" class="smobitrigger ion-navicon-round"></a>
            <ul class="mobimenu">
<!--            <li><a href="{{ url('blog') }}">部落格</a></li>-->
                <li class="navbar-host"><a href="{{ url('dashboard/activity#tab-0') }}">辦活動</a></li>
                @if (Auth::guest())
                <li class="drawer"><a href="{{ url('login') }}">登入</a></li>
                <li class="drawer"><a href="{{ url('register') }}">註冊</a></li>
                <li class="drawer-mb">
                    <a href="{{ url('login') }}">登入</a>
                    <a href="{{ url('register') }}">註冊</a>
                    <a href="{{ url('dashboard/activity#tab-'. (Auth::check() && Auth::user()->hoster)? 1 : 0 ) }}">辦活動</a>
                    <a href="{{ url('About') }}">關於 514</a>
                    <a href="{{ url('Join') }}">加入我們</a>
                    <a href="{{ url('Advertising') }}">廣告合作專區</a>
                    <a href="{{ url('Cooperation') }}">企業合作專區</a>
                    <a href="{{ url('Privacy') }}">隱私與服務條款</a>
                </li>
                @else
                <li class="drawer">
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
                <li class="drawer-mb">
                    <a href="{{ url('dashboard/activity#tab-0') }}">辦活動</a>
                    <a href="{{ url('dashboard/member#tab-0') }}">個人設定</a>
                    <a href="{{ url('dashboard') }}">我的後台</a>
                    <a href="{{ url('dashboard/activity') }}">我的活動</a>
                    <a href="{{ url('About') }}">關於 514</a>
                    <a href="{{ url('Join') }}">加入我們</a>
                    <a href="{{ url('Advertising') }}">廣告合作專區</a>
                    <a href="{{ url('Cooperation') }}">企業合作專區</a>
                    <a href="{{ url('Privacy') }}">隱私與服務條款</a>
                    <a href="{{ url('logout') }}">登出</a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
