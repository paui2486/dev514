<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
    會員列表
    <div class="pull-right wrapper-create">
        <a href="#" data-url="{{{ URL::to('dashboard/member/create') }}}"
           class="btn btn-sm btn-primary">
             <span class="glyphicon glyphicon-plus-sign"></span> 新增
         </a>
    </div>
</h4>

<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>名字</th>
            <th>信箱</th>
            <th>管理</th>
            <th>廠商</th>
            <th>達人</th>
            <th>狀態</th>
            <th>最後更改人</th>
            <th>註冊時間</th>
            <th>設定</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    var oTable;
    oTable = $('#table').DataTable({
        "dom": 'Bfrtip',
        "select": true,
        "lengthMenu": [
            [ 50, 10, 25, -1 ],
            [ '50 rows', '10 rows', '25 rows', 'Show all' ]
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
                "aTargets": [ 8 ]
            },
            {
                "targets": [ 7 ],
                "visible": false
            }
        ],
        "aaSorting": [[7, 'desc']],
        "processing": true,
        "responsive": true,
        "ajax": "{{ URL::to('dashboard/member/data') }}",
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
            location.reload(true);
        },
        success: function(data) {
            $('.r-tabs-panel').html(data);
        }
    });
}
</script>
