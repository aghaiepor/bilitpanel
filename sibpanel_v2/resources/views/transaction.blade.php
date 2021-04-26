@extends('MainLayout')

@section('title')
    <title>
        @if($report_type == 0)
            گزارش ریز تراکنش
        @else
            گزارش ریز تراکنش پیش فروش
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
        .SelectSpinner
        {
            width: 30px;
            height: 30px;
            color: #fff !important;
            box-shadow: 0px 0px 15px 3px #999;
        }
    </style>
@endsection
@php
    $api = new App\Api\Api() ;
@endphp
@section('content')
<div class="content">
    <div class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-right" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close mt-2 pt-3" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @elseif(session('error'))

                <div class="alert alert-danger alert-dismissible fade show text-right" role="alert">
                    {{ session('error') }}
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
                                        <i class="material-icons">article</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">
                                        @if($report_type == 0)
                                            گزارش ریز تراکنش
                                        @else
                                            گزارش ریز تراکنش پیش فروش
                                        @endif

                                    </h4>
                                </div>
                                <div class="col-md">
                                    <a {{--onclick="history.go(-1);"--}} href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <form action="{{Route('GetTransaction')}}" method="get">
                                <input type="hidden" name="reportType" value="{{$report_type}}">

                            <div class="row mt-3">
                                {{--  Project --}}
                                @if(count($ProjectList) > 1)
                                    <div class="col-md-3 text-right">
                                        <label for="">  پروژه </label>
                                        <select name="project_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="اپراتور">
                                            @foreach($ProjectList as $Project)
                                                @if(is_null(request('project_id')) &&  $Project['project_id'] == 1 )
                                                    <option selected value="{{$Project['project_id']}}">{{$Project['project_name']}}</option>
                                                @elseif(request('project_id') == $Project['project_id'])
                                                    <option selected value="{{$Project['project_id']}}">{{$Project['project_name']}}</option>
                                                @else
                                                    <option value="{{$Project['project_id']}}">{{$Project['project_name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-3 text-right">
                                    <label for=""> انتخاب استان  </label>
                                    <select name="province_id" id="province"  class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب استان">
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
                                <div class="col-md-3 text-right position-relative">
                                    <div id="loader_cityList" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0px;bottom: 0;justify-content: center;align-items: center;background: #ffffff99;cursor: not-allowed; display: none; padding-top: 41px;">
                                        <div class="spinner-border SelectSpinner mx-auto d-block mb-3"></div>
                                    </div>
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
                                    <div id="loader_locationList" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0px;bottom: 0;justify-content: center;align-items: center;background: #ffffff99;cursor: not-allowed; display: none; padding-top: 41px;">
                                        <div class="spinner-border SelectSpinner mx-auto d-block mb-3 " ></div>
                                    </div>
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
                                    <div id="loader_ServiceList" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0px;bottom: 0;justify-content: center;align-items: center;background: #ffffff99;cursor: not-allowed; display: none; padding-top: 41px;">
                                        <div class="spinner-border SelectSpinner mx-auto d-block mb-3"></div>
                                    </div>
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


                                <div class="col-md-3  text-right">
                                    <label for="">  نوع بلیت </label>
                                    <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
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
                                <div class="col-md-3  text-right">
                                    <label for="">  نوع پرداخت </label>
                                    <select name="sell_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع پرداخت">
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
                                <div class="col-md-3  text-right">
                                    <label for="">  وضعیت بلیت </label>
                                    <select name="status_code" class="selectpicker" data-style="btn btn-primary border-dark" title="وضعیت بلیت">
                                        <option @if(request('status_code') == "255" || request('status_code') == "") selected @endif value="255">همه</option>
                                        <option @if(request('status_code') == "1") selected @endif value="1">استفاده نشده</option>
                                        <option @if(request('status_code') == "3") selected @endif value="3">حذف شده</option>
                                        <option @if(request('status_code') == "5") selected @endif value="5">استفاده شده</option>
                                    </select>
                                </div>
                                <div class="col-md-3  text-right">
                                    <label for="">  اپراتور </label>
                                    <select name="operator_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="اپراتور">
                                            <option value="" selected> همه </option>
                                        @foreach($SellerUsersList as $Seller)
                                            @if(request('operator_id') == $Seller['sib_user_id'])
                                                <option selected value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                            @else
                                                <option value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                @if($report_type == 0)
                                    <div class="col-md-3 text-right">
                                        <label for="">  نوع فروش  </label>
                                        <select name="pre_sale" class="selectpicker" data-style="btn btn-primary border-dark" title="ییش فروش">
                                            <option value="" selected> همه  </option>
                                            @foreach($SellModelList as $SellModel)
                                                @if(request('pre_sale') == $SellModel["sell_model_id"])
                                                    <option value="{{$SellModel["sell_model_id"]}}"> {{$SellModel["sell_model"]}} </option>
                                                @else
                                                    <option value="{{$SellModel["sell_model_id"]}}"> {{$SellModel["sell_model"]}} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="pre_sale" value="1" >
                                @endif
                                {{-- **** Voucher Number  **** --}}
                                <div class="col-md-3 text-right">
                                    <label for="">  شماره کارت تخفیف </label>
                                    <input  name="card_number" value="{{request('card_number')}}" type="text" class="form-control" placeholder="شماره کارت تخفیف">
                                </div>
                                {{-- **** Voucher Number  **** --}}
                                <div class="col-md-3 text-right">
                                    <label for="">  شماره بلیت </label>
                                    <input  name="voucher_number" value="{{request('voucher_number')}}" type="text" class="form-control" placeholder="شماره بلیت">
                                </div>
                                {{-- **** RRN Number  **** --}}
                                <div class="col-md-3 text-right">
                                    <label for="">  شماره RRN  </label>
                                    <input  name="rrn" value="{{request('rrn')}}" type="text" class="form-control" placeholder="شماره RRN">
                                </div>

                                <div class="col-md-3 text-right">
                                    @php


                                        $formDate = $api->fa2en(request('startDate'))  ;
                                        $endtDate = $api->fa2en(request('endtDate'))  ;
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
                                        else
                                            $time_endtDate = "";

                                    @endphp
                                    <label for="">  تاریخ شروع  </label>
                                    <input id="FromDate" value="{{$time}}" name="startDate" type="text" class="form-control" placeholder="از تاریخ">
                                </div>
                                <div class="col-md-3 text-right">
                                    <label for="">  تاریخ پایان  </label>
                                    <input id="ToDate" name="endtDate" value="{{$time_endtDate}}" type="text" class="form-control" placeholder="تا تاریخ">
                                </div>
                                <input type="hidden" name="page" value="1">
                                <div class="col-md-3 mr-auto">
                                    <label for="">&nbsp;</label>
                                   <button type="submit" class="btn bgPer btn-block"> جست و جو <i class="material-icons"> search</i> </button>
                                </div>
                            </div>
                            <!-- Modal -->
                            </form>
                        </div>
                        @if(Route::current()->getName() == "GetTransaction")
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table id="TransationTable"  class="table text-center">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th class="text-left" colspan="11">
                                            @php
                                                $url = str_replace("GetTransaction","transactionToExcel",\Illuminate\Support\Facades\URL::full())
                                            @endphp
                                            <button @if(Route::current()->getName() != "GetTransaction" || count($data['log']) == 0) disabled @endif onclick="export2excel()" class="btn btn-info  mt-2 "> دانلود اکسل این صفحه<i class="material-icons"> vertical_align_bottom </i>  </button>
                                            <a @if(Route::current()->getName() != "GetTransaction" || count($data['log']) == 0) href="no" @else href="{{$url}}" @endif id="excelBtn"  {{--target="_blank"--}} anchor="download" class="btn btn-success  mt-2 "> دانلود اکسل تمامی صفحات<i class="material-icons"> vertical_align_bottom </i>  </a>
                                        </th>
                                    </tr>
                                    <tr class="">
                                        <th>
                                            نام مکان
                                        </th>
                                        <th>
                                            نام جاذبه
                                        </th>
                                        <th>
                                           شماره تلفن کاربر
                                        </th>
                                        <th >
                                            شماره بلیت
                                        </th>
                                        <th >
                                            RRN
                                        </th>
                                        <th >
                                            نوع بلیت
                                        </th>
                                        <th >
                                            نوع پرداخت
                                        </th>
                                        <th >
                                            وضعیت پرداخت
                                        </th>
                                        <th >
                                            تعداد
                                        </th>
                                        <th >
                                            زمان تراکنش
                                        </th>
                                       {{-- <th >
                                            جمع کل بدون تخفیف (ریال)
                                        </th>--}}
                                        <th >
                                            جمع کل (ریال)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($data == null || count($data['log']) == 0 )
                                        <tr>
                                            <td colspan="11">
                                                <h6 class="text-center py-5"> موردی یافت نشد ! </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($data['log'] as $result)
                                            <tr>
                                                <td>
                                                    {{$result['location_name']}}
                                                </td>
                                                <td>
                                                    {{$result['service_name']}}
                                                </td>
                                                <td>
                                                    {{ ( $result['user_cellphone'] == "" ) ? " - " :  $result['user_cellphone']}}
                                                </td>
                                                <td>
                                                    {{$result['voucher_number']}}
                                                </td>
                                                <td>
                                                    {{ ( $result['RRN'] == "" ) ? " - " :  $result['RRN']}}
                                                </td>
                                                <td>
                                                    {{$result['voucher_type_name']}}
                                                </td>
                                                <td>
                                                    {{$result['sale_type_name']}}
                                                </td>
                                                <td>
                                                    @if($result['procedure_status'] == 1 || $result['procedure_status'] == 10 )
                                                        <span class="badge badge-sm badge-secondary"> استفاده نشده </span>
                                                        @elseif($result['procedure_status'] == 11 || $result['procedure_status'] == 5)
                                                        <span class="badge badge-sm badge-success"> استفاده شده </span>
                                                        @elseif($result['procedure_status'] == 3)
                                                        <span class="badge badge-sm badge-danger"> حذف شده </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($result['ticket_number'] , 0 , '.' , ',')}}
                                                </td>
                                                <td dir="ltr">
                                                    {{ str_replace("-" , "/" , $result['get_voucher_date_jalali'])  }}
                                                </td>
                                             {{--   <td>
                                                    @if(request('reportType') == 1)
                                                        {{number_format($result['amount_without_discount'] * 0.85 , 0 ,'.' , ',' )}}
                                                    @else
                                                        {{number_format($result['amount_without_discount'] , 0 ,'.' , ',' )}}
                                                    @endif
                                                </td>--}}
                                                <td>
                                                    @if(request('reportType') == 1)
                                                        {{number_format($result['amount'] * 0.85 , 0 ,'.' , ',' )}}
                                                    @else
                                                        {{number_format($result['amount'] , 0 ,'.' , ',' )}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-light">
                                            <th colspan="4" class="text-center" >
                                                تعداد :
                                                {{ number_format($data['total_count'] , 0 , '.' , ',')}}
                                            </th>
                                            <th colspan="4"  class="text-center">

                                                {{--مجموع پرداختی :
                                                @if(request('reportType') == 1)
                                                    {{ number_format($data['total_paid_amount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                @else
                                                    {{ number_format($data['total_paid_amount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                @endif
                                                --}}
                                            </th>
                                          {{--  <th class="text-center" colspan="3">
                                                جمع بدون تخفیف :
                                                @if(request('reportType') == 1)
                                                    {{ number_format($data['total_amount_without_discount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                @else
                                                    {{ number_format($data['total_amount_without_discount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                @endif
                                            </th>--}}
                                            <th  class="text-center" colspan="4">
                                                جمع :
                                                @if(request('reportType') == 1)
                                                    {{ number_format($data['total_amount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                @else
                                                    {{ number_format($data['total_amount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                @endif
                                            </th>

                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        <div class="card-footer justify-content-center">
                            <ul class="pagination justify-content-center">
                                @if($data != null /*|| count($data['log']) != 0 */)
                                    @php
                                        $result = new \Illuminate\Pagination\LengthAwarePaginator( $data['log'],$data['total_pages'], 1,  \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage(),array('path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()));
                                        $page = (int)request('page');
                                        $result->withPath(url()->full());
                                    @endphp
                                    {{$result->render()}}
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{asset('')}}assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/js/tableToExcel.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // console.log("test");
            $('#FromDate').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                altField: '#inlineExampleAlt',
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
            if(start != ''){
                $("#FromDate").val(start);
                start = start.replace(/[٠-٩]/g, d => "٠١٢٣٤٥٦٧٨٩".indexOf(d)).replace(/[۰-۹]/g, d => "۰۱۲۳۴۵۶۷۸۹".indexOf(d));
                console.log(start);
                $("#FromDate").attr("data-date" , start );
            }
            let end = "{{request('endtDate')}}";
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
            province= "{{request('province_id')}}";
            cityList = "{{request('city_id')}}";
            locationList = "{{request('location_id')}}";
            service_id = "{{request('service_id')}}";
            let session_fall = true;

            $(".dropdown-toggle").click(function () {
                $("#sidebar").css("z-index" , 2) ;

            })

            /*
                $('#project').change(function () {
                var project_id = $('#project').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('ProvinceListReport')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'project_id' : project_id ,
                    },
                    statusCode: {
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
                        $("#province").html('');
                        $("#province").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i < data.data.length ; i++){
                            $("#province").append(new Option( data.data[i].province_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });
            */
            $('#province').change(function () {
                var province_id = $('#province').val();
                $("#loader_cityList").css("display", "flex");
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
                            $("#cityList").append(new Option( data.data[i].name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                        $("#loader_cityList").hide();
                    }
                });
            });
            $('#cityList , #province').change(function () {
                var province_id = $('#province').val();
                var city_id = $('#cityList').val();
                $("#loader_locationList").css("display", "flex");
                $.ajax({
                    type:'POST',
                    url:"{{Route('location_list')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                        'city_id' : city_id ,
                    },
                    statusCode: {
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

                        $("#locationList").html('');
                        $("#locationList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.data.length ; i++){
                            if(city_id == data.data[i].id )
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id , true));
                            else
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id));
                        }
                        $('#locationList').selectpicker('refresh');
                        $("#loader_locationList").hide();
                    }
                });
            });
            $('#cityList , #province , #locationList').change(function () {
                var locationID = $('#locationList').val();
                $("#loader_ServiceList").css("display", "flex");
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
                                session_fall = false;
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
                        $("#loader_ServiceList").hide();
                    }
                });
            });

            $('.selectpicker').selectpicker('refresh');

            $("#excelBtn").click(function (e)
            {
                e.preventDefault();
                let href = $("#excelBtn").attr("href") ;
                if (href == "no"){
                    Swal.fire(
                        'خطا ... ',
                        'اطلاعاتی جهت دانلود یافت نشد ! ',
                        'warning'
                    )
                }else{
                    Swal.fire(
                        'در حال دانلود... ',
                        ' این در خواست ممکن است کمی طول بکشد ، لطفا صبور باشید. ',
                        'info'
                    )
                    // document.location = href ;
                    setTimeout(function () {
                        window.open(href, "_blank");
                    } , 1500)
                }

            });
            // $('#TransationTable').DataTable();
        });
        function export2excel() {
            Swal.fire(
                'در حال دانلود... ',
                ' این در خواست ممکن است کمی طول بکشد ، لطفا صبور باشید. ',
                'info'
            )
            TableToExcel.convert(document.getElementById("TransationTable"));
        }
    </script>
@endsection
