@extends('layouts.admin')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @elseif (Session::has('message'))
              <div class="alert alert-danger">
                  <ul>
                      <li>{{ Session::get('message') }}</li>
                  </ul>
              </div>
            @endif
            <!--state overview start-->
            <div class="row state-overview">
                @if (isset($state))
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
                @endif
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
