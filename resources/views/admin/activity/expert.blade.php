<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
    公司列表
</h4>

<table id="table" class="table table-striped table-hover">
   <thead>
       <tr>
           <th>公司名稱</th>
           <th>公司統編</th>
           <th>申請帳號</th>
           <th>聯絡姓名</th>
           <th>聯絡電話</th>
           <th>聯絡信箱</th>
           <th>ID資料</th>
           <th>Bank資料</th>
           <th>活動數目</th>
           <th>總觀看數</th>
           <th>相關設定</th>
       </tr>
   </thead>
   <tbody></tbody>
</table>


<script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    var oTable;
    oTable = $('#table').DataTable({
        "dom": 'Bfrtip',
        "select": true,
        "lengthMenu": [
            [ 50, 25, 10, -1 ],
            [ '50 rows', '25 rows', '10 rows', 'Show all' ]
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
