<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
   我的票券
</h4>

<table id="ticket_table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>票券資訊</th>
            <th>票券時間</th>
            <th>登記信箱</th>
            <th>登記電話</th>
            <th>付款狀態</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var tTable;
        tTable = $('#ticket_table').DataTable({
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
                // {
                //     extend: 'pdfHtml5',
                //     download: 'open'
                // },
                // 'csvHtml5',
            ],
            "processing": true,
            "responsive": true,
            "ajax": "{{ URL::to('dashboard/activity/tickets/data') }}",
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
    });
</script>
