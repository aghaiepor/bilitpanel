@extends('MainLayout')

@section('title')
    <title>
        مدیریت استان
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <div class="content">
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
                                        <i class="material-icons">location_city</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت ترمینال های </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  افزودن ترمیتال جدید</span>
                                    <a onclick="history.go(-1);" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table class="table text-center">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th >شماره ترمینال

                                        </th>
                                        <th >سریال ترمینال

                                        </th>
                                        <th >نوع ترمینال

                                        </th>
                                        <th >دامنه

                                        </th>
                                        <th >سریال دستگاه

                                        </th>
                                        <th >ویرایش

                                        </th>
                                        <th>حذف

                                        </th>



                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> تست </td>
                                        <td>تست</td>
                                        <td>تست</td>
                                        <td>تست</td>
                                        <td>تست</td>
                                        <td>تست</td>
                                        <td>تست</td>
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
        <form action="{{Route('AddProvince')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن ترمیتال جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm text-right">
                            <label for="">  انتخاب پروژه </label>
                            <select name="projects" class="selectpicker" data-style="btn btn-primary border-dark" title="انتخاب پروژه">
                               {{-- @foreach($projectList as $project)
                                    <option value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                @endforeach--}}
                            </select>
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  نام  استان </label>
                            <input name="name_fa" type="text" class="form-control" id="nameStateFa" placeholder="نام  استان">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">   نام  استان به انگلیسی </label>
                            <input name="name_en" type="text" class="form-control" id="nameStateEn" placeholder=" نام  استان به انگلیسی">
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
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
@endsection
