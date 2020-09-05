@extends('MainLayout')

@section('title')
    <title>
        مدیریت متن بلیت
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت متن بلیت </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> متن جدید </span>
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
                                            متن بالای فارسی
                                        </th>
                                        <th >
                                            متن بالای انگلیسی
                                        </th>
                                        <th >
                                            متن پایین فارسی
                                        </th>
                                        <th >
                                            متن پایین انگلیسی
                                        </th>
                                        <th >
                                            ویرایش متن
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i= 0 ;
                                    @endphp
                                    @foreach($voucherTexts as $voucherText)
                                        <tr>
                                            <td>
                                                {{$voucherText['top_text']}}
                                            </td>
                                            <td>
                                                {{$voucherText['english_top_text']}}

                                            </td>
                                            <td>
                                                {{$voucherText['bottom_text']}}
                                            </td>
                                            <td>
                                                {{$voucherText['english_bottom_text']}}
                                            </td>
                                            <td>
                                                <button data-toggle="modal" id="statebtn" data-target="#edit{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple">
                                                    <i class="material-icons">edit</i>
                                                    ویرایش
                                                </button>
                                                <div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form method="post" action="{{Route('EditVoucherText' , ['id'=>$voucherText['id']])}}">
                                                        @csrf
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title " id="testLabel"> اضافه کردن متن بلیت </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-row mt-3">
                                                                    <div class="col-md text-right">
                                                                        <label for="" class="text-right"> متن فارسی بالای بلیت </label>
                                                                        <textarea  class="form-control" style="height: auto !important;" name="top_text" id="" cols="30" rows="3">{{$voucherText['top_text']}}</textarea>
                                                                    </div>
                                                                    <div class="col-md text-right">
                                                                        <label for="" class="text-right">  متن فارسی پایین بلیت </label>
                                                                        <textarea class="form-control" style="height: auto !important;" name="bottom_text" id="" cols="30" rows="3">  {{$voucherText['bottom_text']}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mt-3">
                                                                    <div class="col-md text-right">
                                                                        <label for="" class="text-right">متن انگلیسی بالای بلیت </label>
                                                                        <textarea class="form-control" style="height: auto !important;" name="english_top_text" id="" cols="30" rows="3">  {{$voucherText['english_top_text']}}</textarea>
                                                                    </div>
                                                                    <div class="col-md text-right">
                                                                        <label for="" class="text-right">  متن انگلیسی پایین بلیت </label>
                                                                        <textarea class="form-control" style="height: auto !important;" name="english_bottom_text" id="" cols="30" rows="3"> {{$voucherText['english_bottom_text']}}</textarea>
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
                                                <a href="{{Route("DeleteVoucherText" , ['id' => $voucherText['id'] ])}}" class="btn TableEditBtn btn-danger btn-simple">
                                                    <i class="material-icons">close</i>
                                                    حدف
                                                </a>
                                            </td>

                                        </tr>
                                        @php $i++ ; @endphp
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
        <form action="{{Route('AddVoucherText')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> اضافه کردن متن بلیت </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> متن فارسی بالای بلیت </label>
                            <textarea name="top_text" class="form-control" style="height: auto !important;" id="" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  متن فارسی پایین بلیت </label>
                            <textarea class="form-control" name="bottom_text" style="height: auto !important;" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right">متن انگلیسی بالای بلیت </label>
                            <textarea class="form-control" name="english_top_text" style="height: auto !important;" id="" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  متن انگلیسی پایین بلیت </label>
                            <textarea class="form-control" name="english_bottom_text" style="height: auto !important;" id="" cols="30" rows="3"></textarea>
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
