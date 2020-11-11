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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-success">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">location_on</i>
                                </div>
                                <h4 class="card-title text-right">
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <h2>۲۲۹</h2>
                                <h4>نقطه فعال</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-success">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">credit_card</i>
                                </div>
                                <h4 class="card-title text-right">
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <h2>+۱۷ میلیون</h2>
                                <h4>عدد بلیت کارتی</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-success">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">money</i>
                                </div>
                                <h4 class="card-title text-right">
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <h2>+۱.۸ میلیون</h2>
                                <h4>عدد بلیت نقدی</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-success">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">language</i>
                                </div>
                                <h4 class="card-title text-right">
                                </h4>
                            </div>
                            <div class="card-body text-center">
                                <h2>+۵۰ هزار</h2>
                                <h4>عدد بلیت اینترنتی</h4>
                            </div>
                        </div>
                    </div>


                </div>
{{--                <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                        <div class="card ">--}}
{{--                            <div class="card-header card-header-success card-header-icon">--}}
{{--                                <div class="card-icon float-right">--}}
{{--                                    <i class="material-icons"></i>--}}
{{--                                </div>--}}
{{--                                <h4 class="card-title">Global Sales by Top Locations</h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body ">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="table-responsive table-sales">--}}
{{--                                            <table class="table">--}}
{{--                                                <tbody>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/US.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>USA</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        2.920--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        53.23%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/DE.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>Germany</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        1.300--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        20.43%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/AU.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>Australia</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        760--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        10.35%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/GB.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>United Kingdom</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        690--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        7.87%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/RO.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>Romania</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        600--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        5.94%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                <tr>--}}
{{--                                                    <td>--}}
{{--                                                        <div class="flag">--}}
{{--                                                            <img src="../assets/img/flags/BR.png">--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td>Brasil</td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        550--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-right">--}}
{{--                                                        4.34%--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-6 ml-auto mr-auto">--}}
{{--                                        <div id="worldMap" style="height: 300px;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-info">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش مقایسه تعداد انواع بلیط ها
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="voucher_type_voucher_count" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-info">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش مقایسه مبلغ انواع بلیط ها
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChartPie" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>

{{--                    <div class="col-md-6">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header card-header-icon card-header-info">--}}
{{--                                <div class="card-icon float-right ml-2">--}}
{{--                                    <i class="material-icons">pie_chart</i>--}}
{{--                                </div>--}}
{{--                                <h4 class="card-title text-right">گزارش مقایسه ای ۱۴ روز اخیر--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <canvas id="days_report_amount" width="350" height="400"></canvas>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header card-header-icon card-header-info">--}}
{{--                                <div class="card-icon float-right ml-2">--}}
{{--                                    <i class="material-icons">pie_chart</i>--}}
{{--                                </div>--}}
{{--                                <h4 class="card-title text-right">گزارش مقایسه تعداد فروش ۱۴ روز اخیر--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <canvas id="days_report_voucher_count" width="350" height="400"></canvas>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                    <div class="col-md-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header card-header-icon card-header-rose">--}}
{{--                                <div class="card-icon float-right">--}}
{{--                                    <i class="material-icons">insert_chart</i>--}}
{{--                                </div>--}}
{{--                                <h4 class="card-title">Multiple Bars Chart--}}
{{--                                    <small>- Bar Chart</small>--}}
{{--                                </h4>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="ct-chart ct-golden-section" id="chart1"></div>--}}
{{--                                <canvas id="myChart" width="350" height="400"></canvas>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-info">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش مقایسه تعداد انواع بلیط ها به تفکیک استان
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="province_based_report_province_voucher_count" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-info">
                                <div class="card-icon float-right ml-2">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش مقایسه مبلغ انواع بلیط ها به تفکیک استان
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="province_based_report_amount" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon float-right ml-3">
                                    <i class="material-icons">insert_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش فروش استان ها
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="province_chart" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon float-right ml-3">
                                    <i class="material-icons">insert_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش مبلغ فروش مکان های گردشگری
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="location_amount" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon float-right ml-3">
                                    <i class="material-icons">insert_chart</i>
                                </div>
                                <h4 class="card-title text-right">گزارش تعداد فروش مکان های گردشگری
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="location_amount_voucher_count" width="350" height="400"></canvas>
                            </div>
                        </div>
                    </div>
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
    @php
        $api = new \App\Api\Api();
        $stats = $api->statsChart();
        $stats_24hours_reports = $stats["24hours_report"]["result"] ;

        $stats_14days_reports = $stats["14days_report"]["result"] ;
        $days_report_data = [] ;
        $days_report_amount = [] ;
        $days_report_voucher_count = [] ;
        foreach ($stats_14days_reports as $stats_14days_report){
            array_push($days_report_data,$stats_14days_report["date"]);
            array_push($days_report_amount,intval($stats_14days_report["amount"]));
            array_push($days_report_voucher_count,intval($stats_14days_report["voucher_count"]));
        }


        $voucher_type_report = $stats["voucher_type_report"]["result"] ;
        $voucher_type_name = [] ;
        $voucher_type_amount = [] ;
        $voucher_type_voucher_count = [] ;
        foreach ($voucher_type_report as $voucher_type_report){
            array_push($voucher_type_name,$voucher_type_report["voucher_type_name"]);
            array_push($voucher_type_amount,intval($voucher_type_report["amount"]));
            array_push($voucher_type_voucher_count,intval($voucher_type_report["voucher_count"]));
        }

        $location_based_reports = $stats["location_based_report"]["result"] ;
        $location_based_name = [] ;
        $location_based_amount = [] ;
        $location_based_voucher_count = [] ;
        foreach ($location_based_reports as $location_based_report){
            array_push($location_based_name,$location_based_report["location_name"]);
            array_push($location_based_amount,intval($location_based_report["amount"]));
            array_push($location_based_voucher_count,intval($location_based_report["voucher_count"]));
        }

        $province_based_reports = $stats["province_based_report"]["result"] ;
        $province_name = [] ;
        $province_amount = [] ;
        $province_voucher_count = [] ;
        foreach ($province_based_reports as $province_based_report){
            array_push($province_name,$province_based_report["province_name"]);
            array_push($province_amount,intval($province_based_report["amount"]));
            array_push($province_voucher_count,intval($province_based_report["voucher_count"]));
        }

        $voucher_count = [];
        $amount = [];
        foreach ($stats_24hours_reports as $stats_24hours_report){
            array_push($voucher_count,$stats_24hours_report["voucher_count"]);
            array_push($amount,$stats_24hours_report["amount"]);
        }

    @endphp
    <script>
        let stats2 = @json($stats);
        let stats = @json($voucher_count);
        let amount = @json($amount);
        // console.log("stats : " , stats2);
        // console.log("stats : " , stats);
        // console.log("amount : " , amount);
        let voucher_type_name = @json($voucher_type_name);
        let voucher_type_amount = @json($voucher_type_amount);
        let voucher_type_voucher_count = @json($voucher_type_voucher_count);

        let province_name = @json($province_name);
        let province_amount = @json($province_amount);
        let province_voucher_count = @json($province_voucher_count);

        let location_based_name = @json($location_based_name);
        let location_based_amount = @json($location_based_amount);
        let location_based_voucher_count = @json($location_based_voucher_count);

        let days_report_data = @json($days_report_data);
        let days_report_amount = @json($days_report_amount);
        let days_report_voucher_count = @json($days_report_voucher_count);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
{{--    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script>

    {{-- voucher chart   --}}
    <script>
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };
        var inputs = {
            min: -100,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: stats,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [
                    {
                    label: false,
                    maxBarThickness : 80 ,
                    data: amount,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                } ,
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                scales: {
                    xAxes: [{
                        display: true,
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>



    <script>
        let ctx12 = document.getElementById('myChartPie').getContext('2d');
        var myChart = new Chart(ctx12, {
            type: 'pie',
            data: {
                labels: voucher_type_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    data: voucher_type_amount,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                     'rgb(255, 205, 86)',
                     'rgb(75, 192, 192)',
                     'rgb(54, 162, 235)',
                     'rgb(153, 102, 255)',
                     'rgb(231,233,237)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                layout : {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 100,
                        bottom: 90
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                    outlabels: {
                        text: '%l  %p \n %v' ,
                        color: '#000',
                        font: {
                            resizable: true,
                            minSize: 12,
                            maxSize: 18
                        },
                    }
                } ,
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                labels : [voucher_type_name] ,
            }
        });
        document.getElementById('myChartPie').append(voucher_type_name);
    </script>
    <script>
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };
        var inputs = {
            min: -100,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        let colors = [] ;
        ctx2 = document.getElementById('voucher_type_voucher_count').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: voucher_type_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: voucher_type_voucher_count,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 100,
                        bottom: 90
                    }
                } ,
                plugins: {
                    datalabels: {
                        display: false,
                    },
                    outlabels: {
                        text: '%l  %p \n %v' ,
                        color: '#000',
                        font: {
                            resizable: true,
                            minSize: 12,
                            maxSize: 18
                        },
                    }
                } ,
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                labels : [voucher_type_name] ,
            }
        });
    </script>

    {{--  days report    --}}
    <script>
        ctx2 = document.getElementById('days_report_amount').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: days_report_data,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: days_report_voucher_count,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                labels : [voucher_type_name] ,
            }
        });
    </script>
    <script>
        ctx2 = document.getElementById('days_report_voucher_count').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: days_report_data,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: days_report_voucher_count,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                labels : [voucher_type_name] ,
            }
        });
    </script>




    {{--  province Chart  --}}
    <script>
        let ctx4 = document.getElementById('province_based_report_province_voucher_count').getContext('2d');
        let color = [];
        var myChart = new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: province_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: province_voucher_count,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)' ,
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)' ,
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                layout : {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 100,
                        bottom: 90
                    },
                },


                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                    outlabels: {
                        text: '%l  %p \n %v' ,
                        color: '#000',
                        font: {
                            resizable: true,
                            minSize: 12,
                            maxSize: 18
                        },
                    }
                } ,
                labels : [voucher_type_name] ,
            }
        });

    </script>
    <script>
        let ctx5 = document.getElementById('province_based_report_amount').getContext('2d');
        var myChart = new Chart(ctx5, {
            type: 'pie',
            data: {
                labels: province_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: province_amount,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)' ,
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(231,233,237)' ,
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                layout : {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 100,
                        bottom: 90
                    },
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                    outlabels: {
                        text: '%l  %p \n %v' ,
                        color: '#000',
                        font: {
                            resizable: true,
                            minSize: 12,
                            maxSize: 18
                        },
                    }
                } ,
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
            }
        });
    </script>
    <script>
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)' ,

        };
        var inputs = {
            min: -100,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        var ctx = document.getElementById('province_chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: province_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: province_amount,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgb(255, 159, 64)' ,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                    labels: {
                        display : false ,
                    }
                } ,
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                scales: {
                    xAxes: [{
                        display: true,
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>

    {{--  Location Chart  --}}
    <script>

        var ctx1 = document.getElementById('location_amount').getContext('2d');
        var myChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: location_based_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: location_based_amount,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor:  'rgb(54, 162, 235)',
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                } ,
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                scales: {
                    xAxes: [{
                        display: true,
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
    <script>
        var ctx6 = document.getElementById('location_amount_voucher_count').getContext('2d');
        var myChart = new Chart(ctx6, {
            type: 'bar',
            data: {
                labels: location_based_name,
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: false,
                    maxBarThickness : 80 ,
                    data: location_based_voucher_count,

                    // data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    fill: false,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend:{
                    display:false ,
                    labels: {
                        defaultFontFamily : "iransans" ,
                        fontColor: 'black' ,
                    }
                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                } ,
                title: {
                    display: false,
                    text: ' نمودار ماهانه فروش'
                },
                scales: {
                    xAxes: [{
                        display: true,
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>

    {{-- Other js sources   --}}
    <script>
        $(document).ready(function () {

            $().ready(function () {
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

                $('.fixed-plugin a').click(function (event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function () {
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

                $('.fixed-plugin .background-color .badge').click(function () {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function () {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function () {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function () {
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

                $('.switch-sidebar-image input').change(function () {
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

                $('.switch-sidebar-mini input').change(function () {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function () {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function () {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

            md.initVectorMap();

        });
    </script>
@endsection
