{{-- */
    $layouts = ( isset($_GET['view'])) ? 'admin.layouts.tabs' : 'layouts.admin';
/* --}}
@extends($layouts)

@section('style')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>
@stop

{{-- Content --}}

@section('content')

@if(!isset($_GET['view']))
<section id="main-content">
    <section class="wrapper">
        <ul class="nav nav-tabs">
            @foreach( $AdminTabs as $key => $tab )
                <li >
                    <a href="/dashboard/activity#tab-{{ $key }}" >{{ $tab->name }}</a>
                </li>
            @endforeach
            <li class="active">
                <a href="#tab-general" data-toggle="tab">票卷列表 @if(isset($act_info)) {{ ' - ' . $act_info->title }} @endif</a>
            </li>
        </ul>
@endif

        <h4 class="wrapper-title">
           票卷列表  @if(isset($act_info)) {{ ' : ' . $act_info->title }} @endif
           <div class="pull-right wrapper-create">
               <a href="{{{ URL::to('dashboard/activity/' . $id . '/tickets/create') }}}"
                  class="btn btn-sm  btn-primary">
                    <span class="glyphicon glyphicon-plus-sign"></span> 新增
                </a>
           </div>
        </h4>
        @if (Session::has('message'))
          <div class="alert alert-danger">
              <ul>
                  <li>{{ Session::get('message') }}</li>
              </ul>
          </div>
        @endif
        <table id="table" class="table table-striped table-hover">
           <thead>
               <tr>
                   <th>活動名稱</th>
                   <th>票卷名稱</th>
                   <th>票卷總數</th>
                   <th>剩餘票數</th>
                   <th>票卷金額</th>
                   <th>狀態</th>
                   <th>設定</th>
               </tr>
           </thead>
           <tbody></tbody>
        </table>

@if(!isset($_GET['view']))
    </section>
</section>
@endif

@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    var oTable;
    oTable = $('#table').DataTable({
        "dom": 'Bfrtip',
        "select": true,
        "lengthMenu": [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "buttons": [
            'pageLength',
            {
                extend: 'colvis',
                columns: ':not(:first-child)',
                text: '顯示欄位'
            },
            {
                extend: 'pdfHtml5',
                download: 'open'
            },
            'csvHtml5',
        ],
        "aoColumnDefs": [
            {
                "bSortable": false,
                "aTargets": [ 6 ]
            },
            // {
            //     "targets": [ 0,1 ],
            //     "visible": false
            // },
        ],
        // "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "processing": true,
        "responsive": true,
        // "serverSide": true,
        "ajax": "{{ URL::to('dashboard/activity/'. $id .'/tickets/data') }}",
        "fnDrawCallback": function (oSettings) {
            $(".iframe").colorbox({
                iframe: true,
                speed: 660,
                width: "40%",
                height: "30%",
                opacity: 0.4,
                transition: "fade",
                onClosed: function () {
                    window.location.reload();
                }
            });
        }
    });

    $(".btn-primary").click(function() {
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'GET',
            async: true,
            data: { view: 'ajax' },
            error: function(xhr) {
                alert('Ajax request 發生錯誤');
            },
            success: function(data) {
                $('.r-tabs-panel').html(data);
            }
        });
    });
});

function showColorBox(id) {
    var url = id.getAttribute('data-url');
    $.colorbox({
        href: url,
        iframe: true,
        speed: 660,
        width: "60%",
        height: "30%",
        opacity: 0.4,
        transition: "fade",
        onClosed: function () {
            window.location.reload();
        }
    });
}

function edit(item) {
    $.ajax({
        url: item.getAttribute('data-url'),
        type: 'GET',
        async: true,
        data: { view: 'ajax' },
        error: function(xhr) {
            alert('Ajax request 發生錯誤');
        },
        success: function(data) {
            // console.log("here");
            $('.r-tabs-panel').html(data);
        }
    });
}
</script>
@stop
