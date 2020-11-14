@extends('MainLayout')

@section('title')
    <title>
        مدیریت پیش فروش
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
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
    </style>
@endsection
@section('content')
    <div class="content">
        <div id="loader" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت پیش فروش </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> جدید </span>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div style="overflow: auto ; height: 60vh ;" class="col-md-4 border-left">
                                    <ul class="nav nav-pills nav-pills-rose flex-column" role="tablist">
                                        @php
                                          $i = 0  ;
                                        @endphp
                                        @foreach($ProvinceList as $Province)
                                            <li class="nav-item border rounded ml-0">
                                                <a province_id="{{$Province["id"]}}" class="nav-link province @if($i == 0) active show @endif" data-toggle="tab" href="#link4" role="tablist"> {{$Province['province_name']}}</a>
                                            </li>
                                            @php
                                            $i++ ;
                                            @endphp
                                        @endforeach
{{--                                        <li class="nav-item border rounded">--}}
{{--                                            <a class="nav-link active show" data-toggle="tab" href="#link4" role="tablist">استان فارس</a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nav-item border rounded ml-0" style="/* display: block; */">--}}
{{--                                            <a class="nav-link" data-toggle="tab" href="#link5" role="tablist" style="display: block;">--}}
{{--                                                استان تهران--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nav-item border rounded ml-0">--}}
{{--                                            <a class="nav-link" data-toggle="tab" href="#link6" role="tablist">--}}
{{--                                                استان خراسان رضوی--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <div class="tab-content text-right">
                                        <div class="tab-pane active show" style="overflow: auto ;" id="link4">
                                            <table id="AccountTable"  class="table table-striped" style="font-size: 10pt;">
                                                <thead>
                                                <tr >
                                                    <th style="min-width: 160px ; max-width: 250px">نام</th>
                                                    <th style="">
                                                        شماره شبای حساب
                                                        <br>
                                                        <small>
                                                            شناسه ی پرداخت
                                                        </small>
                                                    </th>
                                                    <th class="text-center"> موجودی <small class="text-secondary" style="font-size: 8pt">(ريال)</small> </th>
                                                    <th class="text-center">وضعیت</th>
                                                    <th class="text-center"> خدمات</th>
                                                </tr>
                                                </thead>
                                                <tbody id="AccountTableTbody">
{{--                                                <tr>--}}
{{--                                                    <td>مجموعه زنديه و ساير اماکن استان فارس</td>--}}
{{--                                                    <td>--}}

{{--                                                    <span>--}}
{{--                                                        IRI123456789012345678901234--}}
{{--                                                    </span>--}}
{{--                                                        <br>--}}
{{--                                                        <small>123456789012345678901234567890--}}
{{--                                                        </small>--}}

{{--                                                    </td>--}}
{{--                                                    <td class="text-center">900,000,000</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        <div class="togglebutton">--}}
{{--                                                            <label>--}}
{{--                                                                <input type="checkbox" checked="">--}}
{{--                                                                <span class="toggle"></span>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="td-actions text-right">--}}
{{--                                                        <button type="button" rel="tooltip" class="btn btn-info mr-1" data-original-title="" title="">--}}
{{--                                                            <i class="material-icons">flash_on</i>--}}
{{--                                                            <div class="ripple-container"></div>--}}
{{--                                                        </button>--}}
{{--                                                        <button type="button" rel="tooltip" class="btn btn-success mr-1" data-original-title="" title="">--}}
{{--                                                            <i class="material-icons">list</i>--}}
{{--                                                            <div class="ripple-container"></div>--}}
{{--                                                        </button>--}}
{{--                                                        <button type="button" class="btn btn-danger mr-1" data-toggle="modal" data-target="#setting" data-original-title="" title="">--}}
{{--                                                            <i class="material-icons">settings</i>--}}
{{--                                                            <div class="ripple-container"></div><div class="ripple-container"></div>--}}
{{--                                                        </button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
                                                </tbody>
                                            </table>
                                        </div>
{{--                                        <div class="tab-pane" id="link5">--}}
{{--                                            Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.--}}
{{--                                            <br>--}}
{{--                                            <br>Dramatically maintain clicks-and-mortar solutions without functional solutions.--}}
{{--                                        </div>--}}
{{--                                        <div class="tab-pane" id="link6">--}}
{{--                                            Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.--}}
{{--                                            <br>--}}
{{--                                            <br>Dynamically innovate resource-leveling customer service for state of the art customer service.--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="#" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> اضافه ..  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-md text-right">
                                <label for="" class="text-right"> متن  </label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md text-right">
                                <label for="" class="text-right"> متن  </label>
                                <input type="text" class="form-control">
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

<div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_setting" action="#" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> تنظیمات حساب </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> میزان متوسط مصرف  </label>
                            <input name="average_balance_use" id="average_balance_use" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right">
                                <span style=" vertical-align :middle" class="material-icons text-success">info</span>
                                سطح سبز <small>(درصد)</small>
                            </label>
                            <input name="green_percentage" id="green_percentage" type="text" class="form-control">
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">
                                <span style=" vertical-align :middle ; color: #ffc716" class="material-icons">info</span>
                                سطح زرد <small>(درصد)</small>
                            </label>
                            <input name="yellow_percentage" id="yellow_percentage" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right">
                                <span style=" vertical-align :middle;" class="material-icons text-warning">info</span>
                                سطح نارنجی <small>(درصد)</small>
                            </label>
                            <input id="orange_percentage" name="orange_percentage" type="text" class="form-control">
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">
                                <span style=" vertical-align :middle" class="material-icons text-danger">info</span>
                                سطح قرمز <small>(درصد)</small>
                            </label>
                            <input id="red_percentage" name="red_percentage" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button type="submit" class="btn btn-success px-5 ml-0 mr-auto">
                        <span style="vertical-align :middle" class="material-icons ml-1">save</span>
                        ذخیره
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
{{--    <button id="dark">--}}
{{--        dark--}}
{{--    </button>--}}
@endsection
@section('AddJs')
    <script>
        $(document).ready(function () {

            $(document).on("click",'.location_button' , function () {
                $(this).parent().parent().next().fadeToggle() ;
            });
            $(document).on("click",'.setting_btn' , function () {

                let green_percentage = $(this).attr("green_percentage");
                let orange_percentage = $(this).attr("orange_percentage");
                let red_percentage = $(this).attr("red_percentage");
                let yellow_percentage = $(this).attr("yellow_percentage");
                let average_balance_use = $(this).attr("average_balance_use");
                let url = "{{Route("SetAccountSetting")}}/" + $(this).attr("id") ;
                $("#form_setting").attr("action" , url );
                $("#average_balance_use").val(average_balance_use);
                $("#green_percentage").val(green_percentage);
                $("#orange_percentage").val(orange_percentage);
                $("#red_percentage").val(red_percentage);
                $("#yellow_percentage").val(yellow_percentage);
            });
            $(document).on("change",'input[name=locationaccount_id]' ,function () {

                let locationaccount_id = $(this).attr('data-location');
                let activation = $(this).is(':checked');

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
                            url:"{{Route('LocationAccountActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'id' : locationaccount_id ,
                                'activation' : activation ,
                            },
                            success:function(data) {
                                console.log(data);
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
            GetAccountProvince(1);

            $(".province").click(function () {
                let province_id = $(this).attr("province_id") ;
                GetAccountProvince(province_id);
            });

        });
        function number_format (number, decimals, decPoint, thousandsSep) {

            number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
            var n = !isFinite(+number) ? 0 : +number
            var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
            var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
            var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
            var s = ''

            var toFixedFix = function (n, prec) {
                if (('' + n).indexOf('e') === -1) {
                    return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
                } else {
                    var arr = ('' + n).split('e')
                    var sig = ''
                    if (+arr[1] + prec > 0) {
                        sig = '+'
                    }
                    return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
                }
            }

            // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || ''
                s[1] += new Array(prec - s[1].length + 1).join('0')
            }

            return s.join(dec)
        }
        function GetAccountProvince(id){
            let province_id = id ;
            $("#loader").css("display" , "flex");
            $.ajax({
                type:'POST',
                url:"{{Route('GetAccountProvince')}}" ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'id' : province_id ,
                },
                success : function (data) {

                    // console.log("data : " , data["ContentData"]["location_accounts"]);
                    let account  = data["ContentData"]["location_accounts"] ;
                    let table = document.getElementById("AccountTable").getElementsByTagName('tbody')[0];
                    if(account.length == 0 ){
                        $("#AccountTableTbody").html(" ");
                        var row = table.insertRow();
                        var cell = row.insertCell();
                        cell.id = "myTd";
                        cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                        document.getElementById("myTd").colSpan = "5";
                        $("#loader").hide();
                    }else {
                        $("#AccountTableTbody").html(" ");
                        let row ;
                        let name ;
                        let saba_number ;
                        let mojodi ;
                        let state ;
                        let service ;
                        let setting = [] ;
                        for(let i = 0 ; i < account.length ; i++){
                            row = table.insertRow();
                            name = row.insertCell();
                            saba_number = row.insertCell();
                            mojodi = row.insertCell();
                            state = row.insertCell();
                            service = row.insertCell();

                            name.innerHTML = account[i].name ;
                            let saba = "<span>" +
                                "IRI" + account[i].shaba +
                                "</span>\n" +
                                "<br>" +
                                "<small>" + account[i].payment_id + "</small>" ;
                            saba_number.innerHTML = saba;
                            mojodi.innerHTML = number_format(eval(account[i].inventory) , 0 , "." , ",");
                            mojodi.style = "color : " + account[i].account_state + ";";

                            state.innerHTML = "<button class='btn btn-primary btn-sm location_button'> مکان ها </button>" ;

                            let service_html = '<button disabled type="button" rel="tooltip" class="btn btn-sm px-2 btn-info mr-1" data-original-title="" title="">\n' +
                                '<i class="material-icons">flash_on</i>\n' +
                                '<div class="ripple-container"></div>\n' +
                                '</button>\n' +
                                '<button disabled type="button" rel="tooltip" class="btn btn-sm px-2 btn-success mr-1" data-original-title="" title="">\n' +
                                '<i class="material-icons">list</i>\n' +
                                '<div class="ripple-container"></div>\n' +
                                '</button>\n' +
                                '<button type="button" class="btn setting_btn btn-sm px-2 btn-danger mr-1" data-toggle="modal" data-target="#setting" data-original-title="" id="'+ account[i].account_id +'" average_balance_use="' + account[i].average_balance_use + '"' +
                                ' green_percentage="'+ account[i].green_percentage +'" orange_percentage="'+ account[i].orange_percentage + '" red_percentage="'+ account[i].red_percentage +'" yellow_percentage="'+ account[i].yellow_percentage+'" title="">\n' +
                                '<i class="material-icons">settings</i>\n' +
                                '<div class="ripple-container"></div><div class="ripple-container"></div>\n' +
                                '</button>';
                            service.innerHTML = service_html ;

                            let location = account[i].locations;
                            let tbl = document.createElement('table');
                            tbl.className  = "subTable" ;
                            row = table.insertRow();
                            row.className = "subRow";
                            cell = row.insertCell();
                            cell.className = "myTd";
                            cell.colSpan = "5";
                            cell.appendChild(tbl);
                            // cell.innerHTML = ;

                            for (let x = 0 ; x < location.length ; x++){
                                row = tbl.insertRow();
                                row.class = "myTr";
                                location_name = row.insertCell();
                                location_name.colSpan = "3"
                                location_name.innerHTML = location[x].name;
                                location_state = row.insertCell();
                                location_state.colSpan = "2"
                                let state_html = ' <div class="togglebutton">' + '<label>' ;

                                if (location[x].presell_activation)
                                    state_html += '<input  data-location="' + location[x].locationaccount_id + '" type="checkbox" name="locationaccount_id" checked="">'  ;
                                else
                                    state_html += '<input data-location="' + location[x].locationaccount_id + '" type="checkbox" name="locationaccount_id">'  ;

                                state_html +=   '<span class="toggle"></span>' + '</label>' + '</div>';

                                location_state.innerHTML =  state_html;
                                tbl.appendChild(row);
                            }

                            // document.getElementsByClassName("myTr").colSpan = "5";

                        }
                        $("#loader").hide();
                    }
                }
            })
        }
    </script>
@endsection
