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
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
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
                                <form  class="form-row mt-3" action="{{Route("getLocationFilter")}}" method="get">
                                    <div class="col-md">
                                        <select name="project_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                            <option disabled > انتخاب پروژه </option>
                                            @foreach($GetProjectList as $GetProject)
                                                @if($GetProject['project_id'] == 1 || $GetProject["project_id"] == request("project_id") )
                                                    <option selected value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                                @else
                                                    <option value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select name="province_id" id="province_filter" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب استان">
                                            <option value="" >همه</option>
                                            @foreach($province as $item )
                                                @if(request('province_id') ==  $item['id'])
                                                    <option selected value="{{$item['id']}}"> {{$item['province_name']}}</option>
                                                @else
                                                    <option value="{{$item['id']}}"> {{$item['province_name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select name="city_id" id="cityList_filter" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب شهر">

                                            @if(is_null($city_id_list))
                                                <option selected value=""> همه </option>
                                                @else
                                                <option @if(is_null(request("city_id"))) selected @endif value=""> همه </option>
                                                @foreach($city_id_list as $city_id)
                                                    <option @if($city_id["id"] == request("city_id")) selected @endif  value="{{$city_id["id"]}}"> {{$city_id["city_name"]}} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-auto ml-auto">
                                        <button type="submit" class="btn bgPer"> فیلتر </button>
                                    </div>
                                </form>
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
                                            تخفیف
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
                                            <td colspan="9">
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
                                                    <button data-url="{{Route("AddLocationOff" , [$location['id']])}}" type="button" data-target="#add_off" data-toggle="modal" rel="tooltip" class="btn off_btn btn-primary btn-simple">
                                                        <i class="material-icons">local_offer</i>
                                                        تخفیف
                                                    </button>
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
                                                                      {{--  <div class="col-md text-right">
                                                                            <label for=""> انتخاب پروژه </label>
                                                                            <select id="project_id" name="project_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                                                <option disabled > انتخاب پروژه </option>
                                                                                @foreach($GetProjectList as $GetProject)
                                                                                    @if($GetProject['project_id'] == 1 )
                                                                                        <option selected value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                                                                    @else
                                                                                        <option value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                                                                    @endif

                                                                                @endforeach
                                                                            </select>
                                                                        </div>--}}
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                        <div class="col-md text-right">
                                                                            <label for=""> طول جغرافیایی </label>
                                                                            <input name="longitude" type="text" value="{{$location['longitude']}}" class="form-control" placeholder="طول جغرافیایی">
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for=""> عرض جغرافیایی </label>
                                                                            <input name="latitude" type="text" value="{{$location['latitude']}}" class="form-control"  placeholder="عرض جغرافیایی">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> آدرس </label>
                                                                            <textarea style="height: 64px !important;" class="form-control" name="location_address" cols="30" rows="3">{{$location['location_address']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  آدرس به انگلیسی </label>
                                                                            <textarea  style="height: 64px !important;" class="form-control" name="location_english_address" cols="30" rows="3">{{$location['location_english_address']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2 texts">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> متن فارسی بالای بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control persian_top_text" name="" cols="30" rows="3">{{$location['text']['top_text']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  متن فارسی پایین بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control persian_bottom_text" name="" cols="30" rows="3">{{$location['text']['bottom_text']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-2">
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right"> متن انگلیسی بالای بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control english_top_text" name=""  cols="30" rows="3">{{$location['text']['english_top_text']}}</textarea>
                                                                        </div>
                                                                        <div class="col-md text-right">
                                                                            <label for="" class="text-right">  متن انگلیسی پایین بلیت </label>
                                                                            <textarea disabled style="height: 64px !important;" class="form-control english_bottom_text" name="" cols="30" rows="3">{{$location['text']['english_bottom_text']}}</textarea>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer mt-4">
                                                                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                    <button  type="submit" class="btn btn-success px-5 ml-0 mr-auto form_submit"> ویرایش  </button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <form id="DeleteLocationFrom" action="{{Route('DeleteLocation' , ['id'=> $location['id']])}}" method="post">
                                                        @csrf
                                                        <button  id="DeleteLocationBtn" style="width: 110px" type="submit" class="btn  btn-danger btn-simple">
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
                    @if(env("HAS_OFFICE_NO"))
                    <div class="col-md text-right">
                        <label for=""> شناسه مکان </label>
                        <input name="officeNo" type="text" class="form-control" id="nameStateFa" placeholder="شناسه مکان">
                    </div>
                    @endif
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
                        <label for=""> انتخاب پروژه </label>
                        <select id="project_id" name="project_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                            <option disabled > انتخاب پروژه </option>
                            @foreach($GetProjectList as $GetProject)
                                @if($GetProject['project_id'] == 1 )
                                    <option selected value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                @else
                                    <option value="{{$GetProject['project_id']}}"> {{$GetProject['project_name']}}</option>
                                @endif

                            @endforeach
                            {{-- <option value="3">تست</option>
                             <option value="5">سال رونق تولید مبارک</option>
                             <option value="1">سال جهش تولید</option>
                             <option value="4">ستاد گردشگری شهرداری تهران</option>
                             <option value="6">فرهیخته گرامی،ارزش رسمی بلیت ورودی 50 هزار ریال است که به دلیل نگرش واقف در خدمت رسانی نیک اندیشانه،از شهروندان 20 هزار ریال دریافت می گردد.</option>
                         --}}
                        </select>
                    </div>
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

                </div>
                <div class="form-row mt-2">
                    <div class="col-md text-right">
                        <label for=""> طول جغرافیایی </label>
                        <input name="longitude" type="text" class="form-control" placeholder="طول جغرافیایی">
                    </div>
                    <div class="col-md text-right">
                        <label for=""> عرض جغرافیایی </label>
                        <input name="latitude" type="text" class="form-control"  placeholder="عرض جغرافیایی">
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
    <script src="{{asset('')}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/plugins/sweetalert2.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
            $(document).on(  "click" ,  ".off_btn"  , function () {
                let url = $(this).attr("data-url");
                $("#add_off_form").attr("action" , url)
            });

            $(document).on("click" , "#DeleteLocationBtn" , function (e) {
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
                        $("#DeleteLocationFrom").submit();
                    }else
                        e.preventDefault();
                })
            })

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

            let pro_id = "{{request('province_id')}} ";
            let city_id = "{{request('city_id')}} ";
/*
            if(pro_id != ''){
                var province_id = pro_id;
                // $('#loader').css('display' , 'flex');

                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
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
                        $("#cityList_filter").html('');
                        $("#cityList_filter").append(new Option( 'همه' , '',true));

                        console.log("pro_id => "  , city_id )

                        for(var i = 0 ; i < data.data.length ; i++){
                            console.log("data.data[i].id =>" , data.data[i].id)
                            if (data.data[i].id == city_id){
                                $("#cityList_filter").find("option").attr('selected' , false);
                                $("#cityList_filter").append(new Option( data.data[i].city_name , data.data[i].id , true));
                            }else
                                $("#cityList_filter").append(new Option( data.data[i].city_name , data.data[i].id));
                        }

                        // $('#loader').hide();
                        $('.selectpicker').selectpicker('refresh');
                    }

                });
            }*/

            $('#province').change(function () {
                var province_id = $('#province').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
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
                // $('#loader').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
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
                                if(data.data)
                                {
                                    Swal.fire(
                                        'تغییر مورد نظر اعمال گردید',
                                        '',
                                        'success'
                                    )
                                }
                                else if (data.data == "Permission Denied") {
                                    Swal.fire(
                                        'شما مجاز به انجام اين عمليات نمي باشيد ',
                                        '',
                                        'warning'
                                    )
                                }else
                                {
                                    Swal.fire(
                                        'خطا در اعمال تغيير ',
                                        '',
                                        'error'
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
            $(".form_submit").click(function (e) {
                e.preventDefault();
                let element = $(this).parent().parent();
                let location_name =  $(this).parent().parent().find('input[name=location_name]').val();
                let location_english_name =  $(this).parent().parent().find('input[name=location_english_name]').val();
                let location_address = $(this).parent().parent().find('textarea[name=location_address]').val();
                let location_english_address =  $(this).parent().parent().find('textarea[name=location_english_address]').val();
                if (location_name.length  == 0 ) {
                    swal({ title:"خطا!", text: "لطفا فیلد نام مکان را پر نمایید . ", buttonsStyling: false, confirmButtonClass: "btn btn-success"})
                }else if(location_english_name.length  == 0){
                    swal({ title:"خطا!", text: "لطفا فیلد نام انگلیسی مکان را پر نمایید . ", buttonsStyling: false, confirmButtonClass: "btn btn-success"})
                }
                else if ( location_address.length  == 0){
                    swal({ title:"خطا!", text: "لطفا فیلد آدرس را پر نمایید . ", buttonsStyling: false, confirmButtonClass: "btn btn-success"})
                }
                else if (location_english_address.length  == 0){
                    swal({ title:"خطا!", text: "لطفا فیلد آدرس به انگلیسی را پر نمایید . ", buttonsStyling: false, confirmButtonClass: "btn btn-success"})
                }
                else
                    $(this).parent().parent().parent().submit();
            });
        });
    </script>
@endsection
