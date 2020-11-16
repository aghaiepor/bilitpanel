
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
                </div>

            </div>
                    <div class="row">
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
                                                        @if(count($GetUserPermission) != 0 && (in_array( $project['project_id'] , $project_ids ) || (( count($project_ids) != 0 ) ?  ($project_ids[0] == '*') : '') ))
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value=" {{$project['project_id']}}" name="project" class="form-check-input pr" type="checkbox" checked value="">
                                                                    {{$project['project_name']}}
                                                                    <span class="form-check-sign">
                                                              <span class="check"></span>
                                                            </span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input value=" {{$project['project_id']}}" name="project" class="form-check-input pr" type="checkbox" value="">
                                                                    {{$project['project_name']}}
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
                                  {{--  Filter: <input type="text" id="search" /><button id="clear">Clear</button>--}}
                                    <div id="jstree">
                                        <ul>
                                            @foreach($GetInfo as $info)
                                                <li id="P{{$info['province']['id']}}"> {{$info['province']['name']}}
                                                <ul>
                                                    @foreach($info['city_info'] as $city)
                                                            @foreach($city['city'] as $cit)
                                                                <li id="C{{$cit['id'] }}"> {{$cit['name'] }}
                                                                    <ul>
                                                                        @foreach($city['location_info'] as $locInfo)
                                                                            @foreach($locInfo['location'] as $loc)
                                                                                <li id="L{{$loc['id'] }}"> {{$loc['name'] }}
                                                                                <ul>
                                                                                    @foreach($locInfo['service_info'] as $servInfo)
                                                                                        @foreach($servInfo['service'] as $serv)
                                                                                            <li id="{{$serv['id'] }}"> {{$serv['name'] }}</li>
                                                                                        @endforeach
                                                                                    @endforeach
                                                                                </ul>
                                                                                </li>
                                                                            @endforeach
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endforeach
                                                    @endforeach
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
        $('#search').on("keyup change", function () {
            $('#jstree').jstree(true).search($(this).val())
        })

        let service = data['service_ids'] ;
        console.log(service==null)  ;
        if(service!=null && service[0] == '*')
            $("#jstree").jstree().check_all();
        else
            $("#jstree").jstree().check_node(service);



        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                console.log("The selected nodes are:");
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
                // after that remove duplicate entity
                var uniqueNames = [];
                $.each(newArr, function(i, el){
                    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                });
                // After that Definition new value for dataSelect
                dataSelected  = uniqueNames ;
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
               /* if(voucher_type_id.length == $("[name=VoucherType]").length)
                    voucher_type_id = ['*'];
                if(project_id.length == $("[name=project]").length)
                    project_id = ['*'];
                if(sale_type_id.length == $("[name=SaleType]").length)
                    sale_type_id = ['*'];
                if(terminal_type_id.length == $("[name=Terminal]").length)
                    terminal_type_id = ['*'];*/
                console.log("city_id" , city_id);
                console.log("province_id" , province_id);
                console.log("location_id" , location_id);
                console.log("service_id" , service_id);
                console.log("project_id" , project_id);
                console.log("terminal_type_id" , terminal_type_id);
                console.log("voucher_type_id" , voucher_type_id);
                console.log("sale_type_id" , sale_type_id);
                console.log("sib_user_id" , sib_user_id);
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
                    },
                    success:function(data) {
                        // console.clear();
                        console.log(data);
                        if(data['Header']['Status'] == 0 ){
                            Swal.fire(
                                'تغییر مورد نظر اعمال گردید',
                                '',
                                'success'
                            )
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
                console.log('city_id : ' + city_id) ;
                console.log('province_id : ' + province_id) ;
                console.log('location_id : ' + location_id) ;
                console.log('service_id : ' + service_id) ;
                console.log('------------------') ;
                console.log('project_id : ' + project_id) ;
                console.log('terminal_type_id : ' + terminal_type_id) ;
                console.log('voucher_type_id : ' + voucher_type_id) ;
                console.log('sale_type_id : ' + sale_type_id) ;
                console.log('sib_user_id : ' + sib_user_id) ;
            });
        });
    </script>
@endsection


