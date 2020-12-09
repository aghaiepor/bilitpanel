@extends('MainLayout')

@section('title')
    <title>
        مدیریت بلیت های {{$GetServices['service_name']}}
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .citzen_main_img{
            width: 70px;
            height: 70px;
            border-radius: 20%;
            object-fit: cover;
            cursor: pointer;
            transition: 0.3s all;
        }
        .citzen_main_img:hover{
            filter: brightness(1.2);
            transform: scale(1.1);
        }
        .citzen_main_img:active{
            filter: brightness(1.8);
            transition: .1s filter;
        }
        #herf_modal_image{
            display: block;
            margin: 0 auto;
        }
        .citzen_img_lib{
            padding: 8px;
            border-radius: 5px;
            border: solid 2px #FF9800;
            font-size: 29pt !important;
            color: #FF9800;
            cursor: pointer;
            transition: .3s all;
        }
        .citzen_img_lib:hover{
            border: solid 2px #de8400;
            color: #de8400;
        }
    </style>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
@endsection

@section('content')
<div class="content">
    <div class="content">
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
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">location_city</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">  مدیریت بلیت های  {{$GetServices['service_name']}}</h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  تعریف بلیت </span>
                                    <a href="{{Route("GetService" , ['id' => $location_id])}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                            مبلغ
                                        </th>
                                        <th >
                                            ظرفیت کل
                                        </th>
                                        <th >
                                            ظرفیت باقی مانده
                                        </th>
                                        <th >
                                           حداکثر تخفیف
                                        </th>
                                        <th >
                                            نوع بلیت
                                        </th>
                                        <th >
                                            عکس بلیت
                                        </th>
                                        <th >
                                            تخفيف
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($VoucherInfo) == 0)
                                        <tr>
                                            <td colspan="7">
                                                <h6 class="py-5 text-center"> بلیتی یافت نشد ! </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @for($i = 0 ; $i < count($VoucherInfo) ; $i++)
                                            <tr>
                                                <td>
                                                    {{number_format($VoucherInfo[$i]['amount'],0,'.',',')}}
                                                </td>
                                                <td>
                                                    @if ($VoucherInfo[$i]['total_capacity'] == "")
                                                        نامحدود
                                                        @else
                                                        {{$VoucherInfo[$i]['total_capacity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($VoucherInfo[$i]['remain_capacity'] == "")
                                                        نامحدود
                                                    @else
                                                        {{$VoucherInfo[$i]['remain_capacity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                     {{$VoucherInfo[$i]['max_discount_percentage']}} درصد
                                                </td>
                                                <td>
                                                    {{$VoucherInfo[$i]['voucher_type_name']}}
                                                </td>
                                                <td>
                                                    @php
                                                        $voucher_image = null  ;
                                                        $api = new \App\Api\Api();
                                                    @endphp
                                                    @if(count($voucher_id_image) == 0 )
                                                        <img voucher_id="{{ $VoucherInfo[$i]['id'] }}" image_id="0" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="../../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                    @else
                                                        @foreach($voucher_id_image as $pic)
                                                            @if($pic['voucher_id'] == $VoucherInfo[$i]['id'])
                                                                @php
                                                                    $voucher_image = $pic['picture_id'];
                                                                     $main_image_address = $api->GetImageAddress($voucher_image)
                                                                @endphp
                                                                <img voucher_id="{{ $VoucherInfo[$i]['id'] }}" image_id="{{$pic['picture_id']}}" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="{{$main_image_address}}" rel="main_image">
                                                            @endif
                                                        @endforeach
                                                        @if($voucher_image == null)
                                                            <img voucher_id="{{ $VoucherInfo[$i]['id'] }}" data-toggle="modal" image_id="0" data-target="#image_modal" class="citzen_main_img" src="../../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                        @endif
                                                    @endif
{{--                                                    <img data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="{{asset("")}}assets/img/card-1.jpg" alt="">--}}
                                                </td>
                                                <td>
                                                    <a href="{{Route("VoucherInfoOff" , [$VoucherInfo[$i]['id']])}}" class="btn btn-info btn-simple">
                                                        مديريت تخفيف
                                                    </a>
                                                </td>
                                                <td>
                                                    <button data-id="{{ $VoucherInfo[$i]['id'] }}" data-service_id="{{$VoucherInfo[$i]['service_id']}}" data-location_id="{{$VoucherInfo[$i]['location_id']}}" data-validity_period="{{$VoucherInfo[$i]['validity_period']}}" data-expiration_date="{{$VoucherInfo[$i]['expiration_date']}}"  data-voucher_type_name="{{$VoucherInfo[$i]['voucher_type_name']}}" data-toggle="modal" data-target="#Edit" type="button" rel="tooltip" class="btn TableEditBtn edit_btn  btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    {{--<div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form method="post" action="{{Route('EditVoucherInfo' , ['service_id'=>$VoucherInfo[$i]['service_id'] , 'location_id'=> $VoucherInfo[$i]['location_id'] ,'id'=>$VoucherInfo[$i]['id']])}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title " id="edit1Label">  ویرایش بلیت </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-row mt-3">
                                                                            <div class="col-sm text-right">
                                                                                <label for=""> مبلغ به ریال </label>
                                                                                <input value="{{$VoucherInfo[$i]['amount']}}" name="amount" type="text" class="form-control"  placeholder="مبلغ به ریال">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for=""> ظرفیت </label>
                                                                                <input value="{{$VoucherInfo[$i]['total_capacity']}}" name="capacity" type="text" class="form-control"  placeholder="ظرفیت">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for="">  نوع بلیت </label>
                                                                                <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                                                                    <option disabled> نوع بلیت </option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "نیم بها") selected @endif value="2">نیم بها</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "ایرانی") selected @endif value="3">ایرانی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "رایگان") selected @endif value="1">رایگان</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "ایرانی گروهی") selected @endif value="5">ایرانی گروهی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "خارجی") selected @endif value="4">خارجی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "خارجی گروهی") selected @endif value="6">خارجی گروهی</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer mt-4">
                                                                         <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                                                                        <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> ویرایش </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>

                                                    </div>--}}


