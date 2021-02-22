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
                        <div class="card-body">
                            <div class="row">
                                <div style="overflow: auto ; height: 60vh ;" class="col-md-3 border-left">
                                    <ul id="tablist" class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                                        @php
                                            $i = 0  ;
                                        @endphp
                                        @foreach($GetServiceListFromServicetime as $Province)
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
@endsection
@section('AddJs')
        <script>
            let sans = @json($GetServiceListFromServicetime);
            let activeProvince = $("#tablist").find("a").first();
            let wasActive = activeProvince.attr("province_id")
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
                    html = '<div class="col-md-4">\n' +
                        '                    <div class="card card-pricing bg-light"><div class="card-body ">\n' +
                        '                    <div class="card-icon">\n' +
                        '                    <i class="material-icons">event_note</i>\n' +
                        '                    </div>\n' +
                        '                    <h3 style="" class="sanasCard card-title "> ' + services[i].service_name + ' </h3>\n' +
                        '                    <h6 style=" color: #898585 !important;" class="card-category"> ' + services[i].location_name + '  </h6>\n' +
                        '                    <a href="'+ url +'" class="btn btn-info btn-round "> مشاهده</a>\n' +
                        '                    </div>\n' +
                        '                    </div>\n' +
                        '                    </div>' ;
                    $("#sansArea").append(html);
                    }
                }
                $("#loader").hide();


            }

        </script>
{{--    <script>

        let tagsToReplace = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;'
        };

        function replaceTag(tag) {
            return tagsToReplace[tag] || tag;
        }

        function safe_escape(str) {
            return str.replace(/[&<>]/g, replaceTag);
        }


        let locations = JSON.parse('@json($locations)');
        for (let i =0 ; i<locations.length;i++){
            let obj = locations[i];
            let id = obj['id'];
            let name = obj['name'];

            $("#modal_data").append('<tr>' +
                '<td style="cursor: pointer" onclick="select_location('+id+','+"'"+name+"'"+')">'+name+'</td>' +
                '</tr>');
        }


        var group_id=-1;

        function open_location_modal(id){
            group_id = id;
            $('#location_modal').modal('show');

        }

        function select_location(location_id,location_name) {

            //structure => div_location_groupId_locationId_serviceId_voucherInfoId

            //console.log(location_id);
            $('#location_modal').modal('hide');

            // check if location not exists
            if(!$('#div_location_'+group_id+'_'+location_id).length) {
                $('#div_all_locations_' + group_id).append('<div class="location" id="div_location_' + group_id + '_' + location_id + '" >' + '<div style="font-size: 17px"> ' + location_name + '</div>' + '</div>');


                let services = get_service(location_id);
                for (let i = 0; i < services.length; i++) {
                    let service = services[i];
                    let service_name = service['service_name'];
                    let service_id = service['service_id'];
                    //console.log(service_name + ":" + service_id);
                    $('#div_location_' + group_id + '_' + location_id).append(
                        '<div  class="service" id="div_service_' + group_id + '_' + location_id + '_' + service_id + '">' +
                        '<div style="font-size:15px">' +
                        '<span id="name_service_' + group_id + '_' + location_id + '_' + service_id + '">' + service_name + '</span>' +
                        '<input class="capacity" id="capacity_service_' + group_id + '_' + location_id + '_' + service_id + '" placeholder="ظرفیت" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\\..*)\\./g, \'$1\');" />' +
                        '</div>' +
                        '</div>');

                    let type_amounts = service['type_amounts'];
                    for (let j = 0; j < type_amounts.length; j++) {
                        let type_amount = type_amounts[j];

                        let type_name = type_amount['voucher_type'];
                        let info_id = type_amount['voucherinfo_id'];

                        $('#div_service_' + group_id + '_' + location_id + '_' + service_id).append(
                            '<div  class="voucher_info" style="float: right;padding-right: 25px;margin-top: 10px" id="div_info_' + group_id + '_' + location_id + '_' + service_id + '_' + info_id + '">' +
                            '<input type="checkbox" value="-1"  id="chk_info_' + group_id + '_' + location_id + '_' + service_id + '_' + info_id + '">' +
                            '<span style="font-size:14px"> ' + type_name + ' </span>' +
                            '</div>'
                        );


                    }

                }
            }


        }


        function get_service(location_id) {
            for (let i =0 ; i<locations.length;i++){
                let obj = locations[i];
                let id = obj['id'];
                if (id==location_id){
                    return obj['services'];
                }
            }

        }


        function save_send(gpId,gpName) {
            let service_times=[];
            let data_remove=[];
            $("div[id^='div_service_"+gpId+"']").each(function () {
                let id = this.id.split("_");
                let location_id = id[3];
                let service_id = id[4];

                let name = $("#name_service_"+gpId+"_"+location_id+"_"+service_id).text();
                let capacity = $("#capacity_service_"+gpId+"_"+location_id+"_"+service_id).val();
                if(capacity=='')
                    capacity = -1;
                else
                    capacity = parseInt(capacity);

                let voucher_info_ids=[];

                $("input[id^='chk_info_"+gpId+"_"+location_id+"_"+service_id+"']").each(function () {

                    let info_id = parseInt(this.id.split("_")[5]);

                    if(this.checked ){
                        voucher_info_ids.push(info_id);
                    }else if(!this.checked && this.value != -1){
                        let rm = get_delete(location_id,service_id,info_id);
                        data_remove = data_remove.concat(rm);
                    }

                });

                if (voucher_info_ids.length>0)
                {

                    let item = {
                        'service_time_capacity':capacity,
                        'voucherinfo_ids':voucher_info_ids
                    };
                    service_times.push(item)

                }

            });





            let data = {
                'time_group_id':gpId,
                'time_group_name':gpName,
                'service_time_voucher_info':service_times,
                'add':[],
                'edit':[],
                'delete':data_remove
            };

            //console.log(JSON.stringify(send_data));
            $("#data_form").val(JSON.stringify(data));
            $('#form').submit();
        }


        let group_times = JSON.parse('@json($result_data)');

        function show(){

            for(let i=0; i<group_times.length;i++){

                let group_time = group_times[i];
                let templates = group_time['time_templates'];
                let group_id = group_time['time_group_id'];

                for(let j=0;j<templates.length;j++){
                    let template = templates[j];
                    let times = template['times'];

                    for(let k=0;k<times.length;k++){
                        let time = times[k];
                        let template_id = time['time_template_id'];
                        find_groups(group_id,template_id);
                    }

                }
            }

        }

        function find_groups(gp_id,template_id){

            // search on all locations
            for(let i=0;i<locations.length;i++){
                let location = locations[i];

                let location_id = location['id'];
                let location_name = location['name'];

                let services = location['services'];
                for (let j=0;j<services.length;j++){
                    let service = services[j];

                    let service_id = service['service_id'];
                    let service_name = service['service_name'];

                    let type_amounts = service['type_amounts'];
                    for(let k=0;k<type_amounts.length;k++){
                        let type_amount = type_amounts[k];

                        let info_id = type_amount['voucherinfo_id'];
                        let type_name = type_amount['voucher_type'];


                        let service_times = type_amount['service_times'];
                        for(let l=0;l<service_times.length;l++){
                            let service_time = service_times[l];
                            let times = service_time['times'];

                            for (let m=0;m<times.length;m++){
                                let time = times[m];

                                let service_time_id = time['service_time_id'];
                                let time_template_id = time['time_template_id'];

                                if(template_id == time_template_id){

                                    let capacity = time['capacity'];
                                    console.log(capacity);
                                    $('#capacity_service_'+gp_id+"_"+location_id+"_"+service_id).val(capacity);
                                    group_id=gp_id;
                                    select_location(location_id+"",location_name);
                                    $('#chk_info_'+gp_id+"_"+location_id+"_"+service_id+"_"+info_id).prop('checked', true);
                                    $('#chk_info_'+gp_id+"_"+location_id+"_"+service_id+"_"+info_id).val(service_time_id);

                                }
                            }
                        }
                    }
                }

            }
        }


        function get_delete(locationId,serviceId,infoId){
            let data =[];
            for(let i=0;i<locations.length;i++){
                let location = locations[i];

                let location_id = location['id'];
                if (location_id != locationId)
                    continue;

                let services = location['services'];
                for (let j=0;j<services.length;j++){
                    let service = services[j];

                    let service_id = service['service_id'];

                    if (service_id != serviceId)
                        continue;

                    let type_amounts = service['type_amounts'];
                    for(let k=0;k<type_amounts.length;k++){
                        let type_amount = type_amounts[k];

                        let info_id = type_amount['voucherinfo_id'];
                        if (info_id != infoId)
                            continue;

                        let service_times = type_amount['service_times'];
                        for(let l=0;l<service_times.length;l++){
                            let service_time = service_times[l];
                            let times = service_time['times'];

                            for (let m=0;m<times.length;m++){
                                let time = times[m];

                                let service_time_id = time['service_time_id'];
                                data.push(service_time_id);
                            }
                        }

                    }

                }

            }

            return data;

        }

        function edit_group(gp_id){

            let info_ids = [];
            let selected_group_times ;
            let name;
            $('#div_all_locations_'+gp_id).find(".service").each(function() {

                let id = $(this).attr('id').split("_");
                let ids = [];
                $(this).find("input[type='checkbox']").each(function () {

                    let val = $(this).val();
                    if (val != -1){
                        let info_id = $(this).attr('id').split("_")[5];
                        ids.push(Number(info_id));
                    }
                });


                let capacity = $('#capacity_service_'+id[2]+'_'+id[3]+'_'+id[4]).val();
                if (ids.length>0)
                    info_ids.push({'voucherinfo_ids':ids,'service_time_capacity':Number(capacity)});


            });

            for(let i=0;i<group_times.length;i++) {
                let group_time = group_times[i];
                let id = group_time['time_group_id'];
                if (id == gp_id) {
                    selected_group_times = group_time['time_templates'];
                    name = group_time['group_name'];
                }

            }

            $("#edit_group_times").val(JSON.stringify(selected_group_times));
            $("#edit_info_ids").val(JSON.stringify(info_ids));
            $("#edit_group_name").val(name);
            $("#edit_group_id").val(gp_id);

            document.getElementById("edit").submit();



        }



        $(document).ready(function(){
            show();
        });

    </script>--}}
@endsection

