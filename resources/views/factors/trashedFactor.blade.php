<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | جدول داده</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('.styleSheets.dataStyle')
    @include('.styleSheets.styleSheets')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
@include('.navbar.navbar')
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
    @include('.Sidebar.Sidebar')
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

    @include('header.data.factorsDelete_header')
    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="Data" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>شماره سفارش</th>
                                    <th>مشتری</th>
                                    <th>عنوان فاکتور</th>
                                    <th>اجناس خریداری شده</th>
                                    <th>مبلغ فاکتور</th>
                                    <th>نوع فاکتور</th>
                                    <th>توضیحات</th>
                                    <th>بازگردانی</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($trash_factors as $trash_factor)
                                    <tr>
                                        <td>{{ $trash_factor->order_id }}</td>
                                        <td>{{ $trash_factor->order->user->first_name." ".$trash_factor->order->user->last_name}}</td>
                                        <td>{{ $trash_factor->title }}</td>
                                        <td>
                                            <a class="btn" data-bs-toggle="collapse"
                                               href="#collapseP{{$trash_factor->order_id}}">
                                                همه محصولات
                                            </a>
                                            <div id="collapseP{{$trash_factor->order_id}}" class="collapse"
                                                 data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-hover table-striped">
                                                        @foreach($trash_factor->order->products as $product)
                                                            <tr>
                                                                <td>محصول: {{$product->title}}</td>
                                                                <td>قیمت: {{$product->price}}</td>
                                                                <td>تعداد: {{$product->pivot->count}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $trash_factor->total_pay }}</td>
                                        <td>{{ $trash_factor->type }}</td>
                                        <td>{{ $trash_factor->description }}</td>
                                        <td>
                                            <form action="{{route('factors.recovery',['id' => $trash_factor->id])}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-info">
                                                    <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                </button>

                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('.footer.main_footer')

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- page script -->

<script>
    $(function () {
        $('#Data').DataTable({
            "language":
                {
                    "paginate":
                        {
                            "next": "بعدی",
                            "previous": "قبلی"
                        },
                    "search": "جست و جو : ",
                },

            "info": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "autoWidth": true
        });
    });
</script>

</body>
</html>
