@extends('layouts.admin')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--state overview start-->
            <div class="row state-overview">
                @foreach($state as $key => $value)
                    <div class="col-lg-3 col-sm-6">
                        <section class="panel">
                            <div class="symbol {{ $value->color }}">
                                <i class="fa {{ $value->icon }}"></i>
                            </div>
                            <div class="value">
                                <h1 class="count">
                                    {{ $value->count }}
                                </h1>
                                <p>{{ $key }}</p>
                            </div>
                        </section>
                    </div>
                @endforeach
            </div>
            <!--state overview end-->

            <div class="row">
                <aside class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <div id="calendar" class="has-toolbar"></div>
                        </div>
                    </section>
                </aside>
            </div>
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->

@endsection
