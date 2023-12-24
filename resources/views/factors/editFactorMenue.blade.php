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
        @include('header.editingData.editing_factor')
        <!-- /.content-header -->
        <!-- Main row -->
        <section class="content">
            <!-- form start -->
{{--            @dd($check)--}}


            <div class="container-fluid">
                <form role="form" method="post" action="{{route('factors.update',$factor->id) }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="order_number">شماره سفارش</label>
                            <input type="number" class="form-control" id="order_number" name="order_id"
                                   placeholder="{{$factor->order_id}}" value="{{$factor->order_id}}" readonly>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="name_user">نام مشتری</label>
                                    <input type="text" class="form-control" id="name_user" name="name_user"
                                           placeholder="{{$factor->order->user->first_name." ".$factor->order->user->last_name}}" value="{{$factor->order->user->first_name." ".$factor->order->user->last_name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total_price">مبلغ سفارش</label>
                                    <input type="number" class="form-control" id="total_price" name="total_price"
                                           placeholder="{{$factor->order->total_price}}" value="{{$factor->order->total_price}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="title">عنوان فاکتور</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           placeholder="{{$factor->title}}" value="{{$factor->title}}">
                                </div>
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div>
                                    <label for="total_pay">مبلغ فاکتور</label>
                                    <input type="number" class="form-control" id="total_pay" name="total_pay"
                                       placeholder="{{$factor->total_pay}}" value="{{$factor->total_pay}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="form-label">نوع فاکتور</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="رسمی"
                                        @if($factor->type=="رسمی")
                                            selected
                                            @endif
                                        >رسمی</option>
                                        <option value="غیررسمی"
                                                @if($factor->type=="غیررسمی")
                                                selected
                                            @endif
                                        >غیررسمی</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea type="text" rows="4" class="form-control" id="description" name="description">{{$factor->description}}</textarea>
                            </div>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                        </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- /.card -->


    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->

<!-- /.content -->

<!-- /.content-wrapper -->

@include('.footer.main_footer')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- ./wrapper -->
@include('.scripts')
</body>

</html>
