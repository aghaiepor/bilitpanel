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
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
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
                        <div class="card-header card-header-icon card-header-rose">
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
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-header pb-2 card-header-danger card-header-icon">
                                            <div class="card-icon" style="padding: 5px;margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">person</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1">نام</p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                استان {{$province_name}} / {{$Account["name"]}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-header pb-2 card-header-rose card-header-icon">
                                            <div class="card-icon" style="padding: 5px;margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">attach_money</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1">	کل افزایش اعتبار <small> (ریال) </small></p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                {{ number_format($total_amount , 0,"." , ",")}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-header pb-2 card-header-rose card-header-icon">
                                            <div class="card-icon" style="padding: 5px;margin-left: 15px;margin-right: 0;float: right;">
                                                <i class="material-icons">shopping_cart</i>
                                            </div>
                                            <p class="card-category font-weight-normal mb-1"> کل خرید<small> (ریال) </small> </p>
                                            <h6 class="card-title" style="font-weight: 400;font-size: 10pt;">
                                                {{ number_format($total_buy , 0 , "." ,",")}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-header pb-2 card-header-rose card-header-icon">
                                            <div class="card-icon" style="padding: 5px;margin-left: 15px;margin-right: 0;float: right;">
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
                            <div class="row mb-2">
                                <div class="col-md pl-md-0">
                                    <input id="search_trace_number" type="text" placeholder="شماره پيگيري" class="form-control">
                                </div>
                                <div class="col-md pl-md-0">
                                    <input id="search_reference_number" type="text" placeholder="شماره فيش" class="form-control">
                                </div>
                                <div class="col-md pl-md-0">
                                    <input autocomplete="off"  id="FromDate" type="text" placeholder="تاریخ شروع" class="form-control">
                                </div>
                                <div class="col-md pl-md-0">
                                    <input autocomplete="off"  id="ToDate" type="text" placeholder="تاريخ پایان" class="form-control">
                                </div>
                                <div class="col-md-auto">
                                    <button id="Search_btn" class="btn btn-rose px-5">
                                        جستوجو
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-lg-4 ml-auto">
                                    <select id="transaction_type" name="key" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع تراکنش ها">
                                        <option disabled value="province"  > نوع تراکنش ها </option>
                                        <option value="charge" selected > افزایش اعتبار </option>
                                        <option value="Decharge"> خريد </option>
                                    </select>
                                </div>
                                <div class="col-lg-auto mr-auto">
                                    <button onclick="export2excel()" class="btn btn-success pr-2">
                                        <i class="material-icons"> vertical_align_bottom </i>
                                        دانلود اکسل
                                    </button>
                                </div>
                            </div>

                            <hr>
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
                                        @foreach($transactions["log"] as $transaction)
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
                                                    @if(!is_null( $transaction['picture_id']))
                                                        @php
                                                            $api = new \App\Api\Api();
                                                            $image_id = $transaction['picture_id'];
                                                            $imageUrl = $api->GetDocumentAddress($image_id) ;
                                                        @endphp
                                                    <a  href="{{$imageUrl}}" class="btn btn-success docDownload">دانلود مستندات</a>
                                                    <button data_id="{{$transaction['trace_number']}}" data-toggle="modal" data-target="#showFactor" class="btn btn-primary factor ">فاکتور فروش</button>
                                                    @else
                                                        <button  disabled class="btn btn-success ">دانلود مستندات</button>
                                                        <button data_id="{{$transaction['trace_number']}}" data-toggle="modal" data-target="#showFactor" class="btn btn-primary factor ">فاکتور فروش</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <ul class="pagination justify-content-center">
                                @if(count($transactions) != 0 /* ||  count($transactions['log']) != 0*/ )
                                    @php
                                        $result = new \Illuminate\Pagination\LengthAwarePaginator( $transactions['log'],$transactions['total_pages'], 1,  \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage(),array('path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()));
                                        $page = (int)request('page');
                                        $result->withPath(url()->full());
                                    @endphp
                                    {{$result->render()}}
                                @endif
                            </ul>
                            <nav id="pagination" aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#link" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">1<div class="ripple-container"></div></a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link" aria-label="Next">
                                            <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showFactorBuy" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="chargeForm2" action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel">مشخصات تراکنش خرید بلیت الکترونیک  </h5>
                        <button id="modalClose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printArea2" class="card-body">
                        <div id="loader3" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                        </div>
                        <div class="invoice p-1 border">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="text-right">رسید تراکنش خرید بلیت الکترونیک</div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="invoice-brands text-left">
                                        <img class="brand brand-pec" width="80" height="80" alt="Miras" style="filter: invert(1)" src="{{asset("")}}assets/img/mirasw_logo.png">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class=" text-right">
                                        فاکتور خرید:
                                        #
                                        <span id="buy_factor_number" class="font-weight-bold"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="invoice-ginfo">
                                        <table class="float-left">
                                            <tbody>
                                            <tr>
                                                <th>تاریخ:</th>
                                                <td id="buy_date"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-12">

                                    <h4 class="text-center font-weight-bold py-3">مشخصات تراکنش</h4>
                                    <table class="table table-striped bordered text-right" style="font-size:14px;">
                                        <tbody>
                                        <tr>
                                            <th>نام مرکز:</th>
                                            <td style="">استان {{$province_name}} / {{$Account["name"]}} </td>
                                            <th>  </th>
                                            <td>  </td>
                                        </tr>
                                        <tr>
                                            <th>مبلغ:</th>
                                            <td><span id="buy_deposit_amount"></span> ریال</td>
                                            <th>نوع بلیت:</th>
                                            <td><span id="buy_transaction_type"></span> </td>
                                        </tr>
                                        <tr>
                                            <th>مکان:</th>
                                            <td id="buy_location_name"></td>
                                            <th>شماره بليت:</th>
                                            <td id="buy_reference_number"></td>
                                        </tr>
                                        <tr>
                                            <th>تعداد بلیت:</th>
                                            <td id="buy_ticket_id" style="direction:ltr"></td>
                                            <th>شناسه قبض:</th>
                                            <td id="buy_bill_id" style="direction:ltr"></td>
                                        </tr>
                                        <tr>
                                            <th>شناسه پرداخت:</th>
                                            <td id="buy_payment_id">-</td>
                                            <th>شماره پی گیری:</th>
                                            <td id="buy_trace_number"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="bg-light mb-0">
                                        <div class="row">
                                            <div class="col-sm-12"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 text-center py-4">امضای واحد ذی حساب</div>
                                            <div class="col-sm-6 text-center py-4">امضای دستگاه نظارت</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-1">
                        {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                        <button id="print2" type="submit" class="btn btn-success px-5 ml-0 mr-auto"> پرينت </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="showFactor" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="chargeForm" action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> شارژ اعتبار بلیت الکترونیک  </h5>
                        <button id="FactorCloseBtn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="printArea" class="card-body">
                        <div id="loader2" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                        </div>
                        <div class="invoice p-1 border">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="text-right">رسید شارژ اعتبار بلیت الکترونیک</div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="invoice-brands text-left">
                                        <img class="brand brand-pec" width="80" height="80" alt="Miras" style="filter: invert(1)" src="{{asset("")}}assets/img/mirasw_logo.png">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class=" text-right">
                                        فاکتور فروش:
                                        #
                                        <span id="factor_number" class="font-weight-bold"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-auto">
                                    <div class="invoice-ginfo">
                                        <table class="float-left">
                                            <tbody>
                                            <tr>
                                                <th>تاریخ:</th>
                                                <td id="date"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-12">

                                    <h4 class="text-center font-weight-bold py-3">اطلاعات فاکتور</h4>
                                    <table class="table table-striped bordered text-right" style="font-size:14px;">
                                        <tbody>
                                        <tr>
                                            <th>نام مرکز:</th>
                                            <td style="">استان {{$province_name}} / {{$Account["name"]}} </td>
                                            <th>:نام کاربر</th>
                                            <td id="userName">  </td>
                                        </tr>
                                        <tr>
                                            <th>شناسه پرداخت:</th>
                                            <td>{{$Account["payment_id"]}}</td>
                                            <th>شماره شبای حساب:</th>
                                            <td>{{$Account["shaba"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>مبلغ واریزی:</th>
                                            <td><span id="deposit_amount"></span> ریال</td>
                                            <th>اعتبار بلیت شارژ شده:</th>
                                            <td><span id="transaction_amount"></span> ریال</td>
                                        </tr>
                                        <tr>
                                            <th>بانک مبدا/شعبه:</th>
                                            <td id="source_bank"></td>
                                            <th>شماره فیش:</th>
                                            <td id="reference_number"></td>
                                        </tr>
                                        <tr>
                                            <th>تاریخ واریز:</th>
                                            <td id="payment_datetime" style="direction:ltr"></td>
                                            <th>تاریخ ثبت شارژ:</th>
                                            <td id="created_jalali" style="direction:ltr"></td>
                                        </tr>
                                        <tr>
                                            <th>توضیحات:</th>
                                            <td>-</td>
                                            <th>شماره پی گیری:</th>
                                            <td id="trace_number"></td>
                                        </tr>
                                        <tr>
                                            <th>اسکن مستندات:</th>
                                            <td id="account_doc" class="text-right" style="" colspan="3"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="bg-light mb-0">
                                        <div class="row">
                                            <div class="col-sm-12"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 text-center py-4">امضای واحد ذی حساب</div>
                                            <div class="col-sm-6 text-center py-4">امضای دستگاه نظارت</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-1">
                        {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                        <button id="print"  class="btn btn-success px-5 ml-0 mr-auto"> پرينت </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('AddJs')
    <script src="{{asset('')}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/tableToExcel.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script>
        $('#FromDate').persianDatepicker({
            initialValue: true,
            autoClose : true ,
            format: 'YYYY/MM/DD',
            calendar:{
                persian:{
                    locale: 'fa'
                }
            },navigator:{
                scroll:{
                    enabled:false
                }
            }


        });
        $('#ToDate').persianDatepicker({
            initialValue: true,
            autoClose : true ,
            format: 'YYYY/MM/DD',
            calendar:{
                persian:{
                    locale: 'fa'
                }
            },navigator:{
                scroll:{
                    enabled:false
                }
            },navigator:{
                text:{
                    btnNextText:'بعدی',
                    btnPrevText:'قبلی'
                }
            }

        });

    </script>
    <script>
        $(document).ready(function () {

            $(document).on( "click", ".factorBuy", function () {
                $("#loader3").css("display" , "flex");
                let id = "{{url()->current()}}";
                id = id.split("/");
                id = id[4];
                let trace_number = $(this).attr("data_id") ;
                let type = $("#transaction_type").val();
                // console.log("type => " , type);
                let page = "{{request("page")}}";
                if(page == "")
                    page = 1 ;
                // $("#trace_number , #factor_number").text(trace_number);
                $.ajax({
                    type:'POST',
                    url: "{{Route("GetTransaction")}}" ,
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'account_id' : id ,
                        'page' : page ,
                        'type' : type ,
                        'trace_number' : trace_number ,
                    },
                    statusCode: {
                        500: function() {
                            $("#loader2").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                '',
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
                    success : function (data) {
                        $("#loader3").hide();
                        // console.log("GetChargeTransactions =>" , data) ;
                        let account  = data["GetChargeTransactions"] ;
                        // console.log( "transaction_amount => " , account)
                        $("#buy_deposit_amount").text(number_format(account[0].transaction_amount, 0 , "." , ","));
                        $("#buy_factor_number").text(account[0].trace_number);
                        let date = account[0].created_jalali ;
                        date  = date.split(" ");
                        date = date[0] + "<br>" + date[1];
                        $("#buy_date").html(date);
                        // console.log("additional_data =>" , account[0]["additional_data"]);
                        if(Object.keys(account[0]["description"]).length != 0)
                        {
                            $("#buy_transaction_type").text(account[0]["description"].voucher_type_name);
                            $("#buy_location_name").text(account[0]["description"].location_name);
                            $("#buy_reference_number").text(account[0]["description"].voucher_number);
                            $("#buy_ticket_id").text(account[0]["description"].ticket_number);
                            $("#buy_bill_id").text(account[0]["description"].bill_id);
                            $("#buy_payment_id").text(account[0]["description"].payment_id);
                            $("#buy_trace_number").text(account[0]["description"].RRN);
                        }else
                        {
                            $("#buy_transaction_type").text("");
                            $("#buy_location_name").text("");
                            $("#buy_reference_number").text("");
                            $("#buy_ticket_id").text("");
                            $("#buy_bill_id").text("");
                            $("#buy_payment_id").text("");
                            $("#buy_trace_number").text("");
                        }
                    }
                })
            });
            $(document).on( "click", ".factor", function () {
                $("#loader2").css("display" , "flex");
                let id = "{{url()->current()}}";
                id = id.split("/");
                id = id[4];
                let trace_number = $(this).attr("data_id") ;
                let type = $("#transaction_type").val();
                let page = "{{request("page")}}";
                if(page == "")
                    page = 1 ;
                $("#trace_number , #factor_number").text(trace_number);
                $.ajax({
                    type:'POST',
                    url: "{{Route("GetTransaction")}}" ,
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'account_id' : id ,
                        'page' : page ,
                        'type' : type ,
                        'trace_number' : trace_number ,
                    },
                    statusCode: {
                        500: function() {
                            $("#loader2").hide();
                            Swal.fire(
                                'خطا در دريافت اطلاعات ! ',
                                '',
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
                    success : function (data) {
                        $("#loader2").hide();
                        let account  = data["GetChargeTransactions"] ;
                        let images = data["images_url"] ;
                        let payment_datetime = data["payment_datetime"] ;
                        // console.log("payment_datetime => " ,payment_datetime)
                        // console.log(images)
                        $("#deposit_amount").text(number_format(account.deposit_amount, 0 , "." , ","));
                        let transaction_amount = eval(account.deposit_amount) / 0.85 ;
                        $("#transaction_amount").text(number_format(transaction_amount, 0 , "." , ","));
                        if(Object.keys(account["description_json"]).length != 0)
                        {
                            if(typeof account["description_json"].user === 'undefined') {
                                $("#userName").text(" - ")
                                // console.log("this index was not exist ! ") ;
                            }
                            else {
                                $("#userName").text(account["description_json"].user)
                            }

                            $("#source_bank").text(account["description_json"].source_bank);

                        }else
                        {
                            $("#source_bank").text("");
                            $("#payment_datetime").text("");
                            $("#userName").text(" - ") ;
                        }
                        $("#payment_datetime").text(payment_datetime);
                        $("#reference_number").text(account.reference_number);
                        $("#created_jalali").text(account.created_jalali);
                        let date = account.created_jalali.split(" ");
                        date = date[0] + "<br>" + date[1];
                        $("#date").html(date);

                        let link = "" ;
                        if(images[0] != 0)
                        {
                            link = "<a href='" + images[0] + "' class='docDownload btn btn-sm btn-outline-info'>  <i class=\"material-icons\"> vertical_align_bottom </i> دانلود تصویر  </a>"
                            $("#account_doc").html(link);
                        }
                        else
                        {
                            link = "";
                            $("#account_doc").html("");
                        }
                    }
                })
            });
            $(document).on( "click", "#print2", function (e) {
                e.preventDefault();
                var printContents = document.getElementById('printArea2').innerHTML;
                var mywindow = window.open('', 'new div', 'height=400,width=600');
                mywindow.document.write('<html><head><title></title>');
                mywindow.document.write("<link href=\"{{asset('')}}assets/css/bootstrap-rtl.css\" rel=\"stylesheet\">");
                mywindow.document.write("<link href=\"{{asset('')}}assets/css/material-dashboard.css?v=2.1.2\" rel=\"stylesheet\" />");
                mywindow.document.write('</head><body >');
                mywindow.document.write(printContents);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();
                setTimeout(function(){mywindow.print();},300);

                // var printContents = document.getElementById('printArea2').innerHTML;
                // var originalContents = document.body.innerHTML;
                // document.body.innerHTML = printContents;
                // window.print();
                // document.body.innerHTML = originalContents;
            });
            $(document).on( "click", "#print", function (e) {
                e.preventDefault();
                var printContents = document.getElementById('printArea').innerHTML;
                var mywindow = window.open('', 'new div', 'height=400,width=600');
                mywindow.document.write('<html><head><title></title>');
                mywindow.document.write("<link href=\"{{asset('')}}assets/css/bootstrap-rtl.css\" rel=\"stylesheet\">");
                mywindow.document.write("<link href=\"{{asset('')}}assets/css/material-dashboard.css?v=2.1.2\" rel=\"stylesheet\" />");
                mywindow.document.write('</head><body >');
                mywindow.document.write(printContents);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();
                setTimeout(function(){mywindow.print();},300);

                // var printContents = document.getElementById('printArea').innerHTML;
                // var originalContents = document.body.innerHTML;
                // document.body.innerHTML = printContents;
                // window.print();
                // document.body.innerHTML = originalContents;
                // location.reload();
                // $("body").load();
            });
            $(document).on( "click", ".docDownload", function () {
                var a = document.createElement("a");
                a.href = $(this).attr("href") ;
                a.download = "Image.jpeg";
                a.click();
            });

            $(document).on( "click", ".page_btn", function () {
                let page = $(this).text();
                GetDechargeTransaction(eval(page));
            });

            $("#transaction_type").change(function () {
                let type = $("#transaction_type").val() ;
                if(type == "Decharge")
                    GetDechargeTransaction();
                else
                    GetDechargeTransaction();

            })
            $("#Search_btn").click(function () {
                GetDechargeTransaction();

            })


        });
        $("#pagination").hide();
        function GetDechargeTransaction(curent_page=""){
            $("#loader").css("display" , "flex");
            let page = "{{request("page")}}";
            // console.log("page" , curent_page );
            if(page == "")
                page = 1 ;

            if(curent_page != "")
                page = curent_page ;

            let trace_number = $("#search_trace_number").val();
            let reference_number = $("#search_reference_number").val();
            let FromDate = $("#FromDate").val();
            let ToDate = $("#ToDate").val();
            let transaction_type = $("#transaction_type").val();
            // console.log("transaction_type : " , transaction_type);
            let id = "{{url()->current()}}";
            id = id.split("/");
            id = id[4];
            // console.log(id[4]);
            $.ajax({
                type:'POST',
                url: "{{Route("GetTransactionFilter")}}" ,
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'account_id' : id ,
                    'page' : page ,
                    'trace_number' : trace_number,
                    'reference_number' : reference_number,
                    'FromDate' : FromDate,
                    'ToDate' : ToDate,
                    'type' : transaction_type,
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
                success : function (data) {
                    console.log("data : " , data["Header"]["MessageCode"]);
                    // console.log("page : " , page);
                    let account  = data["GetChargeTransactions"] ;
                    let images = data["images_url"] ;
                    let total_pages = data["total_pages"] ;
                    let page_html = "";
                    if(total_pages > 1 ){
                        $("#pagination").show();
                        let start = 0 ;
                        let end  = 0;
                        $("#pagination .pagination").html("");
                        if (total_pages <= 5)
                        {
                            start = 0 ;
                            end =  total_pages ;
                            for(let i = 1 ; i <= total_pages ; i++){
                                    if(i == page)
                                        page_html = '<li class="page-item page_btn active">\n' ;
                                    else
                                        page_html = '<li class="page-item page_btn">\n' ;

                                    page_html += '<a class="page-link" >'+i+'<div class="ripple-container "></div></a>\n' +
                                        '</li>';
                                    $("#pagination .pagination").append(page_html);
                            }
                        }
                        else {
                        for(let i = 1 ; i <= total_pages ; i++){
                            if(i == 1  || (((i - page) <= 3) && ((i - page) >= 0)) || (((page - i) <= 3) && ((page - i) >= 0) ) || i == total_pages ){
                                if(i == page)
                                    page_html = '<li class="page-item page_btn active">\n' ;
                                else
                                    page_html = '<li class="page-item page_btn">\n' ;

                                page_html += '<a class="page-link" >'+i+'<div class="ripple-container "></div></a>\n' +
                                    '</li>';
                                $("#pagination .pagination").append(page_html);
                            }
                            else if ( (page - i ) == 4 ){
                                page_html = "..."
                                $("#pagination .pagination").append(page_html);
                            }
                            else if ( (i - page) == 4 ){
                                page_html = "..."
                                $("#pagination .pagination").append(page_html);
                            }
                        }
                        }
                    }
                    else
                        $("#pagination").hide();

                    if(data["Header"]["MessageCode"] == 112)
                    {
                        Swal.fire(
                            'خطایی از سمت سوییچ رخ داده است !  ',
                            '',
                            'warning'
                        )
                        $("#loader").hide();
                    }
                    else if (data["Header"]["MessageCode"] == 0)
                    {
                        // console.log("MessageCode zero");
                        // console.log("total_pages : " , total_pages);
                        let table = document.getElementById("AccountTable").getElementsByTagName('tbody')[0];
                        if(account.length == 0 ){
                            $("#tbody").html(" ");
                            var row = table.insertRow();
                            var cell = row.insertCell();
                            cell.id = "myTd";
                            cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                            document.getElementById("myTd").colSpan = "6";
                            $("#loader").hide();
                        }
                        else {
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
                                let showType  = "" ;
                                if( $("#transaction_type").val() == "charge"){
                                    showType = "افزایش اعتبار"
                                }
                                else{
                                    showType = "خرید"
                                }
                                transaction_type.innerHTML = showType ;
                                pigiri_number.innerHTML = account[i].trace_number ;
                                discripton.innerHTML = "-" ;
                                let typeT = $("#transaction_type").val();
                                if(typeT == "charge"){
                                    let image = " <button disabled  class=\"btn btn-success \">دانلود مستندات</button>" ;
                                    if(images[i] != 0 ){
                                        image = " <a href='" + images[i] + "' class=\"btn btn-success docDownload \">دانلود مستندات</a>" ;
                                    }
                                    setting.innerHTML = image +  '<a href="#" data_id="' + account[i].trace_number+ '"  data-toggle="modal" data-target="#showFactor"  class="btn btn-primary factor ">فاکتور فروش</a>' ;
                                }else
                                    setting.innerHTML = '<a href="#" data_id="' + account[i].trace_number+ '"  data-toggle="modal" data-target="#showFactorBuy"  class="btn btn-primary factorBuy "> مشخصات تراکنش</a>' ;

                                // document.getElementsByClassName("myTr").colSpan = "5";

                            }
                            $("#loader").hide();
                        }
                    }
                    else
                    {
                        Swal.fire(
                            'خطایی از سمت سوییچ رخ داده است !  ',
                            '',
                            'warning'
                        )
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
        function export2excel() {
            TableToExcel.convert(document.getElementById("AccountTable"));
        }
    </script>
@endsection
