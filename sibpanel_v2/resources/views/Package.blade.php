@extends('MainLayout')

@section('title')
    <title>
         مدیریت پکیج های
        {{$info['location_name']}}
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .dropdown-menu{
            min-width: 100% !important;
        }
        table { font-family: "iransansFarsi"}
        .SelectSpinner
        {
            width: 30px;
            height: 30px;
            color: #fff !important;
            box-shadow: 0px 0px 15px 3px #999;
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت پکیج های    {{$info['location_name']}} </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  افزودن پکیج جدید </span>
                                    @php

                                        if (url()->current() != url()->previous() && url()->previous() != Route("loading")) {
                                            session(['backPlace' => url()->previous()]);
                                            $url = url()->previous() ;
                                        }
                                        else
                                           session(['backPlace' => Route("places")]);
                                    @endphp
                                    <a href="{{session('backPlace')}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th>
                                            نام پکیج
                                        </th>
                                        <th >
                                            سرویس ها
                                        </th>
                                        <th >
                                          قیمت
                                        </th>
                                        <th >
                                          نوع بلیت
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
                                    @if(count($Packages) == 0)
                                        <tr>
                                            <td colspan="11" >
                                                <h6 class="py-5">
                                                    موردی یافت نشد .
                                                </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($Packages as $key => $Package)
                                            <tr>
                                                <td>
                                                    {{ $Package['name'] }}
                                                </td>
                                                <td>
                                                    @php
                                                        $servies = $GetServices ;
                                                        $PackageServes = $Package['service_ids'] ;
                                                        $serviesId = array_column($servies, 'service_id')  ;
                                                         $serviesIndex = array_filter($servies, function ($event) use ($PackageServes) {
                                                                return in_array( $event['service_id'], $PackageServes);
                                                        });
                                                         $serviesIndex = array_values($serviesIndex) ;
                                                         $serviesIndex = array_column($serviesIndex, 'service_name')  ;
                                                    @endphp
                                                    {{ implode(" - " , $serviesIndex) }}
                                                </td>
                                                <td>

                                                    {{  number_format($Package['amount'] , 0 , "." , ",") }}
                                                </td>
                                                <td>
                                                    @foreach($VoucherTypes as $VoucherType)
                                                        @if($VoucherType["voucher_type_id"] ==  $Package["voucher_type"])
                                                            {{$VoucherType["voucher_type"]}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td >
                                                    <div class="togglebutton text-center">
                                                        <label dir="ltr">
                                                            <input name="activation" data-package="{{$Package['id']}}" type="checkbox" @if($Package['active']) checked @endif>
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button data-package="{{$Package['id']}}" data-toggle="modal" data-target="#edit" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple EditBtn">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <form class="d-inline-block" action="{{Route('DeletePackage' , ['id' => $Package['id']])}}" method="post">
                                                        @csrf
                                                        <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple ServiceDeleteBtn">
                                                            <i class="material-icons">close</i>
                                                            حدف
                                                        </button>
                                                    </form>

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

    {{-- Modal for Add Package   --}}
    <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form id="AddPakcageform" action="{{Route("AddPackage" , ["location_id" => $location_id])}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن پکیج جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  نام پکيج </label>
                            <input id="AddPackageName" name="name" type="text" class="form-control"  placeholder="نام پکيج">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> نوع بليت </label>
                            <select id="voucher_type_id" name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بليت">
                                @foreach($VoucherTypes as $VoucherType)
                                    <option data-price="" value="{{$VoucherType["voucher_type_id"]}}"> {{$VoucherType["voucher_type"]}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-4 " id="serviceList">
                        <div class="col-sm text-right position-relative">
                            <div id="loader_service" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0px;bottom: 0;justify-content: center;align-items: center;background: #ffffff99;cursor: not-allowed; display: none; padding-top: 41px;">
                                <div class="spinner-border SelectSpinner mx-auto d-block mb-3"></div>
                            </div>
                            <label for=""> سرویس ها</label>
                            <select id="service_ids" name="service_ids[]" class="selectpicker" data-style="btn btn-primary border-dark" title="نام سرویس" multiple>
                                <option value=""> همه </option>
                                {{--@foreach($GetServices as $GetService)
                                    <option value="{{$GetService["service_id"]}}"> {{$GetService["service_name"]}} </option>
                                @endforeach--}}
                            </select>
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  قيمت پکيج </label>
                            <input name="amount" type="text" class="form-control"  placeholder="قيمت پکيج ">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm">
                            <table class="table text-right table-bordered">
                                <tr>
                                    <td width="50%" > جمع قیمت سرویس ها </td>
                                    <td  id="AddTotalPrice" class="text-center p-0"> 0 </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button id="AddPackage" type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>

    </div>
    </div>

    {{-- Modal for Edit Package   --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="EditPackage" action="" method="post">
                @csrf
                <div class="modal-content position-relative">
                    <div id="loader2" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                        <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> ویرایش پکیج </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  نام پکيج </label>
                                <input id="package_name" name="name" type="text" class="form-control"  placeholder="نام پکيج">
                            </div>
                            <div class="col-sm text-right">
                                <label for=""> نوع بليت </label>
                                <select id="package_voucher_type" name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بليت">
                                    @foreach($VoucherTypes as $VoucherType)
                                        <option value="{{$VoucherType["voucher_type_id"]}}"> {{$VoucherType["voucher_type"]}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-4">
                            <div class="col-sm text-right position-relative">
                                <div id="loader_service_Edit" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0px;bottom: 0;justify-content: center;align-items: center;background: #ffffff99;cursor: not-allowed; display: none; padding-top: 41px;">
                                    <div class="spinner-border SelectSpinner mx-auto d-block mb-3"></div>
                                </div>
                                <label for=""> سرویس ها</label>
                                <select id="package_service_ids" name="service_ids[]" class="selectpicker" data-style="btn btn-primary border-dark" title="نام سرویس" multiple>
                                    {{--@foreach($GetServices as $GetService)
                                        <option value="{{$GetService["service_id"]}}"> {{$GetService["service_name"]}} </option>
                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="col-sm text-right">
                                <label for="">  قيمت پکيج </label>
                                <input id="package_amount" name="amount" type="text" class="form-control"  placeholder="قيمت پکيج ">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm">
                                <table class="table text-right table-bordered">
                                    <tr>
                                        <td width="50%" > جمع قیمت سرویس ها </td>
                                        <td  id="EditTotalPrice" class="text-center p-0"> 0 </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                        <button id="EditPackageBtn" type="button" class="btn px-5 btn-success ml-0 mr-auto"> ویرایش </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script>

        $(document).ready(function () {
            (function($) {
                $.fn.animateNumbers = function(stop, commas, duration, ease) {
                    return this.each(function() {
                        var $this = $(this);
                        var isInput = $this.is('input');
                        var start = parseInt(isInput ? $this.val().replace(/,/g, "") : $this.text().replace(/,/g, ""));
                        var regex = /(\d)(?=(\d\d\d)+(?!\d))/g;
                        commas = commas === undefined ? true : commas;

                        // number inputs can't have commas or it blanks out
                        if (isInput && $this[0].type === 'number') {
                            commas = false;
                        }

                        $({value: start}).animate({value: stop}, {
                            duration: duration === undefined ? 500 : duration,
                            easing: ease === undefined ? "swing" : ease,
                            step: function() {
                                isInput ? $this.val(Math.floor(this.value)) : $this.text(Math.floor(this.value));
                                if (commas) {
                                    isInput ? $this.val($this.val().replace(regex, "$1,")) : $this.text($this.text().replace(regex, "$1,"));
                                }
                            },
                            complete: function() {
                                if (parseInt($this.text()) !== stop || parseInt($this.val()) !== stop) {
                                    isInput ? $this.val(stop) : $this.text(stop);
                                    if (commas) {
                                        isInput ? $this.val($this.val().replace(regex, "$1,")) : $this.text($this.text().replace(regex, "$1,"));
                                    }
                                }
                            }
                        });
                    });
                };
            })(jQuery);



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ****** Add Package Script
                $(document).on("change" , "#voucher_type_id" , function () {
                    let value = $(this).val() ;
                    UpdateSerivse(value , "Add" , "#service_ids")
                })
                $(document).on("change" , "#service_ids"  , function () {
                    // let amounts = $(this).find('option:selected').attr('data-amount');
                    let amounts = $(this).find('option:selected').map((i, el) => $(el).attr("data-amount")).toArray() ;
                    if(amounts.length != 0 )
                    {
                        let num = 0 ;
                        for(let i = 0 ; i<  amounts.length ; i++)
                        {
                            num += eval(amounts[i]) ;
                        }
                        if(num == 0)
                            $('#AddTotalPrice').animateNumbers(0);
                        else
                            $('#AddTotalPrice').animateNumbers(num);
                    }
                    else
                        $('#AddTotalPrice').animateNumbers(0);
                })
                // check for Add Pachage form
                $(document).on("click" , "#AddPackage" , function (e) {
                    e.preventDefault();
                    let error = 0 ;
                    $("#AddPakcageform input , #AddPakcageform select").each(function () {
                        let value = $(this).val() ;
                        if(value == "")
                        {
                            $(this).addClass("border-danger") ;
                            $(this).parent().prev().addClass("text-danger")
                            error++ ;
                        }
                        else
                        {
                            $(this).removeClass("border-danger") ;
                            $(this).parent().prev().removeClass("text-danger")
                        }

                    });
                    if(error == 0 )
                    {
                        $("#AddPakcageform").submit();
                    }
                    else
                    {
                        Swal.fire(
                            'خطا ! ',
                            " لطفا فیلد های مشخص شده را تکمیل نمایید . " ,
                            'warning' ,
                        )
                    }

                })
            // ****** End Add Package Script

            // ******* Edit Package Script
            let selectedService = "";
            $(document).on("change" , "#package_voucher_type" , function () {
                let value = $(this).val() ;
                UpdateSerivse(value , "Edit" , "#package_service_ids" , selectedService)
            })
            $(document).on("change" , "#package_service_ids"  , function () {
                // let amounts = $(this).find('option:selected').attr('data-amount');
                let amounts = $(this).find('option:selected').map((i, el) => $(el).attr("data-amount")).toArray() ;
                if(amounts.length != 0 )
                {
                    let num = 0 ;
                    for(let i = 0 ; i<  amounts.length ; i++)
                    {
                        num += eval(amounts[i]) ;
                    }
                    if(num == 0)
                        $('#EditTotalPrice').animateNumbers(0);
                    else
                        $('#EditTotalPrice').animateNumbers(num);
                }
                else
                    $('#EditTotalPrice').animateNumbers(0);
            })
            $(document).on("click" , "#EditPackageBtn" , function (e) {
                e.preventDefault();
                let error = 0 ;
                $("#EditPackage input , #EditPackage select").each(function () {
                    let value = $(this).val() ;

                    if(value == "")
                    {
                        $(this).addClass("border-danger") ;
                        $(this).parent().prev().addClass("text-danger")
                        ++error ;
                    }
                    else
                    {
                        $(this).removeClass("border-danger") ;
                        $(this).parent().prev().removeClass("text-danger")
                    }

                });
                if(error == 0 )
                {
                    $("#EditPackage").submit();
                }
                else
                {
                    Swal.fire(
                        'خطا ! ',
                        " لطفا فیلد های مشخص شده را تکمیل نمایید . " ,
                        'warning' ,
                    )
                    return ;
                }

            })

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
            // for Package activation
            $('input[name=activation]').change(function () {
                let package_id =$(this).attr('data-package') ;
                let value = ($(this).is(':checked'));
                let el  = $(this) ;
                console.log("activation value : "  , value )
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
                            url:"{{Route('PackageActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'package_id' : package_id ,
                                'active' : value ,
                                'location_id' : "{{$location_id}}" ,
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
                                console.log(data)
                                $('#loader').hide();
                                if(data.Header.Status == 0 )
                                {
                                    Swal.fire(
                                        'تغییرات با موفقیت اعمال گردید .',
                                        "" ,
                                        'success' ,
                                    )
                                }
                                else if (data.Header.MessageCode == 133)
                                {
                                    if(value)
                                        el.prop( "checked", false );
                                    else
                                        el.prop( "checked", true );

                                    Swal.fire(
                                        'شما مجاز به انجام چنین عملیاتی نیستید .',
                                        "" ,
                                        'warning' ,
                                    )
                                }
                                else {

                                    if(value)
                                        el.prop( "checked", false );
                                    else
                                        el.prop( "checked", true );

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

            // for Get Package
            $('.EditBtn').on( "click" ,  function () {
                let id =$(this).attr('data-package') ;
                let url = "{{Route("EditPackage" , ["location_id" => $location_id ])}}/" +  id ;
                $("#EditPackage").attr("action" , url);
                $('#loader2').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('GetPackage')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'id' : id ,
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
                        data = data["ContentData"];
                        $("#package_name").val(data.name);
                        // $("#package_voucher_type").val(data.voucher_type);
                        selectedService = data.service_ids ;
                        $("#package_voucher_type").val(data.voucher_type).trigger("change");
                        $("#package_amount").val(data.amount);
                        console.log("data : " , data);
                        $('#loader2').hide();

                    }
                });


            });

        });
        function UpdateSerivse(voucher_id , type , targetElement , selectedElement="" ) {
            if(type == "Edit")
                $('#loader_service_Edit').css("display" , "flex");
            else
                $('#loader_service').css("display" , "flex");;

            $.ajax({
                type:'POST',
                url:"{{Route('getServiceWtihVoucherType')}}",
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'voucher_type_id' : voucher_id ,
                    'location_id' : "{{$location_id}}" ,
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
                    // console.log(data)
                    $(targetElement).html("") ;

                    if(data.length > 0 )
                    {
                        for(var i = 0 ; i < data.length ; i++){
                            let option = $('<option data-amount="'+data[i].VoucherAmount+'" value="'+ data[i].ServicesId +'">'+data[i].ServicesName+'</option>');
                            $(targetElement).append(option);
                        }
                        if(type == "Edit")
                            $('#EditTotalPrice').animateNumbers(0);
                        else
                            $('#AddTotalPrice').animateNumbers(0);
                    }
                    else {
                        Swal.fire(
                            'خطا!',
                            " سرویسی برای بلیت انتخابی وجود ندارد ! " ,
                            'warning' ,
                        )
                        let option = $('<option disabled  > بدون سرویس </option>');
                        $(targetElement).append(option);
                    }
                    $(targetElement).selectpicker('refresh');
                    if(type == "Edit")
                    {
                        if(selectedElement != "")
                        {
                            $("#package_service_ids").val(selectedElement).trigger("change");
                            selectedService ="";
                        }

                        $('#loader_service_Edit').hide();
                    }


                    else
                        $('#loader_service').hide();
                }
            });
        }
    </script>
@endsection
