<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}"/>

<h4 class="wrapper-title">
    活動列表
</h4>

<table id="table" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>主辦</th>
            <th>分類</th>
            <th>標題</th>
            <th>觀看</th>
            <th>開始時間</th>
            <th>結束時間</th>
            <th>票卷</th>
            <th>狀態</th>
            <th>創建時間</th>
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
    oTable = $('#table').DataTable({
        "dom": 'Bfrtip',
        "select": true,
        "lengthMenu": [
            [ 50, 10, 25, -1 ],
            [ '50 rows', '10 rows', '25 rows',  'Show all' ]
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
                "aTargets": [ 9 ]
            },
            // {
            //     "targets": [ 8 ],
            //     "visible": false
            // }
        ],
        "aaSorting": [[8, 'desc']],
        "processing": true,
        "responsive": true,
        "ajax": "{{ URL::to('dashboard/activity/data') }}",
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
            // console.log("here");
            $('.r-tabs-panel').html(data);
        }
    });
}
</script>
