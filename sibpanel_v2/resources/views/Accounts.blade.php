@extends('MainLayout')

@section('title')
    <title>
        مدیریت حساب
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت حساب </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>تعریف نوع جدید</span>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                           نام حساب
                                        </th>
                                        <th >
                                            حساب
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                <h6 class="text-center py-5">
                                                    موردی یافت نشد !
                                                </h6>
                                            </td>
                                        </tr>
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
        <form action="#" method="post">
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
