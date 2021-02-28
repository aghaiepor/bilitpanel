@extends('MainLayout')

@section('title')
    <title>
        اضافه کردن سانس
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }
        #plotId{
            font-family: iransans !important;
            box-shadow: 0px 2px 6px -1px #ccc !important;
            border-radius: 5px;
            border: none;
        }
        .pwt-btn , .pwt-btn-today{
            background: #ececec !important;
            border-radius: 5px !important;
            margin-top: 5px !important;
        }
        #plotId .title{
            display: none;
        }
        #plotId .header{
            margin-bottom: 5px;
        }
        .datepicker-plot-area .datepicker-day-view .table-days td div:hover{
            background-color: #ececec !important;
        }
        .sanseBtn:hover{
            background: #FFC107 !important;
        }
        .ticketRow{
            opacity: 0;
            transform: scale(0.6, 0.6);
            transition: opacity .2s ease-out, transform .2s ease-out;
        }
        .visible {
            opacity: 1;
            transform: scale(1, 1);
        }
        .calender_Area{
            transition: opacity .2s ease-out, transform .2s ease-out;
            /*transition : filter 1s ease-out ;*/
        }
        #FromDate , #ToDate , #FromDate2 , #ToDate2 {
            direction: ltr;
        }
        .dt-deselected span:first-child
        {
            font-weight: 400;
            font-size: 11pt;
        }
    </style>

    <link id="s1" rel="stylesheet" type="text/css" href="{{ asset('assets/css/persian-datepicker_service_time.css') }}">
    <link id="s2" rel="stylesheet" type="text/css" href="{{ asset('assets/css/service_time.css') }}">
    {{--  for orginal calender  --}}
    {{--    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">--}}


@endsection

@section('content')
    <div class="content">
        <div id="loader" style="position: fixed;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                    <div class="card">
                        <div class="card-header card-header-icon position-relative card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons"> watch_later </i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">  مدیریت سانس ها </h4>
                                </div>
                                <div class="col-sm">
{{-- <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> سانس جدید </span>--}}

                                    <a id="exportSans" data-toggle="modal" data-target="#sanas"  {{--onclick="history.go(-1);"--}} class="btn btn-success mt-2"> افزودن سانس به سرویس های دیگر </a>
                                    @php
                                        if (url()->current() != url()->previous()) {
                                            session(['back' => url()->previous()]);
                                            $url = url()->previous() ;
                                        }
                                    @endphp
                                    <a {{--onclick="history.go(-1);"--}} href="{{session('back')}}" class="btn btn-dark mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div  class="card-body">

                            {{--   capecity and ...   --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="padding: 10px;overflow:hidden">
                                        <button class="btn btn-primary float-right btn-sm" onclick="selectAll()">انتخاب همه</button>
                                        <button class="btn btn-danger float-right mr-2 btn-sm" onclick="deselctAll()">لغو انتخاب ها</button>
                                        <button id="addSans" class="btn btn-success mr-atuo btn-sm" data-toggle="modal" data-target="#test"> افزودن سانس ها </button>
                                        <button id="sanasDayButton" data-toggle="modal" data-target="#sanasDay" class="btn btn-sm btn-primary mt-2"> تمديد سانس ها </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row calender_Area" id="div_seance" style="display: none">
                                <div class="col-lg panel panel-default">
                                    <div class="panel-body" style="font-family: iransans !important;">
                                        <div class="form-group">
                                            <div id="inline2">
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="removeTime()" class="btn btn-sm btn-danger d-none" style="margin-top: 10px">حذف انتخاب شده
                                    </button>
{{--                                    <button onclick="setTime()" class="btn btn-sm btn-primary" style="margin-top: 10px">اعمال</button>--}}
                                  {{--  <div class="col-md text-right" style="margin-top: 35px;margin-bottom: 10px">
                                        <button onclick="submit()" class="btn btn-success c-font-bold btn-lg">تایید نهایی و اعمال تغییرات</button>
                                    </div>--}}
                                </div>
{{--                                <div class="col-lg-4" style="margin-top: 30px">--}}
                                    {{--
                                    <div class="col-md-5 mr-3 text-center pull-right"
                                         style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                        <div class="row justify-content-center">
                                            <span style="font-size: 16px">ساعت شروع</span>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 10px">
                                            <button onclick="changeMin('start_minute','add')" class="btn btn-primary btn-time"
                                                    style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                            <button onclick="changeHour('start_hour','add')" class="btn btn-primary btn-time"
                                                    style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                            <input id="start_minute" value="00" disabled>
                                            <span style="font-size: 20px">:</span>
                                            <input id="start_hour" value="8" disabled>
                                        </div>
                                        <div class="row justify-content-center time-select">
                                            <button onclick="changeMin('start_minute','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                            <button onclick="changeHour('start_hour','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mr-3 text-center pull-right"
                                         style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                        <div class="row justify-content-center">
                                            <span style="font-size: 16px">ساعت پایان</span>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 10px">
                                            <button onclick="changeMin('end_minute','add')" class="btn btn-primary btn-time"
                                                    style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                            <button onclick="changeHour('end_hour','add')" class="btn btn-primary btn-time"
                                                    style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                            <input id="end_minute" value="00" disabled>
                                            <span style="font-size: 20px">:</span>
                                            <input id="end_hour" value="9" disabled>
                                        </div>
                                        <div class="row justify-content-center time-select">
                                            <button onclick="changeMin('end_minute','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                            <button onclick="changeHour('end_hour','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>

                                        </div>

                                    </div>
                                    <div class="col-lg-12  pull-right" style="margin-top: 20px">

                                        <div class="form-row text-right">
                                            <div class="col">
                                                <label class="w-100" for=""> نوع بليت
                                                </label>
                                                @php
                                                    $VoucherList = [];
                                                @endphp
                                                <select id="vouchers" name="vouchers" class="selectpicker" data-style="btn btn-primary border-dark" title="بلیت">
                                                    @foreach($VoucherTypeList as $VoucherType)
                                                        @php
                                                            array_push($VoucherList , ["VoucherInfo_id" => $VoucherType["voucher_type_id"] , "voucher_type_name" => $VoucherType["voucher_type"]]);
                                                        @endphp
                                                        <option value="{{$VoucherType["voucher_type_id"] .  "-" . $VoucherType["voucher_type"] }}">
                                                            {{$VoucherType["voucher_type"]}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col">
                                                <label for=""> جنسیت </label>
                                                <select name="seance_gender" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                    <option selected value="dont_care">  همه </option>
                                                    <option value="male" > مردانه </option>
                                                    <option value="female" > زنانه </option>
                                                    <option value="single_sex">  تک جنسیتی </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row text-right mt-2">
                                            <div class="col text-right">
                                                <label class="w-100" for=""> ظرفيت</label>
                                                <input type="text" id="capacity" name="capacity" class="form-control" placeholder="ظرفيت">
                                            </div>
                                            <div class="col">
                                                <label class="w-100" for=""> قیمت</label>
                                                <input type="text" name="cap" class="form-control" placeholder="قیمت">
                                            </div>
                                            <div class="col">
                                                <label class="w-100" for=""> حداکثر تخفيف</label>
                                                <input type="text" name="cap" class="form-control" placeholder="حداکثر تخفيف">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-right">
                                                <button onclick="addSeance()" class="btn btn-info mt-3">اضافه کردن سانس</button>
                                                <button onclick="removeAllSeance()" class="btn btn-danger mt-3">حذف همه سانس ها</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    --}}
                                  {{--  <div class="row">
                                        <div class="col-md-12">
                                            <div id="seances" class="col-lg-12"></div>
                                        </div>
                                    </div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <form action="{{Route("add_group_time")}}" method="post" id="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            {{--<div class="col-md-4 ml-auto text-right">
                                                <label for="group_name">نام گروه سانس</label>
                                                <input type="text" class="form-control" id="group_name" name="group_name"
                                                       placeholder="نام گروه سانس">
                                            </div>--}}
                                            <input type="hidden" name="serviceId" value="{{$id}}">
                                            <input type="hidden" id="service_times" name="service_times" value="">
                                            <div class="col-md-offset-4 col-md-4 col-md-offset-4" style="margin-top:50px;">
                                                <img id='img-upload' style="max-width:100%;"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> افزودن سانس </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="loader1" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                        </div>
                        <div class="row mt-3">
                           {{-- <div id="formSans" class="col-lg  pull-right" style="margin-top: 20px">
                                <div class="form-row text-right">
                                    <div class="col">
                                        <label class="w-100" for=""> نوع بليت
                                        </label>
                                        @php
                                            $VoucherList = [];
                                        @endphp
                                        <select id="vouchers" name="vouchers" class="selectpicker" data-style="btn btn-primary border-dark" title="بلیت">
                                            @foreach($VoucherTypeList as $VoucherType)
                                                @php
                                                    array_push($VoucherList , ["VoucherInfo_id" => $VoucherType["voucher_type_id"] , "voucher_type_name" => $VoucherType["voucher_type"]]);
                                                @endphp
                                                <option value="{{$VoucherType["voucher_type_id"] .  "-" . $VoucherType["voucher_type"] }}">
                                                    {{$VoucherType["voucher_type"]}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="form-row text-right mt-2">
                                    <div class="col text-right">
                                        <label class="w-100" for=""> ظرفيت</label>
                                        <input type="text" id="capacity" name="capacity" class="form-control" placeholder="ظرفيت">
                                    </div>
                                    <div class="col">
                                        <label class="w-100" for=""> قیمت</label>
                                        <input type="text" id="amount" name="amount" class="form-control" placeholder="قیمت">
                                    </div>
                                    <div class="col">
                                        <label class="w-100" for=""> حداکثر تخفيف</label>
                                        <input type="text" id="max_persent" name="max_persent" class="form-control" placeholder="حداکثر تخفيف">
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-lg id mx-auto row">
                                <div class="col text-center pull-right"
                                     style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                    <div class="row justify-content-center">
                                        <span style="font-size: 16px">ساعت شروع</span>
                                    </div>
                                    <div class="row justify-content-center time-select" style="margin-top: 10px">
                                        <button type="button" onclick="changeMin('start_minute','add')" class="btn btn-primary btn-time"
                                                style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                        <button type="button" onclick="changeHour('start_hour','add')" class="btn btn-primary btn-time"
                                                style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                    </div>
                                    <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                        <input id="start_minute" value="00" disabled>
                                        <span style="font-size: 20px">:</span>
                                        <input id="start_hour" value="8" disabled>
                                    </div>
                                    <div class="row justify-content-center time-select">
                                        <button type="button" onclick="changeMin('start_minute','minus')" class="btn btn-primary btn-time"
                                                style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                        <button type="button" onclick="changeHour('start_hour','minus')" class="btn btn-primary btn-time"
                                                style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>
                                    </div>
                                </div>
                                <div class="col mr-3 text-center pull-right"
                                     style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                    <div class="row justify-content-center">
                                        <span style="font-size: 16px">ساعت پایان</span>
                                    </div>
                                    <div class="row justify-content-center time-select" style="margin-top: 10px">
                                        <button type="button" onclick="changeMin('end_minute','add')" class="btn btn-primary btn-time"
                                                style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                        <button type="button" onclick="changeHour('end_hour','add')" class="btn btn-primary btn-time"
                                                style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                    </div>
                                    <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                        <input id="end_minute" value="00" disabled>
                                        <span style="font-size: 20px">:</span>
                                        <input id="end_hour" value="9" disabled>
                                    </div>
                                    <div class="row justify-content-center time-select">
                                        <button type="button" onclick="changeMin('end_minute','minus')" class="btn btn-primary btn-time"
                                                style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                        <button type="button" onclick="changeHour('end_hour','minus')" class="btn btn-primary btn-time"
                                                style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>

                                    </div>

                                </div>
                                <div class="col-md-12 px-0 my-3 text-right">
                                    <label for=""> جنسیت </label>
                                    <select name="seance_gender" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                        <option selected value="dont_care">  همه </option>
                                        <option value="male" > مردانه </option>
                                        <option value="female" > زنانه </option>
                                        <option value="single_sex">  تک جنسیتی </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="button" onclick="addSeance()" class="btn btn-sm btn-success mt-3 ">اضافه کردن سانس<div class="ripple-container"></div></button>
                                <button type="button" onclick="removeAllSeance()" class="btn btn-sm btn-danger d-none float-left mt-3">حذف همه سانس ها</button>
                            </div>
                        </div>
                        <hr class="my-1">
                        <div class="row">
                            <div class="col-md">
                                <div  class="col-lg-12 px-0">
                                    <table class="table table-striped text-center" id="SansaTable">
                                        <thead class="text-primary">
                                        <tr>

                                            <th>
                                                زمان شروع
                                            </th>
                                            <th>
                                                زمان پایان
                                            </th>
                                            <th>
                                                جنسیت
                                            </th>
                                            <th>
                                                فعالسازی
                                            </th>
                                            <th>
                                                مدیریت بلیت
                                            </th>
                                            <th>
                                               حذف
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="seances">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="dismis_sanse" type="button" class="btn btn-primary ml-auto" data-dismiss="modal">بستن </button>
                        <button type="button" id="finalSetTimesBtn" onclick="finalSetTimes()" class="btn btn ml-0 mr-auto btn-info" style="margin-top: 10px"> ثبت نهایی تغییرات </button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <div class="modal fade" id="show_tickes" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> افزودن بلیت </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md">
                                <table class="table table-striped text-center" id="">
                                    <thead class="text-primary">
                                    <tr>
                                        <th>
                                            انتخاب
                                        </th>

                                        <th>
                                            ظرفیت
                                        </th>
                                        <th>
                                            نوع بلیت
                                        </th>
                                        <th>
                                            قیمت
                                        </th>
                                       {{-- <th>
                                            حداکثر تخفیف
                                        </th>--}}
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    @foreach($VoucherInfoList as $VoucherInfo)
                                        <tr add_id="{{$VoucherInfo["id"]}}">
                                            <td data-cheack-value="1" class="">
                                                <div  class="form-check">
                                                    <label class="form-check-label">
                                                        <input data_voucherTypeValue="{{$VoucherInfo["voucher_type_id"] . "-" . $VoucherInfo["voucher_type_name"]}}" add_id="{{$VoucherInfo["id"]}}" class="form-check-input ServiseVocher" type="checkbox" value="" >
                                                        <span class="form-check-sign">
                                                    <span class="check"></span>
                                                    </span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td add_id="{{$VoucherInfo["id"]}}" value="{{$VoucherInfo["total_capacity"]}}" class="seance_capacity">
                                                @if($VoucherInfo["total_capacity"] == "")
                                                    نامحدود
                                                @else
                                                    {{$VoucherInfo["total_capacity"]}}
                                                @endif

                                            </td>
                                            <td value="{{$VoucherInfo["voucher_type_id"]}}" data-value="{{$VoucherInfo["voucher_type_id"]}}" vouchersinfo_name="{{$VoucherInfo["voucher_type_name"]}}" class="vouchertyppe_Sanse">
                                                {{$VoucherInfo["voucher_type_name"]}}
                                            </td>

                                            <td value="{{$VoucherInfo["amount"]}}" class="seance_amount">{{$VoucherInfo["amount"]}}</td>
{{--                                            <td value="{{$VoucherInfo["max_discount_percentage"]}}" class="seance_percent">{{$VoucherInfo["max_discount_percentage"]}}</td>--}}
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr class="my-1">
                        <div class="row">
                             <div id="formSans" class="col-lg pull-right">
                                 <div class="form-row text-right">
                                     <div class="col">
                                         <label class="w-100" for=""> نوع بليت
                                         </label>
                                         <select id="vouchers" name="vouchers" class="selectpicker" data-style="btn btn-primary border-dark" title="بلیت">
                                             @foreach($VoucherInfoList as $VoucherType)
                                                 <option value="{{$VoucherType["voucher_type_id"] . "-" . $VoucherType["voucher_type_name"] . "-" . $VoucherType["amount"] . "-" . $VoucherType["total_capacity"] }}">
                                                     {{$VoucherType["voucher_type_name"]}}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>

                                 </div>
                                 <div class="form-row text-right mt-2">
                                     <div class="col text-right">
                                         <label class="w-100" for=""> ظرفيت</label>
                                         <input type="text" id="capacity" name="capacity" class="form-control" placeholder="ظرفيت">
                                     </div>
                                     <div class="col">
                                         <label class="w-100" for=""> قیمت</label>
                                         <input type="text" id="amount" name="amount" class="form-control" placeholder="قیمت">
                                     </div>
                                    {{-- <div class="col">
                                         <label class="w-100" for=""> حداکثر تخفيف</label>
                                         <input type="text" id="max_persent" name="max_persent" class="form-control" placeholder="حداکثر تخفيف">
                                     </div>--}}
                                 </div>
                             </div>
                            <div class="col-12 text-right">
                                <button type="button" onclick="addTicket()" class="btn btn-sm btn-success mt-3 ">اضافه کردن بلیت<div class="ripple-container"></div></button>
                                <button type="button" onclick="removeAllTicket()" class="btn btn-sm btn-danger d-none float-left mt-3">حذف همه بلیت ها</button>
                            </div>
                        </div>
                        <hr class="my-1">
                        <div class="row">
                            <div class="col-md">
                                <div  class="col-lg-12 px-0">
                                    <div id="loader3" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                                        <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                                    </div>
                                    <table class="table table-striped text-center" id="TicketTable">
                                        <thead class="text-primary">
                                        <tr>

                                            <th>
                                                ظرفیت
                                            </th>
                                            <th>
                                               نوع بلیت
                                            </th>
                                            <th>
                                                قیمت
                                            </th>
                                           {{-- <th>
                                                حداکثر تخفیف
                                            </th>--}}
                                            <th>
                                                حذف
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="seances_voucherInfo">

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                        <button data-new="" data-tag="" id="saveVoucher" type="button" onclick="setTime(this)" class="btn btn ml-0 mr-auto btn-success" style="margin-top: 10px"> ثبت بليت </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="sanas" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div id="sansaref" class="modal-dialog" role="document">
            <form method="post" action="{{Route("ImportExportServiceTimes" , ["service_id" => $id ])}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> افزودن سانس مکان  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row text-right">
                            <div class="col-md">
                                <label for=""> استان </label>
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
                            <div class="col-md">
                                <label for=""> شهر </label>
                                <select name="city_id" id="cityList" class="selectpicker"  data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب شهر">
                                    <option value=""> همه </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row text-right">
                            <div class="col-md">
                                <label for=""> مکان </label>
                                <select id="locationList" data-live-search="true" name="locationList" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب نماييد ...">
                                    @foreach($LocationList as $Location)
                                        <option  value="{{$Location["id"]}}"> {{$Location["location_name"]}} </option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md">
                                 <label for=""> سرویس </label>
                                 <select id="ServiceList" data-live-search="true" name="serviceList" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب نماييد ..">
                                     <option selected value="dont_care">  همه </option>
                                 </select>
                             </div>
                        </div>
                        <div class="form-row text-right mt-3">
                            <div class="col-md">
                                <label for=""> تاریخ شروع </label>
                                <input id="FromDate" name="start" type="text" class="form-control text-center " placeholder="تاریخ شروع">


                            </div>
                            <div class="col-md">
                                <label for=""> تاریخ پایان </label>
                                <input id="ToDate" name="end" type="text" class="form-control text-center" placeholder="تاریخ پايان">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                        <button id="exportSanasButton" type="submit" class="btn px-5 btn-success ml-0 mr-auto"> اعمال </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="sanasDay" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div id="sansaref" class="modal-dialog" role="document">
            <form method="post" action="{{Route("ExtendtServiceTimes" , ["service_id" => $id ])}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> تمدید سانس  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row text-right">
                            <div class="col-md-12">
                                <label for=""> مدت تمديد </label>
                                <select id="days_extend" name="days_extend" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب نماييد ...">
                                        <option selected  value="1"> يک روز </option>
                                        <option   value="7"> یک هفته </option>
                                        <option  value="29"> يک ماه - 29 روز </option>
                                        <option  value="30"> يک ماه - 30 روز </option>
                                        <option  value="31"> يک ماه - 31 روز </option>

                                </select>
{{--                                <input id="days_extend" name="days_extend" type="text" class="form-control" placeholder="مثلا 7 روز دیگر">--}}
                            </div>
                        </div>
                        <div class="form-row text-right mt-3">
                            <div class="col-md">
                                <label for=""> تاریخ شروع </label>
                                <input id="FromDate2" name="start" type="text" class="form-control text-center" placeholder="تاریخ شروع">
                            </div>
                            <div class="col-md">
                                <label for=""> تاریخ پایان </label>
                                <input id="ToDate2" name="end" type="text" class="form-control text-center" placeholder="تاریخ پايان">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                        <button id="extendButton" type="submit" class="btn px-5 btn-success ml-0 mr-auto"> اعمال </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('AddJs')

    <script src="{{asset("")}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <div id="scripts">

    </div>
    {{--  for Big calender  --}}
    <script id="sc1" src="{{ asset('assets/js/select_time/persian-date.min.js')}}"></script>
    <script id="sc2" src="{{ asset('assets/js/select_time/persian-datepicker.js')}}"></script>

    <script>
        test();
        function test() {
            $(document).ready(function() {

                $('#FromDate , #FromDate2 ').persianDatepicker({
                    initialValue: true,
                    autoClose : true ,
                    format: 'YYYY-MM-DD',
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
                $('#ToDate , #ToDate2 ').persianDatepicker({
                    initialValue: true,
                    autoClose : true ,
                    format: 'YYYY-MM-DD',
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
            });
        }

        $(function() {
            var active = false ;
            var linkEl ;
            var linkEl1 = $("#s1") ;
            var linkEl2 = $("#s2");
            var linkElsc1 = $("#sc1");
            var linkElsc2 = $("#sc2");
            var heightSans ;
            $(document).on( "click" , ".pwt-btn-next , .pwt-btn-prev"  , function () {
                if(active)
                {
                    $(".seance").hide();
                }
            })

            $("#exportSans , #sanasDayButton").click(function() {
                    active = true ;
                    heightSans = $("#div_seance").height();
                    if(active)

                    $("#div_seance").css("filter" , "blur(5px)");
                    $("#div_seance").animate({opacity: "0.3"} , 300);
                    let localAddress = "{{asset('')}}" + "assets/js/persian-datepicker.min.css" ;
                    linkEl = $("<link id='style1' rel='stylesheet' href='" + localAddress +"'>")
                        .appendTo('head')[0];

                setTimeout(function () {
                    $(".seance").hide();
                    $("#s1").remove();
                    $("#s2").remove();
                    $("#sc1").remove();
                    $("#sc2").remove();
                    $("#plotId").height(heightSans);
                } , 500)


            });
            $('#sanas , #sanasDay').on('hide.bs.modal', function (e) {
                sizeSelected= 0 ;
                showAddButten(sizeSelected)
                deselctAll() ;

                $("#style1").remove();
                $(".seance").show();
                linkEl1.appendTo('head')[0];
                linkEl2.appendTo('head')[0];
                linkElsc1.appendTo('#scripts')[0];
                linkElsc2.appendTo('#scripts')[0];
                active = true;
                $("#div_seance").css("opacity" , "0");
                setTimeout(function () {
                    $("#div_seance").removeAttr('style')
                    $(".table-days").removeAttr('style')
                    $("#div_seance").animate({opacity: "1"} , 300);
                    $("#div_seance").animate({ filter: "0" }, {
                        duration: 1000,
                        complete: function() { $("#div_seance").removeAttr('style') }
                    });
                } , 300)
                active = false ;
            })


        });

    </script>

    <script>
        // export area JS
        $(document).ready(function () {

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

/*
            $('#locationList').change(function () {
                var locationID = $('#locationList').val();
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
                    }
                });
            });*/

            $("#exportSanasButton").click(function (e) {
                let locationList = $("#locationList").val();
                let ServiceList = $("#ServiceList").val();
                // console.log(" locationList  : " , locationList == "")
                // console.log(" ServiceList  : " , ServiceList == "")
                if(locationList == "" || ServiceList == "" )
                {
                    e.preventDefault();
                    Swal.fire(
                        'خطا ! ',
                        'لطفا مکان یا سرویس مورد نظر خود را انتخاب نمایید .',
                        'error'
                    )
                }
            })

            $("#extendButton").click(function (e) {
                let days_extend = $("#days_extend").val();
                console.log(" days_extend  : " , days_extend)
                // console.log(" ServiceList  : " , ServiceList == "")
                if(days_extend == "")
                {
                    e.preventDefault();
                    Swal.fire(
                        'خطا ! ',
                        'لطفا تعداد روز تمديد را وارد نماييد .',
                        'error'
                    )
                }
            })

        });
    </script>

    <script>
        let GetServiceTimeList = @json($GetServiceTimeList) ;
        for (let i = 0; i < GetServiceTimeList.length; i++) {
            let item = GetServiceTimeList[i];
            let day = item['day'];
            // console.log("day" , day);
            let dt = day.split('-').map(Number);
            let y = dt[0];
            let m = dt[1] - 1;
            let d = dt[2];
            item['day'] = new persianDate(new Date(y, m, d)).toLocale('en').format('YYYY-M-D');
        }
        // console.log("GetServiceTimeList : " , GetServiceTimeList)

        let selectedDays = [];
        // console.log("selectedDays" , selectedDays);
        let serviceID = "{{$id}}";
        let locationID = "{{$location_id}}";
        // console.log("serviceID : "  + serviceID + " , locationID :  " + locationID);

        var serviceTimes = [];
        var serviceTimes_new = [];
        if(GetServiceTimeList.length != 0 )
            serviceTimes = GetServiceTimeList;

        /*$("#dismis_sanse").click(function () {
           /!* refreshTimes(function(output){
                serviceTimes = output ;
            });*!/
            $("#finalSetTimesBtn").hide();
        });*/
        $('#test').on('hidden.bs.modal', function (e) {
            serviceTimes_new = [];
            $("#finalSetTimesBtn").hide();
        })

        function refreshTimes(SanseData) {
            let service_id = "{{$id}}" ;
            $("#loader").css("display" , "flex");
            return $.ajax({
                type:'POST',
                url:"{{Route('GetServiceTimeList')}}" ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'service_id' : service_id ,
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

                    }
                },
                success : function (data) {
                    // console.clear();
                    if(data.Header.MessageCode == 0  )
                    {
                        // console.log("Before change ServiceTime  : " , serviceTimes )

                        service_times = data.ContentData ;
                        // console.log("After change ServiceTime  : " , service_times)
                        for (let i = 0; i < service_times.length; i++) {
                            let item = service_times[i];
                            let day = item['day'];
                            // console.log("day" , day);
                            let dt = day.split('-').map(Number);
                            let y = dt[0];
                            let m = dt[1] - 1;
                            let d = dt[2];
                            item['day'] = new persianDate(new Date(y, m, d)).toLocale('en').format('YYYY-M-D');
                        }
                        SanseData(service_times);
                        $("#loader").hide();

                    }
                    else
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            ' دوباره سعی نمایید.',
                            'error'
                        )
                        location.reload();
                    }
                    $("#loader").hide();

                }
            })

            // console.log("sanse : " , sanse);
            // return sanse ;
        }

        $("#expire_date").hide();
        $("#exprieMode").change(function () {
            let value = $(this).val() ;
            console.log(value);
            if(value == "date"){
                $("#expire_date").show();
                $("#expire_time").hide();
                $("#timetype").hide();
            }
            else{
                $("#expire_date").hide();
                $("#expire_time").show();
                $("#timetype").show();
            }
        });
        $("#inline2").persianDatepicker({
            calendar: {
                persian: {
                    enabled: true,
                    locale: 'fa',
                    showHint: false,
                    leapYearMode: "astronomical" // "astronomical"
                },

            },
            altFormat: 'LLLL',
            inline: true,
            viewMode: 'day',
            format: "lll",
            navigator: {
                scroll: {
                    enabled: false
                }
            },

            dayPicker: {
                enabled: true ,
                titleFormat : "MMMM"
            },
            yearPicker: {
                enabled: true
            },
            timePicker: {
                enabled: false,
                meridian: {
                    enabled: true
                }
            },
            toolbox: {
                calendarSwitch: {
                    enabled: false
                }, todayButton: {
                    text: {
                        fa: 'ماه فعلی'
                    }
                }
            },
            navigator: {
                text:{
                    btnNextText:'ماه بعد',
                    btnPrevText:'ماه قبل'
                },
                scroll:{
                    enabled: false
                },

                onNext: function(){
                    setSelected();
                },
                onPrev: function(){
                    setSelected();
                },onSwitch:function (state) {
                    console.log("on switch:"+state);
                }
            },
            monthPicker:{
                onSelect:function (monthIndex) {
                    setSelected();
                }
            }
        });
        $(document).ready(function () {

            setSelected() ;

            $(".ServiseVocher").click(function () {
                let value = $(this).is(":checked");
                let add_id = $(this).attr("add_id");
                if(value){
                    let voucherTypeValue =  $(this).attr("data_voucherTypeValue") ;
                    voucherTypeValue = voucherTypeValue.split("-");
                    let existVoucher = $("#seances_voucherInfo tr td[data-value="+ voucherTypeValue[0] + "]");
                    console.log("existVoucher : " , );
                    if(existVoucher.length > 0 )
                    {
                        if(value)
                            $(this).prop('checked', false);
                        else
                            $(this).prop('checked', true);

                        let message = "بلیت "  + "  <b> ' " + voucherTypeValue[1] + " ' </b>  " + " قبلا اضافه شده است !" ;
                        Swal.fire(
                            ' خطا ',
                            message,
                            'error'
                        )

                        return ;
                    }
                    // when voucher lenght was zero
                    $(".no-voucher").hide();

                    // copy voucher information and add to tabel
                    $(this).parents("tr").clone().appendTo("#seances_voucherInfo");
                    $("#seances_voucherInfo tr[add_id="+ add_id +"] td[data-cheack-value=1]").remove();
                    let tr = $("#seances_voucherInfo tr[add_id="+ add_id +"] ");
                    tr.addClass("ticketRow");
                    let html ='<td><button data-state="notSave" add-id="'+ add_id +'" type="button" class="btn px-2 btn-sm btn-rose text-center" onclick="removeSeance(this)" > <i style="left: 0" class="fa fa-trash"></i> </button> </td>' ;
                    $("#seances_voucherInfo tr[add_id="+ add_id +"]").append(html);
                    setTimeout(function() {
                        tr.addClass("visible");
                    }, 10)
                }
                else
                    {
                        $("#seances_voucherInfo td[add_id="+ add_id +"]").parents("tr").remove();
                        // when voucher not exist
                        let child = $("#seances_voucherInfo tr ") ;
                        if(child.length == 0 )
                            $(".no-voucher").fadeIn();
                    }

            });

        });

        let sizeSelected = 0 ;
        showAddButten(sizeSelected);

        function showAddButten(sizeSelected)
        {
            if(sizeSelected <= 0 )
                $("#addSans").hide();
            else
                $("#addSans").show();
        }

       /* $(document).on("click" , "#addSans" , function () {
            // $("#no-sanse").hide();
            let h = '<td id="no-sanse" class="bg-light" colspan="6"> <h6 class="py-5 text-center"> سانسی وجود ندارد </h6> </td>';
            let child = $("#seances tr ") ;
            if(child.length == 1 ) {
                $("#no-sanse").fadeIn(500);
                $("#seances").html(h);
            }
        })*/

        $(document).on('click', '.dt-deselected', function () {

            $(this).attr('class', 'dt-selected');
            ++sizeSelected;
            showAddButten(sizeSelected)
            let id = $(this).parent().attr("data-date").replace(/,/g, '-');
            $(this).attr('id', id);

            let otherMonth = isOtherMonth($(this));

            if(!otherMonth)
                selectedDays.push(id);
            else{
                // wait for next month to generateGetVoucherText
                setTimeout(function(){
                    setSelected();
                }, 50);
            }
        });

        // for select voucher type
        $(document).on("change" , "#vouchers" , function () {
            let voucherInfo = $("#vouchers").val();
            voucherInfo = voucherInfo.split("-");
            let amount = voucherInfo[2];
            let capacity = voucherInfo[3];

            $("#amount").val(amount);
            $("#capacity").val(capacity);

        });

        $('#test').on('hidden.bs.modal', function () {
            deselctAll()
            $("#seances").html("");
            sizeSelected = 0 ;
            showAddButten(sizeSelected)
        })

        $(document).on('click', '.dt-selected', function () {

            $(this).attr('class', 'dt-deselected');
            --sizeSelected;
            showAddButten(sizeSelected)

            let id =$(this).attr('id');
            let index = selectedDays.indexOf(id);
            if(index != -1)
                selectedDays.splice(index, 1);


        });

        function setSelected(){

            $('.dt-deselected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                // console.log("id : " , id);
                let otherMonth = isOtherMonth($(this));

                if(!otherMonth){
                    if (selectedDays.includes(id)){
                        $(this).attr('class', 'dt-selected');
                        $(this).attr('id', id);
                    }
                    let timesLength = getTimesLength(id);
                    // console.log("timesLength => " , timesLength);

                    if (timesLength !=-1){
                        let html = '<a data-toggle="modal" data-target="#test"  class="px-2 rounded sanseBtn" style="background: #FFEB3B"> سانس ها :  '+ timesLength+'</a>';
                        $(this).find('.seance').html(html);
                    }
                }

            });

            $('.dt-selected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                if (!selectedDays.includes(id)){
                    $(this).attr('class', 'dt-deselected');
                    $(this).removeAttr('id');
                }
                let timesLength = getTimesLength(id);
                if (timesLength !=-1){
                    let html = '<a data-toggle="modal" data-target="#test" class="px-2 rounded sanseBtn" style="background: #FFEB3B"> سانس ها :  '+ timesLength+'</a>';
                    $(this).find('.seance').html(html);
                }
            });
        }
        function reSetSelected(day , num=""){
            let string = "#"+day ;
            if(num == "" )
            {
                $(string).find(".seance").html("");
            }
            else
            {
                $(string).find(".seance a ").html(" سانس ها :  " + num);
            }
        }
        $(document).on("click" , ".sanseBtn" , function () {
            let sansId = $(this).parent().parent().parent().attr("data-date").replace(/,/g, '-');
            // console.log("id ==> " , sansId)
            // console.log("serviceTimes ==> " , serviceTimes)
            let sanas = [] ;
            // refreshTimes();
            // serviceTimes =
            // console.log("serviceTimes : " , serviceTimes)
            let day ;
            for(let i = 0 ; i < serviceTimes.length ; i++){
                if( serviceTimes[i]["day"]== sansId ) {
                    day = serviceTimes[i]["day"] ;
                    sanas.push(serviceTimes[i]) ;
                }
            }
            showSans(sanas , day);
            // console.log("sanas => " , sanas);
        })

        $(document).on("click" , ".settingNew" , function () {
            $("#seances_voucherInfo").html(" ");
            let data_new = $(this).attr("data-new") ;
            $("#saveVoucher").text(" ثبت بلیت ");
            $("#saveVoucher").attr("data-tag" , "create");
            $("#saveVoucher").attr("data-new" , data_new);
            $("#saveVoucher").attr("onclick" , "setTime(this)");
            $(".ServiseVocher").prop('checked', false);

            let dataVoucherInfo = serviceTimes_new ;

            if(dataVoucherInfo.length == 0 )
            {
                let h = "<td data-no='1' class='bg-light no-voucher ' colspan='4'> <h6 class='py-5 text-center'> بلیتی وجود ندارد </h6> </td>";
                $("#seances_voucherInfo").html(h);
            }
            else
            {

                let voucher = [] ;
                for (let j = 0 ; j < dataVoucherInfo.length  ; j++)
                {
                    if(dataVoucherInfo[j].new == data_new )
                    {
                        let voucher_infos = dataVoucherInfo[j].voucher_infos;
                        console.log(" dataVoucherInfo  => " , voucher_infos)
                        voucher.push(voucher_infos) ;
                    }
                }
                if(voucher.length != 0 )
                    showVoucher(voucher[0] , "");
                else
                {
                    let h = "<td data-no='1' class='bg-light no-voucher ' colspan='4'> <h6 class='py-5 text-center'> بلیتی وجود ندارد </h6> </td>";
                    $("#seances_voucherInfo").html(h);
                }

            }

        })

        $(document).on("click" , ".setting" , function () {
            $("#saveVoucher").text(" ثبت تغییرات ");
            $("#saveVoucher").attr("data-tag" , "edit");
            $("#saveVoucher").attr("data-new" , "");
            $(".ServiseVocher").prop('checked', false);
            $("#seances_voucherInfo").html("");
            // $("#saveVoucher").attr("data-id" , "edit");
            let sansId = $(this).attr("data-date").replace(/,/g, '-');
            let start = $(this).attr("data-start");
            let end = $(this).attr("data-end");
            let service_id = $(this).attr("data-service-id")
            $("#saveVoucher").attr("onclick" , "getSansForUpdate("+service_id+")");
            console.log("service_id => " , service_id);
            $("#loader3").css("display", "flex");
            $.ajax({
                type:'POST',
                url:"{{Route('GetServiceTimes')}}" ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'service_id' : service_id ,
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

                    }
                },
                success : function (data) {
                    // console.log("dataVoucherInfo : " , data);
                    let dataVoucherInfo = data[0].voucher_infos ;
                    // console.log(" dataVoucherInfo  1 => " , dataVoucherInfo)
                    if(dataVoucherInfo.length == 0 )
                    {
                        let h = "<td class='bg-light no-voucher ' colspan='4'> <h6 class='py-5 text-center'> بلیتی وجود ندارد </h6> </td>";
                        $("#seances_voucherInfo").html(h);
                    }else
                    {
                        let voucher = [] ;
                        for (let j = 0 ; j < dataVoucherInfo.length  ; j++)
                        {
                            voucher.push(dataVoucherInfo[j]) ;
                        }
                        showVoucher(voucher , service_id);
                    }

                    $("#loader3").hide();
                }
            })

            // let cotactTime = start + end ;
            // console.log("start => ", start)
            // console.log("start => ", end)
            // console.log("id ==> " , sansId)
            // console.log("serviceTimes ==> " , serviceTimes)

            /*for(let i = 0 ; i < serviceTimes.length ; i++){

                if(serviceTimes[i]["day"] == sansId)
                {
                    let times = serviceTimes[i].times ;
                    console.log("times => " , times )
                    for (let j = 0 ; j < times.length  ; j++)
                    {

                        let service_time_contact = times[j]["start"] + times[j]["end"] ;

                        // console.log( " times[j][\"start\"] : " ,  times[j]["start"] );
                        // console.log( " start : " ,  start );
                        console.log("comper =>" , service_time_contact == cotactTime)
                        if( service_time_contact == cotactTime ) {
                            voucher.push(times[j]) ;
                        }
                    }
                }

            }*/



        })

        function showSans(sanas, day) {
            $("#seances").html("");
            let table = document.getElementById("SansaTable").getElementsByTagName('tbody')[0];
            let start_Sanse ;
            let end_Sanse ;
            // let capacity_Sanse ;
            // let vouchertyppe_Sanse ;
            let sex ;
            // let amount_Sanse ;
            let activation ;
            let remove  ;
            let setting  ;

            for(let i = 0 ; i < sanas.length ; i++ ){
                let data = sanas[i].times ;
                let date = sanas[i].day ;

                for(let j = 0 ; j < data.length ; j++ ){
                    let row = table.insertRow();
                    row.setAttribute("SansId", data[j].service_time_id) ;
                    // seance_date = row.insertCell();
                    start_Sanse = row.insertCell();
                    end_Sanse = row.insertCell();
                    // capacity_Sanse = row.insertCell();
                    // vouchertyppe_Sanse = row.insertCell();
                    sex = row.insertCell();
                    // amount_Sanse = row.insertCell();
                    activation = row.insertCell();
                    setting = row.insertCell();
                    remove = row.insertCell();

                    // seance_date.innerHTML = "2020-12-12" ;
                    // seance_date.setAttribute("value", "2020-12-12") ;
                    // seance_date.setAttribute("class", "d-none") ;

                    start_Sanse.innerHTML = data[j].start ;
                    start_Sanse.setAttribute("value", data[j].start) ;
                    start_Sanse.setAttribute("day-value", day) ;
                    start_Sanse.setAttribute("class", "seance_start") ;

                    end_Sanse.innerHTML = data[j].end ;
                    end_Sanse.setAttribute("value", data[j].end) ;
                    end_Sanse.setAttribute("class", "seance_end");

                    // capacity_Sanse.innerHTML = data[j].capacity ;
                    // capacity_Sanse.setAttribute("value", data[j].capacity) ;
                    // capacity_Sanse.setAttribute("class", "seance_capacity") ;
                    //
                    // vouchertyppe_Sanse.innerHTML =  data[j].vouchersInfo_name;
                    // vouchertyppe_Sanse.setAttribute("value",data[j].vouchersInfo ) ;
                    // vouchertyppe_Sanse.setAttribute("vouchersInfo_name", data[j].vouchersInfo_name) ;
                    // vouchertyppe_Sanse.setAttribute("class", "vouchertyppe_Sanse") ;
                    //
                    let gender_val = data[j].sex ;
                    let gender="";

                    if(gender_val === 'male')
                        gender='مردانه';
                    if(gender_val === 'female')
                        gender='زنانه';
                    if(gender_val === 'dont_care')
                        gender='همه';
                    if(gender_val === 'single_sex')
                        gender='تک جنسیتی';

                    sex.innerHTML = gender ;
                    sex.setAttribute("gender_name", gender) ;
                    sex.setAttribute("value", data[j].sex) ;
                    sex.setAttribute("class", "seance_gender") ;

                    // amount_Sanse.innerHTML = data[j].seance_amount ;
                    // amount_Sanse.setAttribute("value", data[j].seance_amount) ;
                    // amount_Sanse.setAttribute("class", "seance_amount") ;

                    let active_shans = data[j].active ;

                    let state_html = ' <div class="togglebutton">' + '<label>' ;

                    if (active_shans)
                        state_html += '<input sans-id="'+ data[j].service_time_id +'"  type="checkbox" name="sanse_id_active" checked="">'  ;
                    else
                        state_html += '<input sans-id="'+ data[j].service_time_id +'"  type="checkbox" name="sanse_id_active">'  ;

                    state_html +=   '<span class="toggle"></span>' + '</label>' + '</div>';

                    activation.innerHTML = state_html ;
                    activation.setAttribute("value", active_shans) ;
                    activation.setAttribute("class", "seance_activation") ;

                    setting.innerHTML = '<button data-tag="load" data-service-id="'+ data[j].service_time_id +'" data-date='+ date +' data-start="'+ data[j].start +'" data-end="'+ data[j].end +'"   type="button" data-toggle="modal" data-target="#show_tickes" class="btn px-2 btn-sm btn-info text-center setting" > <i style="left: 0" class="fa fa-cog"></i> </button>' ;
                    remove.innerHTML = '<button data-deleted="false" add-id="'+ data[j].service_time_id +'" type="button" class="btn px-2 btn-sm btn-rose removeSans text-center" > <i style="left: 0" class="fa fa-trash"></i> </button>' ;
                }
                // console.log("sanas =>" ,


            }
        }

        function showVoucher(voucher , serviceID) {

            $("#seances_voucherInfo").html("");

            let table = document.getElementById("TicketTable").getElementsByTagName('tbody')[0];
            // let start_Sanse ;
            // let end_Sanse ;
            let capacity_Sanse ;
            let vouchertyppe_Sanse ;
            // let sex ;
            let amount_Sanse ;
            let percent ;
            let remove  ;
            // let setting  ;
            let voucherInfos = voucher ;
            console.log("sanas" ,  voucher) ;
            for (let j = 0; j < voucherInfos.length; j++) {
                        console.log("voucher[j] : ", voucherInfos[j]);
                        // console.log("voucher inner  =>  " , voucher[j]) ;
                        let row = table.insertRow();
                        row.setAttribute("class", "ticketRow") ;
                        // seance_date = row.insertCell();
                        // start_Sanse = row.insertCell();
                        // end_Sanse = row.insertCell();
                        capacity_Sanse = row.insertCell();
                        vouchertyppe_Sanse = row.insertCell();
                        // sex = row.insertCell();
                        amount_Sanse = row.insertCell();
                        // percent = row.insertCell();
                        // setting = row.insertCell();
                        remove = row.insertCell();

                        // seance_date.innerHTML = "2020-12-12" ;
                        // seance_date.setAttribute("value", "2020-12-12") ;
                        // seance_date.setAttribute("class", "d-none") ;

                        // start_Sanse.innerHTML = data[j].start ;
                        // start_Sanse.setAttribute("value", data[j].start) ;
                        // start_Sanse.setAttribute("class", "seance_start") ;

                        // end_Sanse.innerHTML = data[j].end ;
                        // end_Sanse.setAttribute("value", data[j].end) ;
                        // end_Sanse.setAttribute("class", "seance_end");

                        let voucher_capacity = (serviceID == "") ? voucherInfos[j].capacity : voucherInfos[j].voucher_capacity ;
                        capacity_Sanse.innerHTML = voucher_capacity;
                        capacity_Sanse.setAttribute("value", voucher_capacity);
                        capacity_Sanse.setAttribute("class", "seance_capacity");
                        //
                        let voucher_type = (serviceID == "") ? voucherInfos[j].vouchersInfo_name : voucherInfos[j].voucher_type ;
                        let voucher_type_id = (serviceID == "") ? voucherInfos[j].vouchersInfo : voucherInfos[j].voucher_type_id ;
                        vouchertyppe_Sanse.innerHTML = voucher_type;
                        vouchertyppe_Sanse.setAttribute("value", voucher_type_id);
                        vouchertyppe_Sanse.setAttribute("data-value", voucher_type_id);
                        vouchertyppe_Sanse.setAttribute("data-service", serviceID);
                        vouchertyppe_Sanse.setAttribute("vouchersInfo_name", voucher_type);
                        vouchertyppe_Sanse.setAttribute("class", "vouchertyppe_Sanse");
                        //
                        // sex.innerHTML = data[j].gender ;
                        // sex.setAttribute("gender_name", data[j].gender) ;
                        // sex.setAttribute("value", data[j].gender_value) ;
                        // sex.setAttribute("class", "seance_gender") ;
                        let amount_without_discount = (serviceID == "") ? voucherInfos[j].seance_amount : voucherInfos[j].amount_without_discount ;
                        amount_Sanse.innerHTML = amount_without_discount;
                        amount_Sanse.setAttribute("value", amount_without_discount);
                        amount_Sanse.setAttribute("class", "seance_amount");
                        /*let off = voucherInfos[j].amount_without_discount - voucherInfos[j].amount ;
                        off = off / voucherInfos[j].amount_without_discount ;
                        off =  Math.round(off * 100) ;
                        */
                        // let off = " - " ;
                       /* percent.innerHTML = off ;
                        percent.setAttribute("value", off);
                        percent.setAttribute("class", "seance_percent");*/
                        // setting.innerHTML = '<button data-date='+ date +' type="button" data-toggle="modal" data-target="#show_tickes" class="btn px-2 btn-sm btn-info text-center" > <i style="left: 0" class="fa fa-cog"></i> </button>' ;
                        if((serviceID == ""))
                            remove.innerHTML = '<button data-deleted="false" type="button" class="btn btn-remove-voucher px-2 btn-sm btn-rose text-center" onclick="removeSeance(this)" > <i style="left: 0" class="fa fa-trash"></i> </button>';
                        else
                            remove.innerHTML = '<button data-deleted="false" type="button" class="btn btn-remove-voucher px-2 btn-sm btn-rose text-center" onclick="removeVoucher(this)" > <i style="left: 0" class="fa fa-trash"></i> </button>';

                        setTimeout(function() {
                            row.classList.add('visible');
                        }, 10)
                    }

            }

        function setTime(e) {

            // return ;


            let newNumber = $(e).attr("data-new")
            let seances = getThisSeances(newNumber);
            // let seances = getAllSeances();
            // console.log("sanse => " , seances);
            if(seances.length == 0 )
            {
                Swal.fire(
                    ' خطا ',
                    ' بليتي براي اين سانس اضافه نشده است! ',
                    'error'
                )
                return ;
            }
            removeSanseIfExists(newNumber)
            serviceTimes_new.push(seances[0]);
            // console.log("serviceTimes_new => " , serviceTimes_new)
            // $('#test').modal('hide')
            $("#loader3").css("display", "flex") ;
            setTimeout(function () {
                $("#loader3").hide();
            }, 500)
        }
        /*$(document).on("click" , "#addSans" , function () {
            for(let i=0; i<selectedDays.length; i++){
                let day = selectedDays[i];
                    console.log("day Selected : " , day )
            }
        });*/
        function finalSetTimes() {
            let newSans = $("#seances tr[new]") ;
            if(serviceTimes_new.length == 0 )
            {
                Swal.fire(
                    ' خطا ',
                    " سانس های جدید ایجاد شده فاقد بلیت می باشند !  ",
                    'error'
                )
                return;
            }
            else {
                let news_id = [];
                let serviceTimes_new_id = [];
                $("#seances tr[new]").each(function(){
                    news_id.push($(this).attr("new"))
                });
                news_id = news_id.sort(function(a, b){return a - b});
                console.log("news_id : " , news_id)
                for(let i = 0 ; i < serviceTimes_new.length ; i++)
                {
                    serviceTimes_new_id.push(serviceTimes_new[i].new)
                }
                serviceTimes_new_id = serviceTimes_new_id.sort(function(a, b){return a - b});
                console.log("serviceTimes_new_id : " , serviceTimes_new_id)

                if(JSON.stringify(news_id) !=JSON.stringify(serviceTimes_new_id))
                {
                    Swal.fire(
                        ' خطا ',
                        " سانس های جدید ایجاد شده فاقد بلیت می باشند !  ",
                        'error'
                    )
                    return;
                }


            }
            serviceTimes = [];
            seances = serviceTimes_new

            for(let i=0; i<selectedDays.length; i++){
                let day = selectedDays[i];
                removeDayIfExists(day);
                serviceTimes.push({'day':day,'times':seances})
            }

            // serviceTimes_new.push(serviceTimes)
            // console.log("serviceTimes => " , serviceTimes)
            // return;
            $("#loader1").css("display", "flex") ;


            selectedDays = [];
            sizeSelected = 0 ;
            showAddButten(sizeSelected)
            setSelected();
            // removeAllSeance();
            // removeAllTicket();
            resetTime();
            submit() ;
        }

        function setTimeFirst() {

            console.log("selectedDays => " , selectedDays)
            sizeSelected = 0 ;
            showAddButten(sizeSelected)
            setSelected();
            removeAllSeance();
            removeAllTicket();
            resetTime();
            // submit() ;
        }
        function setVoucher() {
            let seances = getAllSeances();
            console.log("sanse => " , seances);
            if(seances.length == 0 )
            {
                Swal.fire(
                    ' خطا ',
                    ' سانسی اضافه نشده است! ',
                    'error'
                )
                return ;
            }
            // $('.modal').modal('hide')

            for(let i=0; i<selectedDays.length; i++){
                let day = selectedDays[i];
                removeDayIfExists(day);
                serviceTimes.push({'day':day,'times':seances})
            }
            console.log("selectedDays => " , selectedDays)
            selectedDays = [];
            sizeSelected = 0 ;
            showAddButten(sizeSelected)
            setSelected();
            removeAllSeance();
            resetTime();
        }
        function removeTime() {
            $('.dt-selected').each(function (event) {
                sizeSelected = 0 ;
                showAddButten(sizeSelected)
                $(this).find('.seance').text('');
                $(this).find('.seance').removeAttr('val');
                $(this).css("background-color", "");
                $(this).attr('class', 'dt-deselected');
                $(this).parent().attr('dt-active', 'false');
            });
        }
        function selectAll() {

            $('.dt-deselected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                ++sizeSelected ;
                showAddButten(sizeSelected)
                if (!selectedDays.includes(id)){

                    let otherMonth = isOtherMonth($(this));

                    if(!otherMonth)
                        selectedDays.push(id);
                }
            });

            setSelected();

        }

        function deselctAll() {
            $('.dt-selected').each(function() {
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                sizeSelected = 0 ;
                showAddButten(sizeSelected);
                let index = selectedDays.indexOf(id);
                if (index != -1)
                    selectedDays.splice(index, 1);
            });
            setSelected();
        }
        function getTimes() {
            deselctAll();
            removeAllSeance();

            let times = [];
            for (let i=0;i<serviceTimes.length;i++){
                let object = serviceTimes[i];
                let day = object.day;
                let seances = object.times;
                times.push({'day': new persianDate(day.split('-').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD'), 'times': seances});
            }

            return times;
        }
        function isOtherMonth(elemnt) {
            let otherMonth = false;
            $(elemnt).children('span').each(function () {
                if($(this).hasClass('other-month'))
                    otherMonth = true;

            });
            return otherMonth;
        }
        function changeMin(id, type) {

            let element = document.getElementById(id);
            let current = parseInt(element.value);
            if (type == 'add' && current < 55) {
                element.value = current + 5;
            } else if (type == 'minus' && current > 0) {
                element.value = current - 5;
            }

        }
        function changeHour(id, type) {

            let element = document.getElementById(id);
            let current = parseInt(element.value);
            if (type == 'add' && current < 23) {
                element.value = current + 1;
            } else if (type == 'minus' && current > 0) {
                element.value = current - 1;
            }

        }

        {{--let VoucherList = @json($VoucherList) ;--}}
        var x = 1 ;
        $("#finalSetTimesBtn").hide();
        function addSeance() {

            /*if($("#vouchers").val() == ""){
                console.log("OK !!")
                return ;
            }*/

            let NotValid = false;
            let FistTime = eval($("#start_hour").val()) * 100 + eval($("#start_minute").val());
            let EndTime = eval($("#end_hour").val())  * 100 + eval( $("#end_minute").val());
            // console.log("EndTime => " , EndTime )
            // console.log("FistTime => " , FistTime )
            if (FistTime > EndTime){
                NotValid = true;
                Swal.fire(
                    ' خطا ',
                    'زمان پایان باید بیشتر از زمان شروع باشد . ',
                    'error'
                )
            }

            if(NotValid)
                return;

            $("#finalSetTimesBtn").fadeIn();
            let start = $('#start_hour').val() + ":" + $('#start_minute').val();
            let end = $('#end_hour').val() + ":" + $('#end_minute').val();
            let gender_val = $("select[name='seance_gender']").val();
            // let voucherType = $("#vouchers").val();
            // let capacity = $("#capacity").val();
            // let amount = $("#amount").val();
            // let max_persent = $("#max_persent").val();


            let gender="";

            if(gender_val === 'male')
                gender='مردانه';
            if(gender_val === 'female')
                gender='زنانه';
            if(gender_val === 'dont_care')
                gender='همه';
            if(gender_val === 'single_sex')
                gender='تک جنسیتی';

            let filteredArray = [];
            // let voucherType_val = voucherType.split("-") ;
           /* for(let  i = 0 ; i < VoucherList.length ; i++){
               for  ( let j = 0 ; j < voucherType.length ; j++) {
                   if (VoucherList[i].VoucherInfo_id == voucherType[j]){
                       filteredArray.push(VoucherList[i]);
                       if (filteredArray.length != 1 ) {
                           capacity_val += "<br> " ;
                       }
                       capacity_val += VoucherList[i].voucher_type_name  ;


                   }
               }
            }*/
            let table = document.getElementById("SansaTable").getElementsByTagName('tbody')[0];

            let start_Sanse ;
            let end_Sanse ;
            // let capacity_Sanse ;
            // let vouchertyppe_Sanse ;
            let sex ;
            // let amount_Sanse ;
            let activation ;
            let remove  ;
            let setting  ;

            let row = table.insertRow();
            row.setAttribute("new", x ) ;
            // seance_date = row.insertCell();
            start_Sanse = row.insertCell();
            end_Sanse = row.insertCell();
            // capacity_Sanse = row.insertCell();
            // vouchertyppe_Sanse = row.insertCell();
            sex = row.insertCell();
            // amount_Sanse = row.insertCell();
            activation = row.insertCell();
            setting = row.insertCell();
            remove = row.insertCell();

            // seance_date.innerHTML = "2020-12-12" ;
            // seance_date.setAttribute("value", "2020-12-12") ;
            // seance_date.setAttribute("class", "d-none") ;

            start_Sanse.innerHTML = start ;
            start_Sanse.setAttribute("value", start) ;
            start_Sanse.setAttribute("class", "seance_start") ;

            end_Sanse.innerHTML = end ;
            end_Sanse.setAttribute("value", end) ;
            end_Sanse.setAttribute("class", "seance_end");

            /*capacity_Sanse.innerHTML = capacity ;
            capacity_Sanse.setAttribute("value", capacity) ;
            capacity_Sanse.setAttribute("class", "seance_capacity") ;

            vouchertyppe_Sanse.innerHTML = voucherType_val[1] ;
            vouchertyppe_Sanse.setAttribute("value", voucherType_val[0]) ;
            vouchertyppe_Sanse.setAttribute("vouchersInfo_name", voucherType_val[1]) ;
            vouchertyppe_Sanse.setAttribute("class", "vouchertyppe_Sanse") ;*/

            sex.innerHTML = gender ;
            sex.setAttribute("gender_name", gender) ;
            sex.setAttribute("value", gender_val) ;
            sex.setAttribute("class", "seance_gender") ;

           /*
           amount_Sanse.innerHTML = amount ;
            amount_Sanse.setAttribute("value", amount) ;
            amount_Sanse.setAttribute("class", "seance_amount") ;
            */

            let state_html = ' <div class="togglebutton">' + '<label style="filter: grayscale(1);opacity: 0.4;" >' ;
            state_html += '<input  disabled type="checkbox" name="sanse_id_active" checked="">'  ;
            state_html +=   '<span class="toggle"></span>' + '</label>' + '</div>';
            activation.innerHTML = state_html ;

            setting.innerHTML = '<button data-new="'+ x +'"  data-tag="create" type="button" data-toggle="modal" data-target="#show_tickes" class="btn px-2 btn-sm btn-info text-center settingNew" > <i style="left: 0" class="fa fa-cog"></i> </button>' ;
            remove.innerHTML = '<button data-new="'+ x +'" type="button" class="btn px-2 btn-sm btn-rose text-center" onclick="removeSeance(this)" > <i style="left: 0" class="fa fa-trash"></i> </button>' ;
            x++

        }

        // for sans time Activiton
        $(document).ready(function () {
            $(document).on("click" , "input[name=sanse_id_active]" , function () {
                let value = $(this).is(':checked');
                let service_time_id = $(this).attr("sans-id") ;

                Swal.fire({
                    title: ' از تغییر ایجاد شده مطمئن هستید ؟ ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7bc127',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله' ,
                    cancelButtonText: 'خیر' ,
                }).then((result) => {
                    $('#loader1').css('display' , 'flex');
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            url:"{{Route('ServiceTimeActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'service_time_id' : service_time_id ,
                                'activation' : value ,
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

                                }
                            },
                            success:function(data) {
                                $('#loader1').hide();
                                if(data.Header.MessageCode == 0)
                                {
                                    Swal.fire(
                                        'تغییرات با موفقیت اعمال گردید .',
                                        "" ,
                                        'success' ,
                                    )
                                    refreshTimes(function(output){
                                        serviceTimes = output ;
                                    });
                                    // refreshTimes();
                                }
                                else if (data.Header.MessageCode == 133)
                                {
                                    if(value)
                                        $(this).prop( "checked", false );
                                    else
                                        $(this).prop( "checked", true );

                                    Swal.fire(
                                        'شما مجاز به انجام چنین عملیاتی نیستید .',
                                        "" ,
                                        'warning' ,
                                    )
                                }
                                else {

                                    if(value)
                                        $(this).prop( "checked", false );
                                    else
                                        $(this).prop( "checked", true );

                                    Swal.fire(
                                        'خطا در اعمال تفییرات .',
                                        "" ,
                                        'error' ,
                                    )
                                }

                            }
                        });
                    }
                    else
                        {
                            if(value)
                                $(this).prop( "checked", false );
                            else
                                $(this).prop( "checked", true );
                            $('#loader1').hide();
                        }

                })
            })
        });
        // ----------------------------

        function addTicket() {

            let NotValid = false;
            $("#formSans input , #formSans select ").each(function() {
                var element = $(this);

                if (element.val() == "" && element.attr("id") != "max_persent") {

                    Swal.fire(
                        ' خطا ',
                        '  لطفا فيلد هاي مشخص شده را پر نماييد ! ',
                        'error'
                    )
                    element.parent().prev().css("color", "red");
                    element.addClass("border-danger");
                    NotValid = true;
                } else {
                    element.parent().prev().css("color", "");
                    element.removeClass("border-danger");
                }
            });
            let FistTime = eval($("#start_hour").val()) * 100 + eval($("#start_minute").val());
            let EndTime = eval($("#end_hour").val())  * 100 + eval( $("#end_minute").val());
            // console.log("EndTime => " , EndTime )
            // console.log("FistTime => " , FistTime )
            if (FistTime > EndTime){
                NotValid = true;
                Swal.fire(
                    ' خطا ',
                    'زمان پایان باید بیشتر از زمان شروع باشد . ',
                    'error'
                )
            }

            let voucherTypeValue = $("#vouchers").val()
            voucherTypeValue = voucherTypeValue.split("-");
            voucherTypeName =  voucherTypeValue[1];
            voucherTypeValue = voucherTypeValue[0];
            console.log("voucherTypeValue : " , voucherTypeValue);
            let existVoucher = $("#seances_voucherInfo tr td[data-value="+ voucherTypeValue + "]");
            console.log("existVoucher : " , );
            if(existVoucher.length > 0 )
            {
                let message = "بلیت "  + "  <b> ' " + voucherTypeName + " ' </b>  " + " قبلا اضافه شده است !" ;
                Swal.fire(
                    ' خطا ',
                    message,
                    'error'
                )
                NotValid = true;
            }

            if(NotValid)
                return;

            // when voucher lenght was zero
            $(".no-voucher").hide();

            // let start = $('#start_hour').val() + ":" + $('#start_minute').val();
            // let end = $('#end_hour').val() + ":" + $('#end_minute').val();
            // let gender_val = $("select[name='seance_gender']").val();
            let voucherType = $("#vouchers").val();
            let capacity = $("#capacity").val();
            let amount = $("#amount").val();
            // let max_persent = $("#max_persent").val();


            let filteredArray = [];
            let voucherType_val = voucherType.split("-") ;
            let table = document.getElementById("TicketTable").getElementsByTagName('tbody')[0];

            // let start_Sanse ;
            // let end_Sanse ;
            let capacity_Sanse ;
            let vouchertyppe_Sanse ;
            // let sex ;
            let amount_Sanse ;
            // let percent ;
            let remove  ;
            // let setting  ;

            let row = table.insertRow();
            row.setAttribute("class", "ticketRow") ;

            // seance_date = row.insertCell();
            // start_Sanse = row.insertCell();
            // end_Sanse = row.insertCell();
            capacity_Sanse = row.insertCell();
            vouchertyppe_Sanse = row.insertCell();
            // sex = row.insertCell();
            amount_Sanse = row.insertCell();
            // percent = row.insertCell();
            // setting = row.insertCell();
            remove = row.insertCell();

            // seance_date.innerHTML = "2020-12-12" ;
            // seance_date.setAttribute("value", "2020-12-12") ;
            // seance_date.setAttribute("class", "d-none") ;

            // start_Sanse.innerHTML = start ;
            // start_Sanse.setAttribute("value", start) ;
            // start_Sanse.setAttribute("class", "seance_start") ;
            //
            // end_Sanse.innerHTML = end ;
            // end_Sanse.setAttribute("value", end) ;
            // end_Sanse.setAttribute("class", "seance_end");
            //
            capacity_Sanse.innerHTML = capacity ;
            capacity_Sanse.setAttribute("value", capacity) ;
            capacity_Sanse.setAttribute("class", "seance_capacity") ;

            vouchertyppe_Sanse.innerHTML = voucherType_val[1] ;
            vouchertyppe_Sanse.setAttribute("value", voucherType_val[0]) ;
            vouchertyppe_Sanse.setAttribute("data-value", voucherType_val[0]) ;
            vouchertyppe_Sanse.setAttribute("vouchersInfo_name", voucherType_val[1]) ;
            vouchertyppe_Sanse.setAttribute("class", "vouchertyppe_Sanse") ;

            // sex.innerHTML = gender ;
            // sex.setAttribute("gender_name", gender) ;
            // sex.setAttribute("value", gender_val) ;
            // sex.setAttribute("class", "seance_gender") ;

             amount_Sanse.innerHTML = amount ;
             amount_Sanse.setAttribute("value", amount) ;
             amount_Sanse.setAttribute("class", "seance_amount") ;

             // percent.innerHTML = max_persent ;
             // percent.setAttribute("value", max_persent) ;
             // percent.setAttribute("class", "seance_percent") ;
            // setting.innerHTML = '<button type="button" data-toggle="modal" data-target="#show_tickes" class="btn px-2 btn-sm btn-info text-center" onclick="removeSeance(this)" > <i style="left: 0" class="fa fa-cog"></i> </button>' ;
            remove.innerHTML = '<button data-state="notSave" type="button" class="btn px-2 btn-sm btn-rose text-center" onclick="removeSeance(this)" > <i style="left: 0" class="fa fa-trash"></i> </button>' ;

            setTimeout(function() {
                row.classList.add('visible');
            }, 10)
        }
        function resetTime() {
            $('#start_hour').val("8");
            $('#start_minute').val("0");
            $('#end_hour').val("9");
            $('#end_minute').val("0");
            $('#capacity').val("");
            $('#amount').val("");
            // $('#max_persent').val("");
            $('#seance_gender').find("option").attr("selected" , false);
            $('#seance_gender').selectpicker('refresh');
        }

        function removeSeance(element) {

            let el = $(element).parent().parent();
            let add_id =  $(element).attr("add-id") ;
            let newValue =  $(element).attr("data-new") ;
            removeSanseIfExists(newValue)

            $(".ServiseVocher[add_id="+ add_id +"]").prop('checked', false);
            el.animate({opacity: '0'}, 10, function () {
                el.animate({width: '0'}, 10, function () {
                    el.remove();
                });
            });

            let newLength = $("#seances tr[new]") ;
            newLength = newLength.length ;
            if(newLength == 1)
            {
                $("#finalSetTimesBtn").fadeOut();
            }


                // when voucher not exist
            let child = $("#seances_voucherInfo tr ") ;
            if(child.length == 1 )
                $(".no-voucher").fadeIn(500);

        }

        function removeVoucher(element) {
            let el = $(element).parent().parent();

            let add_id =  $(element).attr("add-id") ;
            $(".ServiseVocher[add_id="+ add_id +"]").prop('checked', false);
            let  deleted = $(element).attr("data-deleted") ;

            // console.log("deleted : " , deleted)
            if(deleted  == "true")
            {
                $(element).attr("data-deleted" , false) ;
                el.css({
                    "filter": "grayscale(0)" ,
                    "opacity": "1" ,
                })
            }
            else
            {
                let deleteSize = $("#seances_voucherInfo button[data-deleted=false] , #seances_voucherInfo button[data-state=notSave] ") ;
                console.log("delete size : ", deleteSize.length )
                if(deleteSize.length > 1)
                {
                    $(element).attr("data-deleted" , true) ;
                    el.css({
                        "filter": "grayscale(1)" ,
                        "opacity": "0.5" ,
                    })
                }
                else
                {
                    Swal.fire(
                        ' خطا ',
                        " امکان حذف تمامی بلیت های موجود ندارد !  ",
                        'error'
                    )
                }


            }

        }

        $(document).ready(function () {

            $(document).on('click', ".removeSans" ,  function (e) {
                let el = $(this) ;
                $("#loader").css("display" , "flex")
                $("#loader").css("zIndex" , "90000000")
                let service_time_id = $(this).attr("add-id") ;
                console.log("service_time_id : " , service_time_id)
                $.ajax({
                    type:'POST',
                    url:"{{Route('DeleteServiceTime')}}" ,
                    dataType:'json',
                    data:{
                        '_token' : '<?php echo csrf_token() ?>',
                        'service_time_id' : service_time_id ,
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

                        }
                    },
                    success : function (data) {
                        $("#loader").hide();
                        console.log("data : " , data);
                        if(data.Header.MessageCode == 0  )
                        {
                            Swal.fire(
                                'عملیات با موفقیت انجام گردید . ',
                                '',
                                'success'
                            )
                            refreshTimes(function(output){
                                serviceTimes = output ;
                            });
                            let seancesSize = $("#seances tr").first();
                            if(seancesSize.length == 1 )
                            {
                                let day = "" ;
                                $('#seances tr td').each(function () {
                                    if($(this).attr("class") == "seance_start" ){
                                        day = $(this).attr("day-value");
                                    }
                                });
                                reSetSelected(day)
                            }
                            removeSeance(el);
                        }
                        else if (data.Header.MessageCode == 13) {
                            Swal.fire(
                                'خطا در انجام عملیات ! ',
                                '  اطلاعات وارد شده نامعتبر مي باشد ',
                                'error'
                            )
                        }
                        else if (data.Header.MessageCode == 182) {
                            Swal.fire(
                                'خطا در انجام عملیات ! ',
                                '  این بلیت خریداری شده و قابل جذف یا ویرایش نیست ',
                                'error'
                            )
                        }
                        else if (data.Header.MessageCode == 133) {
                            Swal.fire(
                                'خطا در انجام عملیات ! ',
                                '  شما مجاز به انجام اين عمليات مي باشيد. ',
                                'warning'
                            )
                        }
                        else
                        {
                            Swal.fire(
                                'خطا در انجام عملیات ! ',
                                ' دوباره سعی نمایید.',
                                'error'
                            )
                        }

                    }
                })
            });

        })

        function removeAllSeance() {
            $('#seances').children().each(function () {
                $(this).remove();
            });
        }
        function removeAllTicket() {
            $('#seances_voucherInfo').children().each(function () {
                $(this).remove();
            });
        }
        function removeDayIfExists(day){

            for(let i=0;i<serviceTimes.length;i++){
                let obj = serviceTimes[i];
                if (obj.day == day)
                    serviceTimes.splice(i, 1);
            }
        }
        function removeSanseIfExists(num){
            console.log("removeSanseIfExists : " , serviceTimes_new.length)
            for(let i=0;i<serviceTimes_new.length;i++){
                let obj = serviceTimes_new[i];

                if (obj.new == num)
                    serviceTimes_new.splice(i, 1);
            }
        }
        function getTimesLength(day){

            for(let i=0;i<serviceTimes.length;i++){
                let obj = serviceTimes[i];
                if (obj.day == day)
                    return obj.times.length;
            }
            return -1;
        }
        function getAllSeances() {

            let times = [];
            let vouchers = [];
            $('#seances_voucherInfo').children().each(function () {

                // let Date =  $(this).find('.seance_date').attr("value") ;
                let capacity = $(this).find('.seance_capacity').attr("value");
                let vouchertyppe_Sanse = $(this).find('.vouchertyppe_Sanse').attr("value");
                let vouchersInfo_id = $(this).find('.vouchertyppe_Sanse').attr("vouchersInfo_name");
                let seance_amount = $(this).find('.seance_amount').attr("value");
                // let seance_percent = $(this).find('.seance_percent').attr("value");
                let seance_percent = "";

                vouchers.push({
                    'capacity': capacity,
                    'vouchersInfo': vouchertyppe_Sanse,
                    'vouchersInfo_name': vouchersInfo_id,
                    'remain':capacity,
                    'seance_amount': seance_amount,
                    'seance_percent': seance_percent,
                });

            });
            if(vouchers.length == 0 )
            {
                return times ;
            }
            $('#seances tr:not([sansid])').each(function () {

                // let Date =  $(this).find('.seance_date').attr("value") ;
                let start = $(this).find('.seance_start').attr("value");
                let end = $(this).find('.seance_end').attr("value");
                // let capacity = $(this).find('.seance_capacity').attr("value");
                // let vouchertyppe_Sanse = $(this).find('.vouchertyppe_Sanse').attr("value");
                // let vouchersInfo_id = $(this).find('.vouchertyppe_Sanse').attr("vouchersInfo_name");

                let gender = $(this).find('.seance_gender').attr("gender_name");
                let gender_value = $(this).find('.seance_gender').attr("value");
                // let seance_amount = $(this).find('.seance_amount').attr("value");
                // let seance_percent = $(this).find('.seance_percent').attr("value");

                times.push({'start': start,
                    'end': end,
                    'sex':gender_value ,
                    'gender': gender ,
                    "voucher_infos" : vouchers ,
                });

            });
            // console.log(times);
            return times;
        }
        function getThisSeances(num) {

            let times = [];
            let vouchers = [];
            $('#seances_voucherInfo tr').each(function () {

                // let Date =  $(this).find('.seance_date').attr("value") ;
                let capacity = $(this).find('.seance_capacity').attr("value");
                let vouchertyppe_Sanse = $(this).find('.vouchertyppe_Sanse').attr("value");
                let vouchersInfo_id = $(this).find('.vouchertyppe_Sanse').attr("vouchersInfo_name");
                let seance_amount = $(this).find('.seance_amount').attr("value");
                // let seance_percent = $(this).find('.seance_percent').attr("value");
                let seance_percent = "";

                vouchers.push({
                    'capacity': capacity,
                    'vouchersInfo': vouchertyppe_Sanse,
                    'vouchersInfo_name': vouchersInfo_id,
                    'remain':capacity,
                    'seance_amount': seance_amount,
                    'seance_percent': seance_percent,
                });

            });
            if(vouchers.length == 0 )
            {
                return times ;
            }
            $('#seances tr:not([sansid])').each(function () {

                if($(this).attr("new") == num)
                {

                // let Date =  $(this).find('.seance_date').attr("value") ;
                let start = $(this).find('.seance_start').attr("value");
                let end = $(this).find('.seance_end').attr("value");
                // let capacity = $(this).find('.seance_capacity').attr("value");
                // let vouchertyppe_Sanse = $(this).find('.vouchertyppe_Sanse').attr("value");
                // let vouchersInfo_id = $(this).find('.vouchertyppe_Sanse').attr("vouchersInfo_name");

                let gender = $(this).find('.seance_gender').attr("gender_name");
                let gender_value = $(this).find('.seance_gender').attr("value");
                // let seance_amount = $(this).find('.seance_amount').attr("value");
                // let seance_percent = $(this).find('.seance_percent').attr("value");

                times.push({'start': start,
                    'new': num,
                    'end': end,
                    'sex':gender_value ,
                    'gender': gender ,
                    "voucher_infos" : vouchers ,
                });

                }

            });
            // console.log(times);
            return times;
        }
        function getSansForUpdate(sansId) {

            let checkSansExist = $("#seances_voucherInfo button[data-deleted=false] , #seances_voucherInfo button[data-state=notSave] ") ;
            if (checkSansExist.length <= 0) {
                Swal.fire(
                    ' خطا ',
                    " امکان حذف تمامی بلیت های موجود ندارد !  ",
                    'error'
                )
                return ;
            }

            let times = [];
            let vouchers = [];
            $('#seances_voucherInfo').children().each(function () {
                // let Date =  $(this).find('.seance_date').attr("value") ;
                let capacity = $(this).find('.seance_capacity').attr("value");
                let vouchertyppe_Sanse = $(this).find('.vouchertyppe_Sanse').attr("value");
                let vouchersInfo_id = $(this).find('.vouchertyppe_Sanse').attr("vouchersInfo_name");
                let seance_amount = $(this).find('.seance_amount').attr("value");
                let deleted = $(this).find('.btn-remove-voucher').attr("data-deleted");
                console.log("deleted : " , deleted)
                let seance_percent = "";
                vouchers.push({
                    'capacity': capacity,
                    'vouchersInfo': vouchertyppe_Sanse,
                    'vouchersInfo_name': vouchersInfo_id,
                    'remain':capacity,
                    'seance_amount': seance_amount,
                    'deleted': deleted,
                    'seance_percent': seance_percent,
                });


            });
            console.log("vouchers list :  " , vouchers)
            if(vouchers.length == 0 )
            {
                Swal.fire(
                    'خطا ! ',
                    ' لطغا بليتي را جهت ثبت انتخاب يا ايجاد نماييد .',
                    'error'
                )
                return ;
            }

            let start , end  , gender , gender_value , day;
            $('#seances tr[SansId='+ sansId +'] td').each(function () {
                console.log( "this seances : " , $(this).attr("value") );
                // let Date =  $(this).find('.seance_date').attr("value") ;
                if($(this).attr("class") == "seance_start" ){
                    day = $(this).attr("day-value");

                    let dt = day.split('-').map(Number);
                    let y = dt[0];
                    let m = dt[1];
                    let d = dt[2];
                    day = new persianDate([eval(y) , eval(m),eval(d)]).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD') ;
                    start = $(this).attr("value");
                }

                else if($(this).attr("class") == "seance_end" )
                    end = $(this).attr("value");

                else if($(this).attr("class") == "seance_gender" )
                {
                    gender = $(this).attr("gender_name");
                    gender_value = $(this).attr("value");
                }
            });

            times.push({
                'service_time_id': sansId,
                'start': day + " " + start,
                'end':  day + " " + end,
                'sex':gender_value ,
                'gender':gender ,
                "voucher_infos" : vouchers ,
            });
            $("#loader3").css("display" , "flex");
            console.log("times : " , times);
            $.ajax({
                type:'POST',
                url:"{{Route('EditServiceTime')}}" ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'times' : times ,
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

                    }
                },
                success : function (data) {
                    $("#loader3").hide();
                    console.log("data : " , data)

                    if(data.Header.MessageCode == 0  )
                    {
                        // for remove items that must be deleted
                        let elm = $('#seances_voucherInfo button[data-deleted=true]') ;
                        elm.parent().parent().remove() ;
                        elm = $('#seances_voucherInfo button[data-state="notSave"]') ;
                        elm.attr("onclick" , "removeVoucher(this)");
                        elm.attr("data-deleted" , "false");
                        elm.addClass("btn-remove-voucher");
                        $(".ServiseVocher").prop('checked', false);

                        Swal.fire(
                            'عملیات با موفقیت انجام گردید . ',
                            '',
                            'success'
                        )
                    }
                    else if (data.Header.MessageCode == 158  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'ویرایش در این تاریخ انتخابی امکان پذیر نیست ! ',
                            'warning'
                        )
                    }
                    else if (data.Header.MessageCode == 165  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'سرویس وارد شده نا معتبر می باشد  ',
                            'error'
                        )
                    }
                    else if (data.Header.MessageCode == 120  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'بليت هاي انتخابي موجود مي باشد   ',
                            'error'
                        )
                    }
                    else if (data.Header.MessageCode == 19  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'موردي يافت نشد   ',
                            'error'
                        )
                    }
                    else if (data.Header.MessageCode == 32  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'لطفا بليتي را انتخاب نماييد  ',
                            'warning'
                        )
                    }
                    else if (data.Header.MessageCode == 133  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'شما محاز به انجام اين عمليات نيستيد !  ',
                            'warning'
                        )
                    }
                    else if (data.Header.MessageCode == 166  )
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            'بلیت های انتخابی با بلیت های موجود در سیستم هم پوشانی دارند !  ',
                            'warning'
                        )
                    }
                    else
                    {
                        Swal.fire(
                            'خطا در انجام عملیات ! ',
                            ' دوباره سعی نمایید.',
                            'error'
                        )
                    }

                }
            })
            return times;
        }


        function submit() {

            var x = document.getElementById("service_times").value = JSON.stringify(getTimes());
            // console.log(x);
            document.getElementById("form").submit();

        }

    </script>

    <script>



        function setCurrentTimes() {

            let service_times = JSON.$(".ServiseVocher").parse(document.getElementById("service_times").value.replace(/'/g,'"'));
            console.log(service_times);
            service_times.forEach(element => {
                let day = element.day;
                let times = element.times;

                $('.dt-deselected').each(function (event) {
                    let dt =  new persianDate($(this).parent().attr('data-date').split(',').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD');
                    if(day === dt){
                        // console.log(  $(this).parent().attr('data-date'));
                        // console.log(dt);
                        $(this).find('.seance').attr('val',JSON.stringify(times));
                        $(this).parent().attr('dt-active',true);
                        $(this).find('.seance').text("سانس ها: "+ times.length)
                    }
                });

            });

        }


        $(document).ready(function(){
            setCurrentTimes();
        });

    </script>

    <script>

        function toggle_seance(active) {

            const div_seance = document.getElementById("div_seance");
            const normal_sale = document.getElementById("normal_sale");
            const normal_1 = document.getElementById("normal_1");
            const normal_0 = document.getElementById("normal_0");

            if (active){
                div_seance.style.display = "";
                normal_sale.value="0";
            }else{
                div_seance.style.display = "none";
                normal_sale.value="1";
            }

        }

        $(document).ready(function(){

            toggle_seance(true);


        });

    </script>
@endsection
