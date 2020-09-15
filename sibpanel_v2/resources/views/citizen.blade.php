@extends('MainLayout')

@section('title')
    <title>
        پنل شهروندی
{{--        {{(empty($array_keys) == 0) ? $GetServices[$array_keys[0]]['location_name'] : ''}}--}}
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
        #herf_modal_image{
            display: block;
            margin: 0 auto;
        }
        .citzen_img_lib{
            padding: 8px;
            border-radius: 5px;
            border: solid 2px #FF9800;
            font-size: 29pt !important;
            color: #FF9800;
            cursor: pointer;
            transition: .3s all;
        }
        .citzen_img_lib:hover{
            border: solid 2px #de8400;
            color: #de8400;
        }
        .text_table{
            max-width: 30px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
        }

        .text_table:hover{
            color: #0d47a1;
            font-weight: bold;
        }

    </style>
@endsection

@section('content')
    <div class="content">
        <div id="loader" style="position: absolute;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">perm_contact_calendart</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> پنل شهروندی    {{(empty($array_keys) == 0) ? $GetServices[$array_keys[0]]['location_name'] : ''}} </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  افزودن  </span>
                                    <a href="{{Route("places")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                            تصویر اصلی
                                        </th>
                                        <th >
                                            گالری مکان
                                        </th>
                                        <th >
                                             توضیحات کوتاه
                                        </th>
                                        <th >
                                             توضیحات کامل
                                        </th>
                                        <th >
                                            طول و عرض جغرافیایی
                                        </th>
                                        <th >
                                            عکس رویداد اصلی
                                        </th>
                                        <th >
                                            عکس بلیت
                                        </th>
                                        <th >
                                           عکس رویدار بلیت
                                        </th>
                                        <th >
                                           لوکوی مکان
                                        </th>
                                        <th >
                                            ویرایش
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="citizen_tbody">
                                    <tr>
                                        <td >
                                            <img data-toggle="modal" data-target="#image_modal"class="citzen_main_img" src="{{asset("")}}assets/img/card-2.jpg" alt="">
                                        </td>
                                        <td>
                                           <span data-toggle="modal" data-target="#image_lib" class="material-icons citzen_img_lib"> photo_library </span>
                                        </td>
                                        <td class="text_table more" >
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                                        </td>
                                        <td class="text_table more" >
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیردلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
{{--                                            <a href="#" class="link more"> <span class="material-icons">launch</span> </a>--}}

                                        </td>
                                        <td >
                                            54.25186157 , 31.89563149
                                        </td>
                                        <td >
                                            <img data-toggle="modal" data-target="#image_modal"class="citzen_main_img" src="{{asset("")}}assets/img/card-1.jpg" alt="">
                                        </td>
                                        <td >
                                            <img data-toggle="modal" data-target="#image_modal"class="citzen_main_img" src="{{asset("")}}assets/img/bg3.jpg" alt="">
                                        </td>
                                        <td >
                                            <img data-toggle="modal" data-target="#image_modal"class="citzen_main_img" src="{{asset("")}}assets/img/bg9.jpg" alt="">
                                        </td>
                                        <td >
                                            <img data-toggle="modal" data-target="#image_modal"class="citzen_main_img" src="{{asset("")}}assets/img/default-avatar.png" alt="">
                                        </td>
                                        <td >
                                            <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
                                                <i class="material-icons">close</i>
                                                حدف
                                            </button>
                                        </td>
                                    </tr>
                                   {{-- @if(count($array_keys) == 0)
                                        <tr>
                                            <td colspan="8" >
                                                <h6 class="py-5">
                                                    جاذبه ای یافت نشد .
                                                </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @for($i = 0 ; $i < count($array_keys) ; $i++)
                                            <tr>
                                                <td>
                                                    @if($GetServices[$array_keys[$i]]['model_name'] == 'Entrance')
                                                        ورودی
                                                        @elseif($GetServices[$array_keys[$i]]['model_name'] == 'Event')
                                                        رویداد
                                                        @elseif($GetServices[$array_keys[$i]]['model_name'] == 'Service')
                                                        جاذبه
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $GetServices[$array_keys[$i]]['service_name'] }}
                                                </td>
                                                <td>
                                                    {{$GetServices[$array_keys[$i]]['english_name']}}
                                                </td>
                                                <td>
                                                    {{$GetServices[$array_keys[$i]]['description']}}
                                                </td>
                                                <td>
                                                    @if($GetServices[$array_keys[$i]]['capacity'] == "")
                                                        نامحدود
                                                    @else
                                                        {{$GetServices[$array_keys[$i]]['capacity']}}
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ Route('VoucherInfoList' , ['service_id' => $GetServices[$array_keys[$i]]['service_id'] , 'location_id' => $GetServices[$array_keys[$i]]['location_id'] ])}}" rel="tooltip" class="btn  btn-info btn-simple">
                                                        <i class="material-icons">location_city</i>
                                                        مدیریت بلیت ها
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="togglebutton text-center">
                                                        <label dir="ltr">
                                                            <input name="activation" data-service="{{$GetServices[$array_keys[$i]]['service_id']}}" type="checkbox" @if($GetServices[$array_keys[$i]]['activation']) checked @endif>
                                                            <span class="toggle"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" data-target="#edit1{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <div class="modal fade" id="edit1{{$i}}" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form method="post" action="{{Route('EditService' , [ 'service_id'=> $GetServices[$array_keys[$i]]['service_id'] ,'location_id'=> $GetServices[$array_keys[$i]]['location_id']   ])}}">
                                                                @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title " id=edit{{$i}}Label">  ویرایش جاذبه </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-row mt-3">
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  نام جاذبه </label>
                                                                            <input value="{{ $GetServices[$array_keys[$i]]['service_name'] }}" name="service_name" type="text" class="form-control" id="nameStateFa" placeholder="نام جاذبه">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  نام انگلیسی جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['english_name']}}" name="service_english_name" type="text" class="form-control" id="nameStateFa" placeholder="نام انگلیسی جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  ظرفیت جاذبه </label>
                                                                            <input value="{{$GetServices[$array_keys[$i]]['capacity']}}" name="capacity" type="text" class="form-control" id="nameStateEn" placeholder=" ظرفیت جاذبه (نامحدود = خالی) ">
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <label for="">  عکس جاذبه </label>
                                                                            <input type="file" class="form-control" id="nameStateEn" placeholder=" عکس جاذبه">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <label for=""> توضیحات </label>
                                                                            <textarea style="height: 64px !important;" class="form-control" name="description" id="" cols="30" rows="3"> {{$GetServices[$array_keys[$i]]['description']}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row mt-4">
                                                                        <div class="col-sm text-right">
                                                                            <select name="model_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع سرویس">
                                                                                <option disabled> نوع سرویس </option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Entrance') selected @endif value="1">ورودی مکان</option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Event') selected @endif value="3">رویداد</option>
                                                                                <option @if($GetServices[$array_keys[$i]]['model_name'] == 'Service') selected @endif value="2"> جاذبه مکان</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm text-right">
                                                                            <div class="togglebutton text-center">
                                                                                <label dir="ltr">
                                                                                    <input name="normal_sale" type="checkbox" @if($GetServices[$array_keys[$i]]['normal_sale']) checked @endif>
                                                                                    <span class="toggle"></span>
                                                                                    شامل سانس
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer mt-4">
                                                                    --}}{{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}{{--
                                                                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> ویرایش </button>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                    <form action="{{Route('DeleteService' , ['service_id' => $GetServices[$array_keys[$i]]['service_id']])}}" method="post">
                                                        @csrf
                                                        <button type="submit" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
                                                            <i class="material-icons">close</i>
                                                            حدف
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endfor
                                    @endif--}}

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  modal for add picture  --}}
    <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{--{{Route('AddService' , ['location_id' => $location_id])}}--}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">لوکوی مکان</label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> طول و عرض جغرافیایی</label>
                            <input name="service_english_name" type="text" class="form-control" id="nameStateFa" placeholder="طول و عرض جغرافیایی">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  عکس اصلی </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">  عکس رویداد اصلی </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for=""> توضیحات کوتاه </label>
                            <textarea name="description" style="height: 64px !important;" class="form-control" name="location_address" id="" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> توضیحات کامل </label>
                            <textarea name="description" style="height: 64px !important;" class="form-control" name="location_address" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  عکس بلیت </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> عکس رویدار بلیت </label>
                            <input type="file" class="form-control"  placeholder=" عکس جاذبه">
                        </div>
                    </div>
            {{--        <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <select name="model_id" class="selectpicker" data-style="btn btn-primary border-dark" title="نوع سرویس">
                                <option disabled selected> نوع سرویس </option>
                                <option value="1">ورودی مکان</option>
                                <option value="3">رویداد</option>
                                <option value="2"> جاذبه مکان</option>
                            </select>
                        </div>
                        <div class="col-sm text-right">
                            <div class="togglebutton text-center">
                                <label dir="ltr">
                                    <input name="normal_sale" type="checkbox">
                                    <span class="toggle"></span>
                                    شامل سانس
                                </label>
                            </div>
                        </div>
                    </div>--}}
                </div>
                <div class="modal-footer mt-4">
                     <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>
                    <button type="submit" class="btn px-5 btn-success ml-0"> افزودن </button>
                </div>
            </div>
        </form>

    </div>
</div>

    {{--  modal for singel images   --}}
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    &nbsp;
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid rounded" id="herf_modal_image" src="" alt="">
                </div>
            </div>
        </div>
    </div>

    {{-- modal for multi images    --}}
    <div class="modal fade" id="image_lib" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    &nbsp;
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{asset("")}}assets/img/login.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset("")}}assets/img/register.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset("")}}assets/img/lock.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
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
            $('input[name=activation]').change(function () {
                var service =$(this).attr('data-service') ;
                var value = ($(this).is(':checked'));
                $('#loader').css('display' , 'flex');
              $.ajax({
                    type:'POST',
                    url:"{{Route('ServiceActivation')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'service' : service ,
                        'value' : value ,
                    },
                    success:function(data) {
                        $('#loader').hide();
                       /* if(data.data)
                            alert('true');
                        else
                            alert('false')*/
                    }
                });
            });

            $(".citzen_main_img").click(function () {
                let src = $(this).attr("src") ;
                $("#herf_modal_image").attr('src' ,src );
            });

            $(".more").click(function () {
               let text = $(this).text();
                Swal.fire(
                    '',
                    text,
                    '' ,
                )
               console.log(text);
            });

        });
    </script>
@endsection
