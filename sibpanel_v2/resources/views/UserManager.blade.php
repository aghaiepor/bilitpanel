@extends('MainLayout')

@section('title')
    <title>
        مدیریت کاربران
    </title>
    <style>
        /*.searchَArea .bootstrap-select{
            width: 600px !important;
        }*/
       /* .bootstrap-select{
            width: 100% !important;
        }*/
        .password_area{
            display: none;
        }
        .swal2-container .swal2-shown{
            z-index: 10000;

        }
        .alphabets span{
            cursor: pointer;
            transition: all 0.3s;
            font-size: 11pt;
            font-weight: 400;
            margin-top: 5px;
        }
        .alphabets span:hover{
            background: #e91e63;
        }
    </style>
@endsection

@section('content')

    <div class="content">
        <div id="loader" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success text-right alert-dismissable fade show" role="alert">
                    {{session('success')}}
                    <button style="top:13px;" type="button" class="close float-left" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger text-right alert-dismissible fade show" role="alert">
                    {{session('error')}}
                    <button style="top:13px;" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                                        <i class="material-icons">group</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت کاربران </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>تعریف کاربر جدید</span>
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <div class="row justify-content-center mt-2" >
                                <div class="col-sm-6 text-right searchَArea">
{{--                                    <select id="user_search" data-live-search="true" name="user_search" class="selectpicker " data-width="100%" data-style="btn btn-primary border-dark" title="جست و جو ..">--}}
{{--                                        @foreach($userLists as $user)--}}
{{--                                            <option value="{{$user['sib_user_id'] . "-" .  $user['has_permission'] }}"> {{$user['first_name'] . " ". $user['last_name'] . " - " .  $user['account_type'] }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
                                    <input id="user_search" name="user_search" class="form-control" placeholder="جست و جو ....">
                                </div>
                                <div class="col-sm-3">
                                    <select id="user_filter" name="user_filter" class="selectpicker " data-width="100%" data-style="btn btn-primary border-dark" title="نوع کاربر">
                                        <option value=""> همه </option>
                                        @foreach($AccountTypeList as $AccountType)
                                            <option value="{{$AccountType["account_type"]}}">{{$AccountType["account_type"]}}</option>
                                        @endforeach
                                        {{--@foreach($userLists as $user)
                                            <option value="{{$user['sib_user_id'] . "-" .  $user['has_permission'] }}"> {{$user['first_name'] . " ". $user['last_name'] . " - " .  $user['account_type'] }}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div data-active="" id="alphabets" class="col-md-auto text-center w-100 text-black alphabets">
{{--                                    <span class="badge badge-lg badge-primary ">آ</span>--}}
                                    <span class="badge badge-lg badge-primary ">همه</span>
                                    <span class="badge badge-lg badge-primary ">الف</span>
                                    <span class="badge badge-primary">ب</span>
                                    <span class="badge badge-primary">پ</span>
                                    <span class="badge badge-primary">ت</span>
                                    <span class="badge badge-primary">ث</span>
                                    <span class="badge badge-primary">ج</span>
                                    <span class="badge badge-primary">چ</span>
                                    <span class="badge badge-primary">ح</span>
                                    <span class="badge badge-primary">خ</span>
                                    <span class="badge badge-primary">د</span>
                                    <span class="badge badge-primary">ذ</span>
                                    <span class="badge badge-primary">ر</span>
                                    <span class="badge badge-primary">ز</span>
                                    <span class="badge badge-primary">ژ</span>
                                    <span class="badge badge-primary">س</span>
                                    <span class="badge badge-primary">ش</span>
                                    <span class="badge badge-primary">ص</span>
                                    <span class="badge badge-primary">ض</span>
                                    <span class="badge badge-primary">ط</span>
                                    <span class="badge badge-primary">ظ</span>
                                    <span class="badge badge-primary">ع</span>
                                    <span class="badge badge-primary">غ</span>
                                    <span class="badge badge-primary">ق</span>
                                    <span class="badge badge-primary">ف</span>
                                    <span class="badge badge-primary">ک</span>
                                    <span class="badge badge-primary">گ</span>
                                    <span class="badge badge-primary">ل</span>
                                    <span class="badge badge-primary">م</span>
                                    <span class="badge badge-primary">ن</span>
                                    <span class="badge badge-primary">و</span>
                                    <span class="badge badge-primary">ه</span>
                                    <span class="badge badge-primary">ی</span>
                                    <span class="badge badge-primary">اعداد</span>
                                    <span class="badge badge-primary">سایر</span>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-striped">
                                <table  id="userInfo" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                            نام و نام خانوادگی
                                        </th>
                                        <th >
                                            شماره موبایل
                                        </th>
                                        <th >
                                            نوع کاربر
                                        </th>
                                        <th >
                                            سطح دسترسی
                                        </th>
                                        <th >
                                         فعال سازی
                                        </th>
                                        <th >
                                            ویرایش کاربر
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $i = 0 ;
                                    @endphp
                                    @if(count($Users) <=0)
                                        <tr>
                                            <td colspan="8">
                                                <h6 class="text-center py-5"> موردی یافت نشد .  </h6>
                                            </td>
                                        </tr>
                                    @else
                                    @foreach($Users as $user)
                                        <tr>
                                            <td>
                                                {{$user['first_name'] . ' ' . $user['last_name']  }}
                                            </td>
                                            <td>
                                                {{$user['mobile']}}
                                            </td>
                                            <td>
                                                {{$user['account_type'] }}
                                            </td>
                                            <td>
                                                @if($user['has_permission'])
                                                    <a href="{{Route('setUserPermission' , ['id' => $user['sib_user_id'] ])}}" class="btn btn-info px-4"> سطح دسترسی  </a>
                                                @else
                                                    <a href="{{Route('setUserPermission' , ['id' => $user['sib_user_id'] ])}}" class="btn btn-primary">
                                                        <i class="material-icons">person_add_alt_1</i>
                                                        تعریف
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <div dir="ltr" class="togglebutton">
                                                    <label>
                                                        <input sib-user-id="{{$user['sib_user_id']}}" name="active" @if($user['active']) checked="" @endif type="checkbox">
                                                        <span class="toggle"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <button data-url="{{Route('EditUser' , ['id' => $user['sib_user_id']])}}" data-toggle="modal" data-id="{{$user['sib_user_id']}}" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">
                                                    <i class="material-icons">edit</i>
                                                    ویرایش
                                                </button>

                                                {{--<button type="button" rel="tooltip" class="btn  btn-danger btn-simple TableEditBtn">
                                                    <i class="material-icons">close</i>
                                                    حدف
                                                </button>--}}
                                            </td>

                                        </tr>
                                        @php
                                            $i++ ;
                                        @endphp
                                    @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            <div id="pagination_links" class="row justify-content-center">
                                {{-- {{ $Users->links() }}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addUserSubmit" action="{{Route('RegisterUser')}}" method="post">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> تعریف کاربر جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div  class="modal-body">
                    <div id="AddUserArea" class="form-row">
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> نام </label>
                            <input id="addUser_name" name="name" type="text" class="form-control"  placeholder="نام  ">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> نام خانوادگی </label>
                            <input id="addUser_lastname" name="last_name" type="text" class="form-control"  placeholder=" نام خانوادگی">
                        </div>

                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> نام کاربری </label>
                            <input id="addUser_username" autocomplete="false" name="username" type="text" class="form-control"  placeholder="نام کاربری  ">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> شماره موبایل </label>
                            <input id="addUser_mobile" name="cellphone" type="number" class="form-control"  placeholder="شماره موبایل">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> نوع اکانت </label>
                            <select id="addUser_account_type_id" name="account_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option value="" disabled selected>  انتخاب کنید </option>
                                @foreach($AccountTypeList as $AccountType)
                                    <option value="{{$AccountType["account_type_id"] . "-" .str_replace(" " , "-" , $AccountType["account_type"])  }}">{{$AccountType["account_type"]}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for="">کد ملی</label>
                            <input id="addUser_ssn" name="national_id" type="number" class="form-control"  placeholder="شمار ملی">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> ایمیل </label>
                            <input name="email" type="email" class="form-control"  placeholder="ایمیل ">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for="">   رمزعبور </label>
                            <input id="addUser_password" autocomplete="new-password" name="password" type="password" class="form-control"  placeholder="کلمه عبور">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> IEMI </label>
                            <input id="addUser_imei" name="imei" type="text" class="form-control"  placeholder="imei برای کاربر استند و گیشه ">
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> دسترسی به پیش فروش </label>
                            <select id="addUser_presell" name="pre_sell" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option selected value="0"> خیر</option>
                                <option value="1"> بله</option>
                            </select>
                        </div>
                        <div class="col-sm-6 text-right mt-3">
                            <label for=""> فعال سازی otp </label>
                            <select id="addUser_otp_verify" name="otp_verify" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option selected value="0"> خیر</option>
                                <option value="1"> بله</option>
                            </select>
                        </div>
                       {{-- <div class="col-sm-6 text-right">
                            <label for=""> دسترسی به پنل (session_verify) </label>
                            <select id="addUser_session_verify" name="session_verify" class="selectpicker" data-style="btn btn-primary border-dark" title="دسترسی به پنل">
                                <option value="false"> خیر</option>
                                <option value="true"> بله</option>
                            </select>
                        </div>--}}
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button id="addUser" type="submit" class="btn btn-success px-5 ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- Edit Modal --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> ویرایش کاربر </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit" action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div id="loader3" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                        </div>
                        <div id="EditUserArea" class="form-row">
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> نام </label>
                                <input id="user_first_name" name="name" type="text" class="form-control"  placeholder="نام  ">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> نام خانوادگی </label>
                                <input id="user_last_name" name="last_name" type="text" class="form-control"  placeholder=" نام خانوادگی">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> نام کاربری </label>
                                <input id="user_username" autocomplete="false" name="username" type="text" class="form-control"  placeholder="نام کاربری  ">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> شماره موبایل </label>
                                <input id="user_mobile" name="cellphone" type="number" class="form-control"  placeholder="شماره موبایل">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> نوع اکانت </label>
                                <select id="user_account_type_id" name="account_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                    @foreach($AccountTypeList as $AccountType)
                                        <option value="{{$AccountType["account_type_id"] . "-" .str_replace(" " , "-" , $AccountType["account_type"])  }}">{{$AccountType["account_type"]}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for="">کد ملی</label>
                                <input id="user_national_id" name="national_id" type="number" class="form-control"  placeholder="شمار ملی">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> ایمیل </label>
                                <input id="user_email" name="email" type="email" class="form-control"  placeholder="ایمیل ">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> دسترسی به پیش فروش </label>
                                <select id="user_pre_sell" name="pre_sell" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                    <option selected value="0"> خیر</option>
                                    <option value="1"> بله</option>
                                </select>
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> IEMI </label>
                                <input id="user_imei" name="imei" type="text" class="form-control"  placeholder="imei برای کاربر استند و گیشه ">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <div dir="ltr" class="togglebutton">
                                    <label>
                                        <input name="pass" type="checkbox">
                                        <span class="toggle"></span>
                                        تغییر رمزعبور ؟
                                    </label>
                                </div>
                                <input id="user_password" autocomplete="false" name="password" type="password" class="form-control "  placeholder="کلمه عبور">
                            </div>
                            <div class="col-sm-6 text-right mt-3">
                                <label for=""> فعال سازی otp </label>
                                <select id="user_otp_verify" name="otp_verify" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                    <option selected value="0"> خیر</option>
                                    <option value="1"> بله</option>
                                </select>
                            </div>
                           {{-- <div class="col-sm-6 text-right">
                                <label for=""> دسترسی به پنل (session_verify) </label>
                                <select id="user_session_verify" name="session_verify" class="selectpicker" data-style="btn btn-primary border-dark" title="دسترسی به پنل">
                                    <option value="false"> خیر</option>
                                    <option value="true"> بله</option>
                                </select>
                            </div>--}}
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button id="edit_form_btn" type="submit" class="btn btn-success px-5 ml-0 mr-auto"> ویرایش  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="../assets/js/plugins/sweetalert2.js"></script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#addUser_password").val("")

            $("#addUser_account_type_id").change(function () {
                let value = $(this).val();
                value = value.split("-") ;
                let value_id = value[0] ;
                if(value_id == 4 || value_id == 3 || value_id == 13 || value_id == 5) {
                    $("#AddUserArea").children().each(function () {

                        if($(this).find("select").attr("id") == "addUser_account_type_id"
                            || $(this).find("input").attr("id") == "addUser_imei"  || $(this).find("input").attr("id") == "addUser_name" )
                        {
                            $(this).fadeIn();
                        }
                        else
                            $(this).fadeOut();
                    })
                }
                else
                {
                    $("#AddUserArea").children().each(function () {
                        $(this).fadeIn();
                    })
                }
            })

            $("#addUser").click( function (e) {
                e.preventDefault();
                let pattern = /^[0-9a-zيA-Zآا-ی][a-zيA-Z0-9_.-آا-ی ]+$/ ;
                let Mobule_pattern = /^[0][9][0-9]+$/ ;
                let error = 0 ;
                let addUser_name = $("#addUser_name").val();
                // let addUser_lastname = $("#addUser_lastname").val();
                let addUser_username = $("#addUser_username").val();
                let addUser_password = $("#addUser_password").val();
                let addUser_account_type_id = $("#addUser_account_type_id").val();
                if(addUser_account_type_id != null)
                {
                    addUser_account_type_id = addUser_account_type_id.split("-") ;
                    addUser_account_type_id = addUser_account_type_id[0] ;
                }
                let addUser_imei = $("#addUser_imei").val();
                let addUser_mobile = $("#addUser_mobile").val();
                let addUser_otp_verify = $("#addUser_otp_verify").val();
                let errorMessage = " لطفا فيلد ها مشخص شده را تکميل نماييد . " ;
                // console.log('addUser_account_type_id' , addUser_account_type_id == null);
                // console.log('addUser_lastname : ' , addUser_lastname == "")

                if(!addUser_name.match(pattern) || !addUser_username.match(pattern) || !addUser_password.match(pattern) || addUser_account_type_id == null || addUser_mobile =="" || addUser_otp_verify == 1 || eval(addUser_account_type_id) == 4 || eval(addUser_account_type_id) == 3 || eval(addUser_account_type_id) == 13 || eval(addUser_account_type_id) == 5){
                    e.preventDefault();
                    if(!addUser_name.match(pattern)) {
                        error++;
                        $("#addUser_name").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_name").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#addUser_name").removeAttr("style");
                        $("#addUser_name").parent().prev().removeAttr("style") ;
                    }

                    if(!addUser_username.match(pattern) ) {
                        error++;
                        $("#addUser_username").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_username").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#addUser_username").removeAttr("style");
                        $("#addUser_username").parent().prev().removeAttr("style") ;
                    }

                    if(!addUser_password.match(pattern) ) {
                        error++;
                        $("#addUser_password").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_password").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#addUser_password").removeAttr("style");
                        $("#addUser_password").parent().prev().removeAttr("style") ;
                    }
                    if(addUser_mobile != "" && (addUser_mobile.length != 11 || !addUser_mobile.match(Mobule_pattern) )) {
                        error++;
                        $("#addUser_mobile").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_mobile").parent().prev().css("color" , "#e91e63") ;
                        errorMessage = " فرمت شماره موبایل وارد شده صحیح نمی باشد  .  ";
                    }
                    else
                    {
                        $("#addUser_mobile").removeAttr("style");
                        $("#addUser_mobile").parent().prev().removeAttr("style") ;
                    }
                    if(addUser_mobile == "" && addUser_otp_verify == 1 ) {
                        error++;
                        $("#addUser_mobile").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_mobile").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#addUser_mobile").removeAttr("style");
                        $("#addUser_mobile").parent().prev().removeAttr("style") ;
                    }

                    if(addUser_account_type_id == null) {
                        error++;
                        $("#addUser_account_type_id").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#addUser_account_type_id").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#addUser_account_type_id").removeAttr("style");
                        $("#addUser_account_type_id").parent().prev().removeAttr("style") ;
                    }
                    let IsCashUser = false ;
                    if((eval(addUser_account_type_id) == 4 || eval(addUser_account_type_id) == 3 || eval(addUser_account_type_id) == 13 || eval(addUser_account_type_id) == 5) )
                    {
                        IsCashUser = true ;
                        if(addUser_imei == "" || !addUser_name.match(pattern))
                        {
                            error++;
                            if(addUser_imei == "")
                            {
                                $("#addUser_imei").css("cssText", "border : solid 2px #e91e63 !important");
                                $("#addUser_imei").parent().prev().css("color", "#e91e63");
                            }
                            else
                            {
                                $("#addUser_imei").removeAttr("style");
                                $("#addUser_imei").parent().prev().removeAttr("style");
                            }
                        }
                        else
                        {
                            $("#addUser_imei").removeAttr("style");
                            $("#addUser_imei").parent().prev().removeAttr("style");
                            error = 0 ;
                        }
                    }
                    else
                    {
                        $("#addUser_imei").removeAttr("style");
                        $("#addUser_imei").parent().prev().removeAttr("style");
                    }

                    if(error == 0 )
                    {
                        $.ajax({
                                type:'POST',
                                url:"{{Route('AddUsermange')}}",
                                dataType:'json',
                                data:{
                                    '_token ': '<?php echo csrf_token() ?>',
                                    'value' : value ,
                                },
                                statusCode: {
                                    500: function() {
                                        $("#loader2").hide();
                                        Swal.fire(
                                            'خطا در دريافت اطلاعات ! ',
                                            'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                            'error'
                                        )
                                    } ,
                                    400: function() {
                                        let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                        let x = 1 ;
                                        let dots = "";
                                        setInterval(function () {
                                            dots += ".";
                                            x++  ;
                                            // console.log(x)
                                            if(x >= 8 ){
                                                x = 1 ;
                                                dots = ".";
                                            }
                                            $("#dots").html(dots)
                                        } , 300)
                                        $("#loader2").hide();
                                        Swal.fire(
                                            'نشست  شما پایان یافته است ! ',
                                            html,
                                            'warning' ,
                                        )
                                        setTimeout(function () {
                                            window.location.href = "{{Route("logout")}}";
                                        } , 1500)
                                        session_fall = false ;

                                    }
                                },
                                success:function(data) {
                                    $("#loader2").hide();

                                }
                        })
                        $("#addUserSubmit").submit();
                    }

                    else{
                        Swal.fire(
                            'خطا ! ',
                            "فیلد های مشخص شده را پر نمایید.",
                            'error'
                        )
                    }
                }


            });


            $("#user_account_type_id").change(function () {
                let value = $(this).val();
                value = value.split("-") ;
                let value_id = value[0] ;
                if(value_id == 4 || value_id == 3 || value_id == 13 || value_id == 5) {
                    $("#EditUserArea").children().each(function () {
                        if($(this).find("select").attr("id") == "user_account_type_id" ||
                            $(this).find("input").attr("id") == "user_imei"  ||
                            $(this).find("input").attr("id") == "user_first_name")
                        {
                            $(this).fadeIn();
                        }
                        else
                            $(this).fadeOut();
                    })
                }
                else
                {
                    $("#EditUserArea").children().each(function () {
                        $(this).fadeIn();
                    })
                }
            })
            $("#edit_form_btn").click( function (e) {
                e.preventDefault();
                let pattern = /^[0-9a-zيA-Zآا-ی][a-zيA-Z0-9_.-آا-ی ]+$/ ;
                let Mobule_pattern = /^[0][9][0-9]+$/ ;
                let addUser_name = $("#user_first_name").val();
                let addUser_username = $("#user_username").val();
                let error = 0 ;
                let addUser_account_type_id = $("#user_account_type_id").val();
                if(addUser_account_type_id != null)
                {
                    addUser_account_type_id = addUser_account_type_id.split("-") ;
                    addUser_account_type_id = addUser_account_type_id[0] ;
                }
                let user_mobile = $("#user_mobile").val();
                let user_otp_verify = $("#user_otp_verify").val();

                let errorMessage = "لطفا فيلد ها مشخص شده را تکميل نماييد ." ;
                console.log("user_mobile => " , user_mobile)
                let addUser_imei = $("#user_imei").val();

                if(!addUser_name.match(pattern) || !addUser_username.match(pattern) || addUser_account_type_id == null  || user_mobile != "" || user_otp_verify == 1  || eval(addUser_account_type_id) == 4 || eval(addUser_account_type_id) == 3 || eval(addUser_account_type_id) == 13 || eval(addUser_account_type_id) == 5  ){

                    if(!addUser_name.match(pattern)) {
                        error++ ;
                        $("#user_first_name").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#user_first_name").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#user_first_name").removeAttr("style");
                        $("#user_first_name").parent().prev().removeAttr("style") ;
                    }

                    if(!addUser_username.match(pattern) ) {
                        error++ ;
                        $("#user_username").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#user_username").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#user_username").removeAttr("style");
                        $("#user_username").parent().prev().removeAttr("style") ;
                    }
                    if(user_mobile != "" && (user_mobile.length != 11 || !user_mobile.match(Mobule_pattern) ) ) {
                        error++;
                        $("#user_mobile").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#user_mobile").parent().prev().css("color" , "#e91e63") ;
                        errorMessage = " فرمت شماره موبایل وارد شده صحیح نمی باشد  .  ";
                    }
                    else
                    {
                        $("#user_mobile").removeAttr("style");
                        $("#user_mobile").parent().prev().removeAttr("style") ;
                    }
                    if(user_mobile == "" && user_otp_verify == 1 ) {
                        error++;
                        $("#user_mobile").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#user_mobile").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#user_mobile").removeAttr("style");
                        $("#user_mobile").parent().prev().removeAttr("style") ;
                    }

                    if(!addUser_account_type_id == null) {
                        error++ ;
                        $("#user_account_type_id").css("cssText" , "border : solid 2px #e91e63 !important" ) ;
                        $("#user_account_type_id").parent().prev().css("color" , "#e91e63") ;
                    }
                    else
                    {
                        $("#user_account_type_id").removeAttr("style");
                        $("#user_account_type_id").parent().prev().removeAttr("style") ;
                    }
                    let IsCashUser = false ;
                    if((eval(addUser_account_type_id) == 4 || eval(addUser_account_type_id) == 3 || eval(addUser_account_type_id) == 13 || eval(addUser_account_type_id) == 5) )
                    {
                        IsCashUser = true ;
                        if(addUser_imei == "" || !addUser_name.match(pattern))
                        {
                            error++;
                            if(addUser_imei == "")
                            {
                                $("#user_imei").css("cssText", "border : solid 2px #e91e63 !important");
                                $("#user_imei").parent().prev().css("color", "#e91e63");
                            }
                            else
                            {
                                $("#user_imei").removeAttr("style");
                                $("#user_imei").parent().prev().removeAttr("style");
                            }
                        }
                        else
                        {
                            $("#user_imei").removeAttr("style");
                            $("#user_imei").parent().prev().removeAttr("style");
                            error = 0 ;
                        }
                    }
                    else
                    {
                        $("#user_imei").removeAttr("style");
                        $("#user_imei").parent().prev().removeAttr("style");
                    }


                    if(error == 0 )
                        $("#form_edit").submit();
                    else{
                        Swal.fire(
                            'خطا ! ',
                            "فیلد های مشخص شده را پر نمایید.",
                            'error'
                        )
                    }
                }
                // if(error == 0)
                // {
                //     $("#edit").submit();
                // }
            });

            var userData = @json($Users);
            var startsWith = [];
            // console.log(startsWithN);
            $(document).on( "change" ,'input[name=active]' ,function () {
                var id =$(this).attr('sib-user-id') ;
                var value = ($(this).is(':checked'));
                // alert(value);
                Swal.fire({
                    title: ' از تغییر ایجاد شده مطمئن هستید ؟ ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7bc127',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله' ,
                    cancelButtonText: 'خیر' ,
                }).then((result) => {
                    if (result.value) {
                        $('#loader').css('display' , 'flex');
                        $.ajax({
                            type:'POST',
                            url:"{{Route('UserActivation')}}",
                            dataType:'json',
                            data:{
                                '_token ': '<?php echo csrf_token() ?>',
                                'id' : id ,
                                'value' : value ,
                            },

                            statusCode: {
                                500: function() {
                                    $("#loader").hide();
                                    Swal.fire(
                                        'خطا در دريافت اطلاعات ! ',
                                        'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                        'error'
                                    )
                                } ,
                                400: function() {
                                    let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                    let x = 1 ;
                                    let dots = "";
                                    setInterval(function () {
                                        dots += ".";
                                        x++  ;
                                        // console.log(x)
                                        if(x >= 8 ){
                                            x = 1 ;
                                            dots = ".";
                                        }
                                        $("#dots").html(dots)
                                    } , 300)
                                    $("#loader").hide();
                                    Swal.fire(
                                        'نشست  شما پایان یافته است ! ',
                                        html,
                                        'warning' ,
                                    )
                                    setTimeout(function () {
                                        window.location.href = "{{Route("logout")}}";
                                    } , 1500)

                                }
                            },
                            success:function(data) {
                                console.log(data);
                                $('#loader').hide();
                                Swal.fire(
                                    'تغییر مورد نظر اعمال گردید',
                                    '',
                                    'success'
                                )
                            }
                        });

                    }else{
                        if(value)
                            $(this).prop( "checked", false );
                        else
                            $(this).prop( "checked", true );
                        $('#loader').hide();
                    }
                })

            });
            let current_user_id  ;
            $(document).on( "change" ,"input[name=pass]" , function () {
                if($(this).is(':checked')){
                    $(this).parent().parent().next().show();
                }
                else{
                    $(this).parent().parent().next().find("input").val('');
                    $(this).parent().parent().next().hide();
                }
            });
            $(document).on("click",'.EditBtnAccess' , function () {
                $("input[name=pass]").parent().parent().next().hide()
                let action = false ;
                let action_url = $(this).attr('data-url');
                var Element = $($(this).attr('data-target')) ;
                let UserId = $(this).attr('data-id');
                if (current_user_id != UserId){
                    current_user_id = UserId ;
                    $("#loader3").css('display' , 'flex');
                    $.ajax({
                        headers: {
                            'Cache-Control': 'max-age=1000'
                        } ,
                        type:'POST',
                        url:"{{Route('GetUserInfo')}}" ,
                        dataType:'json',
                        data:{
                            '_token ': '<?php echo csrf_token() ?>',
                            'UserId' : UserId ,
                        },
                        statusCode: {
                            500: function() {
                                $("#loader").hide();
                                Swal.fire(
                                    'خطا در دريافت اطلاعات ! ',
                                    'اتصال خود به اینترنت را بررسی کنید یا یک بار از پنل خارج شوید و دوباره وارد شوید .',
                                    'error'
                                )
                            } ,
                            400: function() {
                                let html = "<p > درحال انتقال به صفحه لاگین <span id='dots'>.</span> </p><!--<div class=\"spinner-border mx-auto d-block mb-3\" style=\"color: #5e5e5e;\"></div>-->"
                                let x = 1 ;
                                let dots = "";
                                setInterval(function () {
                                    dots += ".";
                                    x++  ;
                                    // console.log(x)
                                    if(x >= 8 ){
                                        x = 1 ;
                                        dots = ".";
                                    }
                                    $("#dots").html(dots)
                                } , 300)
                                $("#loader").hide();
                                Swal.fire(
                                    'نشست  شما پایان یافته است ! ',
                                    html,
                                    'warning' ,
                                )
                                setTimeout(function () {
                                    window.location.href = "{{Route("logout")}}";
                                } , 1500)

                            }
                        },
                        success:function(data) {
                            console.log("data =>" , data)
                            $('#form_edit').attr('action' , action_url );
                           $('#user_first_name').val(data.first_name);
                            $('#user_last_name').val(data.last_name);
                            $('#user_username').val(data.username);
                            $('#user_mobile').val(data.mobile);

                            let accountTypeVal = data.account_type_id + "-" + data.account_type ;
                            accountTypeVal = accountTypeVal.replace(" " , "-");
                            $('#user_account_type_id').val(accountTypeVal).trigger("change")

                            /*
                            $('#user_session_verify').find("option").attr('selected' , false);
                            $('#user_session_verify').find("option[value="+ data.session_verify + "]").attr('selected' , true);
                            $("#user_session_verify").selectpicker('refresh') ;
                            */

                            $('#user_national_id').val(data.national_id);

                            let otp_verify = 0  ;
                            if(data.otp_verify)
                            {
                                otp_verify = 1 ;
                            }
                            console.log( "otp_verify => " , otp_verify)
                            $('#user_otp_verify').val(otp_verify).trigger("change")

                            $('#user_email').val(data.email);
                            let pre_sale = (data.presell)  ? '1' : '0' ;

                            $('#user_pre_sell').val(pre_sale).trigger("change")
                            // Element.find("input[name=pre_sell]").val(data.presell);
                            // console.log(data.presell);
                            $('#user_imei').val((data.imei == "None" ) ? "" : data.imei );
                            $('#user_password').val('');
                            $('#loader3').hide();
                        }
                    });
                }
            });

            // users filters
            $("#user_search").on( "input", function () {
                $('#userInfo tbody').html(" ");
                $('#loader').css('display' , 'flex');
                let pattern = /^[a-zA-Z]/ ;
                let value = $(this).val() ;
                let number = ['1','2','3','4','5','6','7','8','9','0'] ;
                let users = [];
                let alphabet = $("#alphabets").attr("data-active");
                let alphabet_index  = "";
                if (alphabet != "" )
                {
                    alphabet_index = $("#alphabets").children().eq(alphabet).text();
                }
                else
                    alphabet_index = null ;

                let user_filter = $("#user_filter").val();
                if(user_filter == "")
                    user_filter = null

                // console.log(alphabet_index)
                if( alphabet_index == "الف")
                    alphabet_index = "ا" ;
                else if (alphabet_index == "همه")
                    alphabet_index = null ;

                if(user_filter == null && alphabet_index == null )
                    users = userData.filter(d =>  ((value == "")  ?  true : (( (d.first_name + " " + d.last_name ).search(value))  != -1) ) );
                else {
                    if(alphabet_index == "اعداد")
                    {
                        users = userData.filter(d => ((value == "") ? true : ((d.first_name + " " + d.last_name).search(value) != -1)) && ((user_filter == null) ? true : d.account_type == user_filter) && ((alphabet_index == null) ? true : (number.indexOf(d.first_name[0]) != -1) ));
                    }
                    else if (alphabet_index == "سایر") {
                        users = userData.filter(d =>  ((value == "") ? true : ((d.first_name + " " + d.last_name).search(value) != -1)) && ((alphabet_index == null) ? true : (d.first_name.match(pattern) != null) ) && ((user_filter == null) ? true : d.account_type == user_filter) );
                    }
                    else
                        users = userData.filter(d => ((value == "") ? true : ((d.first_name + " " + d.last_name).search(value) != -1)) && ((user_filter == null) ? true : d.account_type == user_filter) && ((alphabet_index == null) ? true : (d.first_name[0] === alphabet_index || ((alphabet_index == "ا") ? d.first_name[0] === "آ" : false))));
                }

                // console.log("value : ", users)

                let table = document.getElementById("userInfo").getElementsByTagName('tbody')[0];
                if(value != ""){
                    if(users.length == 0 ){
                        $("#pagination_links").hide();
                        var row = table.insertRow();
                        var cell = row.insertCell();
                        cell.id = "myTd";
                        cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                        document.getElementById("myTd").colSpan = "6";
                    }
                    else
                    {
                        $("#pagination_links").hide();
                        // console.log(data.array_key)
                        for(let i = 0 ; i < users.length ; i++){
                            var row = table.insertRow();
                            var name = row.insertCell();
                            var mobile = row.insertCell();
                            var account_type = row.insertCell();
                            var permission = row.insertCell();
                            var activation = row.insertCell();
                            var userEdit = row.insertCell();

                            name.innerHTML = users[i].last_name + " " + users[i].first_name;
                            mobile.innerHTML = users[i].mobile;
                            account_type.innerHTML =users[i].account_type;

                            // for permission column
                            let permission_html ;
                            let url ;
                            // console.log( "permisson data : " + data.data.has_permission)
                            if( users[i].has_permission == 1) {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                            }
                            else {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                    ' <i class="material-icons">person_add_alt_1</i>\n' +
                                    '                                                        تعریف\n' +
                                    ' </a>' ;
                            }
                            permission.innerHTML = permission_html;

                            // for activation
                            let check ;
                            if(users[i].active)
                            {
                                check = "checked" ;
                            }
                            else
                                check = "";
                            let active = '<div dir="ltr" class="togglebutton">\n' +
                                '  <label>\n' +
                                '      <input sib-user-id=" ' + users[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                                '    <span class="toggle"></span>\n' +
                                '  </label>\n' +
                                '</div>';
                            // console.log( "activation : " + data.data[array_key[i]].active);
                            // console.log( "checked was : " + $('input', active).is(":checked"))
                            activation.innerHTML = active;

                            // for edit column
                            let user_edit_url = "{{Route('EditUser')}}/" + users[i].sib_user_id;
                            let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + users[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                                ' <i class="material-icons">edit</i>\n' +
                                'ویرایش\n' +
                                ' </button>' ;
                            userEdit.innerHTML = edit_html;
                        }
                    }

                }else
                {
                    if(alphabet_index == "اعداد")
                    {
                        user = userData.filter(d => ((user_filter == null)  ?  true : d.account_type == user_filter) && ((alphabet_index == null) ? true : (number.indexOf(d.first_name[0]) != -1) )  );
                    }
                    else if (alphabet_index == "سایر") {

                        user = userData.filter(d => ((user_filter == null)  ?  true : d.account_type == user_filter) && ((alphabet_index == null) ? true : (d.first_name.match(pattern) != null) ) );
                    }
                    else
                        user = userData.filter(d => ((user_filter == null)  ?  true : d.account_type == user_filter) && ((alphabet_index == null) ? true : (   d.last_name[0] === alphabet_index   || ( (alphabet_index == "ا") ? d.last_name[0] === "آ" : false  ) ))  );

                    let sib_user_id = users.sib_user_id;
                    $("#pagination_links").show();
                    // console.log(data.data.data.length)
                    for(let i = 0 ; i < user.length ; i++){
                        var row = table.insertRow();
                        var name = row.insertCell();
                        var mobile = row.insertCell();
                        var account_type = row.insertCell();
                        var permission = row.insertCell();
                        var activation = row.insertCell();
                        var userEdit = row.insertCell();

                        name.innerHTML = user[i].last_name + " " + user[i].first_name;
                        mobile.innerHTML = user[i].mobile;
                        account_type.innerHTML = user[i].account_type;

                        // for permission column
                        let permission_html ;
                        let url ;
                        // console.log( "permisson data : " + data.data.data.has_permission)
                        if( user[i].has_permission == 1) {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                        }
                        else {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                ' <i class="material-icons">person_add_alt_1</i>\n' +
                                '                                                        تعریف\n' +
                                ' </a>' ;
                        }
                        permission.innerHTML = permission_html;

                        // for activation
                        let check ;
                        if(user[i].active)
                        {
                            check = "checked" ;
                        }
                        else
                            check = "";

                        let active = '<div dir="ltr" class="togglebutton">\n' +
                            '  <label>\n' +
                            '      <input sib-user-id=" ' + user[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                            '    <span class="toggle"></span>\n' +
                            '  </label>\n' +
                            '</div>';
                        // console.log( "activation : " + data.data.data[i].active);
                        // console.log( "checked was : " + $('input', active).is(":checked"))
                        activation.innerHTML = active;

                        // for edit column
                        let user_edit_url = "{{Route('EditUser')}}/" + user[i].sib_user_id;
                        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + user[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                            ' <i class="material-icons">edit</i>\n' +
                            'ویرایش\n' +
                            ' </button>' ;
                        userEdit.innerHTML = edit_html;
                    }
                }
                $('#loader').hide();
                // value = value.split("-");
                // let userId = value[0];
                // let has_permisson = value[1];
                {{--$.ajax({--}}
                {{--    headers: {--}}
                {{--        'Cache-Control': 'max-age=1000'--}}
                {{--    } ,--}}
                {{--    type:'POST',--}}
                {{--    url:"{{Route('GetUserInfo')}}" ,--}}
                {{--    dataType:'json',--}}
                {{--    data:{--}}
                {{--        '_token ': '<?php echo csrf_token() ?>',--}}
                {{--        'UserId' : userId ,--}}
                {{--    },--}}
                {{--    success:function(data) {--}}
                {{--        console.log(data);--}}
                {{--        let sib_user_id = data.sib_user_id;--}}
                {{--        $("#pagination_links").hide();--}}
                {{--        $('#userInfo tbody').html(" ");--}}
                {{--        let table = document.getElementById("userInfo");--}}
                {{--        var row = table.insertRow();--}}
                {{--        var name = row.insertCell();--}}
                {{--        var mobile = row.insertCell();--}}
                {{--        var account_type = row.insertCell();--}}
                {{--        var permission = row.insertCell();--}}
                {{--        var activation = row.insertCell();--}}
                {{--        var userEdit = row.insertCell();--}}
                {{--        name.innerHTML = data.first_name + " " + data.last_name;--}}
                {{--        mobile.innerHTML = data.mobile;--}}
                {{--        account_type.innerHTML = data.account_type;--}}

                {{--        // for permission column--}}
                {{--        let permission_html ;--}}
                {{--        let url ;--}}
                {{--        console.log( "permisson data : " + data.has_permission)--}}
                {{--        if(has_permisson == 1) {--}}
                {{--            url = "{{Route('setUserPermission')}}/" + data.sib_user_id;--}}
                {{--            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';--}}
                {{--        }--}}
                {{--        else {--}}
                {{--            url = "{{Route('setUserPermission')}}/" + data.sib_user_id;--}}
                {{--            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +--}}
                {{--                ' <i class="material-icons">person_add_alt_1</i>\n' +--}}
                {{--                '                                                        تعریف\n' +--}}
                {{--                ' </a>' ;--}}
                {{--        }--}}
                {{--        permission.innerHTML = permission_html;--}}

                {{--        // for activation--}}
                {{--        let check ;--}}
                {{--        if(data.active)--}}
                {{--        {--}}
                {{--            check = "checked" ;--}}
                {{--        }--}}
                {{--        else--}}
                {{--            check = "";--}}
                {{--        let active = '<div dir="ltr" class="togglebutton">\n' +--}}
                {{--            '  <label>\n' +--}}
                {{--            '      <input sib-user-id=" ' + sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +--}}
                {{--            '    <span class="toggle"></span>\n' +--}}
                {{--            '  </label>\n' +--}}
                {{--            '</div>';--}}
                {{--            console.log( "activation : " + data.active);--}}
                {{--            console.log( "checked was : " + $('input', active).is(":checked"))--}}
                {{--        activation.innerHTML = active;--}}

                {{--        // for edit column--}}
                {{--        let user_edit_url = "{{Route('EditUser')}}/" + data.sib_user_id;--}}
                {{--        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +--}}
                {{--            ' <i class="material-icons">edit</i>\n' +--}}
                {{--            'ویرایش\n' +--}}
                {{--            ' </button>' ;--}}
                {{--        userEdit.innerHTML = edit_html;--}}
                {{--        $('#loader').hide();--}}
                {{--    }--}}
                {{--});--}}
            });
            $("#user_filter").change(function () {
                let value = $(this).val() ;
                let serach = $("#user_search").val();
                let pattern = /^[a-zA-Z]/ ;
                console.log("value : " , value=="");
                /*if(value == "")
                    value = null ;*/
                let alphabet = $("#alphabets").attr("data-active");
                let alphabet_index  = "";
                if (alphabet != "" )
                {
                    alphabet_index = $("#alphabets").children().eq(alphabet).text();

                }
                else
                    alphabet_index = null ;

                $('#loader').css('display' , 'flex');
                let number = ['1','2','3','4','5','6','7','8','9','0'] ;
                let  users = [] ;
                // console.log(value=="الف")
                // console.log(alphabet_index == "اعداد")
                if(alphabet_index == "اعداد")
                {
                    users = userData.filter(d =>  ((alphabet_index == null) ? true : (number.indexOf(d.first_name[0]) != -1) ) && ((value == "")  ?  true : d.account_type === value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1));
                }
                else if (alphabet_index == "سایر") {
                    users = userData.filter(d => ((alphabet_index == null) ? true : (d.first_name.match(pattern) != null) ) && ((value == "")  ?  true : d.account_type === value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1) );
                }
                else {
                    if( alphabet_index == "الف")
                        alphabet_index = "ا" ;
                    else if (alphabet_index == "همه")
                        alphabet_index = null ;
                    users = userData.filter(d => ((alphabet_index == null) ? true : (  d.last_name[0] === alphabet_index   || ( (alphabet_index == "ا") ? d.last_name[0] === "آ" : false  ) ) ) && ((value == "")  ?  true : d.account_type === value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1) );
                }
                // console.log("filter" , users)
                $('#userInfo tbody').html(" ");
                let table = document.getElementById("userInfo").getElementsByTagName('tbody')[0];
                if(value != ""){
                    if(users.length == 0 ){
                        $("#pagination_links").hide();
                        var row = table.insertRow();
                        var cell = row.insertCell();
                        cell.id = "myTd";
                        cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                        document.getElementById("myTd").colSpan = "6";
                    }
                    else
                    {
                        $("#pagination_links").hide();
                        // console.log(data.array_key)
                        for(let i = 0 ; i < users.length ; i++){
                            var row = table.insertRow();
                            var name = row.insertCell();
                            var mobile = row.insertCell();
                            var account_type = row.insertCell();
                            var permission = row.insertCell();
                            var activation = row.insertCell();
                            var userEdit = row.insertCell();

                            name.innerHTML = users[i].last_name + " " + users[i].first_name;
                            mobile.innerHTML = users[i].mobile;
                            account_type.innerHTML =users[i].account_type;

                            // for permission column
                            let permission_html ;
                            let url ;
                            // console.log( "permisson data : " + data.data.has_permission)
                            if( users[i].has_permission == 1) {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                            }
                            else {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                    ' <i class="material-icons">person_add_alt_1</i>\n' +
                                    '                                                        تعریف\n' +
                                    ' </a>' ;
                            }
                            permission.innerHTML = permission_html;

                            // for activation
                            let check ;
                            if(users[i].active)
                            {
                                check = "checked" ;
                            }
                            else
                                check = "";
                            let active = '<div dir="ltr" class="togglebutton">\n' +
                                '  <label>\n' +
                                '      <input sib-user-id=" ' + users[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                                '    <span class="toggle"></span>\n' +
                                '  </label>\n' +
                                '</div>';
                            // console.log( "activation : " + data.data[array_key[i]].active);
                            // console.log( "checked was : " + $('input', active).is(":checked"))
                            activation.innerHTML = active;

                            // for edit column
                            let user_edit_url = "{{Route('EditUser')}}/" + users[i].sib_user_id;
                            let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + users[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                                ' <i class="material-icons">edit</i>\n' +
                                'ویرایش\n' +
                                ' </button>' ;
                            userEdit.innerHTML = edit_html;
                        }
                    }

                }else
                {
                    if( alphabet_index == "الف")
                        alphabet_index = "ا" ;
                    else if (alphabet_index == "همه")
                        alphabet_index = null ;

                    if(alphabet_index == "اعداد")
                    {
                        user = userData.filter(d =>  ((alphabet_index == null) ? true : (number.indexOf(d.first_name[0]) != -1) ) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1));
                    }
                    else if (alphabet_index == "سایر") {

                        user = userData.filter(d =>  ((alphabet_index == null) ? true : (d.first_name.match(pattern) != null) ) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1));
                    }
                    else
                        user = userData.filter(d => ((alphabet_index == null) ? true : (   d.last_name[0] === alphabet_index   || ( (alphabet_index == "ا") ? d.last_name[0] === "آ" : false  ) )) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1)   );

                    let sib_user_id = users.sib_user_id;
                    $("#pagination_links").show();
                    // console.log(data.data.data.length)
                    for(let i = 0 ; i < user.length ; i++){
                        var row = table.insertRow();
                        var name = row.insertCell();
                        var mobile = row.insertCell();
                        var account_type = row.insertCell();
                        var permission = row.insertCell();
                        var activation = row.insertCell();
                        var userEdit = row.insertCell();

                        name.innerHTML = user[i].last_name + " " + user[i].first_name;
                        mobile.innerHTML = user[i].mobile;
                        account_type.innerHTML = user[i].account_type;

                        // for permission column
                        let permission_html ;
                        let url ;
                        // console.log( "permisson data : " + data.data.data.has_permission)
                        if( user[i].has_permission == 1) {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                        }
                        else {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                ' <i class="material-icons">person_add_alt_1</i>\n' +
                                '                                                        تعریف\n' +
                                ' </a>' ;
                        }
                        permission.innerHTML = permission_html;

                        // for activation
                        let check ;
                        if(user[i].active)
                        {
                            check = "checked" ;
                        }
                        else
                            check = "";

                        let active = '<div dir="ltr" class="togglebutton">\n' +
                            '  <label>\n' +
                            '      <input sib-user-id=" ' + user[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                            '    <span class="toggle"></span>\n' +
                            '  </label>\n' +
                            '</div>';
                        // console.log( "activation : " + data.data.data[i].active);
                        // console.log( "checked was : " + $('input', active).is(":checked"))
                        activation.innerHTML = active;

                        // for edit column
                        let user_edit_url = "{{Route('EditUser')}}/" + user[i].sib_user_id;
                        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + user[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                            ' <i class="material-icons">edit</i>\n' +
                            'ویرایش\n' +
                            ' </button>' ;
                        userEdit.innerHTML = edit_html;
                    }
                }
                $('#loader').hide();
                // console.log(value == null)
            });
            let ElementIndex = null ;
            let isActive = false ;
            $("#alphabets .badge").click(function () {
                let value = $(this).text();
                let user_filter_value = $("#user_filter").val();
                let serach = $("#user_search").val();
                // loader
                $('#loader').css('display' , 'flex');
                if(ElementIndex == $(this).index() && isActive){
                    $(this).css('backgroundColor' ,  '#494c6b');
                    isActive = false ;
                    $("#alphabets").attr('data-active' ,'' );
                }else
                {
                    ElementIndex = $(this).index();
                    elements = document.getElementsByClassName("badge");
                    for (var i = 0; i < elements.length; i++) {
                        if ( i !=  ElementIndex)
                            elements[i].style.backgroundColor="#494c6b";
                        else
                            elements[i].style.backgroundColor="#e91e63";
                    }
                    $("#alphabets").attr('data-active' ,ElementIndex ) ;
                    isActive = true ;
                }

                // get elements
                let number = ['1','2','3','4','5','6','7','8','9','0'] ;
                let  users  =[] ;
                let pattern = /^[a-zA-Z]/ ;
                // console.log( "match : ", "asdf".match(pattern) ); //"somethingELSE"
                // console.log(value=="الف")
                if(value == "اعداد")
                {
                    users = userData.filter(d => ((value == null) ? true : number.indexOf(d.first_name[0]) != -1) && ((user_filter_value == "")  ?  true : d.account_type === user_filter_value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1));
                }
                else if (value == "سایر") {
                    users = userData.filter(d => ((value == null) ? true : (d.first_name.match(pattern) != null) || (d.first_name == null) ) && ((user_filter_value == "")  ?  true : d.account_type === user_filter_value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1));
                }
                else {
                    if( value == "الف")
                        value = "ا" ;
                    else if (value == "همه")
                        value = null ;

                    users = userData.filter(d => ((value == null) ? true :(d.last_name[0] === value   || ( (value == "ا") ? d.last_name[0] === "آ" : false  ) )) && ((user_filter_value == "")  ?  true : d.account_type === user_filter_value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1)  );
                }

                // console.log("users : ",users) ;
                // for empty list
                $('#userInfo tbody').html(" ");
                let table = document.getElementById("userInfo").getElementsByTagName('tbody')[0];
                if (isActive){
                    if(users.length == 0 ){
                        $("#pagination_links").hide();
                        var row = table.insertRow();
                        var cell = row.insertCell();
                        cell.id = "myTd";
                        cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                        document.getElementById("myTd").colSpan = "6";
                    }else {
                        $("#pagination_links").hide();
                        // console.log(data.array_key)
                        // let array_key = data.array_key;
                        for(let i = 0 ; i < users.length ; i++){
                            var row = table.insertRow();
                            var name = row.insertCell();
                            var mobile = row.insertCell();
                            var account_type = row.insertCell();
                            var permission = row.insertCell();
                            var activation = row.insertCell();
                            var userEdit = row.insertCell();

                            name.innerHTML = users[i].last_name + " " + users[i].first_name;
                            mobile.innerHTML = users[i].mobile;
                            account_type.innerHTML = users[i].account_type;

                            // for permission column
                            let permission_html ;
                            let url ;
                            // console.log( "permisson data : " + data.data.has_permission)
                            if( users[i].has_permission == 1) {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                            }
                            else {
                                url = "{{Route('setUserPermission')}}/" + users[i].sib_user_id;
                                permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                    ' <i class="material-icons">person_add_alt_1</i>\n' +
                                    '                                                        تعریف\n' +
                                    ' </a>' ;
                            }
                            permission.innerHTML = permission_html;

                            // for activation
                            let check ;
                            if(users[i].active)
                            {
                                check = "checked" ;
                            }
                            else
                                check = "";
                            let active = '<div dir="ltr" class="togglebutton">\n' +
                                '  <label>\n' +
                                '      <input sib-user-id=" ' + users[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                                '    <span class="toggle"></span>\n' +
                                '  </label>\n' +
                                '</div>';
                            // console.log( "activation : " + data.data[array_key[i]].active);
                            // console.log( "checked was : " + $('input', active).is(":checked"))
                            activation.innerHTML = active;

                            // for edit column
                            let user_edit_url = "{{Route('EditUser')}}/" + users[i].sib_user_id;
                            let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + users[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                                ' <i class="material-icons">edit</i>\n' +
                                'ویرایش\n' +
                                ' </button>' ;
                            userEdit.innerHTML = edit_html;
                        }
                    }

                }else {

                        user = userData.filter(d => ((user_filter_value == "")  ?  true : d.account_type === user_filter_value) && ((serach == "")  ?  true : ( (d.first_name + " " + d.last_name ).search(serach))  != -1)   );

                    for(let i = 0 ; i < user.length ; i++){
                        var row = table.insertRow();
                        var name = row.insertCell();
                        var mobile = row.insertCell();
                        var account_type = row.insertCell();
                        var permission = row.insertCell();
                        var activation = row.insertCell();
                        var userEdit = row.insertCell();

                        name.innerHTML = user[i].last_name + " " + user[i].first_name;
                        mobile.innerHTML = user[i].mobile;
                        account_type.innerHTML = user[i].account_type;

                        // for permission column
                        let permission_html ;
                        let url ;
                        // console.log( "permisson data : " + data.data.data.has_permission)
                        if( user[i].has_permission == 1) {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                        }
                        else {
                            url = "{{Route('setUserPermission')}}/" + user[i].sib_user_id;
                            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                ' <i class="material-icons">person_add_alt_1</i>\n' +
                                '                                                        تعریف\n' +
                                ' </a>' ;
                        }
                        permission.innerHTML = permission_html;

                        // for activation
                        let check ;
                        if(user[i].active)
                        {
                            check = "checked" ;
                        }
                        else
                            check = "";
                        let active = '<div dir="ltr" class="togglebutton">\n' +
                            '  <label>\n' +
                            '      <input sib-user-id=" ' + user[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                            '    <span class="toggle"></span>\n' +
                            '  </label>\n' +
                            '</div>';
                        // console.log( "activation : " + data.data.data[i].active);
                        // console.log( "checked was : " + $('input', active).is(":checked"))
                        activation.innerHTML = active;
                        // for edit column
                        let user_edit_url = "{{Route('EditUser')}}/" +user[i].sib_user_id;
                        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + user[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                            ' <i class="material-icons">edit</i>\n' +
                            'ویرایش\n' +
                            ' </button>' ;
                        userEdit.innerHTML = edit_html;
                    }

                }
                setTimeout(function () {
                    $('#loader').hide();
                } , 300);
                // console.log('arr1', arr1.length);

            });
        });
    </script>
@endsection
