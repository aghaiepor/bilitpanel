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
                                        <i class="material-icons">integration_instructions</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">اطلاعات ترمینال های موجود</h4>
                                </div>
                                <div class="col-sm">
                                    <a {{--onclick="history.go(-1);"--}} href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-right">
                                    <select id="province" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب استان">
                                        <option value="0" >همه</option>
                                        @foreach( $provinces as $province)
                                            <option value="{{$province['id']}}" >{{$province['province_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 text-right">
                                    <select id="cityList" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب شهر">
                                        <option value="2"> همه </option>
                                    </select>
                                </div>
                                <div class="col-md-auto ml-auto">
                                    <button class="btn bgPer"> فیلتر
                                    </button>
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
                                            نام مکان
                                        </th>
                                        <th >
                                            آدرس مکان
                                        </th>

                                        <th >
                                            تعریف حساب تسویه
                                        </th>
                                        <th >
                                            مدیریت ترمینال
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i = 0 ;
                                    @endphp
                                    @if(count($locations) <=0)
                                        <tr>
                                            <td colspan="7">
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
                                                    <button data-toggle="modal" data-target="#Edit{{$i}}" type="button" rel="tooltip" @if(!is_null($location['payment_id'])) disabled @endif class="btn  btn-success">
                                                        <i class="material-icons">add</i>
                                                        تعریف حساب
                                                    </button>
                                                        <div class="modal fade" id="Edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <form method="post" action="{{Route('AddClearingAccount' , ['id'=> $location['id']] )}}">
                                                                    @csrf
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title " >  تعریف حساب </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-row mt-2 justify-content-center align-items-center">
                                                                                <div class="col-md text-right">
                                                                                    <label for="" > نام پروژه</label>
                                                                                    <input name="project_name" type="text" class="form-control" placeholder="نام  پروژه">
                                                                                </div>
                                                                                <div class="col-md text-right">
                                                                                    <label for="" >نام مالک</label>
                                                                                    <input name="owner_name" type="text" class="form-control"  placeholder="نام مالک">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-row mt-2">
                                                                                <div class="col-md text-right">
                                                                                    <label for="" > شماره حساب </label>
                                                                                    <input type="shaba" class="form-control" placeholder="شماره حساب">
                                                                                </div>
                                                                                <div class="col-md text-right">
                                                                                    <label for="" > شماره حسابشناسه پرداخت </label>
                                                                                    <input type="payment_id" class="form-control" placeholder="شماره حسابشناسه پرداخت">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer mt-4">
                                                                                {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                                <button  type="submit" class="btn btn-success px-5 ml-0 mr-auto"> تعریف  </button>
                                                                            </div>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                        </div>


                                                </td>
                                                <td>
                                                    @if(is_null($location['payment_id']))
                                                    <button   disabled rel="tooltip" class="btn  btn-primary btn-simple">
                                                        <i class="material-icons">settings </i>
                                                        مدیریت ترمینال
                                                    </button>
                                                        @else
                                                    <a href="{{Route('terminalInfo' , ['id' => $location['id']])}}" @if(!is_null($location['payment_id'])) disabled @endif  rel="tooltip" class="btn  btn-primary btn-simple">
                                                        <i class="material-icons">settings </i>
                                                        مدیریت ترمینال
                                                     </a>
                                                        @endif

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
            $('#province').change(function () {
                var province_id = $('#province').val();
                $('#loader').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('CityList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'province_id' : province_id ,
                    },
                    success:function(data) {
                        $('#loader').hide();
                        $("#cityList").html('');
                        $("#cityList").append(new Option( 'همه' , '',true));
                        for(var i = 0 ; i < data.data.length ; i++){
                            if(cityList == data.data[i].id )
                                $("#cityList").append(new Option( data.data[i].city_name , data.data[i].id , true));
                            else
                                $("#cityList").append(new Option( data.data[i].city_name , data.data[i].id));

                        }
                        $('.selectpicker').selectpicker('refresh');
                    }
                });
            });


        });
    </script>
@endsection
