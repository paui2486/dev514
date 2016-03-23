@extends('layouts.admin')

@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
         <h4 class="wrapper-title">
            待審核活動列表
         </h4>
         <table id="table" class="table table-striped table-hover">
             <thead>
                 <tr>
                     <th>活動主</th>
                     <th>活動名稱</th>
                     <th>活動類型</th>
                     <th>提交日期</th>
                     <th>相關設定</th>
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
                "ajax": "{{ URL::to('dashboard/activity/check/data') }}",
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

        function passActivity(id) {
            var xhttp = new XMLHttpRequest();
            var url = "{{ url('dashboard/activity/pass') }}" + '/' + id;
            xhttp.open("GET", url, true);
            xhttp.send();
            location.reload();
        }
    </script>
@stop
