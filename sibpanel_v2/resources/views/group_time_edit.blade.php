@extends('MainLayout')

@section('title')
    <title>
        ویرایش سانس
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
                                    <h4 class="card-title text-right font-weight-bold "> مدیریت سانس ها </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test" class="btn btn-success mt-2 pr-1"><i class="material-icons"> add_circle_outline </i> سانس جدید </span>
                                    <a onclick="history.go(-1);" class="btn btn-dark mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>
                                </div>
                            </div>
                        </div>
                       {{-- <div class="col-lg-4">
                            <div class="card-2 text-center" style="margin-bottom: 20px;margin-right: 5px">
                                <span style="font-size: 16px;margin-left: 5px">حالت: </span>

                                <div class="md-radio md-radio-inline">
                                    <input id="mode_add" type="radio" name="mode" value="add" onclick="setMode('add')"
                                           checked>
                                    <label style="padding: 0 22px" for="mode_add">حذف/اضافه</label>
                                </div>

                                <div class="md-radio md-radio-inline">
                                    <input id="mode_edit" type="radio" name="mode" value="edit" onclick="setMode('edit')">
                                    <label style="padding: 0 22px" for="mode_edit">ویرایش</label>
                                </div>


                            </div>
                        </div>--}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <form method="post" id="form" action="{{ route('edit_group_time_apply') }}" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-4 text-right">
                                                    <label for="group_name">نام گروه سانس</label>
                                                    <input type="text" class="form-control" id="group_name" name="group_name"
                                                           placeholder="نام گروه سانس" value="{{ $group_name }}">

{{--                                                <div class="clearfix"></div>--}}
                                                <input type="hidden" id="group_id" value="{{ $group_id }}">
                                                <input type="hidden" id="service_times" name="service_times" value="">
                                                <div class="col-md-offset-4 col-md-4 col-md-offset-4" style="margin-top:50px;">
                                                    <img id='img-upload' style="max-width:100%;"/>
                                                </div>
                                            </div>
                                            @csrf
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div style="padding: 10px">
                                            <button class="btn btn-primary" onclick="selectAll()">انتخاب همه</button>
                                            <button class="btn btn-danger" onclick="deselctAll()">لغو انتخاب ها</button>
                                        </div>
                                    </div>
                                    <div class="row" id="div_seance" style="display: none">
                                        <div class="col-lg-6 panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div id="inline2">
                                                    </div>
                                                </div>
                                            </div>
                                            <button onclick="setTime()" id="btn_apply" class="btn btn-primary" >اعمال</button>
                                            <button onclick="removeTime()" id="btn_delete_selected" class="btn btn-danger" >حذف انتخاب شده</button>
                                            <button onclick="undo_edit()" id="btn_undo" class="btn btn-success" style="display:none">انصراف از ویرایش</button>
                                            <div class="col-md text-right" style="margin-top: 35px;margin-bottom: 10px">
                                                <button onclick="submit()" class="btn  btn-success c-font-bold btn-lg">تایید نهایی و اعمال
                                                    تغییرات
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 " style="margin-top: 30px">
                                            <div class="col-md-5 mr-3 text-center pull-right"
                                                 style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                                <div class="row justify-content-center">
                                                    <span style="font-size: 16px">ساعت پایان</span>
                                                </div>
                                                <div class="row justify-content-center time-select" style="margin-top: 10px">
                                                    <button onclick="changeMin('end_minute','add')" class="btn btn-info btn-time"
                                                            style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                                    <button onclick="changeHour('end_hour','add')" class="btn btn-info btn-time"
                                                            style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                                </div>
                                                <div class="row justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                                    <input id="end_minute" value="00" disabled>
                                                    <span style="font-size: 20px">:</span>
                                                    <input id="end_hour" value="9" disabled>
                                                </div>
                                                <div class="row justify-content-center time-select">
                                                    <button onclick="changeMin('end_minute','minus')" class="btn btn-info btn-time"
                                                            style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                                    <button onclick="changeHour('end_hour','minus')" class="btn btn-info btn-time"
                                                            style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mr-3 text-center pull-right"
                                                 style="padding: 20px;border-radius: 8px;box-shadow: 0px 2px 6px -1px #ccc;">
                                                <div class="row justify-content-center">
                                                    <span style="font-size: 16px">ساعت شروع</span>
                                                </div>
                                                <div class="row justify-content-center time-select" style="margin-top: 10px">
                                                    <button onclick="changeMin('start_minute','add')" class="btn btn-info btn-time"
                                                            style="margin-left: 4px"><i class="fa fa-chevron-up"></i></button>
                                                    <button onclick="changeHour('start_hour','add')" class="btn btn-info btn-time"
                                                            style="margin-right: 4px"><i class="fa fa-chevron-up"></i></button>
                                                </div>
                                                <div class="row  justify-content-center time-select" style="margin-top: 4px;margin-bottom: 4px">
                                                    <input id="start_minute" value="00" disabled>
                                                    <span style="font-size: 20px">:</span>
                                                    <input id="start_hour" value="8" disabled>
                                                </div>
                                                <div class="row justify-content-center time-select">
                                                    <button onclick="changeMin('start_minute','minus')" class="btn btn-info btn-time"
                                                            style=";margin-left: 4px"><i class="fa fa-chevron-down"></i></button>
                                                    <button onclick="changeHour('start_hour','minus')" class="btn btn-info btn-time"
                                                            style=";margin-right: 4px"><i class="fa fa-chevron-down"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-lg-12  pull-right" style="margin-top: 20px">
                                                <div class="form-row text-right">
                                                    <div class="col">
                                                        <label for=""> ظرفیت </label>
                                                        <input class="form-control" id="seance_capacity"
                                                               style="text-align: center;width: 100%;height: 40px;border: 2px solid #2d2d2d"
                                                               placeholder="ظرفیت"
                                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
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
                                               {{-- <div class="col-md-12" style="margin-bottom:15px" >
                                                    <span style="font-size: 16px">جنسیت: </span>
                                                    <div class="md-radio md-radio-inline">
                                                        <input id="gender_all" type="radio" name="seance_gender" value="dont_care" checked>
                                                        <label style="padding: 0 22px" for="gender_all">همه</label>
                                                    </div>
                                                    <div class="md-radio md-radio-inline">
                                                        <input id="gender_male" type="radio" name="seance_gender" value="male">
                                                        <label style="padding: 0 22px" for="gender_male">مردانه</label>
                                                    </div>
                                                    <div class="md-radio md-radio-inline">
                                                        <input id="gender_female" type="radio" name="seance_gender" value="female">
                                                        <label style="padding: 0 22px" for="gender_female">زنانه</label>
                                                    </div>
                                                    <div class="md-radio md-radio-inline">
                                                        <input id="gender_single" type="radio" name="seance_gender" value="single_sex">
                                                        <label style="padding: 0 22px" for="gender_single">تک جنسیتی</label>
                                                    </div>
                                                    <input type="hidden" id="edit_template_id" value="">
                                                    <br>
                                                </div>--}}

                                                    <button onclick="addSeance()" id="btn_add_seance" class="btn btn-info" >اضافه کردن سانس</button>
                                                    <button onclick="deleteAllSeance()" id="btn_delete_all_seances" class="btn btn-danger ">حذف همه سانس ها</button>
                                                    <button onclick="do_edit_seance()" id="btn_edit_seance" class="btn btn-primary" style="display:none">ویرایش سانس</button>
                                                    <button onclick="cancel_edit_seance()" id="btn_cancel_edit" class="btn btn-success" style="display:none">لغو</button>

                                            </div>
                                            {{--<div class="card-2" style="margin-right: 5px;display: inline-block">
                                                <div>

                                                </div>

                                            </div>--}}

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="seances" style="margin-bottom: 15px;display: flow-root;">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                       {{-- <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <form method="post" id="form" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-4 mx-auto text-right">
                                               <label for="group_name">نام گروه سانس</label>
                                                    <input type="text" class="form-control" id="group_name" name="group_name"
                                                           placeholder="نام گروه سانس" value="{{ $group_name }}">
                                                <input type="hidden" id="group_id" value="{{ $group_id }}">
                                                <input type="hidden" id="service_times" name="service_times" value="">
                                            </div>
                                            <div class="col-md-offset-4 col-md-4 col-md-offset-4" style="margin-top:50px;">
                                                <img id='img-upload' style="max-width:100%;"/>
                                            </div>

                                        </div>
                                    @csrf
                                </div>
                                </form>
                            </div>
                        </div>
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

                        </div>--}}

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

    <script type="text/javascript">
        let selectedDays = [];
        // let serviceTimes = [];
        let serviceTimesNew = [];
        let serviceTimesEdit = [];
        let serviceTimesDelete = [];

        let tempAdd = [];
        let tempDelete = [];

        let mode = 'add';

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
                    text: {
                        btnNextText: 'ماه بعد',
                        btnPrevText: 'ماه قبل'
                    },
                    scroll: {
                        enabled: false
                    },

                    onNext: function () {
                        setSelected();
                    },
                    onPrev: function () {
                        setSelected();
                    }, onSwitch: function (state) {
                        console.log("on switch:" + state);
                    }
                },
                monthPicker: {
                    onSelect: function (monthIndex) {
                        setSelected();
                    }
                }
            });
        });


        $(document).on('click', '.dt-deselected', function () {

            if (mode == 'edit')
                deselctAll();

            $(this).attr('class', 'dt-selected');
            let id = $(this).parent().attr("data-date").replace(/,/g, '-');
            $(this).attr('id', id);

            let otherMonth = isOtherMonth($(this));

            if (!otherMonth)
                selectedDays.push(id);
            else {
                // wait for next month to generate
                setTimeout(function () {
                    setSelected();
                }, 50);
            }


            // show seances
            if (mode == 'edit')
                show_selected_seances(id);


        });

        $(document).on('click', '.dt-selected', function () {

            $(this).attr('class', 'dt-deselected');
            let id = $(this).attr('id');
            let index = selectedDays.indexOf(id);
            if (index != -1)
                selectedDays.splice(index, 1);

        });

        function setSelected() {

            $('.dt-deselected').each(function () {
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                let otherMonth = isOtherMonth($(this));

                if (!otherMonth) {
                    if (selectedDays.includes(id)) {

                        $(this).attr('class', 'dt-selected');
                        $(this).attr('id', id);

                    }

                    let timesLength = getTimesLength(id);
                    if (timesLength != -1)
                        $(this).find('.seance').text('سانس ها: ' + timesLength);

                }

            });

            $('.dt-selected').each(function () {
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                if (!selectedDays.includes(id)) {
                    $(this).attr('class', 'dt-deselected');
                    $(this).removeAttr('id');
                }

                let timesLength = getTimesLength(id);
                if (timesLength != -1)
                    $(this).find('.seance').text('سانس ها: ' + timesLength);

            });


        }


        function setTime() {

            for (let i = 0; i < selectedDays.length; i++) {

                let day = selectedDays[i];
                let seances = getAllSeances(day);
                removeDayIfExists(day);
                serviceTimes.push({'day': day, 'times': seances});

                addToNewArray(day,seances);
                addToEditArray(day,seances);

            }

            // apply from temp
            for (let i=0;i<tempAdd.length;i++)
                removeFromAddArray(tempAdd[i]);

            for (let i=0;i<tempDelete.length;i++)
                addToDeleteArray(tempDelete[i]);


            selectedDays = [];
            setSelected();


            removeAllSeance();
            resetTime();

            tempAdd = [];
            tempDelete = [];

            deselctAll();
        }

        function removeTime() {

            Swal.fire({
                title: 'حذف سانس های روز',
                text: "از حذف سانس ها در روزهای انتخابی اطمینان دارید؟",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بلی',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.value) {

                    $('.dt-selected').each(function (event) {
                        $(this).find('.seance').text('');
                        $(this).find('.seance').removeAttr('val');
                        $(this).css("background-color", "");
                        $(this).attr('class', 'dt-deselected');
                        $(this).parent().attr('dt-active', 'false');

                        let dt = $(this).parent().attr('data-date');
                        dt = dt.replace(/,/g, '-');

                        for (let i=serviceTimes.length-1;i>=0;i--){

                            let item = serviceTimes[i];
                            let day = item['day'];
                            if (day == dt){
                                let times = item['times'];
                                for (let j=0;j<times.length;j++){

                                    let time = times[j];
                                    let time_template_id = time['time_template_id'];
                                    if (typeof time_template_id !== 'undefined') {
                                        addToDeleteArray(time_template_id);
                                    }

                                    let guid = time['guid'];
                                    if (typeof guid !== 'undefined') {
                                        removeFromAddArray(guid);
                                    }


                                }

                                serviceTimes.splice(i, 1);

                            }
                        }

                    });

                    deselctAll();
                    deselctAll();
                }
            });

        }

        function selectAll() {

            $('.dt-deselected').each(function () {
                let id = $(this).parent().attr("data-date").replace(/,/g, '-');
                if (!selectedDays.includes(id)) {

                    let otherMonth = isOtherMonth($(this));

                    if (!otherMonth)
                        selectedDays.push(id);
                }
            });

            setSelected();

        }

        function deselctAll() {

            $('.dt-selected').each(function () {
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
            for (let i = 0; i < serviceTimes.length; i++) {
                let object = serviceTimes[i];
                let day = object.day;
                let seances = object.times;
                times.push({
                    'day': new persianDate(day.split('-').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD'),
                    'times': seances
                });
            }

            return times;
        }

        function isOtherMonth(elemnt) {
            let otherMonth = false;
            $(elemnt).children('span').each(function () {
                if ($(this).hasClass('other-month'))
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
            let gender = "";

            if (gender_val === 'male')
                gender = 'مردانه';
            if (gender_val === 'female')
                gender = 'زنانه';
            if (gender_val === 'dont_care')
                gender = 'همه';
            if (gender_val === 'single_sex')
                gender = 'تک جنسیتی';

            let capacity = $('#seance_capacity').val();
            if (capacity === '')
                capacity = 'نامحدود';
            let capacity_val = $('#seance_capacity').val();

            if (Number(capacity_val) == 0){
                Swal.fire({
                    title: 'خطا',
                    text: "لطفا ظرفیت را وارد کنید",
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'باشه',
                });

                return;
            }

            $('#seances').append("<div class=\"col-md-2 pull-left seance\" style=\"margin-right: 20px;margin-top:20px;border-radius: 5px;text-align: right;background-color: #c7c7c7;padding: 10px;color: black;font-size: 12px\">\n" +
                "                <div onclick='removeSeance(this)' class=\"delete\" ><i  class=\"fa fa-trash dot\"></i></div>\n" +
                "                <input type='hidden' class=\"guid\" value=" + uuidv4() + ">\n" +
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
            $('#seance_capacity').val("");
            $('#gender_all').prop('checked', true);


        }

        function removeSeance(element) {

            Swal.fire({
                title: 'حذف سانس',
                text: "از حذف این سانس اطمینان دارید؟",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بلی',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.value) {
                    let el = $(element).parent();
                    el.animate({opacity: '0'}, 150, function () {
                        el.animate({width: '0'}, 150, function () {
                            el.remove();

                            // if has guid first remove it from addArray
                            let guid = el.find(".guid").val();
                            if (typeof guid !== 'undefined'){
                                // remove from addArray
                                // add to temp
                                tempAdd.push(guid);

                            }

                            // if has template id then add to removeArray
                            let template_id = el.find(".template_id").val();
                            if (typeof template_id !== 'undefined'){
                                // add to DeleteArray
                                // add to temp
                                tempDelete.push(template_id);
                            }


                        });
                    });
                }
            })


        }

        function removeAllSeance() {
            $('#seances').children().each(function () {

                $(this).remove();

            });
        }


        function deleteAllSeance() {
            $('#seances').children().each(function () {

                $(this).remove();

                // if has guid first remove it from addArray
                let guid = $(this).find(".guid").val();
                if (typeof guid !== 'undefined'){
                    // remove from addArray
                    // add to temp
                    tempAdd.push(guid);

                }

                let template_id = $(this).find(".template_id").val();
                if (typeof template_id !== 'undefined'){
                    // add to DeleteArray
                    // add to temp
                    tempDelete.push(template_id);
                }

            });
        }

        function removeDayIfExists(day) {

            for (let i = 0; i < serviceTimes.length; i++) {
                let obj = serviceTimes[i];
                if (obj.day == day)
                    serviceTimes.splice(i, 1);
            }
        }

        function getTimesLength(day) {

            for (let i = 0; i < serviceTimes.length; i++) {
                let obj = serviceTimes[i];
                if (obj.day == day)
                    return obj.times.length;
            }
            return -1;
        }

        function getAllSeances(day) {

            let times = [];

            $('#seances').children().each(function () {

                let template_id = $(this).find('.template_id').attr("value");

                let start = $(this).find('.seance_start').attr("value");
                let end = $(this).find('.seance_end').attr("value");
                let capacity = $(this).find('.seance_capacity').attr("value");
                let gender = $(this).find('.seance_gender').attr("value");
                let guid = $(this).find('.guid').attr("value")+"-"+day;
                capacity = Number(capacity);
                if (typeof template_id === 'undefined')
                    times.push({'guid':guid,'start': start, 'end': end, 'capacity': capacity, 'remain': capacity, 'sex': gender});
                else{
                    let modified = $(this).find('.modified').attr("value");
                    template_id = Number(template_id);
                    times.push({'time_template_id':template_id,'modified':modified,'start': start, 'end': end, 'capacity': capacity, 'remain': capacity, 'sex': gender});
                }

            });

            console.log(times);
            return times;
        }

        function getFinalResult() {

            // convert dates
            for(let i=0;i<serviceTimesNew.length;i++){
                let item = serviceTimesNew[i];
                let day = item['day'];
                day = new persianDate(day.split('-').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD');
                item['day'] = day;
            }

            for(let i=0;i<serviceTimesEdit.length;i++){
                let item = serviceTimesEdit[i];
                let day = item['day'];
                day = new persianDate(day.split('-').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD');
                item['day'] = day;
            }

            let group_id = $("#group_id").val();
            let group_name = $("#group_name").val();
            let data = {
                'time_group_id':group_id,
                'time_group_name':group_name,
                'service_time_voucher_info':info_ids,
                'add':serviceTimesNew,
                'edit':serviceTimesEdit,
                'delete':serviceTimesDelete
            };

            return data;
        }

        function submit() {

            document.getElementById("service_times").value = JSON.stringify(getFinalResult());

            document.getElementById("form").submit();

        }

    </script>

    <script>

        function setCurrentTimes() {

            let service_times = JSON.parse(document.getElementById("service_times").value.replace(/'/g, '"'));
            console.log(service_times);
            service_times.forEach(element => {
                let day = element.day;
                let times = element.times;

                $('.dt-deselected').each(function (event) {

                    let dt = new persianDate($(this).parent().attr('data-date').split(',').map(Number)).toCalendar('gregorian').toLocale('en').format('YYYY-MM-DD');
                    if (day === dt) {

                        console.log($(this).parent().attr('data-date'));
                        console.log(dt);
                        $(this).find('.seance').attr('val', JSON.stringify(times));
                        $(this).parent().attr('dt-active', true);
                        $(this).find('.seance').text("سانس ها: " + times.length)
                    }


                });

            });

        }


        function show_selected_seances(date) {

            $('#seances').children().each(function () {
                $(this).remove();
            });

            for (let i = 0; i < serviceTimes.length; i++) {
                let serviceTime = serviceTimes[i];
                if (date == serviceTime['day']) {
                    let times = serviceTime['times'];
                    for (let j = 0; j < times.length; j++) {

                        let time = times[j];
                        let template_id = time['time_template_id'];
                        let start = time['start'];
                        let end = time['end'];
                        let gender_val = time['sex'];
                        let gender = "";

                        if (gender_val === 'male')
                            gender = 'مردانه';
                        if (gender_val === 'female')
                            gender = 'زنانه';
                        if (gender_val === 'dont_care')
                            gender = 'همه';
                        if (gender_val === 'single_sex')
                            gender = 'تک جنسیتی';

                        let capacity = time['capacity'];
                        if (capacity === '')
                            capacity = 'نامحدود';
                        let capacity_val = time['capacity'];

                        console.log("template_id:"+template_id);

                        if (typeof template_id !== 'undefined'){
                            $('#seances').append("<div class=\"col-md-2 pull-left seance\" style=\"margin-right: 20px;margin-top:20px;border-radius: 5px;text-align: right;background-color: #c7c7c7;padding: 10px;color: black;font-size: 12px\">\n" +
                                "                <div onclick='removeSeance(this)' class=\"delete\" ><i  class=\"fa fa-trash dot\"></i></div>\n" +
                                "                <div onclick='edit_seance(this)' class=\"edit\" ><i  class=\"fa fa-pencil dot green \"></i></div>\n" +
                                "                <input type='hidden' class=\"template_id\" id=" +"template_id_"+ template_id + " value=" + template_id + ">\n" +
                                "                <input type='hidden' class=\"modified\" value=\"false\">\n" +
                                "                <div class=\"items\"><span class=\"seance_start\" value=" + start + ">شروع: " + start + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_end\" value=" + end + ">پایان: " + end + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_capacity\" value=" + capacity_val + ">ظرفیت: " + capacity + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_gender\" value=" + gender_val + ">جنسیت: " + gender + "</span></div>\n" +
                                "        </div>");
                        }else{

                            let guid = time['guid'];
                            $('#seances').append("<div class=\"col-md-2 pull-left seance\" style=\"margin-right: 20px;margin-top:20px;border-radius: 5px;text-align: right;background-color: #c7c7c7;padding: 10px;color: black;font-size: 12px\">\n" +
                                "                <div onclick='removeSeance(this)' class=\"delete\" ><i  class=\"fa fa-trash dot\"></i></div>\n" +
                                "                <div onclick='edit_seance(this)' class=\"edit\" ><i  class=\"fa fa-pencil dot green \"></i></div>\n" +
                                "                <input type='hidden' class=\"guid\"  value=" + guid + ">\n" +
                                "                <div class=\"items\"><span class=\"seance_start\" value=" + start + ">شروع: " + start + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_end\" value=" + end + ">پایان: " + end + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_capacity\" value=" + capacity_val + ">ظرفیت: " + capacity + "</span></div>\n" +
                                "                <div class=\"items\"><span class=\"seance_gender\" value=" + gender_val + ">جنسیت: " + gender + "</span></div>\n" +
                                "        </div>");
                        }



                    }


                }
            }


        }


        function setMode(md) {
            mode = md;
            removeAllSeance();
            deselctAll();



            if(mode == 'add'){
                $('#btn_delete_selected').attr("style", "");
                $('#btn_undo').css("display","none");
                $('#mode_add').prop('checked', true);
                cancel_edit_seance();
                $('#btn_undo').css("display","none");


            }else if(mode == 'edit'){

                $('#btn_delete_selected').css("display","none");
                $('#btn_undo').attr("style", "");
                $('#mode_edit').prop('checked', true);

            }

        }


        function edit_seance(child){
            let el = $(child).parent();
            let template_id = el.find('.template_id').attr("value");
            let start = el.find('.seance_start').attr("value");
            let end = el.find('.seance_end').attr("value");
            let capacity = el.find('.seance_capacity').attr("value");
            let gender = el.find('.seance_gender').attr("value");

            $('#edit_template_id').val(template_id)

            $('#btn_add_seance').css("display","none");
            $('#btn_delete_all_seances').css("display","none");
            $('#btn_apply').css("display","none");
            $('#btn_undo').css("display","none");

            $('#btn_edit_seance').attr("style", "");
            $('#btn_cancel_edit').attr("style", "");



            // set time

            $('#start_hour').val(start.split(":")[0]);
            $('#start_minute').val(start.split(":")[1]);

            $('#end_hour').val(end.split(":")[0]);
            $('#end_minute').val(end.split(":")[1]);


            $('#seance_capacity').val(capacity);

            console.log("saamad capacity:"+capacity);

            switch (gender) {
                case 'dont_care':
                    $('#gender_all').prop('checked', true);
                    break;
                case 'male':
                    $('#gender_male').prop('checked', true);
                    break;
                case 'female':
                    $('#gender_female').prop('checked', true);
                    break;
                case 'single_sex':
                    $('#gender_single').prop('checked', true);
                    break;

            }

            remove_seance_color();

            el.css('background-color', '#FEA32A');


        }

        function do_edit_seance() {

            let template_id = $('#edit_template_id').val();
            let parent = $('#template_id_'+template_id).parent();

            let start = $('#start_hour').val() + ":" + $('#start_minute').val();
            let end = $('#end_hour').val() + ":" + $('#end_minute').val();
            let gender_val = $("input[name='seance_gender']:checked").val();
            let gender = "";

            if (gender_val === 'male')
                gender = 'مردانه';
            if (gender_val === 'female')
                gender = 'زنانه';
            if (gender_val === 'dont_care')
                gender = 'همه';
            if (gender_val === 'single_sex')
                gender = 'تک جنسیتی';

            let capacity = $('#seance_capacity').val();
            if (capacity === '')
                capacity = 'نامحدود';
            let capacity_val = $('#seance_capacity').val();

            console.log("edit capacity:"+capacity_val);

            if (Number(capacity_val) == 0){
                Swal.fire({
                    title: 'خطا',
                    text: "لطفا ظرفیت را وارد کنید",
                    type: 'error',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'باشه',
                });

                return;
            }


            parent.find(".modified").val(true);

            parent.find(".seance_start").attr("value",start);
            parent.find(".seance_start").text("شروع: "+start);

            parent.find(".seance_end").attr("value",end);
            parent.find(".seance_end").text("پایان: "+end);

            parent.find(".seance_capacity").attr("value",capacity_val);
            parent.find(".seance_capacity").text("ظرفیت: "+capacity);

            console.log("do edit gender:"+gender_val);
            parent.find(".seance_gender").attr("value",gender_val);
            parent.find(".seance_gender").text("جنسیت: "+gender);

            cancel_edit_seance();

        }

        function cancel_edit_seance(){
            $('#btn_add_seance').attr("style", "");
            $('#btn_delete_all_seances').attr("style", "");
            $('#btn_apply').attr("style", "");
            $('#btn_undo').attr("style", "");

            $('#btn_edit_seance').css("display","none");
            $('#btn_cancel_edit').css("display","none");

            resetTime();
            remove_seance_color();
        }

        function remove_seance_color() {

            $('#seances').find('.seance').each(function () {
                $(this).css('background-color', '#c7c7c7');
            })

        }

        function undo_edit(){
            setMode('add');
            resetTime();

        }

        function addToNewArray(newDay,newTime){

            let validTime = [];

            for (let i=0;i<newTime.length;i++){
                let item = newTime[i];
                let guid = item['guid'];
                if (typeof guid !== 'undefined')
                    validTime.push(item);
            }

            let index = -1;
            for (let i=0;i<serviceTimesNew.length;i++){
                let item = serviceTimesNew[i];
                if (item['day'] == newDay){
                    index = i;
                }
            }

            if (index > -1) {
                serviceTimesNew.splice(index, 1);
            }
            if (validTime.length>0){
                serviceTimesNew.push({'day': newDay, 'times': validTime});
            }


        }


        function addToEditArray(newDay,newTime){

            let validTime = [];

            for (let i=0;i<newTime.length;i++){
                let item = newTime[i];
                let template_id = item['time_template_id'];
                let modified = item['modified'];
                console.log("type of modified:"+typeof  modified)
                if (typeof template_id !== 'undefined' && modified == 'true')
                    validTime.push(item);
            }

            let index = -1;
            for (let i=0;i<serviceTimesEdit.length;i++){
                let item = serviceTimesEdit[i];
                if (item['day'] == newDay){
                    index = i;
                }
            }

            if (index > -1) {
                serviceTimesEdit.splice(index, 1);
            }
            if (validTime.length>0){
                serviceTimesEdit.push({'day': newDay, 'times': validTime});
            }


        }

        function addToDeleteArray(template_id){
            template_id = Number(template_id);
            console.log(template_id);
            if(serviceTimesDelete.indexOf(template_id) == -1)
                serviceTimesDelete.push(template_id);
        }


        function removeFromAddArray(guid){
            console.log(guid);

            for (let i=0;i<serviceTimesNew.length;i++){
                let item = serviceTimesNew[i];
                let times = item['times'];
                let index = -1;
                for (let j=0;j<times.length;j++){
                    let time = times[j];
                    if (time['guid'] == guid){
                        index = j;
                    }

                }
                if (index > -1) {
                    serviceTimesNew.splice(index, 1);
                }
            }
        }


        $(document).ready(function () {
            setCurrentTimes();
        });

    </script>

    <script>

        function toggle_seance(active) {

            const div_seance = document.getElementById("div_seance");
            const normal_sale = document.getElementById("normal_sale");
            const normal_1 = document.getElementById("normal_1");
            const normal_0 = document.getElementById("normal_0");

            if (active) {
                div_seance.style.display = "";
                normal_sale.value = "0";
            } else {
                div_seance.style.display = "none";
                normal_sale.value = "1";
            }

        }

        // load edit data

        let info_ids = JSON.parse(@json($voucher_info_ids));
        let service2 = JSON.parse(@json($group_times));
        let serviceTimes = JSON.parse(@json($group_times));

        for (let i = 0; i < serviceTimes.length; i++) {
            let item = serviceTimes[i];
            let day = item['day'];
            let dt = day.split('-').map(Number);
            let y = dt[0];
            let m = dt[1] - 1;
            let d = dt[2];
            item['day'] = new persianDate(new Date(y, m, d)).toLocale('en').format('YYYY-M-D');
        }

        //setSelected();


        $(document).ready(function () {
            setSelected();

            toggle_seance(true);

        });

        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

    </script>


@endsection
