@extends('MainLayout')

@section('title')
    <title>
        ریز تراکنش ها
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
    </style>
@endsection

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
                                    <h4 class="card-title text-right font-weight-bold "> ریز تراکنش های استان {{$province_name}} / {{$Account["name"]}} </h4>
                                </div>
                                <div class="col-sm">
                                    <a href="{{Route("presellManger")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-danger card-header-icon">
                                            <div class="card-icon" style="margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">person</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1">نام</p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                استان {{$province_name}} / {{$Account["name"]}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-rose card-header-icon">
                                            <div class="card-icon" style="margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">attach_money</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1">	کل افزایش اعتبار</p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                {{ number_format($total_amount , 0,"." , ",")}} (ریال)
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-rose card-header-icon">
                                            <div class="card-icon" style="margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">shopping_cart</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1">	کل خرید</p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
{{--                                                {{ number_format($total_buy , 0 , "." ,",")}} (ریال)--}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="card card-stats">
                                        <div class="card-header card-header-rose card-header-icon">
                                            <div class="card-icon" style="margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">account_balance_wallet</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1"> موجودی<small> (ریال) </small></p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                {{ number_format($Account['inventory'] , 0 , "." ,",")}}

                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-2 ml-auto">
                                    <select id="transaction_type" name="key" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع تراکنش ها">
                                        <option disabled value="province"  > نوع تراکنش ها </option>
                                        <option value="charge" selected > افزایش اعتبار </option>
                                        <option value="Decharge"  > خريد </option>
                                    </select>
                                </div>
                                <div class="col-lg-auto mr-auto">
                                    <button class="btn btn-success pr-2">
                                        <i class="material-icons"> vertical_align_bottom </i>
                                        دانلود اکسل
                                    </button>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">

                            <div class="table-responsive table-striped">
                                <table id="AccountTable" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                            مبلغ تراکنش
                                            <small>(ریال)</small>
                                        </th>
                                        <th >
                                            تاریخ پرداخت
                                        </th>
                                        <th >
                                            نوع تراکنش
                                        </th>
                                        <th >
                                            شماره پی گیری
                                        </th>
                                        <th >
                                            توضیحات
                                        </th>
                                        <th >

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody" >
                                    @if(count($transactions) == 0)
                                        <tr>
                                            <td colspan="6">
                                                <h6 class="py-5 text-center"> موردی یافت نشد !  </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td><span class="h5 text-success">{{number_format($transaction["transaction_amount"] ,0,"." , "," )}}</span> </td>
                                                <td> {{$transaction["created_jalali"]}}  </td>
                                                <td>
                                                    @if ($transaction["transaction_type"] == "Charge")
                                                        افزایش اعتبار
                                                    @else
                                                       خريد
                                                    @endif
                                                </td>
                                                <td>{{$transaction["trace_number"]}}</td>
                                                <td>-</td>
                                                <td>
                                                    <a href="#" {{--href="https://chargepanel.tafrihati.com/charge/receiptNEW/1/1791/39438" target="_blank"--}} class="btn btn-success ">دانلود رسید</a>
                                                    <a href="#" {{--href="https://chargepanel.tafrihati.com/uploads/receipt/9812200541003306.jpg" target="_blank"--}} class="btn btn-primary ">اسکن مستندات</a>
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

@endsection
@section('AddJs')
    <script src="{{asset('')}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script>
        $(document).ready(function () {

            $("#transaction_type").change(function () {
                let type = $("#transaction_type").val() ;
                if(type == "Decharge")
                    GetDechargeTransaction("{{Route('GetDechargeTransaction')}}" , "خريد");
                else
                    GetDechargeTransaction("{{Route('GetChargeTransaction')}}" , "افزايش اعتبار");

            })


        });
        function GetDechargeTransaction(url , type){
            $("#loader").css("display" , "flex");
            let page = "{{request("page")}}";
            // console.log("page" , page == "");
            if(page == "")
                page = 1 ;

            let id = "{{url()->current()}}";
            id = id.split("/");
            id = id[4];
            // console.log(id[4]);
            $.ajax({
                type:'POST',
                url: url ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'account_id' : id ,
                    'page' : page ,
                },
                success : function (data) {

                    // console.log("data : " , data);
                    let account  = data ;
                    let table = document.getElementById("AccountTable").getElementsByTagName('tbody')[0];
                    if(account.length == 0 ){
                        $("#tbody").html(" ");
                        var row = table.insertRow();
                        var cell = row.insertCell();
                        cell.id = "myTd";
                        cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                        document.getElementById("myTd").colSpan = "6";
                        $("#loader").hide();
                    }else {
                        $("#tbody").html(" ");
                        let row ;
                        let transition_amount ;
                        let date ;
                        let transaction_type ;
                        let pigiri_number ;
                        let discripton ;
                        let setting ;
                        for(let i = 0 ; i < account.length ; i++){
                            row = table.insertRow();
                            transition_amount = row.insertCell();
                            date = row.insertCell();
                            transaction_type = row.insertCell();
                            pigiri_number = row.insertCell();
                            discripton = row.insertCell();
                            setting = row.insertCell();

                            transition_amount.innerHTML = number_format(eval(account[i].transaction_amount) , 0 , "." , ",") ;
                            transition_amount.className = "h5 text-success" ;
                            date.innerHTML = account[i].created_jalali ;
                            transaction_type.innerHTML = type ;
                            pigiri_number.innerHTML = account[i].trace_number ;
                            discripton.innerHTML = "-" ;

                            setting.innerHTML = " <a href=\"#\" {{--href=\"https://chargepanel.tafrihati.com/charge/receiptNEW/1/1791/39438\" target=\"_blank\"--}} class=\"btn btn-success \">دانلود رسید</a>\n" +
                                "<a href=\"#\" {{--href=\"https://chargepanel.tafrihati.com/uploads/receipt/9812200541003306.jpg\" target=\"_blank\"--}} class=\"btn btn-primary \">اسکن مستندات</a>" ;


                            // document.getElementsByClassName("myTr").colSpan = "5";

                        }
                        $("#loader").hide();
                    }
                }
            })
        }
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
    </script>
@endsection
