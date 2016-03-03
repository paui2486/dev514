@extends('layouts.admin')

@section('content')
<!--main content start-->
<section id="main-content" style="display: block">
    <section class="wrapper" style="height:100%; position: fixed; background-image:url( '{{ asset('img/oops.jpg') }} '); background-repeat:no-repeat;
　background-attachment:fixed;　background-position:10% 50%;　background-attachment: fixed; background-size: cover;">
        <i class="icon-500"></i>
        <h1>Ouch!</h1>
        <h2>系統積極開發中！！！</h2>
        <p class="page-500">Looks like Something went wrong. <a href="{{ URL::to('dashboard') }}">Return Home</a></p>
    </section>
</section>
<!--main content end-->
@stop

{{-- Scripts --}}
@section('scripts')

@stop
