@extends('MainLayout')

@section('title')
    <title>
        @if($report_type == 0)
            گزارش تجمیعی
        @else
            گزارش تجمیعی پیش فروش
        @endif
    </title>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .dropdown-menu{
            width:  270px !important ;
            min-width: 270px !important ;
            max-width: 270px !important ;
        }
        .datepicker-navigator .title{
            margin: 0 !important;
            min-height: 0 !important;

        }
    </style>
@endsection
@php
    $api = new \App\Api\Api();
@endphp
@section('content')

    <div class="content">
        <div class="container-fluid">
            @if(isset($error))
                <div class="alert alert-danger alert-dismissible fade show text-right" role="alert">
                    {{ $error }}
                    <button type="button" class="close mt-2 pt-3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose pb-2 border-bottom">
                            <div class="row">
                                <div class="col-md">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">
                                        @if($report_type == 0)
                                            گزارش تجمیعی
                                        @else
                                            گزارش تجمیعی پیش فروش
                                        @endif

                                    </h4>
                                </div>
                                <div class="col-md">
                                    <a {{--onclick="history.go(-1);"--}} href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <form action="{{Route('GetStat')}}" method="get">
                                <input type="hidden" name="reportType" value="{{$report_type}}">
                                <div class="row mt-3">
                                    {{--  category --}}
                                    <div class="col-md-3 text-right">
                                        <label for=""> نحوه دسته بندی </label>
                                        <select name="key" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                            <option @if(request('key') == "province" || is_null(request('key')) ) selected @endif value="province">استان</option>
                                            <option @if(request('key') == "city") selected @endif value="city">شهر</option>
                                            <option @if(request('key') == "sale_type") selected @endif value="sale_type">نوع پرداخت</option>
                                            <option @if(request('key') == "voucher_type") selected @endif value="voucher_type">نوع بلیت</option>
                                            <option @if(request('key') == "sell_model") selected @endif value="sell_model">نوع فروش</option>
                                            <option @if(request('key') == "operator") selected @endif value="operator">اپراتور</option>
                                            <option @if(request('key') == "location") selected @endif value="location">مکان</option>
                                            <option @if(request('key') == "service") selected @endif value="service">موزه</option>
                                        </select>
                                    </div>
                                    {{--  province --}}
                                    <div class="col-md-3 text-right">
                                        <label for=""> انتخاب استان  </label>
                                        <select name="province_id" id="province" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="Single Select">
                                            <option value="" selected> همه </option>
                                            @foreach($ProvinceList as $Province)
                                                @if(request('province_id') == $Province['id'])
                                                    <option selected value="{{$Province['id']}}"> {{$Province['province_name']}} </option>
                                                @else
                                                    <option value="{{$Province['id']}}"> {{$Province['province_name']}} </option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  City --}}
                                    @php
                                        if(!is_null(request('province_id'))){
                                            $province_id = request('province_id') ;
                                            $citys = $api->CityList($province_id);
                                            $citys = $citys["ContentData"];
                                        }
                                    else
                                        $citys = [] ;
                                    @endphp
                                    <div class="col-md-3 text-right">
                                        <label for=""> انتخاب شهر  </label>
                                        <select name="city_id" id="cityList" class="selectpicker"  data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب شهر">
                                            <option value=""> همه </option>
                                            @foreach($citys as $city )
                                                @if($city["id"] == request("city_id"))
                                                    <option selected value="{{$city["id"]}}"> {{$city["city_name"]}} </option>
                                                @else
                                                    <option value="{{$city["id"]}}"> {{$city["city_name"]}} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  location --}}
                                    @php
                                        if(!is_null(request('city_id'))){
                                            $province_id = request('province_id') ;
                                            $city_id = request('city_id') ;
                                            $location_lists = $api->location_list($province_id ,$city_id );
                                            $location_lists = $location_lists["ContentData"];
                                        }
                                    else
                                        $location_lists = [] ;
                                    @endphp
                                    <div class="col-md-3 text-right">
                                        <label for=""> انتخاب مکان   </label>
                                        <select name="location_id" id="locationList" class="selectpicker"  data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب مکان">
                                            <option value=""> همه </option>
                                            @foreach($location_lists as $location_list )
                                                @if($location_list["id"] == request("location_id"))
                                                    <option selected value="{{$location_list["id"]}}"> {{$location_list["location_name"]}} </option>
                                                @else
                                                    <option value="{{$location_list["id"]}}"> {{$location_list["location_name"]}} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  museum --}}
                                    @php
                                        if(!is_null(request('location_id'))){
                                            $location_id = request('location_id') ;
                                            $ServiceLists = $api->ServiceList($location_id);
                                            $ServiceLists = $ServiceLists["ContentData"];
                                        }
                                    else
                                        $ServiceLists = [] ;
                                    @endphp
                                    <div class="col-md-3 text-right">
                                        <label for=""> انتخاب موزه </label>
                                        <select name="service_id" id="ServiceList" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب موزه ">
                                            <option value=""> همه </option>
                                            @foreach($ServiceLists as $ServiceList )
                                                @if($ServiceList["service_id"] == request("service_id"))
                                                    <option selected value="{{$ServiceList["service_id"]}}"> {{$ServiceList["service_name"]}} </option>
                                                @else
                                                    <option value="{{$ServiceList["service_id"]}}"> {{$ServiceList["service_name"]}} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if(env("HAS_TERMINAL"))
                                    {{--  Terminal --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  ترمینال </label>
                                        <select id="terminal_id" name="terminal_id" class="selectpicker"  data-style="btn btn-primary border-dark" title="Single Select">
                                            <option selected value="">همه</option>
                                        </select>
                                    </div>
                                    @endif
                                    {{--  Voucher --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  نوع بلیت </label>
                                        <select name="voucher_type_id" class="selectpicker"  data-style="btn btn-primary border-dark" title="Single Select">
                                            <option selected value="">همه</option>
                                            @foreach($tikcetType as $ticket)
                                                @if(request('voucher_type_id') == $ticket['voucher_type_id'])
                                                    <option selected value="{{$ticket['voucher_type_id']}}"> {{$ticket['voucher_type']}} </option>
                                                @else
                                                    <option value="{{$ticket['voucher_type_id']}}"> {{$ticket['voucher_type']}} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  type payement --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  نوع پرداخت </label>
                                        <select name="sell_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع پرداخت ">
                                            <option selected value="">همه</option>
                                            @foreach($SaleTypeList as $SaleType)
                                            @if(request('sell_type_id') == $SaleType['sale_type_id'] )
                                                <option selected value="{{$SaleType['sale_type_id']}}">{{$SaleType['sale_type']}}</option>
                                                @else
                                                <option value="{{$SaleType['sale_type_id']}}">{{$SaleType['sale_type']}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    {{--  State voucher --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  وضعیت بلیت </label>
                                        <select name="status_code" class="selectpicker" data-style="btn btn-primary border-dark" title="وضعیت بلیت">
                                            <option @if(request('status_code') == "255" || request('status_code') == "" ) selected @endif value="255">همه</option>
                                            <option @if(request('status_code') == "1") selected @endif value="1">استفاده نشده</option>
                                            <option @if(request('status_code') == "3") selected @endif value="3">حذف شده</option>
                                            <option @if(request('status_code') == "5") selected @endif value="5">استفاده شده</option>
                                        </select>
                                    </div>
                                    {{--  Operator --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  اپراتور </label>
                                        <select name="operator_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="اپراتور">
                                            <option value="" selected> همه  </option>
                                            @foreach($SellerUsersList as $Seller)
                                                @if(request('operator_id') == $Seller['sib_user_id'])
                                                    <option selected value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                                @else
                                                    <option value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--  Project --}}
                                    @if(count($ProjectList) > 1)
                                        <div class="col-md-3 text-right">
                                            <label for="">  پروژه </label>
                                            <select name="project_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="اپراتور">
                                                <option value="" selected> همه  </option>
                                                @foreach($ProjectList as $Project)
                                                    @if(request('project_id') == $Project['project_id'])
                                                        <option selected value="{{$Project['project_id']}}">{{$Project['project_name']}}</option>
                                                    @else
                                                        <option value="{{$Project['project_id']}}">{{$Project['project_name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @php


                                        $formDate = $api->fa2en(request('startDate'))  ;
                                        $endtDate = $api->fa2en(request('endDate'))  ;
                                        if ($formDate != "" )
                                            {
                                               $timestamp = \Hekmatinasser\Verta\Verta::parse($formDate .' 00:00:00')->datetime();
                                               $time = \Carbon\Carbon::instance($timestamp);;
                                            }
                                        else{
                                            $time = "";
                                        }
                                          if ($endtDate != "" )
                                            {
                                               $timestamp_endtDate = \Hekmatinasser\Verta\Verta::parse($endtDate .' 00:00:00')->datetime();
                                               $time_endtDate = \Carbon\Carbon::instance($timestamp_endtDate);;
                                            }
                                        else{
                                            $time_endtDate = "";
                                        }
                                    @endphp
                                    {{--  Start Date --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  تاریخ شروع  </label>
                                        <input autocomplete="off" value="{{$time}}" name="startDate" id="FromDate" type="text" class="form-control" placehrequester="از تاریخ">
                                    </div>
                                    {{--  End Date --}}
                                    <div class="col-md-3 text-right">
                                        <label for="">  تاریخ پایان  </label>
                                        <input autocomplete="off"  value="{{$time_endtDate}}" name="endDate" id="ToDate" type="text" class="form-control" placehrequester="تا تاریخ">
                                    </div>
                                    @if($report_type == 0)
                                        {{-- sale type --}}
                                        <div class="col-md-3 text-right">
                                            <label for="">  نوع فروش  </label>
                                            <select name="pre_sale" class="selectpicker" data-style="btn btn-primary border-dark" title="ییش فروش">
                                                <option value="" selected> همه  </option>
                                                <option @if(request('pre_sale') == "2") selected @endif value="2"> عادی </option>
                                                <option @if(request('pre_sale') == "1") selected @endif value="1"> پیش فروش </option>
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" name="pre_sale" value="1">
                                    @endif
                                    {{-- Search btn --}}
                                    <div class="col-md-3 mr-auto">
                                        <label for="" class="text-white"> .</label>
                                        <button class="btn bgPer btn-block"> جست و جو <i class="material-icons"> search</i> </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Modal -->
                        </div>
                        @php
                            $City = [] ;
                            $count = [] ;
                        @endphp
                        @if(Route::current()->getName() == "GetStat")
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table id="reportTable" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                            نام دسته
                                        </th>
                                        <th >
                                           تعداد
                                        </th>
                                        <th >
                                            جمع (ریال)
                                            {{--<div class="form-row align-items-center">
                                                <div class="col">
                                                    <span>

                                                    </span>
                                                </div>
                                                <div class="col-auto">

                                                </div>
                                            </div>--}}
                                        </th>
                                       {{-- <th>
                                            قیمت بدون تخفیف
                                        </th>--}}
                                        <th width="50">
                                            <button onclick="export2excel()" type="button" class="btn btn-success">
                                                دانلود اکسل
                                                <i class="material-icons"> vertical_align_bottom </i>
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($data == null || count($data['result']) == 0 )
                                        <tr>
                                            <td colspan="5">
                                                <h6 class="text-center py-5"> موردی یافت نشد ! </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($data['result'] as $result)
                                            @php
                                                array_push($City, $result[request('key').'_name']);
                                                array_push($count, $result['count']);
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{$result[request('key').'_name']}}
                                                </td>
                                                <td>

                                                    {{ number_format($result['count'] , 0 , '.' , ',')}}
                                                </td>
                                              {{--  <td>
                                                    {{ number_format($result['amount_without_discount'] , 0 , '.' , ',')}}
                                                </td>--}}
                                                <td>
                                                    @if(request('reportType') == 1)
                                                        {{number_format($result['amount'] * 0.85 , 0 ,'.' , ',' )}}
                                                    @else
                                                        {{number_format($result['amount'] , 0 ,'.' , ',' )}}
                                                    @endif
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endforeach

                                            <tr class="bg-light">
                                                <th >
                                                    جمع
                                                </th>
                                                <th >
                                                    {{ number_format($data['total_count'] , 0 , '.' , ',')}}
                                                </th>
                                                <th>
                                                    @if(request('reportType') == 1)
                                                        {{ number_format($data['total_amount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @else
                                                        {{ number_format($data['total_amount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @endif
                                                </th>
                                               {{-- <th>
                                                    @if(request('reportType') == 1)
                                                        {{ number_format($data['total_amount_without_discount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @else
                                                        {{ number_format($data['total_amount_without_discount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @endif
                                                </th>--}}
                                                <th>

                                                    {{--مبلغ پرداختی :
                                                    @if(request('reportType') == 1)
                                                        {{ number_format($data['total_paid_amount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @else
                                                        {{ number_format($data['total_paid_amount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                    @endif
                                                    --}}
                                                </th>
                                            </tr>

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
                @if(Route::current()->getName() == "GetStat")
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose pb-2 border-bottom">
                            <div class="row">
                                <div class="col-md">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">insert_chart</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> گزارش نموداری </h4>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col py-3" style="height: 500px" >
                                    <h6 class="text-center"> تعداد فروش </h6>
                                    <canvas id="myChart" width="350" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    @endif
        </div>
    </div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/js/tableToExcel.js"></script>
    <script type="text/javascript">
        console.log("ok")
        $(document).ready(function() {
            $('#FromDate').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                format: 'YYYY/MM/DD',
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                },navigator:{
                    text:{
                        btnNextText:'بعدی',
                        btnPrevText:'قبلی'
                    }
                }
            });
            $('#ToDate').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                format: 'YYYY/MM/DD',
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                },navigator:{
                    text:{
                        btnNextText:'بعدی',
                        btnPrevText:'قبلی'
                    }
                }

            });

            let start = "{{request('startDate')}}";
            if(start != '')
                $("#FromDate").val(start);

            let end = "{{request('endDate')}}";
            if(end != '')
                $("#ToDate").val(end);
        });
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let session_fall = true;
            province= "{{request('province_id')}}";
            cityList = "{{request('city_id')}}";
            locationList = "{{request('location_id')}}";


            $('#province').change(function () {
                var province_id = $('#province').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                    },statusCode: {
                        500: function() {
                            $("#loader").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                'error'
                            )
                        } ,
                        400: function() {
                            let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                            let x = 1 ;
                            let dots = "";
                            setInterval(function () {
                                dots += ".";
                                x++  ;
                                // console.log(x)
                                if(x >= 8 ){
                                    x = 1 ;
                                    dots = ".";
                                }
                                $("#dots").html(dots)
                            } , 300)
                            $("#loader").hide();
                            Swal.fire(
                                'نشست  شما پایان یافته است ! ',
                                html,
                                'warning' ,
                            )
                            setTimeout(function () {
                                window.location.href = "{{Route("logout")}}";
                            } , 1500)
                            session_fall = false ;

                        }
                    },
                    success:function(data) {
                        $("#cityList").html('');
                        $("#cityList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i < data.data.length ; i++){
                            $("#cityList").append(new Option( data.data[i].city_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });
            $('#cityList , #province').change(function () {
                var province_id = $('#province').val();
                var city_id = $('#cityList').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('location_list')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                        'city_id' : city_id ,
                    },statusCode: {
                        500: function() {
                            $("#loader").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                'error'
                            )
                        } ,
                        400: function() {
                             if (session_fall){
                                 let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                 let x = 1 ;
                                 let dots = "";
                                 setInterval(function () {
                                     dots += ".";
                                     x++  ;
                                     // console.log(x)
                                     if(x >= 8 ){
                                         x = 1 ;
                                         dots = ".";
                                     }
                                     $("#dots").html(dots)
                                 } , 300)
                                 $("#loader").hide();
                                 Swal.fire(
                                     'نشست  شما پایان یافته است ! ',
                                     html,
                                     'warning' ,
                                 )
                                 setTimeout(function () {
                                     window.location.href = "{{Route("logout")}}";
                                 } , 1500)
                                 session_fall = false ;
                             }


                        }
                    },
                    success:function(data) {
                        $("#locationList").html('');
                        $("#locationList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.data.length ; i++){
                            if(city_id == data.data[i].id )
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id , true));
                            else
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });
            $('#cityList , #province , #locationList').change(function () {
                var locationID = $('#locationList').val();
                // console.log("in the terminal location id is :  " + locationID)
                $.ajax({
                    type:'POST',
                    url:"{{Route('ServiceListReport')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'locationID' : locationID ,
                    },statusCode: {
                        500: function() {
                            $("#loader").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                'error'
                            )
                        } ,
                        400: function() {
                            if(session_fall){
                                let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                let x = 1 ;
                                let dots = "";
                                setInterval(function () {
                                    dots += ".";
                                    x++  ;
                                    // console.log(x)
                                    if(x >= 8 ){
                                        x = 1 ;
                                        dots = ".";
                                    }
                                    $("#dots").html(dots)
                                } , 300)
                                $("#loader").hide();
                                Swal.fire(
                                    'نشست  شما پایان یافته است ! ',
                                    html,
                                    'warning' ,
                                )
                                setTimeout(function () {
                                    window.location.href = "{{Route("logout")}}";
                                } , 1500)
                                session_fall = false ;
                            }


                        }
                    },
                    success:function(data) {
                        $("#ServiceList").html('');
                        $("#ServiceList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.array_keys.length ; i++){
                            $("#ServiceList").append(new Option( data.data[[data.array_keys[i]]].service_name , data.data[[data.array_keys[i]]].service_id));
                        }

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
                $.ajax({
                    type:'POST',
                    url:"{{Route('ReportTerminalLocationList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'locationID' : locationID ,
                    },statusCode: {
                        500: function() {
                            $("#loader").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                'error'
                            )
                        } ,
                        400: function() {
                            if (session_fall){
                                let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                let x = 1 ;
                                let dots = "";
                                setInterval(function () {
                                    dots += ".";
                                    x++  ;
                                    // console.log(x)
                                    if(x >= 8 ){
                                        x = 1 ;
                                        dots = ".";
                                    }
                                    $("#dots").html(dots)
                                } , 300)
                                $("#loader").hide();
                                Swal.fire(
                                    'نشست  شما پایان یافته است ! ',
                                    html,
                                    'warning' ,
                                )
                                setTimeout(function () {
                                    window.location.href = "{{Route("logout")}}";
                                } , 1500)
                                session_fall = false ;
                            }


                        }
                    },
                    success:function(data) {
                        console.log(data.data)
                        $("#terminal_id").html('');
                        $("#terminal_id").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.data.length ; i++){
                            $("#terminal_id").append(new Option( data.data[i].service_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });

            $('.selectpicker').selectpicker('refresh');

        });
        function export2excel() {
            TableToExcel.convert(document.getElementById("reportTable"));
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script>
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };
        var inputs = {
            min: -100,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        let colors = [] ;
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($City),
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: @json($count),

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: changeColor(@json($City)),
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                scales: {
                    xAxes: [{
                        display: true,
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        function changeColor(array) {
            len = array.length ;
            for(let i =0 ; i < len ; i++){
                if(i % 2 == 0)
                    colors.push('#ec407a')
                else
                    colors.push('#494c6b')
            }
            console.log(colors);
            return colors ;
        }
    </script>

@endsection
