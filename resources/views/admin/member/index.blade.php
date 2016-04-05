@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
<link rel="stylesheet" href="{{asset('css/responsive-tabs.css')}}" />
<link rel="stylesheet" href="{{asset('css/datatables.min.css')}}"/>
@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery.responsiveTabs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datatables.min.js' )}}"></script>
<script>
$(document).ready(function () {
    var $tabs = $('.wrapper');
    $tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: true,
        scrollToAccordion: true,
        active: 1,
        activate: function(e, tab) {
            var target = $(tab.selector);
            $.ajax({
                url: target.attr('data-url'),
                type: 'GET',
                data: { view: 'ajax' },
                error: function(xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function(data) {
                    $( target.html(data) );
                }
            });
        },
    });
});
</script>
@stop

{{-- Content --}}

@section('content')

@if (!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
        <ul class="nav nav-tabs">
        @foreach( $adminTabs[Request::segment(2)] as $key => $tab )
            <li >
                @if ($tab['level'] <= Auth::user()->adminer)
                <a href="#tab-{{ $key }}" >{{ $tab['name'] }}</a>
                @endif
            </li>
        @endforeach
        </ul>
@endif

    @foreach( $adminTabs[Request::segment(2)] as $key => $tab )
        @if ($tab['level'] <= Auth::user()->adminer)
        <div id="tab-{{ $key }}" data-url="{{ URL($tab['url']) }}"></div>
        @endif
    @endforeach
    </section>
</section>

@stop
