<!--
=========================================================
Material Dashboard PRO - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard-pro
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <title> ورود به حساب کاربری </title>

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = '../assets/FontAwesome/css/all.min.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
</head>


<body class="off-canvas-sidebar">
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('../../assets/img/login.jpg'); background-size: cover; background-position: top center;">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        @if(session('error'))
            <div style="position: absolute ; top: 15px;right: 15px; z-index: 100;" class="row">
                <div class="col-md-12">
                    <div style="padding-top: 15px" class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div style="direction: ltr" class="col-md-5 ml-auto mr-auto">
{{--                    <div class="spinner-border mx-auto d-block mb-3" style="width: 25px;height: 25px;"></div>--}}
                    <div >
                        <img class="mx-auto d-block" style="width: 100px" src="{{asset("")}}assets/img/loading.gif" alt="">
                    </div>
                    <div class="progress rounded" style="height: 7px;">
                        <div id="pro" class="progress-bar rounded progress-bar-danger progress-bar-animated progress-bar-striped" role="progressbar"  {{--@if(Cache::has('LocationList')) style="width: 100%;" @else style="width: 37%;" @endif--}} aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h6 dir="rtl" class="text-right" id="LoadingText"> در حال دریافت اطلاعات (<span id="current">0</span>/{{$num}})... </h6>
                    <p>
                        {{--{{json_encode(\Illuminate\Support\Facades\Cache::get('LocationList'))}}--}}
                    </p>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <nav class="float-left">
                    {{--<ul>
                        <li>
                            <a href="https://www.creative-tim.com/">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="https://www.creative-tim.com/presentation">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="https://www.creative-tim.com/blog">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="https://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>--}}
                </nav>
                <div class="copyright">
                    &copy;
                     تمامی حقوق برای شرکت آتی شهر هوشمند ایرانیان محفوظ است.
                    <br>
                    <small>
                   نسخه  :  {{ config('app.APP_VER') }}
                    </small>
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="../../assets/js/core/jquery.min.js"></script>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap-material-design.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="{{asset('')}}assets/js/plugins/sweetalert2.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="../../assets/demo/demo.js"></script>
<script>
    $(document).ready(function() {
        $().ready(function() {
            $sidebar = $('.sidebar');

            $sidebar_img_container = $sidebar.find('.sidebar-background');

            $full_page = $('.full-page');

            $sidebar_responsive = $('body > .navbar-collapse');

            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                    $('.fixed-plugin .dropdown').addClass('open');
                }

            }

            $('.fixed-plugin a').click(function(event) {
                // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                if ($(this).hasClass('switch-trigger')) {
                    if (event.stopPropagation) {
                        event.stopPropagation();
                    } else if (window.event) {
                        window.event.cancelBubble = true;
                    }
                }
            });

            $('.fixed-plugin .active-color span').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-color', new_color);
                }

                if ($full_page.length != 0) {
                    $full_page.attr('filter-color', new_color);
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.attr('data-color', new_color);
                }
            });

            $('.fixed-plugin .background-color .badge').click(function() {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');

                var new_color = $(this).data('background-color');

                if ($sidebar.length != 0) {
                    $sidebar.attr('data-background-color', new_color);
                }
            });

            $('.fixed-plugin .img-holder').click(function() {
                $full_page_background = $('.full-page-background');

                $(this).parent('li').siblings().removeClass('active');
                $(this).parent('li').addClass('active');


                var new_image = $(this).find("img").attr('src');

                if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    $sidebar_img_container.fadeOut('fast', function() {
                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $sidebar_img_container.fadeIn('fast');
                    });
                }

                if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $full_page_background.fadeOut('fast', function() {
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                        $full_page_background.fadeIn('fast');
                    });
                }

                if ($('.switch-sidebar-image input:checked').length == 0) {
                    var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                    var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                }

                if ($sidebar_responsive.length != 0) {
                    $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                }
            });

            $('.switch-sidebar-image input').change(function() {
                $full_page_background = $('.full-page-background');

                $input = $(this);

                if ($input.is(':checked')) {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar_img_container.fadeIn('fast');
                        $sidebar.attr('data-image', '#');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page_background.fadeIn('fast');
                        $full_page.attr('data-image', '#');
                    }

                    background_image = true;
                } else {
                    if ($sidebar_img_container.length != 0) {
                        $sidebar.removeAttr('data-image');
                        $sidebar_img_container.fadeOut('fast');
                    }

                    if ($full_page_background.length != 0) {
                        $full_page.removeAttr('data-image', '#');
                        $full_page_background.fadeOut('fast');
                    }

                    background_image = false;
                }
            });

            $('.switch-sidebar-mini input').change(function() {
                $body = $('body');

                $input = $(this);

                if (md.misc.sidebar_mini_active == true) {
                    $('body').removeClass('sidebar-mini');
                    md.misc.sidebar_mini_active = false;

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                } else {

                    $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                    setTimeout(function() {
                        $('body').addClass('sidebar-mini');

                        md.misc.sidebar_mini_active = true;
                    }, 300);
                }

                // we simulate the window Resize so the charts will get updated in realtime.
                var simulateWindowResize = setInterval(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 180);

                // we stop the simulation of Window Resize after the animations are completed
                setTimeout(function() {
                    clearInterval(simulateWindowResize);
                }, 1000);

            });
        });
    });
