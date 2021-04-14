
@extends('MainLayout')

@section('title')
    <title>
        مدیریت کاربران
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }

    </style>
    <link href="{{asset('')}}assets/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
    <style>

        @font-face {
            font-family: 'Glyphicons Halflings';
            src: url('{{asset('')}}assets/font/glyphicons-halflings-regular.eot');
            src: url('{{asset('')}}assets/font/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('{{asset('')}}assets/font/glyphicons-halflings-regular.woff') format('woff'), url('{{asset('')}}assets/font/glyphicons-halflings-regular.ttf') format('truetype'), url('{{asset('')}}assets/font/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg')
        }

        .glyphicon {
            position: relative;
            top: 1px;
            display: inline-block;
            font-family: 'Glyphicons Halflings';
            -webkit-font-smoothing: antialiased;
            font-style: normal;
            font-weight: normal;
            line-height: 1
        }
        .glyphicon-plus:before {
            content: "\2a"
        }
        .glyphicon-plus:before {
            content: "\2b"
        }
        .glyphicon-minus:before {
            content: "\2212"
        }
        .TitlePro {
            position: absolute;
            padding: 0px 7px 0px 6px;
            right: 0;
            font-weight: 400;
            /*border: solid 1px #e9e9e9;*/
            border-radius: 5px 0px 0px 5px;
            font-size: 9pt;
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
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissable fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                                        <i class="material-icons">group</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> تخصیص سطح دسترسی به کاربر </h4>
                                </div>
                                <div class="col-sm">
                                    <a href="{{Route("UserManager")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                    </div>
                    @if($GetUserPermissionHeader == 135)
                        <div class="alert alert-danger text-right alert-dismissible fade show" role="alert">
                            کاربر مورد نظر غیر فعال می  باشد .
                        </div>
                        <script>
                            $(document).ready(function () {
                                $(':button').prop('disabled', true);
                                $(':input').prop('disabled', true);
                                $('#jstree li').each( function() {
                                    $("#jstree").jstree().disable_node(this.id);
                                })
                            });
                        </script>
                    @endif
                </div>
            </div>
                    <div  @if($GetUserPermissionHeader == 135) style="opacity: 0.5" @endif class="row">
                        <div class="col-6 text-right">
                            <div class="card">
                                <div class="card-body">
                                    <div id="accordion" role="tablist">
                                        <div class="card card-collapse">
                                            <div class="card-header" role="tab" id="headingOne">
                                                <h5 class="mb-0">
                                                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        پروژه
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </a>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    @php
                                                    if(count($GetUserPermission) != 0){
                                                        $project_ids = (!is_null($GetUserPermission)) ?  $GetUserPermission['project_ids'] : [];
                                                    }
                                                    @endphp
                                                    @foreach($projectList as $project)
                                                        @php
                                                            $bgColor = "#".dechex( rand(170 , 255)).dechex( rand(170 , 255)).dechex( rand(170 , 255)) ;
                                                        @endphp
                                                        @if(count($GetUserPermission) != 0 && (in_array( $project['project_id'] , $project_ids ) || (( count($project_ids) != 0 ) ?  ($project_ids[0] == '*') : '') ))
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input data-name="{{$project['project_name']}}" data-color="{{$bgColor}}" value="{{$project['project_id']}}" name="project" class="form-check-input pr" type="checkbox" checked >
                                                                    {{$project['project_name']}}
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                                <span class="mr-1" style="background:{{$bgColor}}"> &nbsp;&nbsp; </span>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input data-name="{{$project['project_name']}}" data-color="{{$bgColor}}" value="{{$project['project_id']}}" name="project" class="form-check-input pr" type="checkbox">
                                                                    {{$project['project_name']}}
                                                                    <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                    </span>
                                                                </label>
                                                                <span class="mr-1" style="background:{{$bgColor}}  " > &nbsp;&nbsp; </span>
                                                            </div>
                                                        @endif

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{--                   collapseTwo                     --}}
                                        <div class="card card-collapse">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        نوع ترمینال
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </a>
                                                </h5>
                                            </div>
                                            @php
                                                if(count($GetUserPermission) != 0)
                                                    $terminal_type_ids =(!is_null($GetUserPermission)) ?  $GetUserPermission['terminal_type_ids'] : [];

                                            @endphp
                                            <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($TerminalTypeList as $TerminalType)
                                                        @if( count($GetUserPermission) != 0 && (in_array($TerminalType['id'] , $terminal_type_ids) || ((count($terminal_type_ids) != 0 ) ? ($terminal_type_ids[0] == '*') : '') ) )
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$TerminalType['id']}}" name="Terminal" class="form-check-input" type="checkbox" checked value="">
                                                                    {{$TerminalType['type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$TerminalType['id']}}" name="Terminal" class="form-check-input" type="checkbox" value="">
                                                                    {{$TerminalType['type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-collapse">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        نوع بلیت
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse show" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body">
                                                    @php
                                                        if(count($GetUserPermission) != 0)
                                                           $voucher_types = (!is_null($GetUserPermission)) ?  $GetUserPermission['voucher_types'] : [];
                                                    @endphp
                                                    @foreach($VoucherTypeList as $VoucherType)
                                                        @if(count($GetUserPermission) != 0 && (in_array( $VoucherType['voucher_type_id'], $voucher_types) || ((count($voucher_types) != 0 ) ?( $voucher_types[0] == '*') : '') ))
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$VoucherType['voucher_type_id']}}" name="VoucherType" class="form-check-input" type="checkbox" checked value=""> {{$VoucherType['voucher_type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$VoucherType['voucher_type_id']}}" name="VoucherType" class="form-check-input" type="checkbox" value=""> {{$VoucherType['voucher_type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                            </div>
                                        </div>
                                        <div class="card card-collapse">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        نوع فروش
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </a>
                                                </h5>
                                            </div>
                                            @php
                                                if(count($GetUserPermission) != 0)
                                                     $sale_types =(!is_null($GetUserPermission)) ?  $GetUserPermission['sale_types'] : [];
                                            @endphp
                                            <div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                                                <div class="card-body">

                                                @foreach($SaleTypeList as $SaleType)
                                                        @if(count($GetUserPermission) != 0 && (in_array($SaleType['sale_type_id'],$sale_types)  ||   ((count($sale_types) != 0 ) ? ($sale_types[0] == '*') : '') ) )
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$SaleType['sale_type_id']}}" name="SaleType" class="form-check-input" type="checkbox" checked value="">  {{$SaleType['sale_type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$SaleType['sale_type_id']}}" name="SaleType" class="form-check-input" type="checkbox" value="">  {{$SaleType['sale_type']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                            @if( (($presell == 1) ? true : false)  && session('UserInfo')['presell'])
                                                <div class="card card-collapse">
                                            <div class="card-header" role="tab" id="headingFive">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFour">
                                                        مدیریت پیش فروش
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </a>
                                                </h5>
                                            </div>
                                            @php
                                                if(count($GetUserPermission) != 0)
                                                     $switch_web_service_ids =(!is_null($GetUserPermission)) ?  $GetUserPermission['switch_web_service_ids'] : [];
                                            @endphp
                                            <div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                                                <div class="card-body">

                                                @foreach($GetSwitchWebServiceList as $GetSwitchWebService)
                                                        @if(count($GetUserPermission) != 0 && (in_array($GetSwitchWebService['switch_web_service_id'],$switch_web_service_ids)  ||   ((count($switch_web_service_ids) != 0 ) ? ($switch_web_service_ids[0] == '*') : '') ) )
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$GetSwitchWebService['switch_web_service_id']}}" name="switch_web_service_ids" class="form-check-input" type="checkbox" checked value="">  {{$GetSwitchWebService['name']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value="{{$GetSwitchWebService['switch_web_service_id']}}" name="switch_web_service_ids" class="form-check-input" type="checkbox" value="">  {{$GetSwitchWebService['name']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                            @endif
                                    </div>
                                    <button id="AcceptBtn" class="btn d-block btn-success mt-5 px-5 mr-auto"> اعمال دسترسی </button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-right" dir="rtl">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="font-weight-bold">
                                        تخصیص سطح دسترسی
                                    </h5>
                                    <hr>
                                </div>
                                <div class="card-body">
{{--                                    Filter: <input type="text" id="search" /><button id="clear">Clear</button>--}}
                                    <div id="jstree">
                                        <ul>
                                            @foreach($GetInfo as $info)
                                                <li parent-node="1" id="P{{$info['id']}}"> {{$info['name']}}
                                                <ul>
                                                    @if(array_key_exists("cities" , $info ))
                                                        @foreach($info['cities'] as $cit)
{{--                                                            @foreach($city['city'] as $cit)--}}
                                                                <li id="C{{$cit['id'] }}"> {{$cit['name'] }}
                                                                    <ul>
{{--                                                                        @foreach($city['location_info'] as $locInfo)--}}
                                                                        @if(array_key_exists("locations" , $cit ))
                                                                            @foreach($cit['locations'] as $loc)
                                                                                <li data-project="{{$loc["project"]}}"  id="L{{$loc['id'] }}"> {{$loc['name'] }}
                                                                                    <span data-project-title="{{$loc["project"]}}" class="TitlePro"> تست </span>
                                                                                <ul>
{{--                                                                                    @foreach($locInfo['service_info'] as $servInfo)--}}
                                                                                    @if(array_key_exists("services" , $loc ))
                                                                                        @foreach($loc['services'] as $serv)
                                                                                            <li data-service-project="{{$loc["project"]}}"  id="{{$serv['id'] }}"> {{$serv['name'] }}</li>
                                                                                        @endforeach
                                                                                    @endif
{{--                                                                                    @endforeach--}}
                                                                                </ul>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
{{--                                                                        @endforeach--}}
                                                                    </ul>
                                                                </li>
{{--                                                            @endforeach--}}
                                                    @endforeach
                                                    @endif
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    {{--<p>Selected items:</p>
                                    <ul id="output">
                                    </ul>--}}
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
@endsection
@section('AddJs')
    <script src="{{asset('')}}assets/jstree/dist/jstree.min.js"></script>
    <script>
        let data = @json($GetUserPermission);
        // console.log("data : " , data)
        $('#jstree').jstree({
            'plugins': ['search', 'checkbox' , 'sort'],
            'core': {
                'animation': true,
                close_node : {
                    jstree : false
                } ,
                    'themes': {
                    'icons': false,
                }
            },
            'checkbox' : {
                'checked_parent_open' : true ,
            },
            'search': {
                'show_only_matches': true,
                'show_only_matches_children': true
            }
        } )
       /*
       $('#search').on("keyup change", function () {
            $('#jstree').jstree(true).search($(this).val())
        })

        $("#search1, #search2, #search3").click(function () {
            $("#demo2").jstree("search", $(this).attr("rel"));
        });
        */

        // ****** service checked ******
        let service = data['service_ids'] ;
        if(service!=null && service[0] == '*')
            $("#jstree").jstree().check_all();
        else
            $("#jstree").jstree().check_node(service);

        // check if Location set checked ******
        undetermined  = $("#jstree").jstree().get_undetermined();
        console.log("undetermined : " , undetermined)
        let location_ids =  data['location_ids'] ;
        console.log("location_ids" , location_ids)
        let loc = [] ;
        if(location_ids != null )
        {
            location_ids.forEach(function (entry) {
                let string = "L" + entry ;
                loc.push(string)
            });
        }
        locCheack = loc  ;
        if(locCheack!=null && locCheack[0] == '*')
            $("#jstree").jstree().check_all();
        else
        {
            let check = []
            $.each(locCheack, function(i, entry){
                if(!undetermined.includes(entry))
                    check.push(entry);
            });
            console.log("check : " , check)
            $("#jstree").jstree().check_node(check);
        }

        //****** checked ******

        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let Current_project_id = data['project_ids'] ;
            $("#jstree").jstree().open_all();
            let now_projects = Current_project_id;
            let color = getColor() ;
            let name = getColorName() ;

            now_projects = getProject() ;
            $("li[data-service-project]").each(function () {
                let data_service_project_id = $(this).attr("data-service-project") ;
                if(!now_projects.includes(data_service_project_id))
                {
                    let el_id = $(this).attr("id");
                    $("#jstree").jstree().uncheck_node(el_id);
                }
            });
            $("li[data-project]").each(function () {
                let data_project_id = $(this).attr("data-project") ;
                let indexItem  = now_projects.indexOf(data_project_id) ;
                if(!now_projects.includes(data_project_id))
                {
                    $(this).hide();
                    let el_id = $(this).attr("id");
                    $("#jstree").jstree().close_node(el_id);
                }
                else
                {
                    let el_id = $(this).attr("id");
                    $("#jstree").jstree().open_node(el_id);
                    $("#"+el_id).css("background" , color[indexItem])
                    $("#"+el_id).find("span").css("background" , color[indexItem])
                    $("#"+el_id).find("span").text(name[indexItem].substr(0, 5) + "..")
                    $("#"+el_id).find("span").attr("title" , name[indexItem])

                    /*
                    $("#"+el_id).pseudo(":after","content"," تست") ;
                    $("#"+el_id).pseudo(":after","background","#ccc") ;
                    $("#"+el_id).pseudo(":after","position","absolute") ;
                    $("#"+el_id).pseudo(":after","left","0") ;
                    */
                }
            });

            $("input[name=project]").on("click" ,  function () {

                let chack = $(this).is(":checked") ;
                let color = getColor() ;
                let name = getColorName() ;
                // console.log("colorArray : " ,color)
                if(chack)
                {
                    now_projects = getProject()
                    console.log("new now_projects : " , now_projects)
                    $("li[data-service-project]").each(function () {
                        let data_service_project_id = $(this).attr("data-service-project") ;
                        // console.log("index : " , now_projects.filter(item => item.value == data_service_project_id));
                        // console.log("-------- End Item --------") ;
                        if(now_projects.includes(data_service_project_id))
                        {
                            $(this).show(300);
                            let el_id = $(this).attr("id");
                        }
                    });

                    $("li[data-project]").each(function () {
                        let data_project_id = $(this).attr("data-project") ;
                        // let index = now_projects.indexOf(data_project_id) ;
                        // console.log("index : " ,index)
                        let indexItem  = now_projects.indexOf(data_project_id) ;
                        if(now_projects.includes(data_project_id))
                        {
                            $(this).show(300);
                            let el_id = $(this).attr("id");
                            $("#jstree").jstree().open_node(el_id);
                            $("#"+el_id).css("background" , color[indexItem]);
                            $("#"+el_id).find("span").css("background" , color[indexItem])
                            $("#"+el_id).find("span").text(name[indexItem].substr(0, 6))
                            $("#"+el_id).find("span").attr("title" , name[indexItem])
                        }
                    });
                }
                else
                {
                    now_projects = getProject()
                    $("li[data-service-project]").each(function () {
                        let data_service_project_id = $(this).attr("data-service-project") ;
                        if(!now_projects.includes(data_service_project_id))
                        {
                            let el_id = $(this).attr("id");
                            $("#jstree").jstree().uncheck_node(el_id);
                        }
                    });

                    $("li[data-project]").each(function () {
                        let data_project_id = $(this).attr("data-project") ;
                        if(!now_projects.includes(data_project_id))
                        {
                            $(this).hide(300);
                            let el_id = $(this).attr("id");
                            $("#"+el_id).css("background" , "");
                            $("#jstree").jstree().close_node(el_id);
                        }
                    });

                }
            });

            $("#jstree").on('open_node.jstree', function () {

                now_projects = getProject() ;
                $("li[data-service-project]").each(function () {
                    let data_service_project_id = $(this).attr("data-service-project") ;
                    if(!now_projects.includes(data_service_project_id))
                    {
                        let el_id = $(this).attr("id");
                        $("#jstree").jstree().uncheck_node(el_id);
                    }
                });
                $("li[data-project]").each(function () {
                    let data_project_id = $(this).attr("data-project") ;
                    if(!now_projects.includes(data_project_id))
                    {
                        $(this).hide();
                        let el_id = $(this).attr("id");
                        $("#jstree").jstree().close_node(el_id);
                    }
                });

            })
            $("#jstree").on('close_node.jstree', function () {
                console.log("Close !") ;
            })

            function getProject(){
                now_projects = [] ;
                $("input[name=project]").each(function () {
                    if($(this).is(":checked")) {
                        now_projects.push($(this).val())
                    }
                })
                return now_projects ;
            }

            function getColor(){
                colors = [] ;
                $("input[name=project]").each(function () {
                    if($(this).is(":checked"))
                    {
                        let color = $(this).attr("data-color");
                        colors.push(color)
                    }
                })
                return colors ;
            }
            function getColorName(){
                let names = [] ;
                $("input[name=project]").each(function () {
                    if($(this).is(":checked"))
                    {
                        let name = $(this).attr("data-name");
                        console.log("name : " , name)
                        names.push(name)
                    }
                })
                return names ;
            }


            /*
            $("#jstree").jstree().open_node(function () {
            });
            */


            let Locations = [] ;
            let City = [] ;
            let Province = [] ;
            let Service = [] ;
            let voucher_type_id = [] ;
            let project_id = [];
            let sale_type_id = [];
            let sib_user_id = {{$userId}};
            let terminal_type_id = [];
            $("#jstree").on("changed.jstree", function (e, data) {
                // console.log("The selected nodes are:");
                let x  = $("#jstree").jstree().get_checked();

                for(let i = 0 ; i <  data.selected.length ; i++){
                    if (data.selected[i][0] == 'L'){
                        let l = data.selected[i] ;
                        Locations.push(l.substr(1));
                    }
                    else if (data.selected[i][0] == 'C') {
                        let c = data.selected[i] ;
                        City.push(c.substr(1));
                    }
                    else if (data.selected[i][0] == 'P') {
                        let p = data.selected[i] ;
                        Province.push(p.substr(1));
                    }
                    else{
                        let s = data.selected[i] ;
                        Service.push(s);
                    }

                    // let saleT = $('input[name=project]') ;


                }


            });



            $('#AcceptBtn').click(function () {
                console.clear();
                let voucher_type_id = [];
                let project_id = [];
                let sale_type_id = [];
                let terminal_type_id = [];
                let switch_web_service_ids = [];
                var city_id = [];
                var province_id = [];
                var location_id = [];
                var service_id = [];
                // let dataSelected  = $("#jstree").jstree('get_selected' , true);

                let dataSelected = [];
                let checked = $("#jstree").jstree("get_selected", true);
                checked.forEach(function (entry) {
                    dataSelected.push($("#jstree").jstree(true).get_path(entry, "", true))
                });

                // concat multi array in one
                var newArr = [];
                for(var i = 0; i < dataSelected.length; i++)
                {
                    newArr = newArr.concat(dataSelected[i]);
                }
                // console.log("newArr contact array  : "  , newArr);
                // after that remove duplicate entity
                var uniqueNames = [];
                $.each(newArr, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });

                // After that Definition new value for dataSelect
                dataSelected  = uniqueNames ;
                console.log("dataSelected after unique  : "  , dataSelected);

                for(let i = 0 ; i <  dataSelected.length ; i++){
                    if (dataSelected[i][0] == 'L'){
                        let l = dataSelected[i] ;
                        location_id.push(eval(l.substr(1)));
                    }
                    else if (dataSelected[i][0] == 'C') {
                        let c = dataSelected[i] ;
                        city_id.push(parseInt(c.substr(1)));
                    }
                    else if (dataSelected[i][0] == 'P') {
                        let p = dataSelected[i] ;
                        province_id.push(eval(p.substr(1)));
                    }
                    else{
                        let s = dataSelected[i] ;
                        service_id.push(eval(s));
                    }
                }

                console.log("city_id  : "  , city_id);

                for(let i = 0 ; i < $("[name=SaleType]").length ; i++){
                    if($("[name=SaleType]")[i].checked)
                        sale_type_id.push(eval($("[name=SaleType]")[i].value))
                }
                for(let i = 0 ; i < $("[name=project]").length ; i++){
                    if($("[name=project]")[i].checked)
                        project_id.push(eval($("[name=project]")[i].value))
                }
                for(let i = 0 ; i < $("[name=Terminal]").length ; i++){
                    if($("[name=Terminal]")[i].checked)
                        terminal_type_id.push(eval($("[name=Terminal]")[i].value))
                }
                for(let i = 0 ; i < $("[name=VoucherType]").length ; i++){
                    if($("[name=VoucherType]")[i].checked)
                        voucher_type_id.push(eval($("[name=VoucherType]")[i].value))
                }
                for(let i = 0 ; i < $("[name=switch_web_service_ids]").length ; i++){
                    if($("[name=switch_web_service_ids]")[i].checked)
                        switch_web_service_ids.push(eval($("[name=switch_web_service_ids]")[i].value))
                }
               /*
               if(voucher_type_id.length == $("[name=VoucherType]").length)
                    voucher_type_id = ['*'];
                if(project_id.length == $("[name=project]").length)
                    project_id = ['*'];
                if(sale_type_id.length == $("[name=SaleType]").length)
                    sale_type_id = ['*'];
                if(terminal_type_id.length == $("[name=Terminal]").length)
                    terminal_type_id = ['*'];
                */
                // console.log("city_id" , city_id);
                console.log("province_id" , province_id);
                console.log("location_id" , location_id);
                console.log("service_id" , service_id);
                // console.log("project_id" , project_id);
                // console.log("terminal_type_id" , terminal_type_id);
                // console.log("voucher_type_id" , voucher_type_id);
                // console.log("sale_type_id" , sale_type_id);
                // console.log("sib_user_id" , sib_user_id);
                // console.log("switch_web_service_ids" , switch_web_service_ids);
                $("#loader").css("display" , "flex");
                $.ajax({
                    type:'POST',
                    url:"{{Route('AssignPermission')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'city_id' : city_id ,
                        'province_id' : province_id ,
                        'location_id' : location_id ,
                        'service_id' : service_id ,
                        'project_id' : project_id ,
                        'terminal_type_id' : terminal_type_id ,
                        'voucher_type_id' : voucher_type_id ,
                        'sale_type_id' : sale_type_id ,
                        'sib_user_id' : sib_user_id ,
                        'switch_web_service_ids' : switch_web_service_ids ,
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
                        // console.clear();
                        // console.log(data);
                        if(data['Header']['Status'] == 0 ){
                            Swal.fire(
                                'تغییر مورد نظر اعمال گردید',
                                '',
                                'success'
                            )
                          /*  setInterval(function () {
                                window.location.href = "{{Route("UserManager")}}";
                            } , 1000)*/

                        }
                        else if(data['Header']['Status'] == 2){
                            Swal.fire(
                                ' خطا ! ',
                                'شما مجاز به انجام چنین کاری نمی باشید .',
                                'warning'
                            )
                        }
                        else
                            Swal.fire(
                                'خطا در اعمال تغییرات',
                                '',
                                'error'
                            )
                        $('#loader').hide();
                    }
                });
                // console.log('city_id : ' + city_id) ;
                // console.log('province_id : ' + province_id) ;
                // console.log('location_id : ' + location_id) ;
                // console.log('service_id : ' + service_id) ;
                // console.log('------------------') ;
                // console.log('project_id : ' + project_id) ;
                // console.log('terminal_type_id : ' + terminal_type_id) ;
                // console.log('voucher_type_id : ' + voucher_type_id) ;
                // console.log('sale_type_id : ' + sale_type_id) ;
                // console.log('sib_user_id : ' + sib_user_id) ;
            });
        });
    </script>
@endsection


