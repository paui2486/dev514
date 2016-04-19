<form class="form-horizontal" enctype="multipart/form-data"
    method="post" autocomplete="off" role="form" action="{{ Request::url() }}">
    {!! csrf_field() !!}
    <div class="tab-content">
        <div class="tab-pane active" id="tab-general">
            <div class="col-md-12">
                <div class="panel-group">
                    {{--*/ $count = 0; /*--}}
                    @foreach( $tickets as $key => $ticket )
                    {{--*/ $count += $ticket->price * $ticket->sold; /*--}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}">
                                    {{ '【 活動： ' . $ticket->activity_name . ' 】     〖 票券： ' . $ticket->ticket_name . ' 〗 -   $ ' . $ticket->price * $ticket->sold . ' 元' }}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="progress progress-md">
                                    <div class="progress-bar progress-bar-danger" style="width: {{ ($ticket->total_numbers - $ticket->sold) / $ticket->total_numbers * 100 }}%">
                                        未售出 {{ $ticket->total_numbers - $ticket->sold }} 張票
                                    </div>
                                    <div class="progress-bar progress-bar-info" style="width: {{ $ticket->sold / $ticket->total_numbers * 100 }}%">
                                        已售出 {{ $ticket->sold }} 張票
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-lg-2 col-sm-2 control-label">票卷名稱</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">{{ $ticket->activity_name . ' ： ' . $ticket->ticket_name }}</p>
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-lg-2 col-sm-2 control-label">票券單價</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">{{ $ticket->price }}</p>
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-lg-2 col-sm-2 control-label">售出數量</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">{{ $ticket->sold }}</p>
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-lg-2 col-sm-2 control-label">輸出總額</label>
                                <div class="col-lg-10">
                                    <p class="form-control-static">{{ $ticket->sold * $ticket->price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-4 invoice-block pull-right">
                        <ul class="unstyled amounts">
                            <li><strong>票券金額 :</strong> $ {{ $count }} 元</li>
                            <li><strong>服務費 :</strong> 10%</li>
                            <li><strong>結清金額 :</strong> $ {{ intval($count * 0.9) }} 元</li>
                        </ul>
                    </div>
                </div>
            		<div class="form-group">
              			<div class="col-md-12">
                				<button type="submit" class="btn btn-sm btn-success">
                  					<span class="glyphicon glyphicon-ok-circle"></span> 前往提款
                				</button>
              			</div>
                </div>
            </div>
        </div>
    </div>
</form>
