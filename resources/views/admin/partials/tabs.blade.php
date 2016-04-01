<ul class="nav nav-tabs">
    @foreach( $adminTabs[Request::segment(2)] as $urlPath => $tabName )
        <li class="">
            <a href="{{ URL($urlPath) }}" data-toggle="tab">{{ $tabName }}</a>
        </li>
    @endforeach
</ul>