{{--                                                    --}}{{-- DELETE BUTTON  DONT REMOVE THIS PART --}}
{{--                                                 --}}{{--   <button type="button" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">--}}
{{--                                                        <i class="material-icons">close</i>--}}
{{--                                                        حدف--}}
{{--                                                    </button>--}}
                                                </td>
                                            </tr>
                                        @endfor
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{Route('AddVoucherInfo' , ['service_id'=>$service_id , 'location_id' =>$location_id])}}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن بلیت </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> مبلغ به ریال </label>
                            <input type="text" class="form-control" name="amount" placeholder="مبلغ به ریال">
                        </div>
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> ظرفیت </label>
                            <input type="text" class="form-control" name="capacity" placeholder="ظرفیت">
                        </div>
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> نوع بلیت </label>
                            <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                <option disabled> نوع بلیت </option>
                                <option value="2">نیم بها</option>
                                <option value="3">ایرانی</option>
                                <option value="1">رایگان</option>
                                <option value="5">ایرانی گروهی</option>
                                <option value="4">خارجی</option>
                                <option value="6">خارجی گروهی</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> حداکثر تخفيف(درصد) </label>
                            <input min="0" max="100" type="text" class="form-control" name="max_discount_percentage" placeholder="حداکثر تخفيف">
                        </div>
                        <div class="col-sm">
                            <label for=""></label>
                            <select name="exprieMode" class="selectpicker" data-style="btn btn-primary border-dark" name="" id="exprieMode">
                                <option value="time">مدت انقضا  </option>
                                <option value="date">تاریخ انقضا  </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div id="expire_time" class="col-sm text-right">
                            <label class="mb-0" for="" > مدت انقضا </label>
                            <input type="text" class="form-control" name="validity_period" placeholder="مدت انقضا">
                        </div>
                        <div id="timetype" class="col-sm text-right">
                            <label class="mb-0" for=""> نوع زمان </label>
                            <select class="selectpicker" data-style="btn btn-primary border-dark" name="timetype" >
                                <option value="seconds">ثانیه  </option>
                                <option value="min">دقیقه  </option>
                                <option value="hour">ساعت  </option>
                                <option value="day">روز  </option>
                                <option value="week">هفته  </option>
                                <option value="month">ماه  </option>
                                <option value="year">سال  </option>
                            </select>
                        </div>
                        <div id="expire_date" class="col-sm text-right">
                            <label class="mb-0" for="expiration_date"> تاريخ انقضا </label>
                            <input dir="ltr" id="expiration_date" type="text" class="form-control" name="expiration_date" placeholder="تاريخ انقضا">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="edit_form" method="post" action="#">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن بلیت </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> مبلغ به ریال </label>
                            <input id="edit_price" type="text" class="form-control" name="amount" placeholder="مبلغ به ریال">
                        </div>
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> ظرفیت </label>
                            <input id="edit_capacity" type="text" class="form-control" name="capacity" placeholder="ظرفیت">
                        </div>
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> نوع بلیت </label>
                            <select id="edit_voucher_type" name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                <option disabled> نوع بلیت </option>
                                <option value="2">نیم بها</option>
                                <option value="3">ایرانی</option>
                                <option value="1">رایگان</option>
                                <option value="5">ایرانی گروهی</option>
                                <option value="4">خارجی</option>
                                <option value="6">خارجی گروهی</option>
                            </select>
                        </div>
                    </div>
<div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label class="mb-0" for=""> حداکثر تخفيف(درصد) </label>
                            <input id="edit_max_percent" min="0" max="100" type="text" class="form-control" name="max_discount_percentage" placeholder="حداکثر تخفيف">
                        </div>
                        <div class="col-sm">
                            <label for=""></label>
                            <select name="exprieMode" class="selectpicker" data-style="btn btn-primary border-dark"  id="Edit_exprieMode">
                                <option value="time">مدت انقضا</option>
                                <option value="date">تاریخ انقضا</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div id="Edit_expire_time" class="col-sm text-right">
                            <label class="mb-0" for="" > مدت انقضا </label>
                            <input id="edit_validity_period" type="text" class="form-control" name="validity_period" placeholder="مدت انقضا">
                        </div>
                        <div id="Edit_timetype" class="col-sm text-right">
                            <label class="mb-0" for=""> نوع زمان </label>
                            <select id="edit_timetype" class="selectpicker" data-style="btn btn-primary border-dark" name="timetype" >
                                <option value="seconds">ثانیه  </option>
                                <option value="min">دقیقه  </option>
                                <option value="hour">ساعت  </option>
                                <option value="day">روز  </option>
                                <option value="week">هفته  </option>
                                <option value="month">ماه  </option>
                                <option value="year">سال  </option>
                            </select>
                        </div>
                        <div id="Edit_expire_date" class="col-sm text-right">
                            <label class="mb-0" for="expiration_date"> تاريخ انقضا </label>
                            <input dir="ltr" id="Edit_expiration_date" type="text" class="form-control" name="expiration_date" placeholder="تاريخ انقضا">
                        </div>
                    </div>

                </div>
                <div class="modal-footer mt-4">
 <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>

                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- Off modal --}}
{{--
<div class="modal fade" id="off" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="#">--}}
{{--{{Route('AddVoucherInfoOff' , ['id'=>$VoucherInfo[$i]['id']])}}--}}{{--

            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="edit1Label">  افزودن تخفيف </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  تخفيف به درصد </label>
                            <input value="" name="percentage" type="text" class="form-control"  placeholder="تخفيف به درصد">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  تاريخ فعال سازي </label>
                            <input dir="ltr" value="" name="activation_date" id="activation_date_off" type="text" class="form-control text-center"  placeholder="تخفيف به درصد">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  تاريخ انقضا </label>
                            <input dir="ltr" value="" name="expiration_date" id="expiration_date_off" type="text" class="form-control text-center"  placeholder="تخفيف به درصد">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for=""> توضيحات  </label>
                            <textarea style="min-height: 150px !important;" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>
    </div>

</div>
--}}

