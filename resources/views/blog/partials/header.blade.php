<nav class="navbar blog-navbar">
    <div class="navbar-container">
            <!-- Collapsed Hamburger -->
           <button type="button"
                    class="navbar-toggle blog-navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="glyphicon glyphicon-list"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand blog-navbar-brand" href="{{ url('blog') }}">
                <img src="/img/pics/logo_blog.png">
            </a>

        <div class="navbar-collapse collapse " id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-right blog-navbar-right  nav navbar-nav ">
                <!-- Authentication Links -->

                @foreach ($header_categories as $header_category)
                    <li class="collapse-blog-category">
                        <a href="{{ URL('blog/'.$header_category->name ) }}">
                            {{ $header_category->name }}
                        </a>
                      </li>
                @endforeach

                @if (Auth::guest())
                    <li class="blog-right-text"><a href="{{ url('/login') }}">登入</a></li>
                    <li class="blog-right-text"><a href="{{ url('/register') }}">註冊</a></li>
                @else
                 <li class="blog-right-text dropdown">
                    <a href="#"
                       class=" dropdown-toggle"
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
                    <li class="blog-right-text"><a href="{{ url('/') }}">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
                    </li>


            </ul>
        </div>
        <div class="row navbar-blog-category">
            @foreach ($header_categories as $header_category)
                <li class="top-line-category" >
                    <a href="{{ URL('blog/'.$header_category->name ) }}">
                        {{ $header_category->name }}
                    </a>
                </li>
            @endforeach
        </div>
    </div>
</nav>
