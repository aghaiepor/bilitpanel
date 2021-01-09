@extends('MainLayout')

@section('title')
    <title>
         مدیریت جاذبه های
        {{(empty($array_keys) == 0) ? $GetServices[$array_keys[0]]['location_name'] : ''}}
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
        <div id="loader" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
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
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">location_city</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت جاذبه های    {{(empty($array_keys) == 0) ? $GetServices[$array_keys[0]]['location_name'] : ''}} </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  افزودن جاذبه جدید </span>
                                    <a href="{{Route("places")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                           نوع
                                        </th>
                                        <th >
                                            نام جاذبه
                                        </th>
                                        <th >
                                            نام انگلیسی
                                        </th>
                                        <th >
                                            توضیحات
                                        </th>
                                        <th >
                                            ظرفیت
                                        </th>
                                        <th >
                                            سانس
                                        </th>
                                        <th >
                                            تخفیف
                                        </th>
                                        <th >
                                            مدیریت بلیت ها
                                        </th>
                                        <th >
                                         تصویر سرویس
                                        </th>
                                        <th >
                                            فعال/غیرفعال
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($array_keys) == 0)
                                        <tr>
                                            <td colspan="11" >
                                                <h6 class="py-5">
                                                    موردی یافت نشد .
                                                </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @for($i = 0 ; $i < count($array_keys) ; $i++)
                                            <tr>
                                                <td>
                                                    @if($GetServices[$array_keys[$i]]['model_name'] == 'Entrance')
                                                        ورودی
                                                        @elseif($GetServices[$array_keys[$i]]['model_name'] == 'Event')
                                                        رویداد
                                                        @elseif($GetServices[$array_keys[$i]]['model_name'] == 'Service')
                                                        جاذبه
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $GetServices[$array_keys[$i]]['service_name'] }}
                                                </td>
                                                <td>
                                                    {{$GetServices[$array_keys[$i]]['english_name']}}
                                                </td>
                                                <td>
                                                    {{$GetServices[$array_keys[$i]]['description']}}
                                                </td>
                                                <td>
                                                    @if($GetServices[$array_keys[$i]]['capacity'] == "")
                                                        نامحدود
                                                    @else
                                                        {{$GetServices[$array_keys[$i]]['capacity']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{Route("add_group_time_index" , ["service_id"  => $GetServices[$array_keys[$i]]['service_id'] , 'location_id' => $GetServices[$array_keys[$i]]['location_id']  ])}}" class="btn off_btn btn-dribbble btn-simple">
                                                      افزودن سانس
                                                    </a>
                                                </td>
                                                <td>
                                                    <button data-url="{{Route("AddServiceOff" , [ $GetServices[$array_keys[$i]]['service_id'] ])}}" type="button" data-target="#add_off" data-toggle="modal" rel="tooltip" class="btn off_btn btn-primary btn-simple">
                                                        <i class="material-icons">local_offer</i>
                                                        تخفیف
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ Route('VoucherInfoList' , ['service_id' => $GetServices[$array_keys[$i]]['service_id'] , 'location_id' => $GetServices[$array_keys[$i]]['location_id'] ])}}" rel="tooltip" class="btn  btn-info btn-simple">
                                                        <i class="material-icons">location_city</i>
                                                        مدیریت بلیت ها
                                                    </a>
                                                </td>
                                                <td >
                                                    @php
                                                        $voucher_image = null  ;
                                                        $api = new \App\Api\Api();
                                                    @endphp
                                                    @if(count($service_pics) == 0 )
                                                        <img service_id="{{ $GetServices[$array_keys[$i]]['service_id'] }}" image_id="0" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                    @else
                                                        @foreach($service_pics as $pic)
                                                            @if($pic['service_id'] == $GetServices[$array_keys[$i]]['service_id'])
                                                                @php
                                                                    $voucher_image = $pic['picture_id'];
                                                                     $main_image_address = $api->GetImageAddress($voucher_image)
                                                                @endphp
                                                                <img service_id="{{ $GetServices[$array_keys[$i]]['service_id'] }}" image_id="{{$pic['picture_id']}}" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="{{$main_image_address}}" rel="main_image">
                                                            @endif
                                                        @endforeach
                                                        @if($voucher_image == null)
                                                            <img service_id="{{ $GetServices[$array_keys[$i]]['service_id'] }}" data-toggle="modal" image_id="0" data-target="#image_modal" class="citzen_main_img" src="../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                        @endif
                                                    @endif
{{--                                                    <img data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="{{asset("")}}assets/img/card-1.jpg" alt="">--}}
                                                </td>
                                                <td>
                                                    <div class="togglebutton text-center">
                                                        <label dir="ltr">
                                                            <input name="activation" data-service="{{$GetServices[$array_keys[$i]]['service_id']}}" type="checkbox" @if($GetServices[$array_keys[$i]]['activation']) checked @endif>
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#edit1{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <div class="modal fade" id="edit1{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form method="post" action="{{Route('EditService' , [ 'service_id'=> $GetServices[$array_keys[$i]]['service_id'] ,'location_id'=> $GetServices[$array_keys[$i]]['location_id']   ])}}">
                                                                @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title " id=edit{{$i}}Label">  ویرایش جاذبه </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-row mt-3">
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  نام جاذبه </label>
                                                                            <input value="{{ $GetServices[$array_keys[$i]]['service_name'] }}" name="service_name" type="text" class="form-control"  placeholder="نام جاذبه">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  نام انگلیسی جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['english_name']}}" name="service_english_name" type="text" class="form-control"  placeholder="نام انگلیسی جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  ظرفیت جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['capacity']}}" name="capacity" type="text" class="form-control"  placeholder=" ظرفیت جاذبه (نامحدود = خالی) ">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  عکس جاذبه </label>
                                                                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for=""> توضیحات </label>
                                                                            <textarea style="height: 64px !important;" class="form-control" name="description" cols="30" rows="3"> {{$GetServices[$array_keys[$i]]['description']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <select name="model_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع سرویس">
                                                                                <option disabled> نوع سرویس </option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Entrance') selected @endif value="1">ورودی مکان</option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Event') selected @endif value="3">رویداد</option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Service') selected @endif value="2"> جاذبه مکان</option>
                                                                            </select>
                                                                        </div>
                                                                       {{-- <div class="col-sm text-right">
                                                                            <div class="togglebutton text-center">
                                                                                <label dir="ltr">
                                                                                    <input name="normal_sale" type="checkbox" @if($GetServices[$array_keys[$i]]['normal_sale']) checked @endif>
                                                                                    <span class="toggle"></span>
                                                                                    شامل سانس
                                                                                </label>
                                                                            </div>
                                                                        </div>--}}
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer mt-4">
                                                                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> ویرایش </button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                    <form action="{{Route('DeleteService' , ['service_id' => $GetServices[$array_keys[$i]]['service_id']])}}" method="post">
                                                        @csrf
                                                        <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple ServiceDeleteBtn">
                                                            <i class="material-icons">close</i>
                                                            حدف
                                                        </button>
                                                    </form>

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
    {{-- Modal for add Off --}}
    <div class="modal fade" id="add_off" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="add_off_form" method="post" action="">
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
                                <input dir="ltr" value="" name="activation_date" id="activation_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                            <div class="col-sm text-right">
                                <label for="">  تاريخ انقضا </label>
                                <input dir="ltr" value="" name="expiration_date" id="expiration_date_off" type="text" class="form-control text-center"  placeholder="">
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
                        <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    {{-- Modal for Add Service   --}}
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('AddService' , ['location_id' => $location_id])}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن جاذبه جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  نام جاذبه </label>
                            <input name="service_name" type="text" class="form-control"  placeholder="نام جاذبه">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  نام انگلیسی جاذبه </label>
                            <input name="service_english_name" type="text" class="form-control"  placeholder="نام انگلیسی جاذبه">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <label for="">  ظرفیت جاذبه </label>
                            <input name="capacity" type="text" class="form-control"  placeholder=" ظرفیت جاذبه (نامحدود = خالی) ">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  عکس جاذبه </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <label for=""> توضیحات </label>
                            <textarea name="description" style="height: 64px !important;" class="form-control" name="location_address" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <select name="model_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع سرویس">
                                <option disabled selected> نوع سرویس </option>
                                <option value="1">ورودی مکان</option>
                                <option value="3">رویداد</option>
                                <option value="2"> جاذبه مکان</option>
                            </select>
                        </div>
                       {{-- <div class="col-sm text-right">
                            <div class="togglebutton text-center">
                                <label dir="ltr">
                                    <input name="normal_sale" type="checkbox">
                                    <span class="toggle"></span>
                                    شامل سانس
                                </label>
                            </div>
                        </div>--}}
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
                    <img class="img-fluid rounded" id="herf_modal_image" data-service-id="" data-image-id="" src="" alt="">
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
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // persianDatepicker
            $('#activation_date_off , #expiration_date_off').persianDatepicker({
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

            // for DeleteBtn Question
            $(document).on("click" , ".ServiceDeleteBtn" , function (e) {
                e.preventDefault();
                Swal.fire({
                    title: ' از تغییر ایجاد شده مطمئن هستید ؟ ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7bc127',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله' ,
                    cancelButtonText: 'خیر' ,
                }).then((result) => {
                    if (result.value) {
                        $(this).parent().submit()
                    }

                })
            })

            // get location address
            $(document).on(  "click" ,  ".off_btn"  , function () {
                let url = $(this).attr("data-url");
                $("#add_off_form").attr("action" , url)
            });

            // for show image and id on modal
            $(".citzen_main_img").click(function () {
                let src = $(this).attr("src") ;
                let service_id = $(this).attr("service_id");
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
                $("#herf_modal_image").attr('data-service-id' ,service_id );

            });
            // for add url on action form
            $("#insertBtn").click(function () {
                let service_id = $("#herf_modal_image").attr('data-service-id');
                let image_id = $("#herf_modal_image").attr('data-image-id');
                let url = "{{Route("AddServicePicture")}}/"+ service_id;
                $("#addImageForm").attr('action',url);

            });

            // for service activation
            $('input[name=activation]').change(function () {
                var service =$(this).attr('data-service') ;
                var value = ($(this).is(':checked'));
                console.log("activation clicked !  " )
                $('#loader').css('display' , 'flex');
                Swal.fire({
                    title: ' از تغییر ایجاد شده مطمئن هستید ؟ ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7bc127',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله' ,
                    cancelButtonText: 'خیر' ,
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            url:"{{Route('ServiceActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'service' : service ,
                                'value' : value ,
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
                                $('#loader').hide();
                                if(data.data)
                                {
                                    Swal.fire(
                                        'تغییرات با موفقیت اعمال گردید .',
                                        "" ,
                                        'success' ,
                                    )
                                }
                                else if (data.data == "Permission Denied")
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

                    }else{
                        if(value)
                            $(this).prop( "checked", false );
                        else
                            $(this).prop( "checked", true );
                        $('#loader').hide();
                    }
                })


            });

        });
    </script>
@endsection
