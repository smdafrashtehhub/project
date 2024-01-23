<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت | داشبورد اول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('styleSheets.styleSheets')
    <link rel="stylesheet" href="{{asset('persenalCss/app.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
@include('navbar.navbar')
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
    @include('Sidebar.Sidebar')
    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
    @include('header.adding.addّFactor_header')
    <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('factors.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="order_id">اسم سفارش</label>
                            <select name="order_id" class="form-control" >
                                    <option value="{{ $order->id }}" data-total-price="{{ $order->total_price }}" name_of_user="{{$order->user->first_name." ".$order->user->last_name}}">
                                        {{ $order->title }}
                                    </option>
                            </select>
                            <div class="form-group">
                                <label for="name_user">نام مشتری</label>
                                <input type="text" class="form-control" id="name_user" name="name_user" value="{{$order->user->first_name.' '.$order->user->last_name}}"  readonly>
                            </div>
                            @error('name_user')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="total_pay">مبلغ سفارش</label>
                                <input type="text" class="form-control" id="total_pay" name="total_pay" value="{{$order->total_price}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="title">عنوان فاکتور </label>
                                <input type="text" class="form-control" id="title" name="title"  >
                            </div>
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="type">نوع فاکتور</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="رسمی" selected>رسمی</option>
                                    <option value="غیررسمی">غیررسمی</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">توضیحات </label>
                                <textarea type="text" class="form-control" id="description" name="description" rows="4" placeholder="لطفا توضیحات مربوطه را وارد کنید"></textarea>
                            </div>
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{--                    /.card-body--}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
{{--    /.card --}}


<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
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
@include('.scripts')
<script>
    function updateTotalPrice(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var totalPrice = selectedOption.getAttribute('data-total-price');
        var nameuser = selectedOption.getAttribute('name_of_user');
        document.getElementById('total_pay').value = totalPrice;
        document.getElementById('name_user').value = nameuser;
    }
</script>

</body>

</html>
