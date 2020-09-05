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
    </style>
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
                                    <a onclick="history.go(-1);" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                            مدیریت بلیت ها
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
                                            <td colspan="8" >
                                                <h6 class="py-5">
                                                    جاذبه ای یافت نشد .
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
                                                    <a href="{{ Route('VoucherInfoList' , ['service_id' => $GetServices[$array_keys[$i]]['service_id'] , 'location_id' => $GetServices[$array_keys[$i]]['location_id'] ])}}" rel="tooltip" class="btn  btn-info btn-simple">
                                                        <i class="material-icons">location_city</i>
                                                        مدیریت بلیت ها
                                                    </a>
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
                                                                            <input value="{{ $GetServices[$array_keys[$i]]['service_name'] }}" name="service_name" type="text" class="form-control" id="nameStateFa" placeholder="نام جاذبه">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  نام انگلیسی جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['english_name']}}" name="service_english_name" type="text" class="form-control" id="nameStateFa" placeholder="نام انگلیسی جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  ظرفیت جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['capacity']}}" name="capacity" type="text" class="form-control" id="nameStateEn" placeholder=" ظرفیت جاذبه (نامحدود = خالی) ">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  عکس جاذبه </label>
                                                                            <input type="file" class="form-control" id="nameStateEn" placeholder=" عکس جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for=""> توضیحات </label>
                                                                            <textarea style="height: 64px !important;" class="form-control" name="description" id="" cols="30" rows="3"> {{$GetServices[$array_keys[$i]]['description']}}</textarea>
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
                                                                        <div class="col-sm text-right">
                                                                            <div class="togglebutton text-center">
                                                                                <label dir="ltr">
                                                                                    <input name="normal_sale" type="checkbox" @if($GetServices[$array_keys[$i]]['normal_sale']) checked @endif>
                                                                                    <span class="toggle"></span>
                                                                                    شامل سانس
                                                                                </label>
                                                                            </div>
                                                                        </div>
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
                                                        <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
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
                            <input name="service_name" type="text" class="form-control" id="nameStateFa" placeholder="نام جاذبه">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  نام انگلیسی جاذبه </label>
                            <input name="service_english_name" type="text" class="form-control" id="nameStateFa" placeholder="نام انگلیسی جاذبه">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <label for="">  ظرفیت جاذبه </label>
                            <input name="capacity" type="text" class="form-control" id="nameStateEn" placeholder=" ظرفیت جاذبه (نامحدود = خالی) ">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  عکس جاذبه </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                    </div>
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <label for=""> توضیحات </label>
                            <textarea name="description" style="height: 64px !important;" class="form-control" name="location_address" id="" cols="30" rows="3"></textarea>
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
                        <div class="col-sm text-right">
                            <div class="togglebutton text-center">
                                <label dir="ltr">
                                    <input name="normal_sale" type="checkbox">
                                    <span class="toggle"></span>
                                    شامل سانس
                                </label>
                            </div>
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
            $('input[name=activation]').change(function () {
                var service =$(this).attr('data-service') ;
                var value = ($(this).is(':checked'));
                $('#loader').css('display' , 'flex');
              $.ajax({
                    type:'POST',
                    url:"{{Route('ServiceActivation')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'service' : service ,
                        'value' : value ,
                    },
                    success:function(data) {
                        $('#loader').hide();
                       /* if(data.data)
                            alert('true');
                        else
                            alert('false')*/
                    }
                });
            });

        });
    </script>
@endsection
