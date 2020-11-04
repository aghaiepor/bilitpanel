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
                                    <select id="user_search" data-live-search="true" name="user_search" class="selectpicker " data-width="100%" data-style="btn btn-primary border-dark" title="جست و جو ..">
                                        @foreach($userLists as $user)
                                            <option value="{{$user['sib_user_id'] . "-" .  $user['has_permission'] }}"> {{$user['first_name'] . " ". $user['last_name'] . " - " .  $user['account_type'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select id="user_filter" name="user_filter" class="selectpicker " data-width="100%" data-style="btn btn-primary border-dark" title="فیلتر">
                                        <option value=""> همه </option>
                                        <option value="admin user">admin user</option>
                                        <option value="panel user">panel user</option>
                                        <option value="validator user">validator user</option>
                                        <option value="api user">api user</option>
                                        <option value="operator user">operator user</option>
                                        <option value="local admin user">local admin user</option>
                                        <option value="b2b user">b2b user</option>
                                        <option value="stand user">stand user</option>
                                        <option value="cash user">cash user</option>س
                                        {{--@foreach($userLists as $user)
                                            <option value="{{$user['sib_user_id'] . "-" .  $user['has_permission'] }}"> {{$user['first_name'] . " ". $user['last_name'] . " - " .  $user['account_type'] }}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div data-active="" id="alphabets" class="col-md-auto text-center w-100 text-black alphabets">
                                    <span class="badge badge-lg badge-primary "> آ </span>
                                    <span class="badge badge-lg badge-primary "> الف </span>
                                    <span class="badge badge-primary"> ب </span>
                                    <span class="badge badge-primary"> پ </span>
                                    <span class="badge badge-primary"> ت </span>
                                    <span class="badge badge-primary"> ث </span>
                                    <span class="badge badge-primary"> ج </span>
                                    <span class="badge badge-primary"> چ </span>
                                    <span class="badge badge-primary"> ح </span>
                                    <span class="badge badge-primary"> خ </span>
                                    <span class="badge badge-primary"> د </span>
                                    <span class="badge badge-primary"> ذ </span>
                                    <span class="badge badge-primary"> ر </span>
                                    <span class="badge badge-primary"> ز </span>
                                    <span class="badge badge-primary"> ژ </span>
                                    <span class="badge badge-primary"> س </span>
                                    <span class="badge badge-primary"> ش </span>
                                    <span class="badge badge-primary"> ص </span>
                                    <span class="badge badge-primary"> ض </span>
                                    <span class="badge badge-primary"> ط </span>
                                    <span class="badge badge-primary"> ظ </span>
                                    <span class="badge badge-primary"> ع </span>
                                    <span class="badge badge-primary"> غ </span>
                                    <span class="badge badge-primary"> ق </span>
                                    <span class="badge badge-primary"> ف </span>
                                    <span class="badge badge-primary"> ک </span>
                                    <span class="badge badge-primary"> گ </span>
                                    <span class="badge badge-primary"> ل </span>
                                    <span class="badge badge-primary"> م </span>
                                    <span class="badge badge-primary"> ن </span>
                                    <span class="badge badge-primary"> و </span>
                                    <span class="badge badge-primary"> ه </span>
                                    <span class="badge badge-primary"> ی </span>
                                    <span class="badge badge-primary"> اعداد </span>
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
        <form action="{{Route('RegisterUser')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> تعریف کاربر جدید </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> نام </label>
                            <input name="name" type="text" class="form-control"  placeholder="نام  ">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for=""> نام خانوادگی </label>
                            <input name="last_name" type="text" class="form-control"  placeholder=" نام خانوادگی">
                        </div>
                    </div>

                    <div class="form-row mt-3 text-right" >
                        <div class="col-sm-6">
                            <label for=""> نام کاربری </label>
                            <input autocomplete="false" name="username" type="text" class="form-control"  placeholder="نام کاربری  ">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for=""> شماره موبایل </label>
                            <input name="cellphone" type="number" class="form-control"  placeholder="شمار موبایل">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> نوع اکانت </label>
                            <select name="account_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option value="" disabled selected>  انتخاب کنید </option>
                                <option value="1">admin user</option>
                                <option value="2">panel user</option>
                                <option value="5">validator user</option>
                                <option value="6">api user</option>
                                <option value="8">operator user</option>
                                <option value="9">local admin user</option>
                                <option value="7">b2b user</option>
                                <option value="4">stand user</option>
                                <option value="3">cash user</option>
                            </select>
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for="">کد ملی</label>
                            <input name="national_id" type="number" class="form-control"  placeholder="شمار ملی">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> ایمیل </label>
                            <input name="email" type="email" class="form-control"  placeholder="ایمیل ">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for="">   رمزعبور </label>
                            <input autocomplete="false" name="password" type="password" class="form-control"  placeholder="کلمه عبور">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm-6 text-right">
                            <label for=""> IEMI </label>
                            <input name="imei" type="text" class="form-control"  placeholder="imei برای کاربر استند و گیشه ">
                        </div>
                        <div class="col-sm-6 text-right">
                            <label for=""> دسترسی به نوع فروش </label>
                            <select name="pre_sell" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                <option selected value="0"> خیر</option>
                                <option value="1"> بله</option>
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
                        <div class="form-row mt-3">
                            <div class="col-sm-6 text-right">
                                <label for=""> نام </label>
                                <input id="user_first_name" name="name" type="text" class="form-control"  placeholder="نام  ">
                            </div>
                            <div class="col-sm-6 text-right">
                                <label for=""> نام خانوادگی </label>
                                <input id="user_last_name" name="last_name" type="text" class="form-control"  placeholder=" نام خانوادگی">
                            </div>
                        </div>

                        <div class="form-row mt-3 text-right" >
                            <div class="col-sm-6">
                                <label for=""> نام کاربری </label>
                                <input id="user_username" autocomplete="false" name="username" type="text" class="form-control"  placeholder="نام کاربری  ">
                            </div>
                            <div class="col-sm-6 text-right">
                                <label for=""> شماره موبایل </label>
                                <input id="user_mobile" name="cellphone" type="number" class="form-control"  placeholder="شمار موبایل">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm-6 text-right">
                                <label for=""> نوع اکانت </label>
                                <select id="user_account_type_id" name="account_type_id" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                    <option value="1">admin user</option>
                                    <option value="2">panel user</option>
                                    <option value="5">validator user</option>
                                    <option value="6">api user</option>
                                    <option value="8">operator user</option>
                                    <option value="9">local admin user</option>
                                    <option value="7">b2b user</option>
                                    <option value="4">stand user</option>
                                    <option value="3">cash user</option>
                                </select>
                            </div>
                            <div class="col-sm-6 text-right">
                                <label for="">کد ملی</label>
                                <input id="user_national_id" name="national_id" type="number" class="form-control"  placeholder="شمار ملی">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm-6 text-right">
                                <label for=""> ایمیل </label>
                                <input id="user_email" name="email" type="email" class="form-control"  placeholder="ایمیل ">
                            </div>
                            <div class="col-sm-6 text-right">
                                <label for=""> دسترسی به نوع فروش </label>
                                <select id="user_pre_sell" name="pre_sell" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                    <option selected value="0"> خیر</option>
                                    <option value="1"> بله</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm-6 text-right">
                                <label for=""> IEMI </label>
                                <input id="user_imei" name="imei" type="text" class="form-control"  placeholder="imei برای کاربر استند و گیشه ">
                            </div>
                            <div class="col-sm-6 text-right">
                                <div dir="ltr" class="togglebutton">
                                    <label>
                                        <input name="pass" type="checkbox">
                                        <span class="toggle"></span>
                                        تغییر رمزعبور ؟
                                    </label>
                                </div>
                                <input id="user_password" autocomplete="false" name="password" type="password" class="form-control "  placeholder="کلمه عبور">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> ویرایش  </button>
                    </div>
                </form>
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

            var userData = @json($Users);
            var startsWith = [];
            // console.log(startsWithN);
            $('input[name=active]').change(function () {
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
                            success:function(data) {
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
            $("input[name=pass]").change(function () {
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
                    $("#loader").css('display' , 'flex');
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
                        success:function(data) {
                            $('#form_edit').attr('action' , action_url );
                           $('#user_first_name').val(data.first_name);
                            $('#user_last_name').val(data.last_name);
                            $('#user_username').val(data.username);
                            $('#user_mobile').val(data.mobile);
                            $('#user_account_type_id').find("option[value="+ data.account_type_id + "]").attr('selected' , true);
                            $('#user_national_id').val(data.national_id);
                            $('#user_email').val(data.email);
                            let pre_sale = (data.presell)  ? '1' : '0' ;
                            $('#user_pre_sell').find("option[value="+ pre_sale + "]").attr('selected' , true);
                            // Element.find("input[name=pre_sell]").val(data.presell);
                            // console.log(data.presell);
                            $('#user_imei').val(data.imei);
                            $('#user_password').val('');
                            $('#loader').hide();
                            $('.selectpicker').selectpicker('refresh');
                        }
                    });
                }
            });

            // users filters
            $("#user_search").change(function () {
                $('#userInfo tbody').html(" ");
                $('#loader').css('display' , 'flex');
                let value = $(this).val() ;
                value = value.split("-");
                let userId = value[0];
                let has_permisson = value[1];
                $.ajax({
                    headers: {
                        'Cache-Control': 'max-age=1000'
                    } ,
                    type:'POST',
                    url:"{{Route('GetUserInfo')}}" ,
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'UserId' : userId ,
                    },
                    success:function(data) {
                        console.log(data);
                        let sib_user_id = data.sib_user_id;
                        $("#pagination_links").hide();
                        $('#userInfo tbody').html(" ");
                        let table = document.getElementById("userInfo");
                        var row = table.insertRow();
                        var name = row.insertCell();
                        var mobile = row.insertCell();
                        var account_type = row.insertCell();
                        var permission = row.insertCell();
                        var activation = row.insertCell();
                        var userEdit = row.insertCell();
                        name.innerHTML = data.first_name + " " + data.last_name;
                        mobile.innerHTML = data.mobile;
                        account_type.innerHTML = data.account_type;

                        // for permission column
                        let permission_html ;
                        let url ;
                        console.log( "permisson data : " + data.has_permission)
                        if(has_permisson == 1) {
                            url = "{{Route('setUserPermission')}}/" + data.sib_user_id;
                            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                        }
                        else {
                            url = "{{Route('setUserPermission')}}/" + data.sib_user_id;
                            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                ' <i class="material-icons">person_add_alt_1</i>\n' +
                                '                                                        تعریف\n' +
                                ' </a>' ;
                        }
                        permission.innerHTML = permission_html;

                        // for activation
                        let check ;
                        if(data.active)
                        {
                            check = "checked" ;
                        }
                        else
                            check = "";
                        let active = '<div dir="ltr" class="togglebutton">\n' +
                            '  <label>\n' +
                            '      <input sib-user-id=" ' + sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                            '    <span class="toggle"></span>\n' +
                            '  </label>\n' +
                            '</div>';
                            console.log( "activation : " + data.active);
                            console.log( "checked was : " + $('input', active).is(":checked"))
                        activation.innerHTML = active;

                        // for edit column
                        let user_edit_url = "{{Route('EditUser')}}/" + data.sib_user_id;
                        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                            ' <i class="material-icons">edit</i>\n' +
                            'ویرایش\n' +
                            ' </button>' ;
                        userEdit.innerHTML = edit_html;
                        $('#loader').hide();
                    }
                });
            });
            $("#user_filter").change(function () {
                let value = $(this).val() ;
                // console.log(value);
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

                // console.log(value == null)
                $('#loader').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('getUserWithFilter')}}" ,
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'filter' : value ,
                        'alphabet_index' : alphabet_index ,
                    },
                    success:function(data) {
                        $('#userInfo tbody').html(" ");
                        let table = document.getElementById("userInfo").getElementsByTagName('tbody')[0];
                        // console.log(data);
                        if(data.data.length == 0 )
                        {
                            $("#pagination_links").hide();
                            var row = table.insertRow();
                            var cell = row.insertCell();
                            cell.id = "myTd";
                            cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                            document.getElementById("myTd").colSpan = "6";
                        }
                        else if(data.array_key == -1 ){
                        let sib_user_id = data.sib_user_id;
                        $("#pagination_links").show();
                        // console.log(data.data.data.length)
                        for(let i = 0 ; i < data.data.length ; i++){
                            var row = table.insertRow();
                            var name = row.insertCell();
                            var mobile = row.insertCell();
                            var account_type = row.insertCell();
                            var permission = row.insertCell();
                            var activation = row.insertCell();
                            var userEdit = row.insertCell();

                            name.innerHTML = data.data[i].first_name + " " + data.data[i].last_name;
                            mobile.innerHTML = data.data[i].mobile;
                            account_type.innerHTML = data.data[i].account_type;

                            // for permission column
                            let permission_html ;
                            let url ;
                            // console.log( "permisson data : " + data.data.data.has_permission)
                            if( data.data[i].has_permission == 1) {
                                url = "{{Route('setUserPermission')}}/" + data.data[i].sib_user_id;
                                permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                            }
                            else {
                                url = "{{Route('setUserPermission')}}/" + data.data[i].sib_user_id;
                                permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                    ' <i class="material-icons">person_add_alt_1</i>\n' +
                                    '                                                        تعریف\n' +
                                    ' </a>' ;
                            }
                            permission.innerHTML = permission_html;

                            // for activation
                            let check ;
                            if(data.data[i].active)
                            {
                                check = "checked" ;
                            }
                            else
                                check = "";
                            let active = '<div dir="ltr" class="togglebutton">\n' +
                                '  <label>\n' +
                                '      <input sib-user-id=" ' + data.data[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                                '    <span class="toggle"></span>\n' +
                                '  </label>\n' +
                                '</div>';
                            // console.log( "activation : " + data.data.data[i].active);
                            // console.log( "checked was : " + $('input', active).is(":checked"))
                            activation.innerHTML = active;

                            // for edit column
                            let user_edit_url = "{{Route('EditUser')}}/" + data.data[i].sib_user_id;
                            let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.data[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                                ' <i class="material-icons">edit</i>\n' +
                                'ویرایش\n' +
                                ' </button>' ;
                            userEdit.innerHTML = edit_html;
                        }
                        }
                        else
                        {
                            $("#pagination_links").hide();
                            // console.log(data.array_key)
                            let array_key = data.array_key;
                            for(let i = 0 ; i < array_key.length ; i++){
                                var row = table.insertRow();
                                var name = row.insertCell();
                                var mobile = row.insertCell();
                                var account_type = row.insertCell();
                                var permission = row.insertCell();
                                var activation = row.insertCell();
                                var userEdit = row.insertCell();

                                name.innerHTML = data.data[array_key[i]].first_name + " " + data.data[array_key[i]].last_name;
                                mobile.innerHTML = data.data[array_key[i]].mobile;
                                account_type.innerHTML = data.data[array_key[i]].account_type;

                                // for permission column
                                let permission_html ;
                                let url ;
                                // console.log( "permisson data : " + data.data.has_permission)
                                if( data.data[array_key[i]].has_permission == 1) {
                                    url = "{{Route('setUserPermission')}}/" + data.data[array_key[i]].sib_user_id;
                                    permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                                }
                                else {
                                    url = "{{Route('setUserPermission')}}/" + data.data[array_key[i]].sib_user_id;
                                    permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                        ' <i class="material-icons">person_add_alt_1</i>\n' +
                                        '                                                        تعریف\n' +
                                        ' </a>' ;
                                }
                                permission.innerHTML = permission_html;

                                // for activation
                                let check ;
                                if(data.data[array_key[i]].active)
                                {
                                    check = "checked" ;
                                }
                                else
                                    check = "";
                                let active = '<div dir="ltr" class="togglebutton">\n' +
                                    '  <label>\n' +
                                    '      <input sib-user-id=" ' + data.data[array_key[i]].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                                    '    <span class="toggle"></span>\n' +
                                    '  </label>\n' +
                                    '</div>';
                                // console.log( "activation : " + data.data[array_key[i]].active);
                                // console.log( "checked was : " + $('input', active).is(":checked"))
                                activation.innerHTML = active;

                                // for edit column
                                let user_edit_url = "{{Route('EditUser')}}/" + data.data[array_key[i]].sib_user_id;
                                let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.data[array_key[i]].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
                                    ' <i class="material-icons">edit</i>\n' +
                                    'ویرایش\n' +
                                    ' </button>' ;
                                userEdit.innerHTML = edit_html;
                            }
                        }
                        $('#loader').hide();
                    }
                });
            });

            let ElementIndex = null ;
            let isActive = false ;
            $("#alphabets .badge").click(function () {
                let value = $(this).text();
                let user_filter_value = $("#user_filter").val();
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
                let  users ;
                console.log(value.length)
                if(value.length >= 4)
                {
                    users = userData.filter(d => number.indexOf(d.first_name[0]) != -1 && ((user_filter_value == "")  ?  true : d.account_type === user_filter_value));
                }
                else {
                    value = value[1];
                    users = userData.filter(d => d.first_name[0] === value && ((user_filter_value == "")  ?  true : d.account_type === user_filter_value)   );
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

                            name.innerHTML = users[i].first_name + " " + users[i].last_name;
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
                    for(let i = 0 ; i < userData.length ; i++){
                        var row = table.insertRow();
                        var name = row.insertCell();
                        var mobile = row.insertCell();
                        var account_type = row.insertCell();
                        var permission = row.insertCell();
                        var activation = row.insertCell();
                        var userEdit = row.insertCell();

                        name.innerHTML = userData[i].first_name + " " + userData[i].last_name;
                        mobile.innerHTML = userData[i].mobile;
                        account_type.innerHTML = userData[i].account_type;

                        // for permission column
                        let permission_html ;
                        let url ;
                        // console.log( "permisson data : " + data.data.data.has_permission)
                        if( userData[i].has_permission == 1) {
                            url = "{{Route('setUserPermission')}}/" + userData[i].sib_user_id;
                            permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';
                        }
                        else {
                            url = "{{Route('setUserPermission')}}/" + userData[i].sib_user_id;
                            permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +
                                ' <i class="material-icons">person_add_alt_1</i>\n' +
                                '                                                        تعریف\n' +
                                ' </a>' ;
                        }
                        permission.innerHTML = permission_html;

                        // for activation
                        let check ;
                        if(userData[i].active)
                        {
                            check = "checked" ;
                        }
                        else
                            check = "";
                        let active = '<div dir="ltr" class="togglebutton">\n' +
                            '  <label>\n' +
                            '      <input sib-user-id=" ' + userData[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +
                            '    <span class="toggle"></span>\n' +
                            '  </label>\n' +
                            '</div>';
                        // console.log( "activation : " + data.data.data[i].active);
                        // console.log( "checked was : " + $('input', active).is(":checked"))
                        activation.innerHTML = active;
                        // for edit column
                        let user_edit_url = "{{Route('EditUser')}}/" +userData[i].sib_user_id;
                        let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + userData[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +
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

            {{--$.ajax({--}}
            {{--        type:'POST',--}}
            {{--        url:"{{Route('getUserWithAlphabet')}}" ,--}}
            {{--        dataType:'json',--}}
            {{--        data:{--}}
            {{--            '_token ': '<?php echo csrf_token() ?>',--}}
            {{--            'filter' : value ,--}}
            {{--            'isActive' : isActive,--}}
            {{--            'user_filter_value' : user_filter_value ,--}}
            {{--        },--}}
            {{--        success:function(data) {--}}
            {{--            // console.log(data);--}}
            {{--            $('#userInfo tbody').html(" ");--}}
            {{--            let table = document.getElementById("userInfo").getElementsByTagName('tbody')[0];--}}
            {{--            // console.log(data);--}}
            {{--            if(data.data.length == 0 )--}}
            {{--            {--}}
            {{--                $("#pagination_links").hide();--}}
            {{--                var row = table.insertRow();--}}
            {{--                var cell = row.insertCell();--}}
            {{--                cell.id = "myTd";--}}
            {{--                cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";--}}
            {{--                document.getElementById("myTd").colSpan = "6";--}}
            {{--            }--}}
            {{--            else if(data.array_key == -1 ){--}}
            {{--                let sib_user_id = data.sib_user_id;--}}
            {{--                $("#pagination_links").show();--}}
            {{--                // console.log(data.data.data.length)--}}
            {{--                for(let i = 0 ; i < data.data.length ; i++){--}}
            {{--                    var row = table.insertRow();--}}
            {{--                    var name = row.insertCell();--}}
            {{--                    var mobile = row.insertCell();--}}
            {{--                    var account_type = row.insertCell();--}}
            {{--                    var permission = row.insertCell();--}}
            {{--                    var activation = row.insertCell();--}}
            {{--                    var userEdit = row.insertCell();--}}

            {{--                    name.innerHTML = data.data[i].first_name + " " + data.data[i].last_name;--}}
            {{--                    mobile.innerHTML = data.data[i].mobile;--}}
            {{--                    account_type.innerHTML = data.data[i].account_type;--}}

            {{--                    // for permission column--}}
            {{--                    let permission_html ;--}}
            {{--                    let url ;--}}
            {{--                    // console.log( "permisson data : " + data.data.data.has_permission)--}}
            {{--                    if( data.data[i].has_permission == 1) {--}}
            {{--                        url = "{{Route('setUserPermission')}}/" + data.data[i].sib_user_id;--}}
            {{--                        permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';--}}
            {{--                    }--}}
            {{--                    else {--}}
            {{--                        url = "{{Route('setUserPermission')}}/" + data.data[i].sib_user_id;--}}
            {{--                        permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +--}}
            {{--                            ' <i class="material-icons">person_add_alt_1</i>\n' +--}}
            {{--                            '                                                        تعریف\n' +--}}
            {{--                            ' </a>' ;--}}
            {{--                    }--}}
            {{--                    permission.innerHTML = permission_html;--}}

            {{--                    // for activation--}}
            {{--                    let check ;--}}
            {{--                    if(data.data[i].active)--}}
            {{--                    {--}}
            {{--                        check = "checked" ;--}}
            {{--                    }--}}
            {{--                    else--}}
            {{--                        check = "";--}}
            {{--                    let active = '<div dir="ltr" class="togglebutton">\n' +--}}
            {{--                        '  <label>\n' +--}}
            {{--                        '      <input sib-user-id=" ' + data.data[i].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +--}}
            {{--                        '    <span class="toggle"></span>\n' +--}}
            {{--                        '  </label>\n' +--}}
            {{--                        '</div>';--}}
            {{--                    // console.log( "activation : " + data.data.data[i].active);--}}
            {{--                    // console.log( "checked was : " + $('input', active).is(":checked"))--}}
            {{--                    activation.innerHTML = active;--}}

            {{--                    // for edit column--}}
            {{--                    let user_edit_url = "{{Route('EditUser')}}/" + data.data[i].sib_user_id;--}}
            {{--                    let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.data[i].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +--}}
            {{--                        ' <i class="material-icons">edit</i>\n' +--}}
            {{--                        'ویرایش\n' +--}}
            {{--                        ' </button>' ;--}}
            {{--                    userEdit.innerHTML = edit_html;--}}
            {{--                }--}}
            {{--            }--}}
            {{--            else--}}
            {{--            {--}}
            {{--                $("#pagination_links").hide();--}}
            {{--                // console.log(data.array_key)--}}
            {{--                let array_key = data.array_key;--}}
            {{--                for(let i = 0 ; i < array_key.length ; i++){--}}
            {{--                    var row = table.insertRow();--}}
            {{--                    var name = row.insertCell();--}}
            {{--                    var mobile = row.insertCell();--}}
            {{--                    var account_type = row.insertCell();--}}
            {{--                    var permission = row.insertCell();--}}
            {{--                    var activation = row.insertCell();--}}
            {{--                    var userEdit = row.insertCell();--}}

            {{--                    name.innerHTML = data.data[array_key[i]].first_name + " " + data.data[array_key[i]].last_name;--}}
            {{--                    mobile.innerHTML = data.data[array_key[i]].mobile;--}}
            {{--                    account_type.innerHTML = data.data[array_key[i]].account_type;--}}

            {{--                    // for permission column--}}
            {{--                    let permission_html ;--}}
            {{--                    let url ;--}}
            {{--                    // console.log( "permisson data : " + data.data.has_permission)--}}
            {{--                    if( data.data[array_key[i]].has_permission == 1) {--}}
            {{--                        url = "{{Route('setUserPermission')}}/" + data.data[array_key[i]].sib_user_id;--}}
            {{--                        permission_html = '<a href=" ' + url + '" class="btn btn-info px-4"> سطح دسترسی  </a>';--}}
            {{--                    }--}}
            {{--                    else {--}}
            {{--                        url = "{{Route('setUserPermission')}}/" + data.data[array_key[i]].sib_user_id;--}}
            {{--                        permission_html = ' <a href=" ' + url + '" class="btn btn-primary">\n' +--}}
            {{--                            ' <i class="material-icons">person_add_alt_1</i>\n' +--}}
            {{--                            '                                                        تعریف\n' +--}}
            {{--                            ' </a>' ;--}}
            {{--                    }--}}
            {{--                    permission.innerHTML = permission_html;--}}

            {{--                    // for activation--}}
            {{--                    let check ;--}}
            {{--                    if(data.data[array_key[i]].active)--}}
            {{--                    {--}}
            {{--                        check = "checked" ;--}}
            {{--                    }--}}
            {{--                    else--}}
            {{--                        check = "";--}}
            {{--                    let active = '<div dir="ltr" class="togglebutton">\n' +--}}
            {{--                        '  <label>\n' +--}}
            {{--                        '      <input sib-user-id=" ' + data.data[array_key[i]].sib_user_id  +'" name="active" ' + check + ' type="checkbox">\n' +--}}
            {{--                        '    <span class="toggle"></span>\n' +--}}
            {{--                        '  </label>\n' +--}}
            {{--                        '</div>';--}}
            {{--                    // console.log( "activation : " + data.data[array_key[i]].active);--}}
            {{--                    // console.log( "checked was : " + $('input', active).is(":checked"))--}}
            {{--                    activation.innerHTML = active;--}}

            {{--                    // for edit column--}}
            {{--                    let user_edit_url = "{{Route('EditUser')}}/" + data.data[array_key[i]].sib_user_id;--}}
            {{--                    let edit_html = '<button data-url="' + user_edit_url + '" data-toggle="modal" data-id="' + data.data[array_key[i]].sib_user_id +'" data-target="#edit" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">\n' +--}}
            {{--                        ' <i class="material-icons">edit</i>\n' +--}}
            {{--                        'ویرایش\n' +--}}
            {{--                        ' </button>' ;--}}
            {{--                    userEdit.innerHTML = edit_html;--}}
            {{--                }--}}
            {{--            }--}}
            {{--            $('#loader').hide();--}}
            {{--        }--}}
            {{--    });--}}
            });
        });
    </script>
@endsection
