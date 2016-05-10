@extends('layouts.admin')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="{{ asset('css/responsive-tabs.css') }}" />
@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery.responsiveTabs.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-selectize/dist/js/standalone/selectize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ckfinder/ckfinder.js') }}"></script>
<script>
$(document).ready(function () {
    var $tabs = $('.wrapper');
    $tabs.responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: true,
        scrollToAccordion: true,
        active: @if(Auth::user()->hoster) 1 @elseif(Auth::user()->adminer) 4 @else 0 @endif,
        activate: function(e, tab) {
            $(tab.anchor.context).addClass('active');
            var target = $(tab.selector);
            $( target.html("<div class='loading'>Loading<img src='{{ asset('img/icons/ellipsis.gif') }}'></img></div>") );
            $.ajax({
                url: target.attr('data-url'),
                type: 'GET',
                async: true,
                data: { view: 'ajax' },
                error: function(xhr) {
                    alert('Ajax request 發生錯誤');
                },
                success: function(data) {
                    $( target.html(data) );
                }
            });
        },
        deactivate: function(e, tab) {
            $(tab.anchor.context).removeClass('active');
        }
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
        @foreach( $AdminTabs as $key => $tab )
            <li >
                @if ( $tab->level >= 0 )
                    @if ((Auth::user()->adminer > 1) || ($tab->level <= Auth::user()->hoster))
                    <a href="#tab-{{ $key }}" >{{ $tab->name }}</a>
                    @endif
                @else
                <a href="#tab-{{ $key }}" >{{ $tab->name }}</a>
                @endif
            </li>
        @endforeach
        </ul>
@endif

    @foreach( $AdminTabs as $key => $tab )
        <div class="row" id="tab-{{ $key }}" data-url="{{ URL($tab->url) }}"></div>
    @endforeach
    </section>
</section>

@stop
