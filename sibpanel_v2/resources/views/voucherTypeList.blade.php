@extends('MainLayout')

@section('title')
    <title>
        مدیریت نوع بلیت
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
                                        <i class="material-icons">confirmation_number</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت نوع بلیت </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>تعریف نوع جدید</span>
                                    <a onclick="history.go(-1);" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                            نوع به فارسی
                                        </th>
                                        <th >
                                            نوع به انگلیسی
                                        </th>
                                        <th >
                                            زبان
                                        </th>
                                        <th >
                                            رایگان
                                        </th>
                                        <th >
                                            حداقل تعداد
                                        </th>
                                        <th >
                                            حداکثر تعداد
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i = 0 ;
                                    @endphp
                                    @foreach($voucherTypeList as $voucherType)
                                        <tr>
                                            <td>
                                                {{$voucherType['voucher_type']}}

                                            </td>
                                            <td>
                                                {{$voucherType['english_name']}}
                                            </td>
                                            <td>
                                                @if($voucherType['language'] == "persian")
                                                    فارسی
                                                @elseif($voucherType['language'] == "english")
                                                    انگلیسی
                                                @endif
                                                {{--{{$voucherType['language']}}--}}
                                            </td>
                                            <td>
                                                @if($voucherType['is_free'])
                                                    بله
                                                @elseif($voucherType['is_free'] == false)
                                                    خیر
                                                @endif
                                            </td>
                                            <td>
                                                {{$voucherType['min_ticket_count']}}

                                            </td>
                                            <td>
                                                {{$voucherType['max_ticket_count']}}
                                            </td>
                                            <td>
                                                <button data-toggle="modal" data-target="#edit{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple">
                                                    <i class="material-icons">edit</i>
                                                    ویرایش
                                                </button>
                                                <div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form action="{{Route('EditVoucherType' , ['id'=> $voucherType['voucher_type_id']])}}" method="post">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title " id="testLabel"> تعریف نوع جدید </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-row mt-3">
                                                                        <div class="col-sm-6 text-right">
                                                                            <label for=""> نام فارسی </label>
                                                                            <input name="name_fa" value="{{$voucherType['voucher_type']}}" type="text" class="form-control" placeholder="نام  فارسی">
                                                                        </div>
                                                                        <div class="col-sm-6 text-right">
                                                                            <label for=""> نام انگلیسی </label>
                                                                            <input name="name_en" type="text" class="form-control" value="{{$voucherType['english_name']}}" placeholder=" نام انگلیسی">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-3">
                                                                        <div class="col-sm-6 text-right">
                                                                            <label for=""> حداقل تعداد (خالی برای صفر) </label>
                                                                            <input type="text" name="min_count" class="form-control" value="{{$voucherType['min_ticket_count']}}" placeholder="حداقل تعداد (خالی برای صفر) ">
                                                                        </div>
                                                                        <div class="col-sm-6 text-right">
                                                                            <label for=""> حداکثر تعداد (خالی برای نامشخص) </label>
                                                                            <input type="text" name="max_count" class="form-control" value="{{$voucherType['max_ticket_count']}}" placeholder="حداکثر تعداد (خالی برای نامشخص)">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-3">
                                                                        <div class="col-sm-6 font-weight-bold text-right">
                                                                            زبان :
                                                                            <div class="form-check form-check-radio form-check-inline mr-0">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"  type="radio" name="language" value="persian" @if( $voucherType['language'] == 'persian' ) checked="" @endif> فارسی
                                                                                    <span class="circle">
                                                                                  <span class="check"></span>
                                                                                </span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-radio form-check-inline mr-0">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input" type="radio" name="language" value="english" @if( $voucherType['language'] == 'english' ) checked="" @endif> انگلیسی
                                                                                    <span class="circle">
                                                                                  <span class="check"></span>
                                                                                </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 font-weight-bold text-right">
                                                                            رایگان :
                                                                            <div class="form-check form-check-radio form-check-inline mr-0">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input" type="radio" name="is_free" value="1"  @if( $voucherType['is_free'] == true) checked="" @endif> بلی
                                                                                    <span class="circle">
                                                                                  <span class="check"></span>
                                                                                </span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-radio form-check-inline mr-0">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input" type="radio" name="is_free" value="0" @if( !$voucherType['is_free']) checked="" @endif > خیر
                                                                                    <span class="circle">
                                                                                  <span class="check"></span>
                                                                                </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer mt-4">
                                                                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                    <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> ویرایش </button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                               {{-- <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
                                                    <i class="material-icons">close</i>
                                                    حدف
                                                </button>--}}
                                            </td>
                                        </tr>
                                        @php
                                            $i++ ;
                                        @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('AddVoucherType')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> تعریف نوع جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> نام فارسی </label>
                            <input name="name_fa" type="text" class="form-control" id="nameStateFa" placeholder="نام  فارسی">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for=""> نام انگلیسی </label>
                            <input name="name_en" type="text" class="form-control" id="nameStateEn" placeholder=" نام انگلیسی">
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> حداقل تعداد (خالی برای صفر) </label>
                            <input name="min_count" type="text" class="form-control" value=""  placeholder="حداقل تعداد (خالی برای صفر) ">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for=""> حداکثر تعداد (خالی برای نامشخص) </label>
                            <input name="max_count" type="text" class="form-control" value="" placeholder="حداکثر تعداد (خالی برای نامشخص)">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm-6 font-weight-bold text-right">
                            زبان :
                            <div class="form-check form-check-radio form-check-inline mr-0">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="language" value="persian" checked=""> فارسی
                                    <span class="circle">
                              <span class="check"></span>
                            </span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio form-check-inline mr-0">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="language" value="english"> انگلیسی
                                    <span class="circle">
                              <span class="check"></span>
                            </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 font-weight-bold text-right">
                            رایگان :
                            <div class="form-check form-check-radio form-check-inline mr-0">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="is_free" value="true"> بلی
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio form-check-inline mr-0">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="is_free" value="false" checked=""> خیر
                                    <span class="circle">
                                      <span class="check"></span>
                                    </span>
                                </label>
                            </div>
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
@endsection
@section('AddJs')

@endsection
