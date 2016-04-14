<sidebar>
    <div id="sidebar"  class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a href="{{URL::to('dashboard')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>首頁</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('dashboard/member')}}">
                    <i class="fa fa-list-alt"></i>
                    <span>會員設定</span>
                </a>
            </li>
            @if ( Auth::user()->adminer )
            <li>
                <a href="{{URL::to('dashboard/system')}}">
                    <i class="fa fa-cogs"></i>
                    <span>系統管理</span>
                </a>
            </li>
            @endif
            @if ( Auth::user()->adminer || Auth::user()->author )
            <li>
                <a href="{{URL::to('dashboard/blog')}}">
                    <i class="fa fa-book"></i>
                    <span>文章管理</span>
                </a>
            </li>
            @endif
            <li>
                <a href="{{URL::to('dashboard/activity')}}">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>活動管理</span>
                </a>
            </li>
            <li>
                <a href="{{URL::to('dashboard/customer')}}">
                    <i class="fa fa-comments-o"></i>
                    <span>聯絡客服</span>
                </a>
            </li>
            <li>
                <a class="" href="{{URL::to('logout')}}">
                    <i class="fa fa-key"></i>
                    <span>登出系統</span>
                </a>
            </li>
        </ul>
    </div>
</sidebar>