</script>
<script>

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var currentNumber = 1 ;
        var num = "{{$num}}";
        var percentComplete = 0 ;
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        percentComplete += evt.loaded / evt.total;
                        // console.log(percentComplete);
                        $('#pro').css({
                            width: (percentComplete * 100)/num + '%'
                        });
                        /*if (percentComplete === 1) {
                            $('#pro').addClass('hide');
                        }*/
                    }
                }, false);
                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        percentComplete += evt.loaded / evt.total;
                        // console.log(percentComplete);
                        $('#pro').css({
                            width: (percentComplete * 100)/num + '%'
                        });
                    }
                }, false);
                return xhr;
            },
            type:'POST',
            url:"{{Route('locationCache')}}",
            dataType:'json',
            data:{
                '_token ': '<?php echo csrf_token() ?>',
                'currentNumber' : currentNumber ,
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
                if(data.status == 0 ){
                    currentNumber++;
                    $('#current').text(currentNumber);
                    $.ajax({
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                     percentComplete += evt.loaded / evt.total;
                                    // console.log(percentComplete);
                                    $('#pro').css({
                                        width: (percentComplete * 100)/num + '%'
                                    });
                                    /*if (percentComplete === 1) {
                                        $('#pro').addClass('hide');
                                    }*/
                                }
                            }, false);
                            xhr.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    percentComplete += evt.loaded / evt.total;
                                    // console.log(percentComplete);
                                    $('#pro').css({
                                        width: (percentComplete * 100)/num + '%'
                                    });
                                }
                            }, false);
                            return xhr;
                        },
                        type:'POST',
                        url:"{{Route('ServiceList')}}",
                        dataType:'json',
                        data:{
                            '_token ': '<?php echo csrf_token() ?>',
                            'currentNumber' : currentNumber ,
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
                        success:function(data2) {
                            /*$("#msg").html(data.table_data);
                            $("#msg2").html(data.table_data);
                            $("#numR").html(data.total_data);
                            $("#numR2").html(data.total_data);*/
                            if(data2.status == 0 ){
                                currentNumber++;
                                $('#current').text(currentNumber);
                                    $.ajax({
                                        xhr: function () {
                                            var xhr = new window.XMLHttpRequest();
                                            xhr.upload.addEventListener("progress", function (evt) {
                                                if (evt.lengthComputable) {
                                                    percentComplete += evt.loaded / evt.total;
                                                    // console.log(percentComplete);
                                                    $('#pro').css({
                                                        width: (percentComplete * 100)/num + '%'
                                                    });
                                                    /*if (percentComplete === 1) {
                                                        $('#pro').addClass('hide');
                                                    }*/
                                                }
                                            }, false);
                                            xhr.addEventListener("progress", function (evt) {
                                                if (evt.lengthComputable) {
                                                    percentComplete += evt.loaded / evt.total;
                                                    // console.log(percentComplete);
                                                    $('#pro').css({
                                                        width: (percentComplete * 100)/num + '%'
                                                    });
                                                }
                                            }, false);
                                            return xhr;
                                        },
                                        type:'POST',
                                        url:"{{Route('ProvinceList')}}",
                                        dataType:'json',
                                        data:{
                                            '_token ': '<?php echo csrf_token() ?>',
                                            'currentNumber' : currentNumber ,
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
                                        success:function(data3) {
                                            /*$("#msg").html(data.table_data);
                                            $("#msg2").html(data.table_data);
                                            $("#numR").html(data.total_data);
                                            $("#numR2").html(data.total_data);*/
                                            if(data3.status == 0 ){
                                                currentNumber++;
                                                $('#current').text(currentNumber);
                                                $.ajax({
                                                    xhr: function () {
                                                        var xhr = new window.XMLHttpRequest();
                                                        xhr.upload.addEventListener("progress", function (evt) {
                                                            if (evt.lengthComputable) {
                                                                percentComplete += evt.loaded / evt.total;
                                                                // console.log(percentComplete);
                                                                $('#pro').css({
                                                                    width: (percentComplete * 100)/num + '%'
                                                                });
                                                                /*if (percentComplete === 1) {
                                                                    $('#pro').addClass('hide');
                                                                }*/
                                                            }
                                                        }, false);
                                                        xhr.addEventListener("progress", function (evt) {
                                                            if (evt.lengthComputable) {
                                                                percentComplete += evt.loaded / evt.total;
                                                                // console.log(percentComplete);
                                                                $('#pro').css({
                                                                    width: (percentComplete * 100)/num + '%'
                                                                });
                                                            }
                                                        }, false);
                                                        return xhr;
                                                    },
                                                    type:'POST',
                                                    url:"{{Route('SellerUserListCashe')}}",
                                                    dataType:'json',
                                                    data:{
                                                        '_token ': '<?php echo csrf_token() ?>',
                                                        'currentNumber' : currentNumber ,
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
                                                    success:function(data4) {

                                                        if(data4.status == 0 ){
                                                            currentNumber++;
                                                            $('#current').text(currentNumber);
                                                            $.ajax({
                                                                xhr: function () {
                                                                    var xhr = new window.XMLHttpRequest();
                                                                    xhr.upload.addEventListener("progress", function (evt) {
                                                                        if (evt.lengthComputable) {
                                                                            percentComplete += evt.loaded / evt.total;
                                                                            // console.log(percentComplete);
                                                                            $('#pro').css({
                                                                                width: (percentComplete * 100)/num + '%'
                                                                            });
                                                                            /*if (percentComplete === 1) {
                                                                                $('#pro').addClass('hide');
                                                                            }*/
                                                                        }
                                                                    }, false);
                                                                    xhr.addEventListener("progress", function (evt) {
                                                                        if (evt.lengthComputable) {
                                                                            percentComplete += evt.loaded / evt.total;
                                                                            // console.log(percentComplete);
                                                                            $('#pro').css({
                                                                                width: (percentComplete * 100)/num + '%'
                                                                            });
                                                                        }
                                                                    }, false);
                                                                    return xhr;
                                                                },
                                                                type:'POST',
                                                                url:"{{Route('SaleTypeListCashe')}}",
                                                                dataType:'json',
                                                                data:{
                                                                    '_token ': '<?php echo csrf_token() ?>',
                                                                    'currentNumber' : currentNumber ,
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
                                                                success:function(data5) {

                                                                    if(data5.status == 0 ){
                                                                        currentNumber++;
                                                                        $('#current').text(currentNumber);
                                                                        $.ajax({
                                                                            xhr: function () {
                                                                                var xhr = new window.XMLHttpRequest();
                                                                                xhr.upload.addEventListener("progress", function (evt) {
                                                                                    if (evt.lengthComputable) {
                                                                                        percentComplete += evt.loaded / evt.total;
                                                                                        // console.log(percentComplete);
                                                                                        $('#pro').css({
                                                                                            width: (percentComplete * 100)/num + '%'
                                                                                        });
                                                                                        /*if (percentComplete === 1) {
                                                                                            $('#pro').addClass('hide');
                                                                                        }*/
                                                                                    }
                                                                                }, false);
                                                                                xhr.addEventListener("progress", function (evt) {
                                                                                    if (evt.lengthComputable) {
                                                                                        percentComplete += evt.loaded / evt.total;
                                                                                        // console.log(percentComplete);
                                                                                        $('#pro').css({
                                                                                            width: (percentComplete * 100)/num + '%'
                                                                                        });
                                                                                    }
                                                                                }, false);
                                                                                return xhr;
                                                                            },
                                                                            type:'POST',
                                                                            url:"{{Route('VoucherTypeListCashe')}}",
                                                                            dataType:'json',
                                                                            data:{
                                                                                '_token ': '<?php echo csrf_token() ?>',
                                                                                'currentNumber' : currentNumber ,
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
                                                                            success:function(data6) {

                                                                                if(data6.status == 0 ){
                                                                                    currentNumber++;
                                                                                    $('#current').text(currentNumber);
                                                                                    $.ajax({
                                                                                        xhr: function () {
                                                                                            var xhr = new window.XMLHttpRequest();
                                                                                            xhr.upload.addEventListener("progress", function (evt) {
                                                                                                if (evt.lengthComputable) {
                                                                                                    percentComplete += evt.loaded / evt.total;
                                                                                                    // console.log(percentComplete);
                                                                                                    $('#pro').css({
                                                                                                        width: (percentComplete * 100)/num + '%'
                                                                                                    });
                                                                                                    /*if (percentComplete === 1) {
                                                                                                        $('#pro').addClass('hide');
                                                                                                    }*/
                                                                                                }
                                                                                            }, false);
                                                                                            xhr.addEventListener("progress", function (evt) {
                                                                                                if (evt.lengthComputable) {
                                                                                                    percentComplete += evt.loaded / evt.total;
                                                                                                    // console.log(percentComplete);
                                                                                                    $('#pro').css({
                                                                                                        width: (percentComplete * 100)/num + '%'
                                                                                                    });
                                                                                                }
                                                                                            }, false);
                                                                                            return xhr;
                                                                                        },
                                                                                        type:'POST',
                                                                                        url:"{{Route('GetInfoCashe')}}",
                                                                                        dataType:'json',
                                                                                        data:{
                                                                                            '_token ': '<?php echo csrf_token() ?>',
                                                                                            'currentNumber' : currentNumber ,
                                                                                        }, statusCode: {
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
                                                                                        success:function(data7) {

                                                                                            if(data7.status == 0 ){
                                                                                                currentNumber++;
                                                                                                $('#current').text(currentNumber);
                                                                                                $.ajax({
                                                                                                    xhr: function () {
                                                                                                        var xhr = new window.XMLHttpRequest();
                                                                                                        xhr.upload.addEventListener("progress", function (evt) {
                                                                                                            if (evt.lengthComputable) {
                                                                                                                percentComplete += evt.loaded / evt.total;
                                                                                                                // console.log(percentComplete);
                                                                                                                $('#pro').css({
                                                                                                                    width: (percentComplete * 100)/num + '%'
                                                                                                                });
                                                                                                                /*if (percentComplete === 1) {
                                                                                                                    $('#pro').addClass('hide');
                                                                                                                }*/
                                                                                                            }
                                                                                                        }, false);
                                                                                                        xhr.addEventListener("progress", function (evt) {
                                                                                                            if (evt.lengthComputable) {
                                                                                                                percentComplete += evt.loaded / evt.total;
                                                                                                                // console.log(percentComplete);
                                                                                                                $('#pro').css({
                                                                                                                    width: (percentComplete * 100)/num + '%'
                                                                                                                });
                                                                                                            }
                                                                                                        }, false);
                                                                                                        return xhr;
                                                                                                    },
                                                                                                    type:'POST',
                                                                                                    url:"{{Route('GetVoucherTextCashe')}}",
                                                                                                    dataType:'json',
                                                                                                    data:{
                                                                                                        '_token ': '<?php echo csrf_token() ?>',
                                                                                                        'currentNumber' : currentNumber ,
                                                                                                    }, statusCode: {
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
                                                                                                    success:function(data8) {
                                                                                                        if(data8.status == 0 ){
                                                                                                            currentNumber++;
                                                                                                            $('#current').text(currentNumber);
                                                                                                            $.ajax({
                                                                                                                xhr: function () {
                                                                                                                    var xhr = new window.XMLHttpRequest();
                                                                                                                    xhr.upload.addEventListener("progress", function (evt) {
                                                                                                                        if (evt.lengthComputable) {
                                                                                                                            percentComplete += evt.loaded / evt.total;
                                                                                                                            // console.log(percentComplete);
                                                                                                                            $('#pro').css({
                                                                                                                                width: (percentComplete * 100)/num + '%'
                                                                                                                            });
                                                                                                                            /*if (percentComplete === 1) {
                                                                                                                                $('#pro').addClass('hide');
                                                                                                                            }*/
                                                                                                                        }
                                                                                                                    }, false);
                                                                                                                    xhr.addEventListener("progress", function (evt) {
                                                                                                                        if (evt.lengthComputable) {
                                                                                                                            percentComplete += evt.loaded / evt.total;
                                                                                                                            // console.log(percentComplete);
                                                                                                                            $('#pro').css({
                                                                                                                                width: (percentComplete * 100)/num + '%'
                                                                                                                            });
                                                                                                                        }
                                                                                                                    }, false);
                                                                                                                    return xhr;
                                                                                                                },
                                                                                                                type:'POST',
                                                                                                                url:"{{Route('ProjectListCashe')}}",
                                                                                                                dataType:'json',
                                                                                                                data:{
                                                                                                                    '_token ': '<?php echo csrf_token() ?>',
                                                                                                                    'currentNumber' : currentNumber ,
                                                                                                                }, statusCode: {
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
                                                                                                                success:function(data9) {

                                                                                                                    if(data9.status == 0 ){
                                                                                                                        currentNumber++;
                                                                                                                        $('#current').text(currentNumber);
                                                                                                                        $('#LoadingText').text(' در حال ورود ');
                                                                                                                        let url = "{{session()->get('previous_url')}}";
                                                                                                                        // console.log(url);
                                                                                                                        if(url == "")
                                                                                                                            url = "{{Route('dashboard')}}";
                                                                                                                        setTimeout(function(){
                                                                                                                            window.location.href = url ;
                                                                                                                        }, 600);
                                                                                                                    }
                                                                                                                }
                                                                                                            });
                                                                                                        }

                                                                                                    }
                                                                                                });
                                                                                            }

                                                                                        }
                                                                                    });
                                                                                }

                                                                            }
                                                                        });
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                            }
                        }
                    });
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        md.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    });
</script>
</body>

</html>
