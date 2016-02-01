@extends('admin.layouts.default')

@section('title') Management :: @parent @stop
@section('content')

@section('main')

    <div class="page-header">
        <h3>
            {{$title}}
        </h3>
    </div>

    <div class="row">

        <!-- <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-list fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$photoalbum}}</div>
                            <div>{{ trans("admin/admin.photo_albums") }}!</div>
                        </div>
                    </div>
                </div>
                <a href="{{URL::to('admin/photoalbum')}}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-camera fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$photo}}</div>
                            <div>{{ trans("admin/admin.photo_items") }}!</div>
                        </div>
                    </div>
                </div>
                <a href="{{URL::to('admin/photo')}}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-list fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$videoalbum}}</div>
                            <div>{{ trans("admin/admin.video_albums") }}!</div>
                        </div>
                    </div>
                </div>
                <a href="{{URL::to('admin/videoalbum')}}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>-->
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-facetime-video fa-3x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$video}}</div>
                            <div>{{ trans("admin/admin.video_items") }}!</div>
                        </div>
                    </div>
                </div>
                <a href="{{URL::to('admin/video')}}">
                    <div class="panel-footer">
                        <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        @if( Auth::user()->admin || Auth::user()->group_admin )
            @if( Auth::user()->group_admin )
                @if( Auth::user()->group )
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="glyphicon glyphicon-user fa-3x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{$groups}}</div>
                                        <div>{{ trans("admin/admin.groups") }}!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{URL::to('admin/groups')}}">
                                <div class="panel-footer">
                                    <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-user fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$companys}}</div>
                                    <div>{{ trans("admin/admin.companys") }}!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{URL::to('admin/companys')}}">
                            <div class="panel-footer">
                                <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-user fa-3x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$users}}</div>
                                <div>{{ trans("admin/admin.users") }}!</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{URL::to('admin/users')}}">
                        <div class="panel-footer">
                            <span class="pull-left">{{ trans("admin/admin.view_detail") }}</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
