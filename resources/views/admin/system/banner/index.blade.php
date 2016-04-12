<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
    Banner 設定
    <div class="pull-right wrapper-create">
        <a href="{{{ URL::to('dashboard/banner/create') }}}"
            class="btn btn-sm  btn-primary">
            <span class="glyphicon glyphicon-plus-sign"></span> 新增
        </a>
    </div>
</h4>
<table id="banner-table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>圖片</th>
            <th>標題</th>
            <th>標語</th>
            <th>設定</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable;
        oTable = $('#banner-table').DataTable({
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
                    "aTargets": [ 3 ]
                },
            ],
            // "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "processing": true,
            "responsive": true,
            // "serverSide": true,
            "ajax": "{{ URL::to('dashboard/banner/data') }}",
            "fnDrawCallback": function (oSettings) {
                $(".iframe").colorbox({
                    iframe: true,
                    speed: 660,
                    width: "40%",
                    height: "300px",
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
