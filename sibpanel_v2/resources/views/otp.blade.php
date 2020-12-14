
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> تایید شماره موبایل </title>

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = '../assets/FontAwesome/css/all.min.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap-rtl.css" rel="stylesheet">
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        input[type=number] {
           width: 50px;
            display: inline-block;
            margin-right: 5px !important;
        }
        input[type=number]:focus {
            margin-right: 5px;
        }
    </style>
</head>

<body class="off-canvas-sidebar">

  <div class="wrapper wrapper-full-page">
    <div class="page-header lock-page header-filter" style="background-image: url('../../assets/img/lock.jpg')">
      <!--   you can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
      <div class="container">
          <div id="loader" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
              <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
          </div>
        <div class="row">
          <div class="col-md-5 ml-auto mr-auto">
            <div style="width: 360px" class="card card-profile text-center card-hidden">
              <div class="card-header ">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../../assets/img/faces/card-profile1-square.jpg">
                  </a>
                </div>
              </div>
              <div class="card-body text-right   ">
                <h4 class="card-title text-center font-weight-normal"> {{  session('UserInfo')['first_name']  . " "  . session('UserInfo')['last_name'] }} </h4>
                <p class="card-title font-weight-normal">
                    رمز یک بار مصرف به شماره {{  session('UserInfo')['mobile'] }}  به صورت پیامک ارسال گردید.
                </p>

                <div class="form-group d-flex justify-content-center" dir="ltr">
{{--                  <label for="exampleInput1" class="mb-2">Enter Password</label>--}}
                  <input id="first" type="number" class="form-control text-center">
                  <input type="number" class="form-control text-center" >
                  <input type="number" class="form-control text-center">
                  <input type="number" class="form-control text-center">
                  <input type="number" class="form-control text-center">
                  <input type="number" class="form-control text-center">
                </div>
                  <p class="text-dark" >
                      تا
                      <span id="timer">01:00</span>
                      دیگر امکان ارسال مجدد رمز یکبار مصرف به شماره شما امکان پذیر خواهید بود.</p>
              </div>
              <div class="card-footer justify-content-center">
                <button id="accept" href="#pablo" class="btn btn-rose btn-round">تایید شماره موبایل</button>
                <button id="resend" style="display: none;" href="#pablo" class="btn btn-info btn-round"> ارسال مجدد </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
         {{-- <nav class="float-left">
            <ul>
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
            </ul>
          </nav>--}}
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
  <!-- Chartist JS -->
  <script src="../../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>

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
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    }
    );
    let time = 300 ;
    // console.log("time =>" , time)

    $("#timer").css("font-weight" , "bold");
    setInterval(function () {
        let date =  new Date(time * 1000).toISOString().substr(14, 5) ;
        // console.log(date)
        if(time >= 0){
                let current_time =  date;
                if(time <= 5 ){
                    $("#timer").css("color" , "red");
                }
                $("#timer").text(current_time);
                time--;

                if(time < 0){
                    $('#accept').css("display" , "none");
                    $('#resend').show();
                }
        }
        } , 1000)
    $('#resend').click(function () {
        time = 300;
        $("#timer").css("color" , "");
        $('#accept').show();
        $('#resend').hide();
        $("#loader").css("display" , "flex") ;
        $.ajax({
            type:'POST',
            url:"{{Route('VerifyOtpNew')}}",
            dataType:'json',
            data:{
                '_token ': '<?php echo csrf_token() ?>',
            },
            success:function(data) {
                $("#loader").hide();
                if(data.Header.Status != 0){
                    Swal.fire(
                        'خظا در ارسال کد !  ',
                        ' دوباره سعی کنید ',
                        'error'
                    )
                }
                else{
                    $("#loader").hide();
                    Swal.fire(
                        'کد جدید برای شما فرستاده شد .   ',
                        '',
                        'success'
                    )
                }

            }
        });
    });
    let old_value ;
/*    $("input[type=number]").on('focusin', function(){
        let len = $(this).val().length;
        if(len <= 1)
            old = $(this).val();
    });*/
    let all_input_value = "" ;
    $("#first").focus();
    $("input[type=number]").on("input" , function () {
        let len = $(this).val().length;
        if(len <= 1)
        {
            let val = $(this).val();
            // $(this).val("") ;
            old_value = val ;
            $(this).val(val) ;

           if($("input[type=number]").filter(function () {
               return $.trim($(this).val()).length == 0
           }).length == 0)
           {
               all_input_value = "" ;
               $("input").each(function() {
                   var element = $(this).val();
                   all_input_value += element ;
               });
               if(all_input_value.length == 6) {
                   $("#loader").css("display" , "flex") ;
                   validation(all_input_value) ;
               }

           }
            else
                $(this).next().focus();
        }
        else{
            $(this).val(old_value)
        }
    })

    function validation(number){
        $("#loader").css("display" , "flex") ;
        $.ajax({
            type:'POST',
            url:"{{Route('VerifyOtp')}}",
            dataType:'json',
            data:{
                '_token ': '<?php echo csrf_token() ?>',
                'number' : number ,
            },
            success:function(data) {
                $("#loader").hide();
                console.log(data);
                if(data.Header.Status != 0){
                    Swal.fire(
                        'عدد وارد شده نامعتبر است ! ',
                        '',
                        'error'
                    )
                }
                else{
                    Swal.fire(
                        'تایید با موفقیت انجام شد .  ',
                        '',
                        'success'
                    )
                    window.location.href = "{{Route('loading')}}";
                }

            }
        });
    }
      $("#accept").click(function () {
          // console.log(all_input_value);
        if(all_input_value.length == 6)
        {
            validation(all_input_value) ;
        }
      });

  </script>
</body>

</html>
