@extends('MainLayout')

@section('title')
    <title>
        سانس های فعال
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .sanasCard{
            color: #3C4858 !important;
            font-size: 14pt;
            font-weight: 400;
        }
        .card-category {
            font-weight: 400;
        }
        .nav-pills > li{
            margin-top : 10px;
        }
        .nav-link {
            font-weight: 400 !important;
        }
        .nav-pills .nav-item .nav-link{
            border-radius: 0 !important;
        }
        .subTable{
            width: 98%;
            margin-right: 3%;
        }
        .subRow{
            display: none;
            position: relative;
        }
        .text-yellow {
            color : #ffcf3f !important;
        }
        .card-pricing .card-icon i {
            font-size: 38px !important;
            border: 1px solid #E5E5E5;
            border-radius: 50%;
            width: 80px !important;
            line-height: 80px !important;
            height: 80px !important;
            color: #3C4858;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/seance.css') }}">

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
    <div class="modal fade" id="location_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >انتخاب مکان</h5>
                </div>
                <div class="modal-body">
                    <table class=" table table-striped " style="text-align: right" id="modal_data">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">format_size</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> سانس هاي فعال </h4>
                                </div>
                                <div class="col-sm">
                                    {{-- <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> جدید </span>--}}
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        @php
                            $activeProvince = null ;
                        @endphp
                        @if(count($GetServiceListFromServicetime) == 0 )
                            <div class="card-body">
                                <div class="row">

                                    <div style="overflow: auto;height: 40vh;color: #999;" class="col-md-12 d-flex justify-content-center align-items-center bg-light">
                                        <h6 class="text-center ">
                                            <i style="font-size: 76pt;color: #ccc;" class="fad mb-3 fa-info-circle"></i>
                                            <br>
                                            سانس فعالی یافت نشد !
                                        </h6>
                                    </div>
                                </div>

                            </div>
                            @else
                            <div class="card-body">
                                <div class="row">
                                    <div style="overflow: auto ; height: 60vh ;" class="col-md-3 border-left">
                                        <ul id="tablist" class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                                            @php
                                                $i = 0  ;
                                            @endphp
                                            @foreach($GetServiceListFromServicetime as $Province)
                                                @php
                                                if($i==0){
                                                    $activeProvince = $Province["province_id"] ;
                                                }
                                                @endphp
                                                <li class="nav-item border rounded ml-0">
                                                    <a province_id="{{$Province["province_id"]}}" class="nav-link province @if($i == 0) active show @endif" data-toggle="tab" href="#link4" role="tablist"> {{$Province['province_name']}}</a>
                                                </li>
                                                @php
                                                    $i++ ;
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div style="overflow: auto ; height: 60vh ;" class="col-md-9">
                                        <div class="tab-content text-right">
                                            <div class="tab-pane active show" style="overflow: auto ; overflow-x: hidden" id="link4">
                                                <div class="row" id="sansArea">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-icon card-header-rose titleStyle">
                        <div class="row">
                            <div class="col-sm">
                                <div class="card-icon float-right ml-3 mr-0">
                                    <i class="material-icons"> watch_later </i>
                                </div>
                                <h4 class="card-title text-right font-weight-bold ">     سانس های فعال </h4>
                            </div>
                            <div class="col-sm">
                                <a href="{{ route('add_group_time_index') }}"  class="btn btn-success mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> سانس جدید </a>
                                <a href="{{Route("dashboard")}}" class="btn btn-dark mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($GetServiceListFromServicetime as $ServiceList)
                        <div class="col-lg-3">
                            <div class="card card-pricing bg-light"><div class="card-body ">
                                    <div class="card-icon">
                                        <i class="material-icons">event_note</i>
                                    </div>
                                    <h3 style="" class="sanasCard card-title "> {{$ServiceList["service_name"]}} </h3>
                                    <h6 style=" color: #898585 !important;" class="card-category"> {{$ServiceList["location_name"]}} </h6>
                                    <a data-toggle="modal" data-target="#showSanas" href="{{Route("add_group_time_index" , ["service_id" => $ServiceList["service_id"] , "location_id" => $ServiceList["location_id"] ,  ] )}}" class="btn btn-info btn-round "> مشاهده</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons"> watch_later </i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">     مدیریت سانس ها </h4>
                                </div>
                                <div class="col-sm">
                                    <a href="{{ route('add_group_time_index') }}"  class="btn btn-success mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> سانس جدید </a>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="container-fluid table-responsive" >
                                    @php
                                    $i = 0 ;
                                    @endphp
                                    @if(count($result_data) <=0)
                                        <h6 class="text-center py-5">
                                            موردی یافت نشد !
                                        </h6>
                                    @else
                                        @foreach( $result_data as $item)

                                            <div class="card card-2" style="width: 100%;height: auto;padding: 20px;text-align: right;background: #f7f7f7">
                                                <div class="form-row align-items-center">
                                                    <div class="col-md">
                                                        <h5 class="font-weight-bold my-0">{{$item['group_name']}}</h5>
                                                    </div>
                                                    <div class="col-md text-left">
                                                        <a class="pull-right" onclick="edit_group({{ $item['time_group_id'] }})" ><button class="btn btn-danger ">ویرایش</button></a>
                                                    </div>
                                                </div>
                                                <div id="div_all_locations_{{ $item['time_group_id'] }}">
                                                </div>

                                                @php
                                                    $i++ ;
                                                @endphp
                                                <div style="margin-top: 30px">
                                                    <button class="btn btn-primary" onclick="open_location_modal({{ $item['time_group_id'] }})"><i class="fa fa-plus"></i> مکان جدید </button>
                                                    <button class="btn btn-success" onclick="save_send('{{ $item['time_group_id'] }}','{{ $item['group_name'] }}')"><i class="fa fa-save"></i> ذخیره </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>

                                <form method="post" id="form" enctype="multipart/form-data" action="/apply_edit_group_time">
                                    @csrf
                                    <input type="hidden" name="service_times" id="data_form" />
                                </form>
                                <form action="{{ route('edit_group_time') }}" method="post" id="edit" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="edit_info_ids" name="voucher_info_ids">
                                    <input type="hidden" id="edit_group_times" name="group_times">
                                    <input type="hidden" id="edit_group_name" name="group_name">
                                    <input type="hidden" id="edit_group_id" name="group_id">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
            <div class="modal fade" id="showSanas" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form method="post" action="">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="testLabel"> سانس ها  </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped text-center">
                                    <thead class="text-primary">
                                    <tr>
                                        <th>
                                            سانس
                                        </th>
                                        <th>
                                            تاریخ
                                        </th>
                                        <th>
                                            زمان شروع
                                        </th>
                                        <th>
                                            زمان پایان
                                        </th>
                                        <th>
                                            شماره بلیت
                                        </th>
                                        <th>
                                            ويرايش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                           شماره یک
                                        </td>
                                        <td>
                                           1399/01/01
                                        </td>
                                        <td>
                                            9:00
                                        </td>
                                        <td>
                                            10:00
                                        </td>
                                        <td>
                                           23
                                        </td>
                                        <td>
                                           <button class="btn btn-danger">
                                               حذف
                                           </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                                <button data-toggle="modal" data-target="#sanas" type="button" class="btn px-5 btn-success ml-0 mr-auto"> افزودن سانس هاي ديگر مکان ها </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal fade" id="sanas" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="testLabel"> افزودن سانس مکان  </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped ">
                                    <thead class="text-primary">
                                    <tr>
                                        <th class="text-right">
                                            نام مکان
                                        </th>
                                        <th>
                                        -
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-right">
                                            شماره یک
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">
                                            شماره دو
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">
                                            شماره سه
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                                <button type="button" class="btn px-5 btn-success ml-0 mr-auto"> اعمال </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
</div>
@endsection
@section('AddJs')
        <script>
            let sans = @json($GetServiceListFromServicetime);
            let activeProvince = $("#tablist").find("a").first();
            let province_id_active = activeProvince.attr("province_id")
            let wasActive = "{{ ( is_null(request("province"))) ?  $activeProvince  : request("province")}}"
            $(".province").removeClass("active");
            $(".province[province_id=" + wasActive + "]").addClass("active");
            $('#pro_list').animate({
                scrollTop: $(".province[province_id=" + wasActive + "]").offset().top - 250 ,
            }, 1000);
            GetSansProvince(wasActive);

            $(".province").click(function () {
                let province_id = $(this).attr("province_id") ;
                GetSansProvince(province_id);
            });

            function GetSansProvince(id){
                let province_id = id ;
                global_provive_id = id ;
                $("#sansArea").html("");
                $("#loader").css("display" , "flex");
                let result ;
                result= sans.filter(d => d.province_id == province_id ) ;
                let html ;
                let url = "";
                for(let j = 0 ; j < result.length ; j++ )
                {
                    let services = result[j].services ;
                    for(let i = 0 ; i < services.length ; i++ )
                    {
                    url = "{{Route("add_group_time_index")}}/" + services[i].service_id +"/" + services[i].location_id ;
                    html = '<div class="col-md-3">\n' +
                        '                    <div class="card mt-1 card-pricing bg-light"><div class="card-body ">\n' +
                        '                    <div class="card-icon">\n' +
                        '                    <i class="material-icons">event_note</i>\n' +
                        '                    </div>\n' +
                        '                    <h3 style="" class="sanasCard card-title "> ' + services[i].service_name + ' </h3>\n' +
                        '                    <h6 style=" color: #898585 !important;" class="card-category"> ' + services[i].location_name + '  </h6>\n' +
                        '                    <a href="'+ url +'" class="btn btn-info btn-sm btn-round "> مشاهده</a>\n' +
                        '                    </div>\n' +
                        '                    </div>\n' +
                        '                    </div>' ;
                    $("#sansArea").append(html);
                    }
                }
                $("#loader").hide();
            }
        </script>
@endsection

