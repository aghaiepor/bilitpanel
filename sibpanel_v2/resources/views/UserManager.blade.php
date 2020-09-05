@extends('MainLayout')

@section('title')
    <title>
        مدیریت کاربران
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .password_area{
            display: none;
        }
        .swal2-container .swal2-shown{
            z-index: 10000;

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
                                                        تعریف  </a>
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
                                                <button data-toggle="modal" data-id="{{$user['sib_user_id']}}" data-target="#edit{{$i}}" type="button" rel="tooltip" class="btn EditBtnAccess TableEditBtn  btn-success btn-simple">
                                                    <i class="material-icons">edit</i>
                                                    ویرایش
                                                </button>
                                                <div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title " id="testLabel"> ویرایش کاربر </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{Route('EditUser' , ['id' => $user['sib_user_id']])}}" method="post">
                                                                @csrf
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
                                                                        <label for=""> دسترسی به نوع فروش </label>
                                                                        <select name="pre_sell" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                                            <option selected value="0"> خیر</option>
                                                                            <option value="1"> بله</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mt-3">
                                                                    <div class="col-sm-6 text-right">
                                                                        <label for=""> IEMI </label>
                                                                        <input name="imei" type="text" class="form-control"  placeholder="imei برای کاربر استند و گیشه ">
                                                                    </div>
                                                                    <div class="col-sm-6 text-right">
                                                                        <div dir="ltr" class="togglebutton">
                                                                                <label>
                                                                                    <input name="pass" type="checkbox">
                                                                                    <span class="toggle"></span>
                                                                                    تغییر رمزعبور ؟
                                                                                </label>
                                                                        </div>
                                                                        <input autocomplete="false" name="password" type="password" class="form-control "  placeholder="کلمه عبور">
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
                                    </tbody>

                                </table>
                            </div>
                            <div class="row justify-content-center">
                                {{ $Users->links() }}
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

            $('.EditBtnAccess').click(function () {
                $("input[name=pass]").parent().parent().next().hide()
                let action = false ;
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
                            Element.find("input[name=name]").val(data.first_name);
                            Element.find("input[name=last_name]").val(data.last_name);
                            Element.find("input[name=username]").val(data.username);
                            Element.find("input[name=cellphone]").val(data.mobile);
                            Element.find("select[name=account_type_id]").find("option[value="+ data.account_type_id + "]").attr('selected' , true);
                            Element.find("input[name=national_id]").val(data.national_id);
                            Element.find("input[name=email]").val(data.email);
                            let pre_sale = (data.presell)  ? '1' : '0' ;
                            Element.find("select[name=pre_sell]").find("option[value="+ pre_sale + "]").attr('selected' , true);
                            // Element.find("input[name=pre_sell]").val(data.presell);
                            // console.log(data.presell);
                            Element.find("input[name=imei]").val(data.imei);
                            Element.find("input[name=password]").val('');
                            $('#loader').hide();
                            $('.selectpicker').selectpicker('refresh');
                        }
                    });
                }



            });
        });
    </script>
@endsection
