@extends('MainLayout')

@section('title')
    <title>
        مدیریت تخفیف
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
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
                            <div class="row">
                                <div class="col-md text-right">
                                    <label for="" class="text-right">  پروژه </label>
                                    <select id="project_id" name="project_id" data-live-search="true" class="selectpicker" data-style="btn btn-primary border-dark" title="پروژه">
                                        <option selected  value="0"  > همه </option>
                                        @foreach($ProjectList as $Project)
                                            <option value="{{$Project["project_id"]}}" > {{$Project["project_name"]}} </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md text-right">
                                    <label for="" class="text-right"> مکان </label>
                                    <select id="location_id" name="location_id" data-live-search="true" class="selectpicker bootstrap-select" data-style="btn btn-primary border-dark" title="مکان">
                                        <option selected value="0"  > همه </option>
                                        @foreach($locations as $location)
                                            <option value="{{$location['id']}}"> {{$location['location_name']}} </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md text-right">
                                    <label for="" class="text-right">  سرویس </label>
                                    <select id="service_id" name="service_id" data-live-search="true" class="selectpicker" data-style="btn btn-primary border-dark w-100" title="سرویس">
                                        <option selected value="0"  > همه </option>
                                        @foreach($ServiceList as $Service)
                                            <option value="{{$Service["service_id"]}}"  > {{$Service["service_name"]}}  </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md text-right">
                                    <label for="" class="text-right"> بلیت  </label>
                                    <select id="voucher_info_id" name="voucher_info_id" data-live-search="true" class="selectpicker" data-style="btn btn-primary border-dark" title="مکان">
                                        <option selected value="0"> همه </option>
                                        @foreach($VoucherTypeList as $VoucherType)
                                            <option value="{{$VoucherType["voucher_type_id"]}}"> {{$VoucherType["voucher_type"]}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md text-right">
                                    <label for="" class="text-right">  کاربر </label>
                                    <select id="sib_user_id" name="sib_user_id" data-live-search="true" class="selectpicker" data-style="btn btn-primary border-dark" title="کاربر">
                                        <option selected value="0"  > همه </option>
                                        @foreach($SellerUserList as $SellerUser)
                                            <option value="{{$SellerUser["sib_user_id"]}}"  >{{$SellerUser["first_name"] . " " . $SellerUser["last_name"] }}  </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive table-striped">
                                <table id="OffTable" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                           توضیحات
                                        </th>
                                        <th >
                                           درصد تخفیف
                                        </th>
                                        <th >
                                           فعال / غیر فعال
                                        </th>
                                        <th >
                                           شماره بیلت
                                        </th>
                                        <th >
                                            نام کاربری
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="OffTableTbody">
                                    <tr>
                                        <td colspan="6">
                                            <h6 class="py-5 text-center">
                                                برای نمایش یکی از فیلتر های بالا را انتخاب نمایید .
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
        <form action="{{Route("AddDiscountPolicy")}}" method="post">
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
                            <input name="percentage" type="text" class="form-control">
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  پروژه </label>
                            <select  name="project_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="پروژه">
                                <option selected  value=""  > همه </option>
                                @foreach($ProjectList as $Project)
                                    <option value="{{$Project["project_id"]}}" > {{$Project["project_name"]}} </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> مکان </label>
                            <select  name="location_id" class="selectpicker" data-live-search="true" data-width="75%" data-style="btn btn-primary border-dark" title="مکان">
                                <option selected value=""  > همه </option>
                                @foreach($locations as $location)
                                    <option value="{{$location['id']}}"> {{$location['location_name']}} </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  سرویس </label>
                            <select  name="service_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark w-100" title="سرویس">
                                <option selected value=""  > همه </option>
                                @foreach($ServiceList as $Service)
                                    <option value="{{$Service["service_id"]}}"  > {{$Service["service_name"]}}  </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> بلیت  </label>
                            <select  name="voucher_info_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="مکان">
                                <option selected value=""> همه </option>
                                @foreach($VoucherTypeList as $VoucherType)
                                    <option value="{{$VoucherType["voucher_type_id"]}}"> {{$VoucherType["voucher_type"]}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md text-right">
                            <label for="" class="text-right">  کاربر </label>
                            <select  name="sib_user_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="کاربر">
                                <option selected value=""  > همه </option>
                                @foreach($SellerUserList as $SellerUser)
                                    <option value="{{$SellerUser["sib_user_id"]}}"  >{{$SellerUser["first_name"] . " " . $SellerUser["last_name"] }}  </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for=""> توضیحات </label>
                            <textarea class="form-control" name="description" style="min-height: 150px"></textarea>
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
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="EditOffForm" action="#" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> اضافه کردن تخفیف </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="active" id="edit_active" value="">
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-md text-right">
                                <label for="" class="text-right"> درصد تخفیف </label>
                                <input id="edit_percent" name="percentage" type="text" class="form-control">
                            </div>
                          {{--  <div class="col-md text-right">
                                <label for="" class="text-right">  پروژه </label>
                                <select id="edit_project_id" name="project_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="پروژه">
                                    <option selected  value=""  > همه </option>

                                </select>
                            </div>--}}
                        </div>
                       {{-- <div class="form-row mt-3">
                            <div class="col-md text-right">
                                <label for="" class="text-right"> مکان </label>
                                <select id="edit_location_id" name="location_id" class="selectpicker" data-live-search="true" data-width="75%" data-style="btn btn-primary border-dark" title="مکان">
                                    <option selected value=""  > همه </option>
                                    @foreach($locations as $location)
                                        <option value="{{$location['id']}}"> {{$location['location_name']}} </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md text-right">
                                <label for="" class="text-right">  سرویس </label>
                                <select  name="service_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark w-100" title="سرویس">
                                    <option selected value=""  > همه </option>
                                    @foreach($ServiceList as $Service)
                                        <option value="{{$Service["service_id"]}}"  > {{$Service["service_name"]}}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md text-right">
                                <label for="" class="text-right"> بلیت  </label>
                                <select  name="voucher_info_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="مکان">
                                    <option selected value=""> همه </option>
                                    @foreach($VoucherTypeList as $VoucherType)
                                        <option value="{{$VoucherType["voucher_type_id"]}}"> {{$VoucherType["voucher_type"]}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md text-right">
                                <label for="" class="text-right">  کاربر </label>
                                <select  name="sib_user_id" class="selectpicker" data-live-search="true" data-style="btn btn-primary border-dark" title="کاربر">
                                    <option selected value=""  > همه </option>
                                    @foreach($SellerUserList as $SellerUser)
                                        <option value="{{$SellerUser["sib_user_id"]}}"  >{{$SellerUser["first_name"] . " " . $SellerUser["last_name"] }}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>--}}
                        <div class="form-row mt-3">
                            <div class="col-md text-right">
                                <label for=""> توضیحات </label>
                                <textarea id="edit_description" class="form-control" name="description" style="min-height: 150px"></textarea>
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
    <script>
        $(document).ready(function () {
            $("#project_id , #location_id , #service_id , #voucher_info_id , #sib_user_id  ").change(function () {
                $('#loader').css("display" , "flex");
                let project_id = $("#project_id").val();
                let location_id = $("#location_id").val();
                let service_id = $("#service_id").val();
                let voucher_info_id = $("#voucher_info_id").val();
                let sib_user_id = $("#sib_user_id").val();

                $.ajax({
                    type:'POST',
                    url:"{{Route('GetDiscountPolicyList')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'project_id' : project_id ,
                        'location_id' : location_id ,
                        'service_id' : service_id ,
                        'voucher_info_id' : voucher_info_id ,
                        'sib_user_id' : sib_user_id ,
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
                        $('#loader').hide();
                        let offs = data["ContentData"];
                        // console.log(offs);
                        let table = document.getElementById("OffTable").getElementsByTagName('tbody')[0];
                        $("#OffTableTbody").html(" ");
                        if(offs.length == 0)
                        {
                            var row = table.insertRow();
                            var cell = row.insertCell();
                            cell.id = "myTd";
                            cell.innerHTML = "<h6 class ='text-center py-5'> موردی یافت نشد!  </h6>";
                            document.getElementById("myTd").colSpan = "6";
                            $("#loader").hide();
                        }
                        else
                        {
                            let row ;
                            let description ;
                            let percent ;
                            let active ;
                            let voucher_info ;
                            let seller_number ;
                            for(let i = 0 ; i < offs.length ; i++){
                                row = table.insertRow();
                                description = row.insertCell();
                                percent = row.insertCell();
                                active = row.insertCell();
                                voucher_info = row.insertCell();
                                sib_user = row.insertCell();
                                Edit = row.insertCell();

                                description.innerHTML = (offs[i].description == null) ? " - " : offs[i].description ;
                                percent.innerHTML = offs[i].percentage ;
                                let state_html = ' <div class="togglebutton">' + '<label>' ;
                                if (offs[i].active)
                                    state_html += '<input data-id="' +offs[i].id + '" data-percent="'+offs[i].percentage+'" data-description="'+ offs[i].description+'"  type="checkbox" name="active" checked="">'  ;
                                else
                                    state_html += '<input data-id="' +offs[i].id + '" data-percent="'+offs[i].percentage+'" data-description="'+ offs[i].description+'"  type="checkbox" name="active">'  ;

                                state_html +=   '<span class="toggle"></span>' + '</label>' + '</div>';
                                active.innerHTML = state_html ;
                                voucher_info.className = "voucher" +i ;
                                /*let voucher ;
                                if(offs[i].sib_user == null)
                                {
                                    voucher = " - "
                                }else
                                {
                                    voucher = '<div class="spinner-border mx-auto d-block" style="color: #c4c4c4;"></div>' ;
                                    VoucherTypeList(offs[i].voucher_info , "voucher" +i)
                                }*/
                                voucher_info.innerHTML =  offs[i].voucher_info;

                                sib_user.className = "user" +i ;
                                let user ;
                                if(offs[i].sib_user == null)
                                {
                                    user = " - "
                                }else
                                {
                                    user = '<div class="spinner-border mx-auto d-block" style="color: #c4c4c4;"></div>' ;
                                    GetSibUser(offs[i].sib_user ,"user" +i )
                                }
                                sib_user.innerHTML = user ;
                                Edit.innerHTML = "<button data-id='" +offs[i].id +"' data-percent='"+ offs[i].percentage +"' data-description='"+ offs[i].description+"' data-toggle='modal' data-target='#EditModal' class='btn btn-success edit_btn'> ویرایش </button>";
                            }
                        }

                        // Swal.fire(
                        //     'تغییرات با موفقیت اعمال گردید .',
                        //     "" ,
                        //     'success' ,
                        // )
                        /* if(data.data)
                             alert('true');
                         else
                             alert('false')*/
                    }
                });
            });

            $(document).on( "click" , ".edit_btn" , function () {
                let id = $(this).attr("data-id");
                let data_percent = $(this).attr("data-percent");
                let data_description = $(this).attr("data-description");
                let data_active = $(this).parent().parent().children().eq(2).find("input").val();
                if(data_active == "on")
                    data_active = true ;
                else
                    data_active = false;

                let url = "{{Route("EditDiscountPolicy")}}/" + id  ;
                $("#EditOffForm").attr("action" , url);
                $("#edit_percent").val(data_percent);
                $("#edit_active").val(data_active);
                if(data_description == "null" )
                    data_description=""
                $("#edit_description").val(data_description);

            });

            $(document).on( "click" , "input[name=active]" , function () {
                let id = $(this).attr("data-id");
                // console.log("id => ", id);
                let data_percent = $(this).attr("data-percent");
                let data_description = $(this).attr("data-description");
                let data_active =  $(this).is(':checked');
                // console.log(data_active);
                $("#loader").css("display" , "flex");
                $.ajax({
                    type:'POST',
                    url:"{{Route('DiscountPolicyَActivaion')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'id' : id ,
                        'active' : data_active ,
                        'description' : data_description ,
                        'percentage' : data_percent ,
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
                        $("#loader").hide();
                        if(data["Header"]["Status"] == 0)
                        {
                            Swal.fire(
                                'تغییرات با موفقیت اعمال گردید .',
                                "" ,
                                'success' ,
                            )
                        }
                    }
                });

            });
        });
        function GetSibUser(id , className) {
            let Username = "" ;
            let cName = "." +className ;
            $.ajax({
                type:'POST',
                url:"{{Route('GetSibUser')}}",
                dataType:'json',
                data:{
                    '_token ': '<?php echo csrf_token() ?>',
                    'id' : id ,
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
                    // $('#loader').hide();
                    let UserInfo = data["ContentData"];
                    // console.log("UserInfo => " , UserInfo.user_name);
                    $(cName).html(UserInfo.user_name);
                    Username = UserInfo.user_name;
                    return Username ;
                }
            });
            // return Username ;
        }
       /* function VoucherTypeList(id , className) {
            let Username = "" ;
            let cName = "." + className ;
            console.log("cName" , cName);
            let VocherInfo = @json($VoucherTypeList);
            let Vocher = VocherInfo.filter(d =>  (d.voucher_type_id == id) );
            console.log("voucher number => " , Vocher[0]);
            $(cName).html(Vocher[0].voucher_type)
            // return Username ;
        }*/
    </script>
@endsection
