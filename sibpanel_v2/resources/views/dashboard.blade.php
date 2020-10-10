@extends('MainLayout')

@section('title')
    <title>
       پنل گردشگری
    </title>
    <style>
        /* width */
       .sidebar-wrapper::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        .sidebar-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        /* Handle */
        .sidebar-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        /* Handle on hover */
        .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection

@section('content')
<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">location_city</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت استان ها و شهر ها</h5>
                            <a href="{{Route('stateMg')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">room</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت مکان ها</h5>
                            <a href="{{Route('places')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">insert_chart</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">گزارش تجمیعی</h5>
                            <a href="{{Route('Report')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">receipt_long</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">ریز تراکنش ها</h5>
                            <a href="{{Route('transaction')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">backspace</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">ابطال بلیت</h5>
                            <a data-toggle="modal" data-target="#deleteVoucher" class="btn btn-rose btn-round text-white"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">format_size</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت متن بلیت ها</h5>
                            <a href="{{Route('voucherText')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">confirmation_number</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت نوع بلیت</h5>
                            <a href="{{Route('voucherTypeList')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons"> watch_later </i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت سانس ها</h5>
                            <a href="{{Route('group_times')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons">supervised_user_circle</i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت کاربران</h5>
                            <a href="{{Route('UserManager')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 cards">
                    <div class="card card-pricing card-raised">
                        <div class="card-body">
                            <div class="card-icon icon-rose">
                                <i class="material-icons"> notifications_active </i>
                            </div>
                            <h5 class="card-title mt-2 font-weight-normal">مدیریت اعلان ها</h5>
                            <a href="{{Route('alerts')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                        </div>
                    </div>
                </div>
                @if(env("HAS_TERMINAL"))
                    <div class="col-lg-3 cards">
                        <div class="card card-pricing card-raised">
                            <div class="card-body">
                                <div class="card-icon icon-rose">
                                    <i class="material-icons">dvr</i>
                                </div>
                                <h5 class="card-title mt-2 font-weight-normal"> مدیریت ترمینال </h5>
                                <a href="{{Route('terminals')}}" class="btn btn-rose btn-round"> مشاهده سرویس </a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('AddJs')
    <!-- Forms Validations Plugin -->
    <script src="../assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="../assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="../assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="../assets/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="../assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>

    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
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
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

            md.initVectorMap();

        });
    </script>
@endsection
