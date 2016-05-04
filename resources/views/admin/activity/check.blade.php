<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
  待審核活動列表
</h4>

<table id="check_table" class="table table-striped table-hover">
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

<script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var cTable;
        cTable = $('#check_table').DataTable({
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
                    width: "90%",
                    height: "90%",
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
