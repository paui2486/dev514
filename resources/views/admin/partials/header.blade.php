<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="縮放 Slider"></div>
    </div>
    <a href="{{URL::to('dashboard')}}" class="logo">514 <span>後台管理系統</span></a>
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img height="30px" alt="" src="{{ Auth::user()->avatar }}">
                    <span class="username">{{ Auth::user()->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="{{URL::to('')}}"><i class="fa fa-home"></i> 回到首頁</a></li>
                    <li><a href="{{URL::to('dashboard/member#tab-0')}}"><i class="fa fa-cog"></i> 個人設定</a></li>
                    <li><a href="{{URL::to('dashboard/activity')}}"><i class="fa fa-bell-o"></i> 我的活動</a></li>
                    <li><a href="{{URL::to('logout')}}"><i class="fa fa-key"></i> 登出</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>
