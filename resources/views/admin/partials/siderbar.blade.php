<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="active" href="{{URL::to('dashboard')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>控制台首頁</span>
                </a>
            </li>
            <li>
                <a class="" href="{{URL::to('dashboard/profile')}}">
                    <i class="fa fa-list-alt"></i>
                    <span>我的個人資料</span>
                </a>
            </li>
            @if( Auth::user()->adminer )
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-cogs"></i>
                    <span>網站管理系統</span>
                </a>
                <ul class="sub">
                    <li><a href="{{URL::to('dashboard/filter')}}">Filter 設定</a></li>
                    <li><a href="{{URL::to('dashboard/banner')}}">Banner 設定</a></li>
                    <li><a href="{{URL::to('dashboard/ad')}}">廣告模組設定</a></li>
                    <li><a href="{{URL::to('dashboard/point')}}">特殊點數管理</a></li>
                    <li><a href="{{URL::to('dashboard/coupon')}}">優惠代碼管理</a></li>
                    <li><a href="{{URL::to('dashboard/invoice')}}">支出收入管理</a></li>
                    <li><a href="{{URL::to('dashboard/analysis')}}">網站分析軟體</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-user"></i>
                    <span>系統會員管理</span>
                </a>
                <ul class="sub">
                    <li><a href="{{URL::to('dashboard/member/create')}}">新增會員</a></li>
                    <li><a href="{{URL::to('dashboard/member/search')}}">查詢會員</a></li>
                    <li><a href="{{URL::to('dashboard/member')}}">會員列表</a></li>
                </ul>
            </li>
            @endif
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-book"></i>
                    <span>文章管理系統</span>
                </a>
                <ul class="sub">
                    @if ( Auth::user()->adminer )
                        <li><a href="{{URL::to('dashboard/blog/create')}}">代為新增文章</a></li>
                        <li><a href="{{URL::to('dashboard/blog/category')}}">文章分類列表</a></li>
                        <li><a href="{{URL::to('dashboard/blog')}}">全部文章列表</a></li>
                        <li><a href="{{URL::to('dashboard/blog/expert')}}">全部達人列表</a></li>
                    @endif
                    @if ( Auth::user()->adminer || Auth::user()->author )
                        <li><a href="{{URL::to('dashboard/blog/expert')}}">我要新增文章</a></li>
                        <li><a href="{{URL::to('dashboard/blog')}}">我的文章列表</a></li>
                    @endif
                    <li><a href="{{URL::to('dashboard/blog/expert')}}">我喜愛的文章</a></li>
                    <li><a href="{{URL::to('dashboard/blog/expert')}}">我關注的達人</a></li>
                    <li><a href="{{URL::to('dashboard/blog/expert')}}">我要成為達人</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-bar-chart-o"></i>
                    <span>活動管理系統</span>
                </a>
                <ul class="sub">
                    @if ( Auth::user()->adminer )
                        <li><a href="{{URL::to('dashboard/activity/create')}}">代為新增活動</a></li>
                        <li><a href="{{URL::to('dashboard/activity/category')}}">活動分類列表</a></li>
                        <li><a href="{{URL::to('dashboard/activity')}}">全部活動列表</a></li>
                        <li><a href="{{URL::to('dashboard/activity/hoster')}}">活動廠商管理</a></li>
                        <li><a href="{{URL::to('dashboard/activity/coupon')}}">優惠代碼管理</a></li>
                    @endif
                    @if ( Auth::user()->adminer || Auth::user()->hoster )
                        <li><a href="{{URL::to('dashboard/activity/create')}}">我要新增活動</a></li>
                        <li><a href="{{URL::to('dashboard/activity')}}">我主辦的活動</a></li>
                        <li><a href="{{URL::to('dashboard/activity/invoice')}}">支出收入管理</a></li>
                    @endif
                    <li><a href="{{URL::to('dashboard/activity')}}">我的活動列表</a></li>
                    <li><a href="{{URL::to('dashboard/activity')}}">我過往的活動</a></li>
                    <li><a href="{{URL::to('dashboard/activity')}}">我關注的活動</a></li>
                    <li><a href="{{URL::to('dashboard/activity')}}">我要舉辦活動</a></li>
                </ul>
            </li>
            @if( Auth::user()->adminer )
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-comments-o"></i>
                    <span>客服與聯絡紀錄</span>
                </a>
                <ul class="sub">
                    <li><a href="{{URL::to('dashboard/customer')}}">過往客服全紀錄</a></li>
                    <li><a href="{{URL::to('dashboard/customer/wait')}}">待處理客服事件</a></li>
                    <li><a href="{{URL::to('dashboard/customer/handle')}}">處理中客服事件</a></li>
                    <li><a href="{{URL::to('dashboard/customer/finish')}}">已處理客服事件</a></li>
                </ul>
            </li>
            @else
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-comments-o"></i>
                    <span>我有話想要說</span>
                </a>
                <ul class="sub">
                    <li><a href="{{URL::to('dashboard/customer')}}">過往客服全紀錄</a></li>
                    <li><a href="{{URL::to('dashboard/customer/wait')}}">待處理客服事件</a></li>
                    <li><a href="{{URL::to('dashboard/customer/handle')}}">處理中客服事件</a></li>
                    <li><a href="{{URL::to('dashboard/customer/finish')}}">已處理客服事件</a></li>
                </ul>
            </li>
            @endif
            <li>
                <a class="" href="{{URL::to('logout')}}">
                    <i class="fa fa-key"></i>
                    <span>登出系統</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
