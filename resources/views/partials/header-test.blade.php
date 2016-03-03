<link rel="stylesheet" type="text/css" href="{{ asset('css/style4.css')}}" />
<script src="js/modernizr.custom.63321.js"></script>
<nav class="navbar">
    <div class="navbar-container">
            <!-- Collapsed Hamburger -->
        <button type="button" 
                class="navbar-toggle collapsed" 
                data-toggle="collapse" 
                data-target="#app-navbar-collapse">
            <span class="glyphicon glyphicon-list"></span>
        </button>
        <!-- Branding Image -->
        <div class="navbar-brand">
            <a  href="{{ url('/') }}">
                <img src="/img/pics/logofin_white.png">
            </a>
        </div>
        
     
        <div class="navbar-collapse collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-right nav navbar-nav">
                <!-- Authentication Links -->
                
                <li><a href="{{ url('blog') }}">部落格</a></li>
                <li class="navbar-host"><a href="{{ url('') }}">辦活動</a></li>
                
                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">登入</a></li>
                <li><a href="{{ url('/register') }}">註冊</a></li>
                @else
                
                <select id="cd-dropdown" class="cd-select">
                    <option value="-1" selected>會員中心</option>
                    <option value="1" class="icon-tux">個人資料</option>
                    <option value="2" class="icon-finder">我的關注</option>
                    <option value="3" class="icon-windows">我的朋友</option>
                    <option value="4" class="icon-android">登出</option>
                </select>
                
<!--
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
-->
                @endif
            </ul>
        </div>
    </div>
</nav>



<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="js/jquery.dropdown.js"></script>


<script>
$( function() {
    $( '#cd-dropdown' ).dropdown();
});
</script>
