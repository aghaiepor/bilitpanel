@extends('MainLayout')

@section('title')
    <title>
        مدیریت بلیت های {{$GetServices['service_name']}}
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
<div class="content">
    <div class="content">
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
                                    <h4 class="card-title text-right font-weight-bold ">  مدیریت بلیت های  {{$GetServices['service_name']}}</h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  تعریف بلیت </span>
                                    <a href="{{Route("GetService" , ['id' => $GetServices['service_id']])}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
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
                                            مبلغ
                                        </th>
                                        <th >
                                            ظرفیت کل
                                        </th>
                                        <th >
                                            ظرفیت باقی مانده
                                        </th>
                                        <th >
                                            نوع بلیت
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($VoucherInfo) == 0)
                                        <tr>
                                            <td colspan="5">
                                                <h6 class="py-5 text-center"> بلیتی یافت نشد ! </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @for($i = 0 ; $i < count($VoucherInfo) ; $i++)
                                            <tr>
                                                <td>
                                                    {{number_format($VoucherInfo[$i]['amount'],0,'.',',')}}
                                                </td>
                                                <td>
                                                    {{$VoucherInfo[$i]['total_capacity']}}
                                                </td>
                                                <td>
                                                    {{$VoucherInfo[$i]['remain_capacity']}}
                                                </td>
                                                <td>
                                                    {{$VoucherInfo[$i]['voucher_type_name']}}
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#edit{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn  btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form method="post" action="{{Route('EditVoucherInfo' , ['service_id'=>$VoucherInfo[$i]['service_id'] , 'location_id'=> $VoucherInfo[$i]['location_id'] ,'id'=>$VoucherInfo[$i]['id']])}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title " id="edit1Label">  ویرایش بلیت </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-row mt-3">
                                                                            <div class="col-sm text-right">
                                                                                <label for=""> مبلغ به ریال </label>
                                                                                <input value="{{$VoucherInfo[$i]['amount']}}" name="amount" type="text" class="form-control"  placeholder="مبلغ به ریال">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for=""> ظرفیت </label>
                                                                                <input value="{{$VoucherInfo[$i]['total_capacity']}}" name="capacity" type="text" class="form-control"  placeholder="ظرفیت">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for="">  نوع بلیت </label>
                                                                                <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                                                                    <option disabled> نوع بلیت </option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "نیم بها") selected @endif value="2">نیم بها</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "ایرانی") selected @endif value="3">ایرانی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "رایگان") selected @endif value="1">رایگان</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "ایرانی گروهی") selected @endif value="5">ایرانی گروهی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "خارجی") selected @endif value="4">خارجی</option>
                                                                                    <option @if($VoucherInfo[$i]['voucher_type_name'] == "خارجی گروهی") selected @endif value="6">خارجی گروهی</option>
                                                                                </select>
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
                                                    <button type="button" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
                                                        <i class="material-icons">close</i>
                                                        حدف
                                                    </button>
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
</div>
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{Route('AddVoucherInfo' , ['service_id'=>$service_id , 'location_id' =>$location_id])}}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن بلیت </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for=""> مبلغ به ریال </label>
                            <input type="text" class="form-control" name="amount" placeholder="مبلغ به ریال">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> ظرفیت </label>
                            <input type="text" class="form-control" name="capacity" placeholder="ظرفیت">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> نوع بلیت </label>
                            <select name="voucher_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع بلیت">
                                <option disabled> نوع بلیت </option>
                                <option value="2">نیم بها</option>
                                <option value="3">ایرانی</option>
                                <option value="1">رایگان</option>
                                <option value="5">ایرانی گروهی</option>
                                <option value="4">خارجی</option>
                                <option value="6">خارجی گروهی</option>
                            </select>
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
    <script src="{{asset('')}}assets/js/plugins/bootstrap-selectpicker.js"></script>
@endsection
