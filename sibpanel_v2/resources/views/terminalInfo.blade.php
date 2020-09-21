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
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1">
                                        <i class="material-icons"> add_circle_outline </i>
                                        افزودن ترمینال جدید
                                    </span>
                                    <a href="{{Route("terminals")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                        <th>
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i =0;
                                    @endphp
                                    @if(is_null($TerminalLocationList))
                                        <tr>
                                            <td colspan="7">
                                                <h6 class="text-center py-5"> موردی یافت نشد !  </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($TerminalLocationList as $TerminalLocation)
                                            <tr>
                                                <td> {{$TerminalLocation['terminal_id']}} </td>
                                                <td>{{$TerminalLocation['serial_number']}}</td>
                                                <td>{{$TerminalLocation['type_id']}}</td>
                                                <td>
                                                    @if($TerminalLocation['domain'] == null)
                                                        None
                                                    @else
                                                        {{$TerminalLocation['domain']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($TerminalLocation['imei'] == null)
                                                        None
                                                    @else
                                                        {{$TerminalLocation['imei']}}
                                                    @endif


                                                </td>
                                                <td>
                                                    <button data-toggle="modal" id="statebtn" data-target="#edit_modal{{$i}}"  type="submit" class="btn btn-success px-5 ml-0 mr-auto form_submit"> ویرایش  </button>
                                                    <div class="modal fade" id="edit_modal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="{{Route('EditAssignTerminal' , ['id'=>])}}" method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title " id="testLabel">  ویرایش ترمینال </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-row">
                                                                            <div class="col-sm text-right">
                                                                                <label for="">  شماره ترمینال </label>
                                                                                <input name="name_fa" type="text" class="form-control" id="nameStateFa" placeholder="شماره ترمینال">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for="">  نام پروژه </label>
                                                                                <select name="projects" class="selectpicker" data-style="btn btn-primary border-dark" title="نام پروژه">
                                                                                    @foreach($projectList as $project)
                                                                                        <option value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-row mt-3">
                                                                            <div class="col-sm text-right">
                                                                                <label for="">   سریال ترمینال </label>
                                                                                <input name="name_en" type="text" class="form-control" id="nameStateEn" placeholder=" سریال ترمینال ">
                                                                            </div>
                                                                            <div class="col-sm text-right">
                                                                                <label for="">   نوع ترمینال </label>
                                                                                <select name="projects" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع ترمینال">
                                                                                    @foreach($TerminalTypeList as $terminalType)
                                                                                        <option value="{{$terminalType['id']}}"> {{$terminalType['type']}} </option>
                                                                                    @endforeach
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
                                                    <button  type="submit" class="btn btn-danger px-5 ml-0 mr-auto form_submit"> حذف  </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
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
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('AssignTerminal' , ['id'=>$id])}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن ترمینال جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm text-right">
                            <label for="">  شماره ترمینال </label>
                            <input name="terminal_id" type="text" class="form-control" id="nameStateFa" placeholder="شماره ترمینال">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  نام پروژه </label>
                            <select name="project_name" class="selectpicker" data-style="btn btn-primary border-dark" title="نام پروژه">
                                @foreach($projectList as $project)
                                    <option value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">   سریال ترمینال </label>
                            <input name="serial_number" type="text" class="form-control" id="nameStateEn" placeholder=" سریال ترمینال ">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">   نوع ترمینال </label>
                            <select name="type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع ترمینال">
                                @foreach($TerminalTypeList as $terminalType)
                                    <option value="{{$terminalType['id']}}"> {{$terminalType['type']}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">   سریال دستگاه </label>
                            <input name="imei" type="text" class="form-control" id="nameStateEn" placeholder=" سریال دامنه ">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">   دامنه </label>
                            <input name="domain" type="text" class="form-control" id="nameStateEn" placeholder="دامنه">
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
