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
                <a href="#tab-general" data-toggle="tab">售票列表 </a>
            </li>
        </ul>
@endif
        <h4 class="wrapper-title">
           售票清單
        </h4>

        <table id="ticket_table" class="table table-striped table-hover">
           <thead>
               <tr>
                   <th>購買人</th>
                   <th>連絡信箱</th>
                   <th>聯絡電話</th>
                   <th>票卷名稱</th>
                   <th>票卷張數</th>
                   <th>票卷金額</th>
                   <th>購票時間</th>
                   <th>票卷狀態</th>
               </tr>
           </thead>
           <tbody></tbody>
        </table>
@if(!isset($_GET['view']))
    </section>
</section>
@endif

@stop

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('js/datatables.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var tTable;
            tTable = $('#ticket_table').DataTable({
                "dom": 'Bfrtip',
                "select": true,
                "lengthMenu": [
                    [ 50, 10, 25,  -1 ],
                    [ '50 rows', '10 rows', '25 rows', 'Show all' ]
                ],
                "buttons": [
                    'pageLength',
                    {
                        extend: 'colvis',
                        columns: ':not(:first-child)',
                        text: '顯示欄位'
                    },
                    'csvHtml5',
                ],
                "aaSorting": [[7, 'desc'], [6, 'desc'], [5, 'desc'], ],
                "processing": true,
                "responsive": true,
                "ajax": "{{ URL::current('') . 'Data' }}",
                "fnDrawCallback": function (oSettings) {
                    $(".iframe").colorbox({
                        iframe: true,
                        fixed: true,
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
@stop
