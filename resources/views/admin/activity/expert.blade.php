@extends('layouts.admin')

@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
         <h4 class="wrapper-title">
             全部活動主列表
             <div class="pull-right wrapper-create">
                 <a href="{{{ URL::to('dashboard/member/create') }}}"
                    class="btn btn-sm  btn-primary">
                      <span class="glyphicon glyphicon-plus-sign"></span> 新增
                  </a>
             </div>
         </h4>
         <table id="table" class="table table-striped table-hover">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>活動主</th>
                     <th>文章數</th>
                     <th>總觀看數</th>
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
                        extend: 'pdfHtml5',
                        download: 'open'
                    },
                    'csvHtml5',
                ],
                "processing": true,
                "responsive": true,
                "ajax": "{{ URL::to('dashboard/activity/hoster/data') }}",
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
