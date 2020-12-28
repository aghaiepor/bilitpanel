@extends('MainLayout')

@section('title')
    <title>
        مدیریت تخفیف
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
@endsection
@php
    $Api= new \App\Api\Api();
@endphp
@section('content')
    <div class="content">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">format_size</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت تخفیف </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> افزودن تخفيف </span>
                                    <a href="{{url()->previous()}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">

                            <div class="table-responsive table-striped">
                                <table id="OffTable" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                           درصد تخفیف
                                        </th>
                                        <th >
                                            تاریع فعال سازی
                                        </th>
                                        <th >
                                            تاریع انقضا
                                        </th>
                                        <th >
                                            فعال / غيرفعال
                                        </th>
                                        <th >
                                            توضیحات
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="OffTableTbody">
                                    @if (count($GetDiscountPolicyList) == 0 )
                                    <tr>
                                        <td colspan="6">
                                            <h6 class="py-5 text-center">
                                                برای نمایش یکی از فیلتر های بالا را انتخاب نمایید .
                                            </h6>
                                        </td>
                                    </tr>
                                        @else
                                        @foreach($GetDiscountPolicyList as $GetDiscountPolicy)
                                            <tr>
                                            <td  >
                                                {{$GetDiscountPolicy["percentage"]}} درصد
                                            </td>
                                            <td dir="ltr" >
                                                {{  new \Hekmatinasser\Verta\Verta(\Carbon\Carbon::parse($GetDiscountPolicy["activation_date"])->toDateTimeString()) }}
                                            </td>
                                            <td dir="ltr">
                                                {{ new \Hekmatinasser\Verta\Verta(\Carbon\Carbon::parse($GetDiscountPolicy["expiration_date"])->toDateTimeString())}}
                                            </td>
                                            <td >
                                                <div class="togglebutton">
                                                    <label>
                                                        <input  data-id="{{$GetDiscountPolicy["id"] }}" data-percent="{{$GetDiscountPolicy["percentage"]}}" data-description="{{$GetDiscountPolicy["description"]}}"  name="active" @if($GetDiscountPolicy["active"]) checked="" @endif type="checkbox">
                                                        <span class="toggle"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td >
                                                @if(is_null($GetDiscountPolicy["description"]))
                                                    -
                                                @else
                                                    {{$GetDiscountPolicy["description"]}}
                                                @endif
                                            </td>
                                            <td >
                                                <button data-id="{{$GetDiscountPolicy["id"]}}" data-percent="{{$GetDiscountPolicy["percentage"]}}" data-activation_date="{{ $Api->fa_number(new \Hekmatinasser\Verta\Verta(\Carbon\Carbon::parse($GetDiscountPolicy["activation_date"])->toDateTimeString()))  }}" data-description="{{$GetDiscountPolicy["description"]}}" data-expiration_date="{{ $Api->fa_number(new \Hekmatinasser\Verta\Verta(\Carbon\Carbon::parse($GetDiscountPolicy["expiration_date"])->toDateTimeString())) }}" data-toggle='modal' data-target='#EditModal' class='btn btn-success edit_btn'> ویرایش </button>
                                            </td>
                                            </tr>
                                        @endforeach
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

<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{Route('AddVoucherInfoOff' , ['id'=>$id])}}">
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

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="EditOffForm" action="#" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel">  ویرایش تخفیف </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="active" id="edit_active" value="">
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تخفيف به درصد </label>
                                <input id="edit_percent" name="percentage" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تاريخ فعال سازي </label>
                                <input dir="ltr" value="" name="activation_date" id="edit_activation_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                            <div class="col-sm text-right">
                                <label for="">  تاريخ انقضا </label>
                                <input dir="ltr" value="" name="expiration_date" id="edit_expiration_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for=""> توضيحات  </label>
                                <textarea id="edit_description" class="form-control" name="description" style="min-height: 150px"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                        <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> افزودن </button>
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
    <script>
        $(document).ready(function () {
            $('#activation_date_off , #expiration_date_off  , #edit_activation_date_off , #edit_expiration_date_off ').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                altField: '#inlineExampleAlt',
                format: 'YYYY/MM/DD H:mm:ss',
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
            $(document).on( "click" , ".edit_btn" , function () {
                let id = $(this).attr("data-id");
                let data_percent = $(this).attr("data-percent");
                let data_description = $(this).attr("data-description");
                let activation_date = $(this).attr("data-activation_date");
                let expiration_date = $(this).attr("data-expiration_date");
                let data_active = $(this).parent().parent().children().eq(3).find("input").val();
                if(data_active == "on")
                    data_active = true ;
                else
                    data_active = false;

                let url = "{{Route("EditDiscountPolicy")}}/" + id  ;
                $("#EditOffForm").attr("action" , url);
                $("#edit_percent").val(data_percent);
                $("#edit_active").val(data_active);
                $("#edit_activation_date_off").attr("value" , activation_date);
                $("#edit_activation_date_off").val(activation_date);
                $("#edit_expiration_date_off").attr("value" , expiration_date);
                $("#edit_expiration_date_off").val(expiration_date);

                if(data_description == "null" )
                    data_description=""
                $("#edit_description").val(data_description);
            });

            $(document).on( "click" , "input[name=active]" , function () {
                let id = $(this).attr("data-id");
                // console.log("id => ", id);
                let data_active =  $(this).is(':checked');
                // console.log(data_active);
                $("#loader").css("display" , "flex");
                $.ajax({
                    type:'POST',
                    url:"{{Route('DiscountPolicyActivation')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'id' : id ,
                        'active' : data_active ,
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
                        $("#loader").hide();
                        if(data["Header"]["Status"] == 0)
                        {
                            Swal.fire(
                                'تغییرات با موفقیت اعمال گردید .',
                                "" ,
                                'success' ,
                            )
                        }
                    }
                });

            });
        });
    </script>
@endsection
