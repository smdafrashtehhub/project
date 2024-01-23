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

    @include('.header.data.usersData_header')
    <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
{{--                            <div id="accordionHead">--}}
{{--                                <form role="form" method="get" action="{{ route('users.filter') }}">--}}
{{--                                    @csrf--}}
{{--                                    <div class="card">--}}
{{--                                        <div class="card-header bg-light">--}}
{{--                                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#fillters">--}}
{{--                                                فیلتر ها--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                        <div class="collapse" id="fillters" data-bs-parent="#accordionHead">--}}
{{--                                            <div class="card-body">--}}
{{--                                                <div class="form-control">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="email">ایمیل</label>--}}
{{--                                                                <input type="text" class="form-control"--}}
{{--                                                                       id="email"--}}
{{--                                                                       name=filter[email]--}}
{{--                                                                       placeholder="email"--}}
{{--                                                                       @if(isset($_GET['email']))--}}
{{--                                                                       value="{{$_GET['email']}}"--}}
{{--                                                                    @endif>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="first_name">نام</label>--}}
{{--                                                                <input type="text" class="form-control"--}}
{{--                                                                       id="first_name"--}}
{{--                                                                       name=filter[first_name] placeholder="نام"--}}
{{--                                                                       @if(isset($_GET['first_name']))--}}
{{--                                                                       value="{{$_GET['first_name']}}"--}}
{{--                                                                    @endif>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="last_name">نام خانوادگی</label>--}}
{{--                                                                <input type="text" class="form-control"--}}
{{--                                                                       id="last_name"--}}
{{--                                                                       name="filter[last_name]"--}}
{{--                                                                       placeholder="نام خانوادگی"--}}
{{--                                                                       @if(isset($_GET['last_name']))--}}
{{--                                                                       value="{{$_GET['last_name']}}"--}}
{{--                                                                    @endif>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="user_name">نام کاربری</label>--}}
{{--                                                                <input type="text" class="form-control"--}}
{{--                                                                       id="user_name"--}}
{{--                                                                       name=filter[user_name]--}}
{{--                                                                       placeholder="نام کاربری"--}}
{{--                                                                       @if(isset($_GET['user_name']))--}}
{{--                                                                       value="{{$_GET['user_name']}}"--}}
{{--                                                                    @endif>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="phone_number">شماره همراه</label>--}}
{{--                                                                <input type="number" class="form-control"--}}
{{--                                                                       id="phone_number"--}}
{{--                                                                       name=filter[phone_number]--}}
{{--                                                                       placeholder="9120000000"--}}
{{--                                                                       @if(isset($_GET['phone_number']))--}}
{{--                                                                       value="{{$_GET['phone_number']}}"--}}
{{--                                                                    @endif>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <div class="row">--}}

{{--                                                                    <div class="col">--}}
{{--                                                                        <label for="filterAge">سن</label>--}}
{{--                                                                        <label for="filterAgeMin"--}}
{{--                                                                               id="filterAge">از</label>--}}
{{--                                                                        <input type="number" class="form-control"--}}
{{--                                                                               id="filterAgeMin" name=filter[filterAgeMin]--}}
{{--                                                                               placeholder="از"--}}
{{--                                                                               @if(isset($_GET['filterAgeMin']))--}}
{{--                                                                               value="{{$_GET['filterAgeMin']}}"--}}
{{--                                                                            @endif>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col">--}}
{{--                                                                        <label for="filterAgeMax">تا</label>--}}
{{--                                                                        <input type="number" class="form-control"--}}
{{--                                                                               id="filterAgeMax" name=filter[filterAgeMax]--}}
{{--                                                                               placeholder="تا"--}}
{{--                                                                               @if(isset($_GET['filterAgeMax']))--}}
{{--                                                                               value="{{$_GET['filterAgeMax']}}"--}}
{{--                                                                            @endif>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="gender">جنسیت</label>--}}
{{--                                                                <select class="form-control" id="gender"--}}
{{--                                                                        name=filter[gender] >--}}
{{--                                                                    <option value=""--}}
{{--                                                                            selected>جنسیت را انتخاب کنید--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="male"--}}
{{--                                                                            @if(isset($_GET['gender']))--}}
{{--                                                                            @if($_GET['gender'] == 'male')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>مرد--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="female"--}}
{{--                                                                            @if(isset($_GET['gender']))--}}
{{--                                                                            @if($_GET['gender'] == 'female')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>زن--}}
{{--                                                                    </option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="status">وضعیت تایید</label>--}}
{{--                                                                <select class="form-control" id="status"--}}
{{--                                                                        name=filter[status] >--}}
{{--                                                                    <option value=""--}}
{{--                                                                            selected--}}
{{--                                                                    >وضعیت کاربر را انتخاب کنید--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="confirmation"--}}
{{--                                                                            @if(isset($_GET['status']))--}}
{{--                                                                            @if($_GET['status'] == 'confirmation')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>تایید--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="disapproval"--}}
{{--                                                                            @if(isset($_GET['status']))--}}
{{--                                                                            @if($_GET['status'] == 'disapproval')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>تایید نشده--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="Awaiting confirmation"--}}
{{--                                                                            @if(isset($_GET['status']))--}}
{{--                                                                            @if($_GET['status'] == 'Awaiting confirmation')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>در انتظار تایید--}}
{{--                                                                    </option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="role">نقش </label>--}}
{{--                                                                <select class="form-control" id="role"--}}
{{--                                                                        name=filter[role] >--}}
{{--                                                                    <option value=""--}}
{{--                                                                            selected--}}
{{--                                                                    >نقش را انتخاب کنید--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="admin"--}}
{{--                                                                            @if(isset($_GET['role']))--}}
{{--                                                                            @if($_GET['role'] == 'admin')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>ادمین--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="seller"--}}
{{--                                                                            @if(isset($_GET['role']))--}}
{{--                                                                            @if($_GET['role'] == 'seller')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>فروشنده--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="customer"--}}
{{--                                                                            @if(isset($_GET['role']))--}}
{{--                                                                            @if($_GET['role'] == 'customer')--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>خریدار--}}
{{--                                                                    </option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}

{{--                                                            <div class="col">--}}
{{--                                                                <label for="postal_code">کد پستی</label>--}}
{{--                                                                <input type="number" class="form-control"--}}
{{--                                                                       id="postal_code"--}}
{{--                                                                       name=filter[postal_code]--}}
{{--                                                                       placeholder="کد پستی را وارد کنید"--}}
{{--                                                                       @if(isset($_GET['postal_code']))--}}
{{--                                                                       value="{{$_GET['postal_code']}}" @endif>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

{{--                                                <div class="form-control">--}}
{{--                                                    <div class="form-group">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <label for="orderFilter">سفارش</label>--}}
{{--                                                                <select class="form-control" id="orderFilter"--}}
{{--                                                                        name=filter[order_filter] >--}}
{{--                                                                    <option value="true"--}}
{{--                                                                            @if(isset($_GET['order_filter']))--}}
{{--                                                                            @if($_GET['order_filter'] == "true")--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>دارد--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="false"--}}
{{--                                                                            @if(isset($_GET['order_filter']))--}}
{{--                                                                            @if($_GET['order_filter'] == "false")--}}
{{--                                                                            selected @endif--}}
{{--                                                                        @endif>ندارد--}}
{{--                                                                    </option>--}}
{{--                                                                    <option value="all"--}}
{{--                                                                            @if(isset($_GET['order_filter']))--}}
{{--                                                                            @if($_GET['order_filter'] == "all")--}}
{{--                                                                            selected @endif--}}
{{--                                                                            @else selected--}}
{{--                                                                        @endif>همه--}}
{{--                                                                    </option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-group">--}}
{{--                                                                                                        <div class="row">--}}
{{--                                                            <div class="col">--}}
{{--                                                                <div class="form-group">--}}
{{--                                                                    <label for="filterRole">سطح دسترسی</label>--}}
{{--                                                                    <select class="form-control" id="filterRole"--}}
{{--                                                                            name=filter[first_name] >--}}
{{--                                                                        <option value="customer"--}}
{{--                                                                                @if(isset($_GET['filterRole']))--}}
{{--                                                                                @if($_GET['filterRole'] == "1") selected @endif--}}
{{--                                                                            @endif>مشتری--}}
{{--                                                                        </option>--}}
{{--                                                                        <option value="seller"--}}
{{--                                                                                @if(isset($_GET['filterRole']))--}}
{{--                                                                                @if($_GET['filterRole'] == "2") selected @endif--}}
{{--                                                                            @endif>فروشنده--}}
{{--                                                                        </option>--}}
{{--                                                                        <option value="admin"--}}
{{--                                                                                @if(isset($_GET['filterRole']))--}}
{{--                                                                                @if($_GET['filterRole'] == "3") selected @endif--}}
{{--                                                                            @endif>--}}
{{--                                                                            ادمین--}}
{{--                                                                        </option>--}}
{{--                                                                        <option value="all"--}}
{{--                                                                                @if(isset($_GET['filterRole']))--}}
{{--                                                                                @if($_GET['filterRole'] == "all") selected--}}
{{--                                                                                @endif--}}
{{--                                                                                @else selected--}}
{{--                                                                            @endif>--}}
{{--                                                                            همه--}}
{{--                                                                        </option>--}}
{{--                                                                    </select>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="card-footer">--}}
{{--                                                <button type="submit" class="btn btn-info">فیلتر</button>--}}
{{--                                                <a href="{{ route('Users_data') }}">--}}
{{--                                                    <button type="button" class="btn btn-warning">حذف فیلتر ها</button>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}

                                                        <div id="accordionHead">
                                <form role="form" method="get" action="{{ route('users.filter') }}">
                                    @csrf
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <a class="btn btn-secondary" data-bs-toggle="collapse" href="#fillters">
                                                فیلتر ها
                                            </a>
                                        </div>
                                        <div class="collapse" id="fillters" data-bs-parent="#accordionHead">
                                            <div class="card-body">
                                                <div class="form-control">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterEmail">ایمیل</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterEmail"
                                                                       name="filterEmail"
                                                                       placeholder="email"
                                                                       @if(isset($_GET['filterEmail']))
                                                                       value="{{$_GET['filterEmail']}}"
                                                                    @endif>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterFirstName">نام</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterFirstName"
                                                                       name="filterFirstName" placeholder="نام"
                                                                       @if(isset($_GET['filterFirstName']))
                                                                       value="{{$_GET['filterFirstName']}}"
                                                                    @endif>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterLastName">نام خانوادگی</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterLastName"
                                                                       name="filterLastName"
                                                                       placeholder="نام خانوادگی"
                                                                       @if(isset($_GET['filterLastName']))
                                                                       value="{{$_GET['filterLastName']}}"
                                                                    @endif>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterUserName">نام کاربری</label>
                                                                <input type="text" class="form-control"
                                                                       id="filterUserName"
                                                                       name="filterUserName"
                                                                       placeholder="نام کاربری"
                                                                       @if(isset($_GET['filterUserName']))
                                                                       value="{{$_GET['filterUserName']}}"
                                                                    @endif>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterPhoneNumber">شماره همراه</label>
                                                                <input type="number" class="form-control"
                                                                       id="filterPhoneNumber"
                                                                       name="filterPhoneNumber"
                                                                       placeholder="9120000000"
                                                                       @if(isset($_GET['filterPhoneNumber']))
                                                                       value="{{$_GET['filterPhoneNumber']}}"
                                                                    @endif>
                                                            </div>
                                                            <div class="col">
                                                                <div class="row">

                                                                    <div class="col">
                                                                        <label for="filterAge">سن</label>
                                                                        <label for="filterAgeMin"
                                                                               id="filterAge">از</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterAgeMin" name="filterAgeMin"
                                                                               placeholder="از"
                                                                               @if(isset($_GET['filterAgeMin']))
                                                                               value="{{$_GET['filterAgeMin']}}"
                                                                            @endif>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="filterAgeMax">تا</label>
                                                                        <input type="number" class="form-control"
                                                                               id="filterAgeMax" name="filterAgeMax"
                                                                               placeholder="تا"
                                                                               @if(isset($_GET['filterAgeMax']))
                                                                               value="{{$_GET['filterAgeMax']}}"
                                                                            @endif>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterGender">جنسیت</label>
                                                                <select class="form-control" id="filterGender"
                                                                        name="filterGender">
                                                                    <option value=""
                                                                            selected>جنسیت را انتخاب کنید
                                                                    </option>
                                                                    <option value="male"
                                                                            @if(isset($_GET['filterGender']))
                                                                            @if($_GET['filterGender'] == 'male')
                                                                            selected @endif
                                                                        @endif>مرد
                                                                    </option>
                                                                    <option value="female"
                                                                            @if(isset($_GET['filterGender']))
                                                                            @if($_GET['filterGender'] == 'female')
                                                                            selected @endif
                                                                        @endif>زن
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterStatus">وضعیت تایید</label>
                                                                <select class="form-control" id="filterStatus"
                                                                        name="filterStatus">
                                                                    <option value=""
                                                                            selected
                                                                    >وضعیت کاربر را انتخاب کنید
                                                                    </option>
                                                                    <option value="confirmation"
                                                                            @if(isset($_GET['filterStatus']))
                                                                            @if($_GET['filterStatus'] == 'confirmation')
                                                                            selected @endif
                                                                        @endif>تایید
                                                                    </option>
                                                                    <option value="disapproval"
                                                                            @if(isset($_GET['filterStatus']))
                                                                            @if($_GET['filterStatus'] == 'disapproval')
                                                                            selected @endif
                                                                        @endif>تایید نشده
                                                                    </option>
                                                                    <option value="Awaiting confirmation"
                                                                            @if(isset($_GET['filterStatus']))
                                                                            @if($_GET['filterStatus'] == 'Awaiting confirmation')
                                                                            selected @endif
                                                                        @endif>در انتظار تایید
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <label for="filterRoles">نقش </label>
                                                                <select class="form-control" id="filterRoles"
                                                                        name="filterRoles">
                                                                    <option value=""
                                                                            selected
                                                                    >نقش را انتخاب کنید
                                                                    </option>
                                                                    <option value="admin"
                                                                            @if(isset($_GET['filterRoles']))
                                                                            @if($_GET['filterRoles'] == 'admin')
                                                                            selected @endif
                                                                        @endif>ادمین
                                                                    </option>
                                                                    <option value="seller"
                                                                            @if(isset($_GET['filterRoles']))
                                                                            @if($_GET['filterRoles'] == 'seller')
                                                                            selected @endif
                                                                        @endif>فروشنده
                                                                    </option>
                                                                    <option value="customer"
                                                                            @if(isset($_GET['filterRoles']))
                                                                            @if($_GET['filterRoles'] == 'customer')
                                                                            selected @endif
                                                                        @endif>خریدار
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="col">
                                                                <label for="filterPostalCode">کد پستی</label>
                                                                <input type="number" class="form-control"
                                                                       id="filterPostalCode"
                                                                       name="filterPostalCode"
                                                                       placeholder="کد پستی را وارد کنید"
                                                                       @if(isset($_GET['filterPostalCode']))
                                                                       value="{{$_GET['filterPostalCode']}}" @endif>
                                                            </div>
div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-control">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="filterOrderStatus">سفارش</label>
                                                                <select class="form-control" id="filterOrderStatus"
                                                                        name="filterOrderStatus">
                                                                    <option value="true"
                                                                            @if(isset($_GET['filterOrderStatus']))
                                                                            @if($_GET['filterOrderStatus'] == "true")
                                                                            selected @endif
                                                                        @endif>دارد
                                                                    </option>
                                                                    <option value="false"
                                                                            @if(isset($_GET['filterOrderStatus']))
                                                                            @if($_GET['filterOrderStatus'] == "false")
                                                                            selected @endif
                                                                        @endif>ندارد
                                                                    </option>
                                                                    <option value="all"
                                                                            @if(isset($_GET['filterOrderStatus']))
                                                                            @if($_GET['filterOrderStatus'] == "all")
                                                                            selected @endif
                                                                            @else selected
                                                                        @endif>همه
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="filterRole">سطح دسترسی</label>
                                                                    <select class="form-control" id="filterRole"
                                                                            name="filterRole">
                                                                        <option value="customer"
                                                                                @if(isset($_GET['filterRole']))
                                                                                @if($_GET['filterRole'] == "1") selected @endif
                                                                            @endif>مشتری
                                                                        </option>
                                                                        <option value="seller"
                                                                                @if(isset($_GET['filterRole']))
                                                                                @if($_GET['filterRole'] == "2") selected @endif
                                                                            @endif>فروشنده
                                                                        </option>
                                                                        <option value="admin"
                                                                                @if(isset($_GET['filterRole']))
                                                                                @if($_GET['filterRole'] == "3") selected @endif
                                                                            @endif>
                                                                            ادمین
                                                                        </option>
                                                                        <option value="all"
                                                                                @if(isset($_GET['filterRole']))
                                                                                @if($_GET['filterRole'] == "all") selected
                                                                                @endif
                                                                                @else selected
                                                                            @endif>
                                                                            همه
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-info">فیلتر</button>
{{--                                                <a href="{{ route('Users_data') }}">--}}
                                                    <button type="button" class="btn btn-warning">حذف فیلتر ها</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <table id="Data" class="table table-bordered table-striped">
                                <thead>
                                <tr>

                                    <th>نام کاربری</th>
                                    <th>ایمیل</th>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>نقش</th>
                                    <th>جنسیت</th>
                                    <th>سن</th>
                                    <th>شماره همراه</th>
                                    <th>کشور</th>
                                    <th>استان</th>
                                    <th>شهر</th>
                                    <th>آدرس</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)

                                    <tr>
                                        {{--                                        <th>{{ $user->role->role_name }}</th>--}}
                                        <td>{{ $user->user_name }}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->role}}</td>
                                        <td>@if($user->gender == 'male')
                                               مرد
                                                @endif
                                            @if($user->gender == 'female')
                                                زن
                                            @endif
                                        </td>
                                        <td>{{ $user->age }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>{{ $user->country }}</td>
                                        <td>{{ $user->province }}</td>
                                        <td>{{ $user->city }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <form class="" action="{{route('users.edit',['id'=>$user->id])}}"
                                                  method="get">
                                                <button type="submit">
                                                    <i class="fa-regular fa-pen-to-square fa-flip-horizontal"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form class="" action="{{route('users.destroy',['id'=>$user->id])}}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            {{--                            {{ $users->onEachSide(3)->links() }}--}}
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

</body>
</html>
