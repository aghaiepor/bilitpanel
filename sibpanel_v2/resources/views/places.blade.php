@extends('MainLayout')

@section('title')
    <title>
        اطلاعات مکان های موجود
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .dropdown-menu{
            width:  270px !important ;
            min-width: 270px !important ;
            max-width: 1000px !important ;
            overflow-x: scroll;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div id="loader" style="position: fixed;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
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
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">room</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> اطلاعات مکان های موجود</h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1">
                                        <i class="material-icons"> add_circle_outline </i>
                                        افزودن مکان جدید
                                    </span>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <select id="province_filter" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="Single Select">
                                        <option disabled selected> انتخاب استان </option>
                                        <option value="0" >همه</option>
                                        <option value="1">فارس</option>
                                        <option value="2">اصفهان</option>
                                        <option value="3">تهران</option>
                                        <option value="6">کرمانشاه</option>
                                        <option value="7">خراسان رضوی</option>
                                        <option value="9">قزوین</option>
                                        <option value="10">همدان</option>
                                        <option value="11">کرمان</option>
                                        <option value="12">یزد</option>
                                        <option value="13">سازمان محیط زیست</option>
                                        <option value="14">آذربایجان شرقی</option>
                                        <option value="15">آذربایجان غربی</option>
                                        <option value="16">اردبیل</option>
                                        <option value="17">زنجان</option>
                                        <option value="18">کردستان</option>
                                        <option value="19">گلستان</option>
                                        <option value="34">خوزستان</option>
                                        <option value="35">لرستان</option>
                                        <option value="36">اصفهان ( شهرداری)</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="cityList_filter" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="Single Select">
                                        <option disabled selected> انتخاب شهر </option>
                                        <option value="2"> همه </option>
                                    </select>
                                </div>
                                <div class="col-md-auto ml-auto">
                                    <button class="btn bgPer"> فیلتر
                                    </button>
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
                                            نام مکان
                                        </th>
                                        <th >
                                            آدرس
                                        </th>
                                        <th >
                                            مدیریت جاذبه
                                        </th>
                                        <th >
                                           پنل شهروندی
                                        </th>
                                        <th >
                                            چاپ QR
                                        </th>
                                        <th >
                                            چاپ پوز
                                        </th>
                                        <th >
                                            فعالسازی
                                        </th>
                                        <th >
                                            ویرایش مکان
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i = 0 ;
                                    @endphp
                                    @if(count($locations) <=0)
                                        <tr>
                                            <td colspan="7">
                                            <h6 class="text-center py-5"> اطلاعات مکانی وجود ندارد.  </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($locations as $location)
                                            <tr>
                                                <td>
                                                    {{$location['location_name']}}
                                                </td>
                                                <td>
                                                    {{$location['location_address']}}
                                                </td>
                                                <td>
                                                    <a href="{{Route('GetService' , ['id' => $location['id']])}}" type="button" rel="tooltip" class="btn  btn-info btn-simple">
                                                        <i class="material-icons">domain </i>
                                                        مدیریت جاذبه
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{Route('citizenPanel' , ['id' => $location['id']])}}" type="button" rel="tooltip" class="btn  btn-warning btn-simple">
                                                        <i class="material-icons">perm_contact_calendar</i>
                                                        پنل شهروندی
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="togglebutton">
                                                        <label>
                                                            <input data-location="{{$location['id']}}" name="QRActivation" @if($location['has_QR']) checked="" @endif type="checkbox">
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="togglebutton">
                                                        <label>
                                                            <input data-location="{{$location['id']}}" name="PosPrintActivation" @if($location['print_pos']) checked="" @endif type="checkbox" >
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="togglebutton">
                                                        <label>
                                                            <input name="Locationactivation" data-location="{{$location['id']}}"  @if($location['activation']) checked="" @endif type="checkbox" >
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button style="width: 110px" data-toggle="modal" data-target="#Edit{{$i}}" type="button" rel="tooltip" class="btn  btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <div class="modal fade" id="Edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <form method="post" action="{{Route('EditLocation' , ['id'=> $location['id']] )}}">
                                                                @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title " id="EditLabel"> ویرایش مکان </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-row mt-2 justify-content-center align-items-center">
                                                                        <div class="col-md text-right">
                                                                            <label for=""> نام  مکان  </label>
                                                                            <input value="{{$location['location_name']}}" name="location_name" type="text" class="form-control" id="nameStateFa" placeholder="نام  مکان">
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for=""> نام  انگلیسی مکان </label>
                                                                            <input value="{{$location['location_english_name']}}" name="location_english_name" type="text" class="form-control" id="nameStateFa" placeholder="نام  انگلیسی مکان">
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for=""> شناسه مکان </label>
                                                                            <input {{--value="{{$location['location_english_name']}}"--}} type="text" class="form-control" id="nameStateFa" placeholder="شناسه مکان">
                                                                        </div>
                                                                        <div class="col-md">
                                                                            <div class="togglebutton text-right">
                                                                                <label dir="ltr">
                                                                                    <input name="mandatory_entrance" type="checkbox" @if('mandatory_entrance') checked="" @endif>
                                                                                    <span class="toggle"></span>
                                                                                    ورودی اجباری
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                       {{-- <div class="col-md">
                                                                            <select class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                                                <option disabled selected> انتخاب استان </option>
                                                                                @foreach($province as $item )
                                                                                    <option value="{{$item['id']}}"> {{$item['province_name']}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md">
                                                                            <select class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                                                <option disabled selected> انتخاب شهر </option>

                                                                            </select>
                                                                        </div>--}}
                                                                        <div class="col-md text-right">
                                                                            <label for=""> انتخاب متن </label>
                                                                            <select name="text_id" class="selectpicker changeText" data-style="btn btn-primary border-dark" title="Single Select">
                                                                                @foreach($GetVoucherText as $text)
                                                                                    @if( $location['text']['id'] == $text['id'])
                                                                                        <option selected value="{{$text['id']}}"> {{$text['top_text']}}</option>
                                                                                    @else
                                                                                        <option value="{{$text['id']}}"> {{$text['top_text']}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> آدرس </label>
                                                                            <textarea style="height: 64px !important;" class="form-control" name="location_address" id="" cols="30" rows="3">{{$location['location_address']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  آدرس به انگلیسی </label>
                                                                            <textarea  style="height: 64px !important;" class="form-control" name="location_english_address" id="" cols="30" rows="3">{{$location['location_english_address']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2 texts">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> متن فارسی بالای بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control persian_top_text" name="" cols="30" rows="3">{{$location['text']['top_text']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  متن فارسی پایین بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control persian_bottom_text" name="" id="" cols="30" rows="3">{{$location['text']['bottom_text']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> متن انگلیسی بالای بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control english_top_text" name="" id="" cols="30" rows="3">{{$location['text']['english_top_text']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  متن انگلیسی پایین بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control english_bottom_text" name="" id="" cols="30" rows="3">{{$location['text']['english_bottom_text']}}</textarea>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer mt-4">
                                                                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                    <button  type="submit" class="btn btn-success px-5 ml-0 mr-auto"> ویرایش  </button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <form action="{{Route('DeleteLocation' , ['id'=> $location['id']])}}" method="post">
                                                        @csrf
                                                        <button style="width: 110px" type="submit" rel="tooltip" class="btn  btn-danger btn-simple">
                                                            <i class="material-icons">close</i>
                                                            حذف
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="testLabel"> افزودن مکان جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{Route('AddLocation')}}" method="post">
                @csrf
            <div class="modal-body">
                <div class="form-row mt-2 justify-content-center align-items-center">
                    <div class="col-md text-right">
                        <label for=""> نام مکان </label>
                        <input type="text" name="location_name" class="form-control" id="nameStateFa" placeholder="نام  مکان">
                    </div>
                    <div class="col-md text-right">
                        <label for=""> نام  انگلیسی مکان </label>
                        <input type="text" name="location_english_name" class="form-control" id="nameStateFa" placeholder="نام  انگلیسی مکان">
                    </div>
                    <div class="col-md text-right">
                        <label for=""> شناسه مکان </label>
                        <input name="officeNo" type="text" class="form-control" id="nameStateFa" placeholder="شناسه مکان">
                    </div>
                    <div class="col-md">
                        <div class="togglebutton text-right">
                            <label dir="ltr">
                                <input name="mandatory_entrance" type="checkbox" checked="" >
                                <span class="toggle"></span>
                                ورودی اجباری
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md text-right">
                        <label for=""> انتخاب استان </label>
                            <select id="province" name="province_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option disabled selected> انتخاب استان </option>
                                @foreach($province as $item )
                                    <option value="{{$item['id']}}"> {{$item['province_name']}}</option>
                                @endforeach
                            </select>
                </div>
                    <div class="col-md text-right">
                        <label for=""> انتخاب شهر </label>
                        <select id="cityList" name="city_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                            <option disabled selected> انتخاب شهر </option>
                            <option value="1">شیراز</option>
                        </select>
                    </div>
                    <div class="col-md text-right">
                        <label for=""> انتخاب متن </label>
                        <select id="voucherText" name="text_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                            <option disabled selected> انتخاب متن </option>
                            @foreach($GetVoucherText as $text)
                                <option value="{{$text['id']}}"> {{$text['top_text']}}</option>
                            @endforeach
                           {{-- <option value="3">تست</option>
                            <option value="5">سال رونق تولید مبارک</option>
                            <option value="1">سال جهش تولید</option>
                            <option value="4">ستاد گردشگری شهرداری تهران</option>
                            <option value="6">فرهیخته گرامی،ارزش رسمی بلیت ورودی 50 هزار ریال است که به دلیل نگرش واقف در خدمت رسانی نیک اندیشانه،از شهروندان 20 هزار ریال دریافت می گردد.</option>
                        --}}
                        </select>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md text-right">
                        <label for="" class="text-right"> آدرس </label>
                        <textarea name="location_address" style="height: 64px !important;" class="form-control"  id="" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md text-right">
                        <label for="" class="text-right">  آدرس به انگلیسی </label>
                        <textarea style="height: 64px !important;" class="form-control" name="location_english_address" id="" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-row mt-2">

                </div>
                <div class="form-row mt-2">
                    <div class="col-md text-right">
                        <label for="" class="text-right"> متن فارسی بالای بلیت </label>
                        <textarea id="top_text_persian" disabled  style="height: 64px !important;" class="form-control" name=""  cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md text-right">
                        <label for="" class="text-right">  متن فارسی پایین بلیت </label>
                        <textarea id="bottom_text_persian" disabled style="height: 64px !important;" class="form-control" name="" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md text-right">
                        <label for="" class="text-right"> متن انگلیسی بالای بلیت </label>
                        <textarea id="top_text_english" disabled style="height: 64px !important;" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md text-right">
                        <label for="" class="text-right">  متن انگلیسی پایین بلیت </label>
                        <textarea id="bottom_text_english" disabled  style="height: 64px !important;" class="form-control" cols="30" rows="3"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer mt-4">
                {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> افزودن </button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let top_text ,bottom_text, english_top_text, english_bottom_text  ;
            $('.changeText').change(function () {
                let element = $(this);
                var voucherText = element.val();
                console.log(element);
                $.ajax({
                    type:'POST',
                    url:"{{Route('GetVoucherTextLoc')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'id' : voucherText ,
                    },
                    success:function(data) {
                        let key = data["array_keys"][0];
                        let data_content = data["GetText"][key];
                        // element.parent().parent().parent().find(".persian_bottom_text").text("");
                        if(data_content != null){
                            top_text = data_content.top_text ;
                            bottom_text = data_content.bottom_text ;
                            english_top_text = data_content.english_top_text ;
                            english_bottom_text = data_content.english_bottom_text ;
                        }
                        // element.parent().parent().parent().find(".persian_top_text").text("awdaowidj");
                        element.parent().parent().parent().find(".persian_top_text").text(top_text);
                        element.parent().parent().parent().find(".persian_bottom_text").text(bottom_text);
                        element.parent().parent().parent().find(".english_top_text").text(english_top_text);
                        element.parent().parent().parent().find(".english_bottom_text").text(english_bottom_text);
                        /*.find("persian_top_text").text()*/
                        /*
                        $("#top_text_persian").text(data_content.top_text);
                        $("#bottom_text_persian").text(data_content.bottom_text);
                        $("#top_text_english").text(data_content.english_top_text);
                        $("#bottom_text_english").text(data_content.english_bottom_text);
*/
                    }
                });
            });

            $('#province').change(function () {
                console.log("ok");
                var province_id = $('#province').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
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
            $('#voucherText').change(function () {
                    var voucherText = $('#voucherText').val();
                    $.ajax({
                        type:'POST',
                        url:"{{Route('GetVoucherTextLoc')}}",
                        dataType:'json',
                        data:{
                            '_token ': '<?php echo csrf_token() ?>',
                            'id' : voucherText ,
                        },
                        success:function(data) {
                            let key = data["array_keys"][0];
                            let data_content = data["GetText"][key];

                           $("#top_text_persian").text(data_content.top_text);
                            $("#bottom_text_persian").text(data_content.bottom_text);
                            $("#top_text_english").text(data_content.english_top_text);
                            $("#bottom_text_english").text(data_content.english_bottom_text);

                        }
                    });
                });

            $('#province_filter').change(function () {
                var province_id = $('#province_filter').val();
                $('#loader').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                    },
                    success:function(data) {
                        $("#cityList_filter").html('');
                        $("#cityList_filter").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i < data.data.length ; i++){
                            $("#cityList_filter").append(new Option( data.data[i].city_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                        $('#loader').hide();
                    }
                });
            });

            $('input[name=Locationactivation]').change(function () {
                var location =$(this).attr('data-location') ;
                var value = ($(this).is(':checked'));
                $('input[name=Locationactivation]')
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
                            url:"{{Route('LocationActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'location' : location ,
                                'value' : value ,
                            },
                            success:function(data) {
                                $('#loader').hide();
                                Swal.fire(
                                    'تغییر مورد نظر اعمال گردید',
                                    '',
                                    'success'
                                )
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
            $('input[name=PosPrintActivation]').change(function () {
                var location =$(this).attr('data-location') ;
                var value = ($(this).is(':checked'));
                // alert(location);
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
                            url:"{{Route('PosPrintActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'location' : location ,
                                'value' : value ,
                            },
                            success:function(data) {
                                $('#loader').hide();
                                Swal.fire(
                                    'تغییر مورد نظر اعمال گردید',
                                    '',
                                    'success'
                                )
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
            $('input[name=QRActivation]').change(function () {
                var location =$(this).attr('data-location') ;
                var value = ($(this).is(':checked'));
                // alert(location);
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
                            url:"{{Route('QRActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'location' : location ,
                                'value' : value ,
                            },
                            success:function(data) {
                                $('#loader').hide();
                                Swal.fire(
                                    'تغییر مورد نظر اعمال گردید',
                                    '',
                                    'success'
                                )
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
