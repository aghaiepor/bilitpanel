@extends('MainLayout')

@section('title')
    <title>
        اضافه کردن سانس
    </title>
    <style>
        .bootstrap-select{
            width: 100% !important;
        }
        #plotId{
            font-family: iransans !important;
            box-shadow: 0px 2px 6px -1px #ccc !important;
            border-radius: 5px;
            border: none;
        }
        .pwt-btn , .pwt-btn-today{
            background: #ececec !important;
            border-radius: 5px !important;
            margin-top: 5px !important;
        }
        #plotId .title{
            display: none;
        }
        #plotId .header{
            margin-bottom: 5px;
        }
        .datepicker-plot-area .datepicker-day-view .table-days td div:hover{
            background-color: #ececec !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/persian-datepicker_service_time.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/service_time.css') }}">


@endsection

@section('content')
<div class="content">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons"> watch_later </i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold ">  مدیریت سانس ها </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> سانس جدید </span>
                                    <a onclick="history.go(-1);" class="btn btn-dark mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-4 mx-auto text-right">
                                                <label for="group_name">نام گروه سانس</label>
                                                <input type="text" class="form-control" id="group_name" name="group_name"
                                                       placeholder="نام گروه سانس">
                                            </div>

                                            <input type="hidden" name="serviceId" value="">
                                            <input type="hidden" id="service_times" name="service_times" value="">
                                            <div class="col-md-offset-4 col-md-4 col-md-offset-4" style="margin-top:50px;">
                                                <img id='img-upload' style="max-width:100%;"/>
                                            </div>

                                            </div>
                                            @csrf
                                        </div>
                                    </form>
                                </div>
                            </div>
                        {{--   capecity and ...   --}}
                            <div class="row">
                                <div style="padding: 10px;overflow:hidden">
                                    <button class="btn btn-primary float-right btn-sm" onclick="selectAll()">انتخاب همه</button>
                                    <button class="btn btn-danger float-right mr-2 btn-sm" onclick="deselctAll()">لغو انتخاب ها</button>
                                </div>
                            </div>
                            <div class="row" id="div_seance" style="display: none">
                                <div class="col-lg-6 panel panel-default">
                                    <div class="panel-body" style="font-family: iransans !important;">
                                        <div class="form-group">
                                            <div id="inline2">
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="removeTime()" class="btn btn-sm btn-danger " style="margin-top: 10px">حذف انتخاب شده
                                    </button>
                                    <button onclick="setTime()" class="btn btn-sm btn-primary" style="margin-top: 10px">اعمال</button>
                                    <div class="col-md text-right" style="margin-top: 35px;margin-bottom: 10px">
                                        <button onclick="submit()" class="btn btn-success c-font-bold btn-lg">تایید نهایی و اعمال تغییرات</button>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="margin-top: 30px">
                                    <div class="col-md-5 mr-3 text-center pull-right"
                                         style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                        <div class="row justify-content-center">
                                            <span style="font-size: 16px">ساعت شروع</span>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 10px">
                                            <button onclick="changeMin('start_minute','add')" class="btn btn-primary btn-time"
                                                    style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                            <button onclick="changeHour('start_hour','add')" class="btn btn-primary btn-time"
                                                    style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                            <input id="start_minute" value="00" disabled>
                                            <span style="font-size: 20px">:</span>
                                            <input id="start_hour" value="8" disabled>
                                        </div>
                                        <div class="row justify-content-center time-select">
                                            <button onclick="changeMin('start_minute','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                            <button onclick="changeHour('start_hour','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>

                                        </div>

                                    </div>
                                    <div class="col-md-5 mr-3 text-center pull-right"
                                         style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                        <div class="row justify-content-center">
                                            <span style="font-size: 16px">ساعت پایان</span>
                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 10px">
                                            <button onclick="changeMin('end_minute','add')" class="btn btn-primary btn-time"
                                                    style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                            <button onclick="changeHour('end_hour','add')" class="btn btn-primary btn-time"
                                                    style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>

                                        </div>
                                        <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                            <input id="end_minute" value="00" disabled>
                                            <span style="font-size: 20px">:</span>
                                            <input id="end_hour" value="9" disabled>
                                        </div>
                                        <div class="row justify-content-center time-select">
                                            <button onclick="changeMin('end_minute','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                            <button onclick="changeHour('end_hour','minus')" class="btn btn-primary btn-time"
                                                    style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>

                                        </div>

                                    </div>
                                    <div class="col-lg-12  pull-right" style="margin-top: 20px">
                                        <div class="form-row text-right">
                                            <div class="col">
                                                <label for=""> ظرفیت </label>
                                                <input class="form-control" id="seance_capacity"
                                                       style="text-align: center;width: 100%;height: 40px;border: 2px solid #2d2d2d" placeholder="ظرفیت" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                            </div>
                                            <div class="col">
                                                <label for=""> جنسیت </label>
                                                <select name="seance_gender" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                    <option selected value="dont_care">  همه </option>
                                                    <option value="male" > مردانه </option>
                                                    <option value="female" > زنانه </option>
                                                    <option value="single_sex">  تک جنسیتی </option>
                                                </select>
                                            </div>
                                        </div>

                                        <button onclick="addSeance()" class="btn btn-info float-right" style="margin-top: 10px">
                                            اضافه
                                            کردن سانس
                                        </button>
                                        <button onclick="removeAllSeance()" class="btn btn-danger float-right"
                                                style="margin-top: 10px">حذف همه سانس ها
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="seances" class="col-lg-12"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('AddJs')

    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{ asset('assets/js/select_time/persian-date.min.js')}}"></script>
    <script src="{{ asset('assets/js/select_time/persian-datepicker.js')}}"></script>


    <script>

        let selectedDays = [];
        let serviceTimes = [];

        $(document).ready(function () {

            $("#inline2").persianDatepicker({
                calendar: {
                    persian: {
                        enabled: true,
                        locale: 'fa',
                        showHint: false,
                        leapYearMode: "astronomical" // "astronomical"
                    },

                },
                altFormat: 'LLLL',
                inline: true,
                viewMode: 'day',
                format: "lll",
                navigator: {
                    scroll: {
                        enabled: false
                    }
                },

                dayPicker: {
                    enabled: true
                },
                yearPicker: {
                    enabled: true
                },
                timePicker: {
                    enabled: false,
                    meridian: {
                        enabled: true
                    }
                },
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }, todayButton: {
                        text: {
                            fa: 'ماه فعلی'
                        }
                    }
                },
                navigator: {
                    text:{
                        btnNextText:'ماه بعد',
                        btnPrevText:'ماه قبل'
                    },
                    scroll:{
                        enabled: false
                    },

                    onNext: function(){
                        setSelected();
                    },
                    onPrev: function(){
                        setSelected();
                    },onSwitch:function (state) {
                        console.log("on switch:"+state);
                    }
                },
                monthPicker:{
                    onSelect:function (monthIndex) {
                        setSelected();
                    }
                }
            });
        });


        $(document).on('click', '.dt-deselected', function () {

            $(this).attr('class', 'dt-selected');
            let id = $(this).parent().attr("data-date").replace(/,/g, '-');
            $(this).attr('id', id);

            let otherMonth = isOtherMonth($(this));

            if(!otherMonth)
                selectedDays.push(id);
            else{
                // wait for next month to generate
                setTimeout(function(){
                    setSelected();
                }, 50);
            }


        });

        $(document).on('click', '.dt-selected', function () {

            $(this).attr('class', 'dt-deselected');
            let id =$(this).attr('id');
            let index = selectedDays.indexOf(id);
            if(index != -1)
                selectedDays.splice(index, 1);

        });

        function setSelected(){

            $('.dt-deselected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                let otherMonth = isOtherMonth($(this));

                if(!otherMonth){
                    if (selectedDays.includes(id)){

                        $(this).attr('class', 'dt-selected');
                        $(this).attr('id', id);

                    }

                    let timesLength = getTimesLength(id);
                    if (timesLength !=-1)
                        $(this).find('.seance').text('سانس ها: ' + timesLength);

                }

            });

            $('.dt-selected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                if (!selectedDays.includes(id)){
                    $(this).attr('class', 'dt-deselected');
                    $(this).removeAttr('id');
                }

                let timesLength = getTimesLength(id);
                if (timesLength !=-1)
                    $(this).find('.seance').text('سانس ها: ' + timesLength);

            });


        }



        function setTime() {
            let seances = getAllSeances();
            for(let i=0; i<selectedDays.length; i++){
                let day = selectedDays[i];
                removeDayIfExists(day);
                serviceTimes.push({'day':day,'times':seances})
            }

            selectedDays = [];
            setSelected();


            removeAllSeance();
            resetTime();
        }

        function removeTime() {
            $('.dt-selected').each(function (event) {
                $(this).find('.seance').text('');
                $(this).find('.seance').removeAttr('val');
                $(this).css("background-color", "");
                $(this).attr('class', 'dt-deselected');
                $(this).parent().attr('dt-active', 'false');
            });
        }

        function selectAll() {

            $('.dt-deselected').each(function(){
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                if (!selectedDays.includes(id)){

                    let otherMonth = isOtherMonth($(this));

                    if(!otherMonth)
                        selectedDays.push(id);
                }
            });

            setSelected();

        }
        function deselctAll() {
            $('.dt-selected').each(function() {
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                let index = selectedDays.indexOf(id);
                if (index != -1)
                    selectedDays.splice(index, 1);
            });
            setSelected();
        }
        function getTimes() {
            deselctAll();
            removeAllSeance();

            let times = [];
            for (let i=0;i<serviceTimes.length;i++){
                let object = serviceTimes[i];
                let day = object.day;
                let seances = object.times;
                times.push({'day': new persianDate(day.split('-').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD'), 'times': seances});
            }

            return times;
        }

        function isOtherMonth(elemnt) {
            let otherMonth = false;
            $(elemnt).children('span').each(function () {
                if($(this).hasClass('other-month'))
                    otherMonth = true;

            });
            return otherMonth;
        }


        function changeMin(id, type) {

            let element = document.getElementById(id);
            let current = parseInt(element.value);
            if (type == 'add' && current < 55) {
                element.value = current + 5;
            } else if (type == 'minus' && current > 0) {
                element.value = current - 5;
            }

        }

        function changeHour(id, type) {

            let element = document.getElementById(id);
            let current = parseInt(element.value);
            if (type == 'add' && current < 23) {
                element.value = current + 1;
            } else if (type == 'minus' && current > 0) {
                element.value = current - 1;
            }

        }


        function addSeance() {

            let start = $('#start_hour').val() + ":" + $('#start_minute').val();
            let end = $('#end_hour').val() + ":" + $('#end_minute').val();
            let gender_val = $("select[name='seance_gender']").val();
            let gender="";

            if(gender_val === 'male')
                gender='مردانه';
            if(gender_val === 'female')
                gender='زنانه';
            if(gender_val === 'dont_care')
                gender='همه';
            if(gender_val === 'single_sex')
                gender='تک جنسیتی';

            let capacity = $('#seance_capacity').val();
            if (capacity === '')
                capacity = 'نامحدود';
            let capacity_val = $('#seance_capacity').val();

            $('#seances').append("<div class=\"col-md-3 pull-left seance\" style=\"margin-right: 20px;margin-top:20px;border-radius: 5px;text-align: right;background-color: #ececec;box-shadow: 1px 2px 5px -1px #ccc;padding: 10px;color: black;font-size: 12px\">\n" +
                "                <div onclick='removeSeance(this)' class=\"delete\" ><i  class=\"fa fa-trash dot\"></i></div>\n" +
                "                <div class=\"items\"><span class=\"seance_start\" value=" + start + ">شروع: " + start + "</span></div>\n" +
                "                <div class=\"items\"><span class=\"seance_end\" value=" + end + ">پایان: " + end + "</span></div>\n" +
                "                <div class=\"items\"><span class=\"seance_capacity\" value=" + capacity_val + ">ظرفیت: " + capacity + "</span></div>\n" +
                "                <div class=\"items\"><span class=\"seance_gender\" value=" + gender_val + ">جنسیت: " + gender + "</span></div>\n" +
                "        </div>");


        }

        function resetTime() {
            $('#start_hour').val("8");
            $('#start_minute').val("0");
            $('#end_hour').val("9");
            $('#end_minute').val("0");
            $('#capacity').val("");
        }

        function removeSeance(element) {
            let el = $(element).parent();
            el.animate({opacity: '0'}, 150, function () {
                el.animate({width: '0'}, 150, function () {
                    el.remove();
                });
            });
        }

        function removeAllSeance() {
            $('#seances').children().each(function () {

                $(this).remove();

            });
        }


        function removeDayIfExists(day){

            for(let i=0;i<serviceTimes.length;i++){
                let obj = serviceTimes[i];
                if (obj.day == day)
                    serviceTimes.splice(i, 1);
            }
        }

        function getTimesLength(day){

            for(let i=0;i<serviceTimes.length;i++){
                let obj = serviceTimes[i];
                if (obj.day == day)
                    return obj.times.length;
            }
            return -1;
        }

        function getAllSeances() {

            let times = [];

            $('#seances').children().each(function () {

                let start = $(this).find('.seance_start').attr("value");
                let end = $(this).find('.seance_end').attr("value");
                let capacity = $(this).find('.seance_capacity').attr("value");
                let gender = $(this).find('.seance_gender').attr("value");

                times.push({'start': start, 'end': end, 'capacity': capacity,'remain':capacity,'sex':gender});

            });

            console.log(times);
            return times;
        }


        function submit() {

            var x = document.getElementById("service_times").value = JSON.stringify(getTimes());
            console.log(x);
            document.getElementById("form").submit();

        }

    </script>

    <script>

        function setCurrentTimes() {

            let service_times = JSON.parse(document.getElementById("service_times").value.replace(/'/g,'"'));
            console.log(service_times);
            service_times.forEach(element => {
                let day = element.day;
                let times = element.times;

                $('.dt-deselected').each(function (event) {

                    let dt =  new persianDate($(this).parent().attr('data-date').split(',').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD');
                    if(day === dt){

                        console.log(  $(this).parent().attr('data-date'));
                        console.log(dt);
                        $(this).find('.seance').attr('val',JSON.stringify(times));
                        $(this).parent().attr('dt-active',true);
                        $(this).find('.seance').text("سانس ها: "+ times.length)
                    }


                });

            });

        }


        $(document).ready(function(){
            setCurrentTimes();
        });

    </script>

    <script>

        function toggle_seance(active) {

            const div_seance = document.getElementById("div_seance");
            const normal_sale = document.getElementById("normal_sale");
            const normal_1 = document.getElementById("normal_1");
            const normal_0 = document.getElementById("normal_0");

            if (active){
                div_seance.style.display = "";
                normal_sale.value="0";
            }else{
                div_seance.style.display = "none";
                normal_sale.value="1";
            }

        }

        $(document).ready(function(){

            toggle_seance(true);


        });

    </script>
@endsection
