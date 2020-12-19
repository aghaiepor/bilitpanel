@extends('MainLayout')

@section('title')
    <title>
        مدیریت پروژه
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        .citzen_main_img{
            width: 70px;
            height: 70px;
            border-radius: 20%;
            object-fit: cover;
            cursor: pointer;
            transition: 0.3s all;
        }
        .citzen_main_img:hover{
            filter: brightness(1.2);
            transform: scale(1.1);
        }
        .citzen_main_img:active{
            filter: brightness(1.8);
            transition: .1s filter;
        }
    </style>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت پروژه </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> افزودن پروژه </span>
                                    <button type="button" data-target="#add_User_off" data-toggle="modal" rel="tooltip" class="btn add_User_off off_btn btn-primary btn-simple">
                                        <i class="material-icons">local_offer </i>
                                        افزودن تخفیف کاربران
                                    </button>
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
                                          #
                                        </th> <th >
                                            نام پروژه
                                        </th>
                                        <th >
                                            توضيحات
                                        </th>
                                        <th >
                                            لوگو
                                        </th>
                                        <th >
                                           مدیریت تخفیف
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($GetProjectList) == 0)
                                        <tr>
                                            <td colspan="4">
                                                <h6 class="text-center py-5"> موردي يافت نشد ! </h6>
                                            </td>
                                        </tr>
                                        @else
                                        @foreach($GetProjectList as $Key => $Project)
                                            <tr>
                                                <td width="20">
                                                    {{$Key + 1 }}
                                                </td>
                                                <td >
                                                    {{$Project["project_name"]}}
                                                </td>
                                                <td >
                                                    @if($Project["description"] == "")
                                                        -
                                                    @else
                                                        {{$Project["description"]}}
                                                    @endif
                                                </td>
                                                <td >
                                                    @php
                                                        $voucher_image = null  ;
                                                        $api = new \App\Api\Api();
                                                        $project_id =  $Project["project_id"];
                                                        $ImageInfo  = $api->GetPicturesInfo(0,0,$project_id,0) ;
                                                        $ImageInfo = $ImageInfo["ContentData"]["project_pics"];
                                                        \Illuminate\Support\Facades\Log::info("ImageInfo" , $ImageInfo);
                                                        $project_image = null;
                                                    @endphp
                                                    @if(count($ImageInfo) == 0 )
                                                        <img project_id="{{ $Project["project_id"] }}" image_id="0" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                    @else
                                                        @foreach($ImageInfo as $pic)
                                                            @if($pic['tag'] == "logo")
                                                            @php
                                                                $project_image = $pic['picture_id'];
                                                                 $main_image_address = $api->GetImageAddress($project_image)
                                                            @endphp
                                                            <img project_id="{{ $Project["project_id"] }}" image_id="{{$pic['picture_id']}}" data-toggle="modal" data-target="#image_modal" class="citzen_main_img" src="{{$main_image_address}}" rel="main_image">
                                                            @endif
                                                        @endforeach
                                                        @if($project_image == null)
                                                            <img project_id="{{ $Project["project_id"] }}" data-toggle="modal" image_id="0" data-target="#image_modal" class="citzen_main_img" src="../assets/img/image_placeholder2.jpg" rel="placeholder">
                                                        @endif
                                                    @endif
{{--                                                    <img project_id="{{ $Project["project_id"] }}"  data-toggle="modal" image_id="0" data-target="#image_modal" class="citzen_main_img" src="{{asset("")}}assets/img/image_placeholder2.jpg" rel="placeholder">--}}
                                                </td>
                                                <td >
                                                   {{-- <a href="{{Route("ProjectOff" , [$Project["project_id"]])}}"  class="btn btn-info edit_btn">
                                                       مدیریت تخفیف
                                                    </a>--}}
                                                    <button data-url="{{Route("AddProjectOff" , [$Project["project_id"]])}}" type="button" data-target="#add_off" data-toggle="modal" rel="tooltip" class="btn off_btn btn-primary btn-simple">
                                                        <i class="material-icons">local_offer</i>
                                                        تخفیف
                                                    </button>

                                                </td>
                                                <td >
                                                    <button data-id="{{$Project["project_id"]}}"  data-toggle="modal" data-target="#edit" class="btn btn-success edit_btn">
                                                        ويرايش
                                                    </button>
                                                </td>
                                            </tr>
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

    <div class="modal fade" id="add_off" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="add_off_form" method="post" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="edit1Label">  افزودن تخفيف </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تخفيف به درصد </label>
                                <input value="" name="percentage" type="text" class="form-control"  placeholder="تخفيف به درصد">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تاريخ فعال سازي </label>
                                <input dir="ltr" value="" name="activation_date" id="activation_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                            <div class="col-sm text-right">
                                <label for="">  تاريخ انقضا </label>
                                <input dir="ltr" value="" name="expiration_date" id="expiration_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for=""> توضيحات  </label>
                                <textarea style="min-height: 150px !important;" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="modal fade" id="add_User_off" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="add_off_form" method="post" action="{{Route("AddUserOff")}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="edit1Label">  افزودن تخفيف </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تخفيف به درصد </label>
                                <input value="" name="percentage" type="text" class="form-control"  placeholder="تخفيف به درصد">
                            </div>
                            <div class="col-sm text-right">
                                <label for="" class="text-right">  کاربر </label>
                                <select id="sib_user_id" name="sib_user_id" data-live-search="true" class="selectpicker" data-style="btn btn-primary border-dark" title="کاربر">
                                    <option selected value="0"  > همه </option>
                                    @foreach($SellerUserList as $SellerUser)
                                        <option value="{{$SellerUser["sib_user_id"]}}"  >{{$SellerUser["first_name"] . " " . $SellerUser["last_name"] }}  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for="">  تاريخ فعال سازي </label>
                                <input dir="ltr" value="" name="activation_date" id="activation_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                            <div class="col-sm text-right">
                                <label for="">  تاريخ انقضا </label>
                                <input dir="ltr" value="" name="expiration_date" id="expiration_date_off" type="text" class="form-control text-center"  placeholder="">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-sm text-right">
                                <label for=""> توضيحات  </label>
                                <textarea style="min-height: 150px !important;" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route("AddProject")}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> اضافه کردن پروژه </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> نام </label>
                            <input name="project_name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md text-right">
                            <label for="" class="text-right"> توضيحات </label>
                            <textarea name="description" style="min-height: 150px !important;" class="form-control"></textarea>
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
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="EditProject" action="#" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="testLabel"> اضافه کردن پروژه </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div id="loader2" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
                                <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md text-right">
                                    <label for="" class="text-right"> نام </label>
                                    <input id="edit_project_name" name="project_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md text-right">
                                    <label for="" class="text-right"> توضيحات </label>
                                    <textarea id="edit_description" name="description" style="min-height: 150px !important;" class="form-control"></textarea>
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

    {{-- Modal for singel images   --}}
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid w-100 rounded" id="herf_modal_image" data-project-id="" data-image-id="" src="" alt="">
                </div>
                <div class="modal-footer">
                    <button id="insertBtn" class="btn btn-success px-3" data-toggle="modal" data-target="#insetImage">
                        افزودن عکس
                    </button>
                    <a id="DelBtn" href="" class="btn btn-danger px-3">
                        حذف عکس
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for add Project image   --}}
    <div class="modal fade" id="insetImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addImageForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
{{--                            <input type="hidden" value="{{$location_id}}" name="location_id">--}}
                            <div class="col text-right">
                                <label for=""> عکس آپلود </label>
                                <input type="file" name="service_image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-5" data-toggle="modal" data-target="">
                            افزودن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('AddJs')
    <script src="{{asset("")}}assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".edit_btn").click(function () {
                let value = $(this).attr("data-id");
                let url = "{{Route("EditProject")}}" + '/' + value ;
                $("#EditProject").attr("action" , url) ;
                let project_name = "";
                let description = "";
                $("#loader2").css("display" , "flex");
                $.ajax({
                    type:'POST',
                    url:"{{Route('GetProject')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'project_id' : value ,
                    },statusCode: {
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
                        let Project = data[0] ;
                        $("#edit_project_name").val(Project.project_name);
                        $("#edit_description").val(Project.description);
                    }
                });

            });

            $('#activation_date_off , #expiration_date_off').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                altField: '#inlineExampleAlt',
                format: 'YYYY/MM/DD hh:mm:ss',
                timePicker : {
                    enabled : true
                } ,
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                },
            });
            $(document).on(  "click" ,  ".off_btn"  , function () {
                let url = $(this).attr("data-url");
                $("#add_off_form").attr("action" , url)
            });
            // for show image and id on modal
            $(".citzen_main_img").click(function () {
                let src = $(this).attr("src") ;
                let project_id = $(this).attr("project_id");
                let image_id = $(this).attr("image_id");
                if(image_id == '0'){
                    $("#DelBtn").attr('href','#');
                    $("#DelBtn").hide();
                    $("#insertBtn").show();

                }else{
                    $("#DelBtn").show();
                    $("#insertBtn").hide();
                    let deleteUrl = "{{Route("imageRemove")}}/" + image_id ;
                    $("#DelBtn").attr('href',deleteUrl);
                }

                $("#herf_modal_image").attr('src' ,src );
                $("#herf_modal_image").attr('data-project-id' ,project_id );

            });
            // for add url on action form
            $("#insertBtn").click(function () {
                let project_id = $("#herf_modal_image").attr('data-project-id');
                let image_id = $("#herf_modal_image").attr('data-image-id');
                let url = "{{Route("AddProjectPicture")}}/"+ project_id;
                $("#addImageForm").attr('action',url);

            });
        });
    </script>
@endsection
