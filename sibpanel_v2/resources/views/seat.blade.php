@extends('MainLayout')

@section('title')
    <title>
        سانس های فعال
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/seance.css') }}">

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
    <div class="modal fade" id="location_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >انتخاب مکان</h5>
                </div>
                <div class="modal-body">
                    <table class=" table table-striped " style="text-align: right" id="modal_data">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
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
                                    <h4 class="card-title text-right font-weight-bold "> صندلی </h4>
                                </div>
                                <div class="col-sm">
                                    {{-- <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> جدید </span>--}}
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <div style="width: 50px" class="seat border d-flex justify-content-center align-center">
                                        <i style="font-size: 12pt" class="fa text-dark fa-loveseat"></i>
                                        <p>
                                            1
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="modal fade" id="showSanas" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form method="post" action="">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="testLabel"> سانس ها  </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped text-center">
                                    <thead class="text-primary">
                                    <tr>
                                        <th>
                                            سانس
                                        </th>
                                        <th>
                                            تاریخ
                                        </th>
                                        <th>
                                            زمان شروع
                                        </th>
                                        <th>
                                            زمان پایان
                                        </th>
                                        <th>
                                            شماره بلیت
                                        </th>
                                        <th>
                                            ويرايش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                           شماره یک
                                        </td>
                                        <td>
                                           1399/01/01
                                        </td>
                                        <td>
                                            9:00
                                        </td>
                                        <td>
                                            10:00
                                        </td>
                                        <td>
                                           23
                                        </td>
                                        <td>
                                           <button class="btn btn-danger">
                                               حذف
                                           </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                                <button data-toggle="modal" data-target="#sanas" type="button" class="btn px-5 btn-success ml-0 mr-auto"> افزودن سانس هاي ديگر مکان ها </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal fade" id="sanas" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="testLabel"> افزودن سانس مکان  </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <table class="table table-striped ">
                                    <thead class="text-primary">
                                    <tr>
                                        <th class="text-right">
                                            نام مکان
                                        </th>
                                        <th>
                                        -
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-right">
                                            شماره یک
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">
                                            شماره دو
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">
                                            شماره سه
                                        </td>
                                        <td class="text-left">
                                            <button class="btn btn-success">
                                                <span class="material-icons">add_circle_outline</span>
                                                افزودن
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                                <button type="button" class="btn px-5 btn-success ml-0 mr-auto"> اعمال </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
@endsection
@section('AddJs')

        <script>
            $(document).ready(function () {
                console.log("ok ");
            });
        </script>
@endsection

