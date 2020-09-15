@extends('MainLayout')

@section('title')
    <title>
        @if($report_type == 0)
            گزارش ریز تراکنش
        @else
            گزارش ریز تراکنش پیش فروش
        @endif
    </title>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .dropdown-menu{
            width:  270px !important ;
            min-width: 270px !important ;
            max-width: 270px !important ;
        }
        .datepicker-navigator .title{
            margin: 0 !important;
            min-height: 0 !important;

        }
    </style>
@endsection

@section('content')
<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose pb-2 border-bottom">
                            <div class="row">
                                <div class="col-md">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">article</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">
                                        @if($report_type == 0)
                                            گزارش ریز تراکنش
                                        @else
                                            گزارش ریز تراکنش پیش فروش
                                        @endif

                                    </h4>
                                </div>
                                <div class="col-md">
                                    <a {{--onclick="history.go(-1);"--}} href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <form action="{{Route('GetTransaction')}}" method="get">
                                <input type="hidden" name="reportType" value="{{$report_type}}">
                            <div class="row mt-3">
                                <div class="col-md-3 text-right">
                                    <label for=""> انتخاب استان  </label>
                                    <select name="province_id" id="province"  class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب استان">
                                        <option value="" selected> همه </option>
                                        @foreach($ProvinceList as $Province)
                                            @if(request('province_id') == $Province['id'])
                                                <option selected value="{{$Province['id']}}"> {{$Province['province_name']}} </option>
                                            @else
                                                <option value="{{$Province['id']}}"> {{$Province['province_name']}} </option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    <label for=""> انتخاب شهر  </label>
                                    <select  name="city_id" id="cityList" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب شهر">
                                        <option selected value=""> همه </option>
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    <label for=""> انتخاب مکان   </label>
                                    <select  name="location_id" id="locationList" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب مکان">
                                        <option selected value=""> همه </option>
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    <label for=""> انتخاب موزه </label>
                                    <select  name="service_id" id="ServiceList"  class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="انتخاب موزه">
                                        <option selected value=""> همه </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3  text-right">
                                    <label for="">  نوع بلیت </label>
                                    <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                        <option selected value="">همه</option>
                                        @foreach($tikcetType as $ticket)
                                            @if(request('voucher_type_id') == $ticket['voucher_type_id'])
                                                <option selected value="{{$ticket['voucher_type_id']}}"> {{$ticket['voucher_type']}} </option>
                                            @else
                                                <option value="{{$ticket['voucher_type_id']}}"> {{$ticket['voucher_type']}} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3  text-right">
                                    <label for="">  نوع پرداخت </label>
                                    <select name="sell_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع پرداخت">
                                        <option selected value="">همه</option>
                                        @foreach($SaleTypeList as $SaleType)
                                            @if(request('sell_type_id') == $SaleType['sale_type_id'] )
                                                <option selected value="{{$SaleType['sale_type_id']}}">{{$SaleType['sale_type']}}</option>
                                            @else
                                                <option value="{{$SaleType['sale_type_id']}}">{{$SaleType['sale_type']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3  text-right">
                                    <label for="">  وضعیت بلیت </label>
                                    <select name="status_code" class="selectpicker" data-style="btn btn-primary border-dark" title="وضعیت بلیت">
                                        <option @if(request('status_code') == "255") selected @endif value="255">همه</option>
                                        <option @if(request('status_code') == "1") selected @endif value="1">استفاده نشده</option>
                                        <option @if(request('status_code') == "3") selected @endif value="3">حذف شده</option>
                                        <option @if(request('status_code') == "5") selected @endif value="5">استفاده شده</option>
                                    </select>
                                </div>
                                <div class="col-md-3  text-right">
                                    <label for="">  اپراتور </label>
                                    <select name="operator_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="اپراتور">
                                            <option value="" selected> همه </option>
                                        @foreach($SellerUsersList as $Seller)
                                            @if(request('operator_id') == $Seller['sib_user_id'])
                                                <option selected value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                            @else
                                                <option value="{{$Seller['sib_user_id']}}">{{$Seller['first_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @if($report_type == 0)
                                    <div class="col-md-3 text-right">
                                        <label for="">  نوع فروش  </label>
                                        <select name="pre_sale" class="selectpicker" data-style="btn btn-primary border-dark" title="ییش فروش">
                                            <option value="" selected> همه  </option>
                                            <option @if(request('pre_sale') == "2") selected @endif value="2"> عادی </option>
                                            <option @if(request('pre_sale') == "1") selected @endif value="1"> پیش فروش </option>
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-3 text-right">
                                    <label for="">  تاریخ شروع  </label>
                                    <input id="FromDate" name="startDate" type="text" class="form-control" placeholder="از تاریخ">
                                </div>
                                <div class="col-md-3 text-right">
                                    <label for="">  تاریخ پایان  </label>
                                    <input id="ToDate" name="endtDate" type="text" class="form-control" placeholder="تا تاریخ">
                                </div>
                                    <input type="hidden" name="page" value="1">
                                <div class="col-md-3 mr-auto">
                                    <label for="">&nbsp;</label>
                                   <button type="submit" class="btn bgPer btn-block"> جست و جو <i class="material-icons"> search</i> </button>
                                </div>
                            </div>
                            <!-- Modal -->
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table id="TransationTable"  class="table text-center">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th class="text-left" colspan="10">
                                            @php
                                                $url = str_replace("GetTransaction","transactionToExcel",\Illuminate\Support\Facades\URL::full())
                                            @endphp
                                            <a id="excelBtn" href="{{$url}}" target="_blank" anchor="download" class="btn btn-success  mt-2 "> دانلود اکسل <i class="material-icons"> vertical_align_bottom </i>  </a>
                                        </th>
                                    </tr>
                                    <tr class="">
                                        <th>
                                            نام مکان
                                        </th>
                                        <th >
                                            نام جاذبه
                                        </th>
                                        <th >
                                            شماره بلیت
                                        </th>
                                        <th >
                                            RRN
                                        </th>
                                        <th >
                                            نوع بلیت
                                        </th>
                                        <th >
                                            نوع پرداخت
                                        </th>
                                        <th >
                                            وضعیت پرداخت
                                        </th>
                                        <th >
                                            تعداد
                                        </th>
                                        <th >
                                            زمان تراکنش
                                        </th>
                                        <th >
                                            جمع کل ریال
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($data == null || count($data['log']) == 0 )
                                        <tr>
                                            <td colspan="10">
                                                <h6 class="text-center py-5"> موردی یافت نشد ! </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($data['log'] as $result)
                                            <tr>
                                                <td>
                                                    {{$result['location_name']}}
                                                </td>
                                                <td>
                                                    {{$result['service_name']}}
                                                </td>
                                                <td>
                                                    {{$result['voucher_number']}}
                                                </td>
                                                <td>
                                                    {{$result['RRN']}}
                                                </td>
                                                <td>
                                                    {{$result['voucher_type_name']}}
                                                </td>
                                                <td>
                                                    {{$result['sale_type_name']}}
                                                </td>
                                                <td>
                                                    {{$result['procedure_status']}}
                                                </td>
                                                <td>
                                                    {{ number_format($result['ticket_number'] , 0 , '.' , ',')}}
                                                </td>

                                                <td>
                                                    {{$result['get_voucher_date_jalali'] }}
                                                </td>
                                                <td>
                                                    @if(request('reportType') == 1)
                                                        {{number_format($result['amount'] * 0.85 , 0 ,'.' , ',' )}}
                                                    @else
                                                        {{number_format($result['amount'] , 0 ,'.' , ',' )}}
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                        <tr class="bg-light">
                                            <th colspan="6" class="text-right" >
                                                جمع
                                            </th>
                                            <th colspan="2" class="text-center" >
                                                {{ number_format($data['total_count'] , 0 , '.' , ',')}}

                                            </th>
                                            <th colspan="2" class="text-center">
                                                @if(request('reportType') == 1)
                                                    {{ number_format($data['total_amount'] * 0.85 , 0 , '.' , ',')}}   ریال &nbsp;
                                                @else
                                                    {{ number_format($data['total_amount'] , 0 , '.' , ',')}}   ریال &nbsp;
                                                @endif
                                            </th>
                                        </tr>

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <ul class="pagination justify-content-center">
                                @if($data != null /*|| count($data['log']) != 0 */)
                                    @php
                                        $result = new \Illuminate\Pagination\LengthAwarePaginator( $data['log'],$data['total_pages'], 1,  \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage(),array('path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()));
                                        $page = (int)request('page') ;
                                        $result->withPath(url()->full());
                                    @endphp
                                    {{$result->render()}}
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{asset('')}}assets/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/js/tableToExcel.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
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

            let start = "{{request('startDate')}}";
            if(start != '')
                $("#FromDate").val(start);

            let end = "{{request('endDate')}}";
            if(end != '')
                $("#ToDate").val(end);
        });
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            province= "{{request('province_id')}}";
            cityList = "{{request('city_id')}}";
            locationList = "{{request('location_id')}}";
            service_id = "{{request('service_id')}}";

            if(province != ''){
                var province_id = province;
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
                            if(cityList == data.data[i].id )
                                $("#cityList").append('<option selected value="' + data.data[i].id + '">' + data.data[i].city_name + '</option>');
                            else
                                $("#cityList").append(new Option( data.data[i].city_name , data.data[i].id));

                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }
            if(cityList != ''){
                var province_id = province;
                var city_id = cityList;
                $.ajax({
                    type:'POST',
                    url:"{{Route('location_list')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                        'city_id' : city_id ,
                    },
                    success:function(data) {
                        $("#locationList").html('');
                        $("#locationList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.data.length ; i++){
                            if(locationList == data.data[i].id ){
                                $("#locationList").append('<option selected value="' + data.data[i].id + '">' + data.data[i].location_name + '</option>');
                            }
                            else
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                        $('.selectpicker').on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {
                            var selected = $(e.currentTarget).val();
                        });
                    }
                });
            }
            if(locationList != ''){
                var locationID = locationList;
                $.ajax({
                    type:'POST',
                    url:"{{Route('ServiceListReport')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'locationID' : locationID ,
                    },
                    success:function(data) {
                        $("#ServiceList").html('');
                        $("#ServiceList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.array_keys.length ; i++){
                            if(service_id == data.data[[data.array_keys[i]]].service_id  ){
                                $("#ServiceList").append('<option selected value="' + data.data[[data.array_keys[i]]].service_id + '">' +  data.data[[data.array_keys[i]]].service_name + '</option>');
                            }
                            else
                                $("#ServiceList").append(new Option( data.data[[data.array_keys[i]]].service_name , data.data[[data.array_keys[i]]].service_id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            }

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
            $('#cityList , #province').change(function () {
                var province_id = $('#province').val();
                var city_id = $('#cityList').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('location_list')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                        'city_id' : city_id ,
                    },
                    success:function(data) {
                        $("#locationList").html('');
                        $("#locationList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.data.length ; i++){
                            if(city_id == data.data[i].id )
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id , true));
                            else
                                $("#locationList").append(new Option( data.data[i].location_name , data.data[i].id));
                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });
            $('#cityList , #province , #locationList').change(function () {
                var locationID = $('#locationList').val();
                $.ajax({
                    type:'POST',
                    url:"{{Route('ServiceListReport')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'locationID' : locationID ,
                    },
                    success:function(data) {
                        $("#ServiceList").html('');
                        $("#ServiceList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i< data.array_keys.length ; i++){
                            $("#ServiceList").append(new Option( data.data[[data.array_keys[i]]].service_name , data.data[[data.array_keys[i]]].service_id));
                        }

                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });

            $('.selectpicker').selectpicker('refresh');

            $("#excelBtn").click(function (e)
            {
                e.preventDefault();
                Swal.fire(
                    'در حال دانلود... ',
                    ' این در خواست ممکن است کمی طول بکشد ، لطفا صبور باشید. ',
                    'info'
                )
               let href = $("#excelBtn").attr("href") ;
                setTimeout(function () {
                    window.open(href, "_blank");
                } , 1500)

            });

            // $('#TransationTable').DataTable();
        });
    </script>
@endsection