{{-- Modal for singel images   --}}
<div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="img-fluid rounded" id="herf_modal_image" data-voucher-id="" data-image-id="" src="" alt="">
            </div>
            <div class="modal-footer">
                <button id="insertBtn" class="btn btn-success px-3" data-toggle="modal" data-target="#insetImage">
                    افزودن عکس
                </button>
                <a id="DelBtn" href="" class="btn btn-danger px-3">
                    حذف عکس
                </a>
            </div>
        </div>
    </div>
</div>


{{-- Modal for add service image   --}}
<div class="modal fade" id="insetImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="addImageForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <input type="hidden" value="{{$location_id}}" name="location_id">
                        <div class="col text-right">
                            <label for=""> عکس آپلود </label>
                            <input type="file" name="service_image" class="form-control">
                        </div>
                        <div class="col text-right">
                            <label for=""> پروژه <small>(اختیاری)</small> </label>
                            <select name="project_id" id="province" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب پروژه">
                                @foreach($projectList as $project)
                                    <option value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success px-5" data-toggle="modal" data-target="">
                        افزودن
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('AddJs')
    <script src="{{asset('')}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // console.log("test");
            $('#expiration_date , #Edit_expiration_date ,#activation_date_off , #expiration_date_off ').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                altField: '#inlineExampleAlt',
                format: 'YYYY/MM/DD hh:mm:ss',
                timePicker : {
                    enabled : true
                } ,
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                },
            });
        });
    </script>
    <script>

        $(document).ready(function () {

            $('.edit_btn').click(function () {
                let voucher_id = $(this).attr("data-id");
                let service_id = $(this).attr("data-service_id");
                let location_id = $(this).attr("data-location_id");
                let validity_period = $(this).attr("data-validity_period");
                let expiration_date = $(this).attr("data-expiration_date");
                let edit_price = $(this).parent().parent().find("td").eq(0).text();
                edit_price = edit_price.replace(",", "");
                edit_price = edit_price.trim();
                edit_price = eval(edit_price);
                let edit_capacity = $(this).parent().parent().find("td").eq(1).text() ;
                edit_capacity = edit_capacity.trim();
                // console.log(edit_capacity == "نامحدود")
                if(edit_capacity == "نامحدود")
                    edit_capacity = "";
                else
                    edit_capacity = eval(edit_capacity);

                let edit_voucher_type = $(this).attr("data-voucher_type_name") ;
                let edit_max_percent = $(this).parent().parent().find("td").eq(3).text() ;
                edit_max_percent = edit_max_percent.replace("درصد" , "");
                edit_max_percent = eval(edit_max_percent);
                $("#Edit_expire_time").show()
                $("#Edit_timetype").show()
                $("#Edit_expire_date").hide()

                let Edit_exprieMode = "" ;
                let edit_validity_period = "" ;
                edit_validity_period = "seconds" ;

                let edit_timetype = "" ;
                let Edit_expiration_date ="" ;

                // console.log("expiration_date =>" , expiration_date)
                // console.log("validity_period =>" , validity_period)
                if(validity_period != "" ){
                    Edit_exprieMode = "time" ;
                }
                else if(expiration_date != ""){
                    Edit_exprieMode = "date" ;
                    $("#Edit_expire_time").hide();
                    $("#Edit_timetype").hide();
                    $("#Edit_expire_date").show();
                }
                else
                    Edit_exprieMode = "time";

                // console.log("Edit_exprieMode =>" , Edit_exprieMode)
                let url = "{{Route('EditVoucherInfo')}}/" + service_id + "/" + location_id + "/" + voucher_id ;
                $("#edit_form").attr("action" , url);
                $("#edit_price").val(edit_price);
                $("#edit_capacity").val(edit_capacity);
                $("#edit_max_percent").val(edit_max_percent);
                // console.log("Edit_exprieMode " , $('#Edit_exprieMode').find("option[value="+ Edit_exprieMode + "]").attr("value"))
                // console.log("edit_validity_period " , edit_validity_period)
                $('#Edit_exprieMode').find("option").attr('selected' , false);
                $('#Edit_exprieMode').find("option[value="+ Edit_exprieMode + "]").attr('selected' , true);
                $('#edit_timetype').find("option").attr('selected' , false);
                $('#edit_timetype').find("option[value="+ edit_validity_period + "]").attr('selected' , true);
                console.log("voucher_type_id =>" , edit_voucher_type);
                $('#edit_voucher_type').find("option").attr('selected' , false);
                let edit_voucher_type_value = $("#edit_voucher_type option").filter(function() {
                    return $(this).text() === edit_voucher_type;
                }).val();
                console.log("edit_voucher_type_value => " , edit_voucher_type_value)
                $('#edit_voucher_type').find("option[value="+ edit_voucher_type_value + "]").attr('selected' , true);
                $("#edit_validity_period").val(validity_period);
                $("#Edit_expiration_date").val(expiration_date);
                $('.selectpicker').selectpicker('refresh');
            });
            $("#Edit_exprieMode").change(function () {
                let value = $(this).val() ;
                if(value == "date"){
                    $("#Edit_expire_date").show();
                    $("#Edit_timetype").hide();
                    $("#Edit_expire_time").hide();
                }
                else{
                    $("#Edit_expire_date").hide();
                    $("#Edit_timetype").show();
                    $("#Edit_expire_time").show();
                }
            });
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
            // for show image and id on modal
            $(".citzen_main_img").click(function () {
                let src = $(this).attr("src") ;
                let voucher_id = $(this).attr("voucher_id");
                let image_id = $(this).attr("image_id");
                if(image_id == '0'){
                    $("#DelBtn").attr('href','#');
                    $("#DelBtn").hide();

                }else{
                    $("#DelBtn").show();
                    let deleteUrl = "{{Route("imageRemove")}}/" + image_id ;
                    $("#DelBtn").attr('href',deleteUrl);
                }

                $("#herf_modal_image").attr('src' ,src );
                $("#herf_modal_image").attr('data-voucher-id' ,voucher_id );

            });
            // for add url on action form
            $("#insertBtn").click(function () {
                let voucher_id = $("#herf_modal_image").attr('data-voucher-id');
                let image_id = $("#herf_modal_image").attr('data-image-id');
                let url = "{{Route("AddVoucherPicture")}}/"+ voucher_id;
                $("#addImageForm").attr('action',url);

            });
        });

    </script>
@endsection

