<div class="input-group">
    <input type="text" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">
            <i class="fa fa-search"></i>
        </button>
      </span>
</div>


<ul class="nav nav-pills nav-stacked" id="menu">
    <li {{ (Request::is('admin') ? ' class=active' : '') }}>
        <a href="{{URL::to('management')}}">
            <i class="fa fa-dashboard fa-fw"></i>
            <span class="hidden-sm text"> Management </span>
        </a>
    </li>
    <!--<li {{ (Request::is('admin/language*') ? ' class=active' : '') }}>
        <a href="{{URL::to('admin/language')}}">-->
            <!--<i class="fa fa-language"></i> -->
            <!--<span class="hidden-sm text"> Language </span>
        </a>
    </li>-->
    <!--<li {{ (Request::is('admin/news*') ? ' class=active' : '') }}>
        <a href="#">
            <i class="glyphicon glyphicon-bullhorn"></i>
            <span class="hidden-sm text"> News items</span>
        </a>
        <ul class="nav nav-second-level collapse">
            <li {{ (Request::is('admin/newscategory') ? ' class=active' : '') }} >
                <a href="{{URL::to('admin/newscategory')}}">
                    <i class="glyphicon glyphicon-list"></i>
                    <span class="hidden-sm text"> News categories </span>
                </a>
            </li>
            <li {{ (Request::is('admin/news') ? ' class=active' : '') }} >
                <a href="{{URL::to('admin/news')}}">
                    <i class="glyphicon glyphicon-bullhorn"></i>
                    <span class="hidden-sm text"> News </span>
                </a>
            </li>
        </ul>
    </li>-->
    <li class="active" >
        <a href="#">
            <i class="glyphicon glyphicon-facetime-video"></i> IPPR
            items<span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level collapse" id="collapseThree">
            <li  {{ (Request::is('admin/video') ? ' class=active' : '') }}>
                <a href="{{URL::to('admin/video')}}">
                    <i class="glyphicon glyphicon-facetime-video"></i><span
                            class="hidden-sm text"> Videos</span>
                </a>
            </li>
        </ul>
    </li>
    @if( Auth::user()->admin || Auth::user()->group_admin )
        @if( Auth::user()->group_admin )
            @if( Auth::user()->group )
                <li {{ (Request::is('admin/groups*') ? ' class=active' : '') }} >
                    <a href="{{URL::to('admin/groups')}}">
                        <i class="glyphicon glyphicon-user"></i><span
                                class="hidden-sm text"> Groups</span>
                    </a>
                </li>
            @endif
            <li {{ (Request::is('admin/companys*') ? ' class=active' : '') }} >
                <a href="{{URL::to('admin/companys')}}">
                    <i class="glyphicon glyphicon-user"></i><span
                            class="hidden-sm text"> Companys</span>
                </a>
            </li>
        @endif
        <li {{ (Request::is('admin/users*') ? ' class=active' : '') }} >
            <a href="{{URL::to('admin/users')}}">
                <i class="glyphicon glyphicon-user"></i><span
                        class="hidden-sm text"> Users</span>
            </a>
        </li>
    @endif


</ul>
