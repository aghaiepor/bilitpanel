@extends('MainLayout')

@section('title')
    <title>
        مدیریت تخفیف
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت تخفیف </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> افزودن </span>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
{{--                                <table class="table text-center">--}}
{{--                                    <thead class=" text-primary">--}}
{{--                                    <tr class="">--}}
{{--                                        <th >--}}
{{--                                            متن بالای فارسی--}}
{{--                                        </th>--}}
{{--                                        <th >--}}
{{--                                            متن بالای انگلیسی--}}
{{--                                        </th>--}}
{{--                                        <th >--}}
{{--                                            متن پایین فارسی--}}
{{--                                        </th>--}}
{{--                                        <th >--}}
{{--                                            متن پایین انگلیسی--}}
{{--                                        </th>--}}
{{--                                        <th >--}}
{{--                                            ویرایش متن--}}
{{--                                        </th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    --}}

{{--                                    </tbody>--}}
{{--                                </table>--}}
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
                    <h5 class="modal-title " id="testLabel"> اضافه کردن تخفیف </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> درصد تخفیف </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  پروژه </label>
                            <select id="transaction_type" name="" class="selectpicker" data-style="btn btn-primary border-dark" title="پروژه">
                                <option  value=""  > همه </option>
                                <option value="" selected > گردشگری </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> مکان </label>
                            <select id="transaction_type" name="" class="selectpicker" data-style="btn btn-primary border-dark" title="مکان">
                                <option value="all"  > همه </option>
                                <option value=""> افزایش اعتبار </option>
                            </select>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  سرویس </label>
                            <select id="transaction_type" name="" class="selectpicker" data-style="btn btn-primary border-dark" title="سرویس">
                                <option value="all"  > همه </option>
                                <option value="" selected > سرویس شماره 1  </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> بلیت  </label>
                            <select id="transaction_type" name="" class="selectpicker" data-style="btn btn-primary border-dark" title="مکان">
                                <option value="all"  > همه </option>
                                <option value=""> بلیت شماره 1 </option>
                            </select>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  کاربر </label>
                            <select id="transaction_type" name="" class="selectpicker" data-style="btn btn-primary border-dark" title="کاربر">
                                <option value="all"  > همه </option>
                                <option value="" selected > مهندس آقایی  </option>
                            </select>
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
    <script src="{{asset("")}}assets/js/plugins/bootstrap-selectpicker.js"></script>
@endsection
