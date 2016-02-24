@extends('layouts.admin')

@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
         <h4 class="wrapper-title">
             會員列表
             <div class="pull-right wrapper-create">
                 <a href="{{{ URL::to('dashboard/member/create') }}}?view=1"
                    class="btn btn-sm  btn-primary iframe">
                      <span class="glyphicon glyphicon-plus-sign"></span> 新增
                  </a>
             </div>
         </h4>

         <table id="table" class="table table-striped table-hover">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>名字</th>
                     <th>Email</th>
                     <th>活動主</th>
                     <th>達人</th>
                     <th>狀態</th>
                     <th>設定</th>
                 </tr>
             </thead>
             <tbody></tbody>
         </table>
    </section>
</section>
<!--main content end-->
@stop

{{-- Scripts --}}
@section('scripts')
    @parent
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
                        extend: 'colvisGroup',
                        text: '活動主',
                        show: [ 1, 2 ],
                        hide: [ 3, 4, 5 ]
                    },
                    {
                        extend: 'colvisGroup',
                        text: '達人',
                        show: [ 3, 4, 5 ],
                        hide: [ 1, 2 ]
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
                ],
                // "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "processing": true,
                "responsive": true,
                // "serverSide": true,
                "ajax": "{{ URL::to('dashboard/member/data') }}",
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        speed: 660,
                        width: "80%",
                        height: "80%",
                        opacity: 0.4,
                        transition: "fade",
                        onClosed: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@stop
