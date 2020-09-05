@extends('MainLayout')

@section('title')
    <title>
        مدیریت اعلان ها
    </title>
    <link rel="stylesheet" href="{{asset('')}}assets/js/persian-datepicker.min.css">
    <style>
        .choseLocation .bootstrap-select{
            width: 600px !important;
        }
        .importance .bootstrap-select{
            width: 100% !important;
        }

        @media only screen and (max-width: 474px) {
            .choseLocation .bootstrap-select{
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div id="loader" style="position: fixed;z-index: 35;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
        <div class="container-fluid">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">location_city</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> اطلاعات استان های موجود </h4>
                                </div>
                                <div class="col-sm">

                                    <a onclick="history.go(-1);" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6 text-right mx-auto choseLocation">
                                    <label class="font-weight-bold" for=""> انتخاب مکان :  </label>
                                    <select id="Location_id" data-live-search="true" name="projects" class="selectpicker " data-style="btn btn-primary border-dark" title="انتخاب مکان">
                                        @foreach($Locations as $Location)
                                            <option value="{{$Location['id']}}"> {{$Location['location_name']}} </option>
                                        @endforeach
                                    </select>
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
                                            عنوان
                                        </th>
                                        <th>
                                            زمان شروع
                                        </th>
                                        <th>
                                            زمان پایان
                                        </th>
                                        <th>
                                            اهمیت
                                        </th>
                                        <th >
                                            ویرایش

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="alertData">
                                    <tr>
                                        <td colspan="6">
                                            <h6 class=" text-center py-5">
                                                برای مشاهده ی اعلان مکانی را انتخاب نمایید .
                                            </h6>
                                        </td>
                                    </tr>
                                    {{--<tr>
                                        <td>
                                            data.title
                                        </td>
                                        <td>
                                            start
                                        </td>
                                        <td>
                                            end
                                        </td>
                                        <td>
                                            importance
                                        </td>
                                        <td>
                                            <button data-toggle="modal" id="statebtn" data-target="#edit" type="button" rel="tooltip" class="btn TableEditBtn  btn-success btn-simple">
                                                <i class="material-icons">edit</i>
                                                ویرایش
                                            </button>
                                            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="" method="post">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title " id="edit1Label"> ویرایش استان </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                --}}{{--<div class="form-row">
                                                                    <div class="col-sm">
                                                                        <select name="projects" class="selectpicker" data-style="btn btn-primary border-dark" title="Single Select">
                                                                            <option disabled selected> انتخاب پروژه </option>
                                                                            @foreach($projectList as $project)
                                                                                @if( (int)$project['project_id'] ==  (int)$Province['project_id'] )
                                                                                    <option selected value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                                                                @else
                                                                                    <option value="{{$project['project_id']}}"> {{$project['project_name']}} </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>--}}{{--
                                                                <div class="form-row mt-3">
                                                                    <div class="col-sm">
                                                                        <input name="name_fa" value="#" type="text" class="form-control" id="nameStateFa" placeholder="نام  استان">
                                                                    </div>
                                                                </div>
                                                                <div class="form-row mt-4">
                                                                    <div class="col-sm">
                                                                        <input name="name_en" value="#" type="text" class="form-control" id="nameStateEn" placeholder=" نام  استان به انگلیسی">
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
                                            <a href="" rel="tooltip" class="btn  btn-danger btn-simple">
                                                <i class="material-icons">delete</i>
                                                حذف
                                            </a>
                                            <a href="" rel="tooltip" class="btn  btn-info btn-simple">
                                                <i class="material-icons">visibility</i>
                                                نمایش
                                            </a>
                                            <button data-toggle="modal" id="statebtn" data-target="#show" type="button" rel="tooltip" class="btn TableEditBtn  btn-success btn-simple">
                                                <i class="material-icons">visibility</i>
                                                نمایش
                                            </button>
                                            <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title " id="edit1Label"> نمایش متن </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    تست تتسس تتس تستست تست
                                                                </p>
                                                            </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                        <td>

                                        </td>

                                    </tr>--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="AddAlert" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('AddAlert')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن اعلان </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="id" name="location_id">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-sm text-right">
                            <label for="">  عنوان </label>
                            <input name="title" type="text" class="form-control" placeholder="عنوان">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> اولویت </label>
                            <select style="width: 100% !important;" name="importance" class="importance selectpicker" data-style="btn btn-primary border-dark" title="اولویت">
                                <option selected value="trivial">عادی</option>
                                <option value="low">پایین</option>
                                <option value="medium">متوسط</option>
                                <option value="high">بالا</option>
                                <option value="critical">ضروری</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  زمان شروع </label>
                            <input dir="ltr" name="start" type="text" class="form-control" id="FromDate" placeholder="زمان شروع">
                        </div>
                        <div class="col-sm text-right">
                            <label for="">
                                زمان پایان </label>
                            <input dir="ltr" name="end" type="text" class="form-control" id="ToDate" placeholder=" زمان پایان">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-sm text-right">
                            <label for="">  توضیحات </label>
                            <textarea name="description" id="" class="form-control"  style="height: 100px !important;"></textarea>
                        </div>
                </div>
                <div class="modal-footer mt-4 pl-0">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button type="submit" class="btn px-5 btn-success ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
            </div>
        </form>

    </div>
</div>
@endsection
@section('AddJs')
    <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{asset('')}}assets/js/persian-date.min.js"></script>
    <script src="{{asset('')}}assets/js/persian-datepicker.min.js"></script>
    <script src="{{asset('')}}assets/js/tableToExcel.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            /*$(document).on('click', '.dataTime', function() {
                // alert("I have been clicked!");

            });*/

            $('#FromDate').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                format: 'YYYY/MM/DD HH:mm',
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                } ,
                timePicker:{
                    enabled : true
                }


            });

            $('#ToDate').persianDatepicker({
                initialValue: true,
                autoClose : true ,
                format: 'YYYY/MM/DD HH:mm',
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                },navigator:{
                    text:{
                        btnNextText:'بعدی',
                        btnPrevText:'قبلی'
                    }
                },
                timePicker:{
                    enabled : true
                }

            });

            let start = "{{request('startDate')}}";
            if(start != '')
                $("#FromDate").val(start);

            let end = "{{request('endDate')}}";
            if(end != '')
                $("#ToDate").val(end);
        });
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#Location_id').change(function () {
                var Location_id = $('#Location_id').val();
                $('#loader').css('display' , 'flex');
                $.ajax({
                    type:'POST',
                    url:"{{Route('getAlert')}}",
                    dataType:'json',
                    data:{
                        '_token ': '<?php echo csrf_token() ?>',
                        'Location_id' : Location_id ,
                    },
                    success:function(data) {

                         console.log(data);
                        $('#alertData').html('');
                        if(data.length != 0){
                            let i ;
                            let importance;
                            for(  i = 0 ; i <  data.length ; i++ ){
                                let select = " " ;
                                switch (data[i].importance) {
                                    case "trivial" :
                                        importance = "عادی";
                                    break ;
                                    case "low" :
                                        importance = "پایین";
                                        break ;
                                    case "medium" :
                                        importance = "متوسط";
                                        break ;
                                    case "high" :
                                        importance = "بالا";
                                        break ;
                                    case "critical" :
                                        importance = "ضروری";
                                        break ;
                                }

                                select +=   "<select style=\"width: 100% !important;\" name=\"importance\" class=\"importance selectpicker\" data-style=\"btn btn-primary border-dark\" title=\"اولویت\">\n" ;
                                select += "<option " ;
                                if(data[i].importance == "trivial"){
                                    select += " selected " ;
                                }
                                select += " value=\"trivial\">عادی</option> <option"  ;
                                if(data[i].importance == "low"){
                                    select += " selected " ;
                                }
                                select +=  " value=\"low\">پایین</option> <option " ;
                                if(data[i].importance == "medium"){
                                    select += " selected " ;
                                }
                                select += "value=\"medium\">متوسط</option> <option"  ;
                                if(data[i].importance == "high"){
                                    select += " selected " ;
                                }
                                select += " value=\"high\">بالا</option> <option"  ;
                                if(data[i].importance == "critical"){
                                    select += 'selected' ;
                                }
                                select += " value=\"critical\">ضروری</option> </select>";

                                let alert = data[i];
                                let date_start = alert.start;
                                let day_start = date_start.split(" ")[0];
                                let time_start = date_start.split(" ")[1];
                                let dt_start = day_start.split('-').map(Number);
                                let start =  new persianDate(new Date(dt_start[0], dt_start[1] - 1, dt_start[2])).toLocale('en').format('YYYY/M/D') + " " + time_start ;


                                let date_end = alert.end;
                                let day_end = date_end.split(" ")[0];
                                let time_end = date_end.split(" ")[1];
                                let dt_end = day_end.split('-').map(Number);
                                let end =  new persianDate(new Date(dt_end[0], dt_end[1] - 1, dt_end[2])).toLocale('en').format('YYYY/M/D') + " " + time_end ;

                                html = "  <tr> " +
                                    "<td>\n" + data[i].title + "</td>" +
                                    "<td dir='ltr'>\n" +start + "</td>" +
                                    "<td dir='ltr'>\n" + end + "</td>" +
                                    "<td>\n" + importance + "</td>" +
                                    "<td colspan='2'>\n" +
                                    "             <button data-toggle=\"modal\" id=\"statebtn\" data-target=\"#edit"+ i +"\" type=\"button\" rel=\"tooltip\" class=\"btn TableEditBtn  btn-success btn-simple\">\n" +
                                    "              <i class=\"material-icons\">edit</i> ویرایش \n" +
                                    "               </button>\n" +
                                    "                <div class=\"modal fade\" id=\"edit"+i+"\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"testLabel\" aria-hidden=\"true\">\n" +
                                    "                  <div class=\"modal-dialog\" role=\"document\">\n" +
                                    "                    <form action=\"EditAlert/"+ data[i].alert_id + "\" method=\"get\">   \n" +
                                    "                       <div class=\"modal-content\">\n" +
                                    "                         <div class=\"modal-header\">\n" +
                                    "                          <h5 class=\"modal-title \" id=\"edit1Label\"> ویرایش اعلان </h5>\n" +
                                    "                         <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" +
                                    "                      <span aria-hidden=\"true\">&times;</span>\n" +
                                    "                   </button>\n" +
                                    "                </div>\n" +
                                    "                <div class=\"modal-body\">\n" +
                                    "                    <div class=\"form-row\">\n" +
                                    "                        <div class=\"col-sm text-right\">\n" +
                                    "                            <label for=\"\">  عنوان </label>\n" +
                                    "                            <input name=\"title\" type=\"text\" value='"+  data[i].title  + "' class=\"form-control\" placeholder=\"عنوان\">\n" +
                                    "                        </div>\n" +
                                    "                        <div class=\"col-sm text-right\">\n" +
                                    "                            <label for=\"\"> اولویت </label>\n" +
                                                                                                select +
                                    "                        </div>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"form-row mt-3\">\n" +
                                    "                        <div class=\"col-sm text-right\">\n" +
                                    "                            <label for=\"\">  زمان شروع </label>\n" +
                                    "                            <input dir=\"rtl\" name=\"start\" type=\"text\" class=\"form-control \" id=\"FromDate" + i +"\" value='"+ data[i].start  + "' placeholder=\"زمان شروع\">\n" +
                                    "                        </div>\n" +
                                    "                        <div class=\"col-sm text-right\">\n" +
                                    "                            <label for=\"\">\n" +
                                    "زمان پایان </label> " +
                                    "                            <input dir=\"rtl\" name=\"end\" type=\"text\" class=\"form-control \" id=\"ToDate" + i +"\"  value='"+ data[i].end  + "' placeholder=\" زمان پایان\">\n" +
                                    "                        </div>\n" +
                                    "                    </div>\n" +
                                    "                    <div class=\"form-row mt-3\">\n" +
                                    "                        <div class=\"col-sm text-right\">\n" +
                                    "                            <label for=\"\">  توضیحات </label>\n" +
                                    "                            <textarea name=\"description\" class=\"form-control \"  style=\"height: 100px !important;\"> " +   data[i].description + " </textarea>\n" +
                                    "                        </div>\n" +
                                    "                </div>\n" +
                                    "                <div class=\"modal-footer mt-4 pl-0\">\n" +
                                    "                    {{-- <button type=\"button\" class=\"btn btn-primary\" data-dismiss=\"modal\">بستن </button>--}}\n" +
                                    "                    <button type=\"submit\" class=\"btn px-5 btn-success ml-0 mr-auto\"> ویرایش </button>\n" +
                                    "                </div>\n" +
                                    "            </div>" +
                                    "                                                        </div>\n" +
                                    "                                                    </form>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                            <a href=\"/DeleteAlert/"+data[i].alert_id +"\" rel=\"tooltip\" class=\"btn  btn-danger btn-simple\">\n" +
                                    "                                                <i class=\"material-icons\">delete</i> حذف \n" +
                                    "                                            </a>\n" +
                                    "                                            <button data-toggle=\"modal\" id=\"statebtn\" data-target=\"#show"+i+"\" type=\"button\" rel=\"tooltip\" class=\"btn TableEditBtn btn-info btn-simple\">\n" +
                                    "                                                <i class=\"material-icons\">visibility</i> نمایش\n" +
                                    "                                            </button>\n" +
                                    "                                            <div class=\"modal fade\" id=\"show"+i+"\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"testLabel\" aria-hidden=\"true\">\n" +
                                    "                                                <div class=\"modal-dialog\" role=\"document\">\n" +
                                    "                                                    <div class=\"modal-content\">\n" +
                                    "                                                            <div class=\"modal-header\">\n" +
                                    "                                                                <h5 class=\"modal-title \" id=\"edit1Label\"> نمایش متن </h5>\n" +
                                    "                                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n" +
                                    "                                                                    <span aria-hidden=\"true\">&times;</span>\n" +
                                    "                                                                </button>\n" +
                                    "                                                            </div>\n" +
                                    "                                                            <div class=\"modal-body\">\n" +
                                    "                                                                <p>\n"  + data[i].description +
                                    "                                                                </p>\n" +
                                    "                                                            </div>\n" +
                                    "                                                    </div>\n" +
                                    "                                                </div>\n" +
                                    "                                            </div>\n" +
                                    "                                        </td>" +
                                    "</tr>" ;

                                $('#alertData').append(html);

                            }

                        }else{
                            html = '<tr> <td colspan="6"> <h6 class="py-5 text-center"> موردی یافت نشد ! </h6> </td> </tr>';
                            $('#alertData').html(html);
                        }
                        $('#id').val($('#Location_id').val());
                        endAdd ='<tr>' +
                                    '<td class="text-right" colspan="6">' +
                                        '<span data-toggle="modal" id="statebtn" data-target="#AddAlert" class="btn btn-success  mt-2 mr-auto">\n' +
                                            '<i class="material-icons"> add_circle_outline </i> افزودن اعلان \n' +
                                        '</span>' +
                                    '</td> ' +
                                '</tr>' ;
                        $('#alertData').append(endAdd);
                        AjaxDate();
                        $('.selectpicker').selectpicker('refresh');

                        $('#loader').hide();

                }
                });
            });
        });

        function AjaxDate (){
            $("[id^='FromDate'] , [id^='ToDate']").persianDatepicker({
                initialValue: true,
                autoClose : true ,
                format: 'YYYY/MM/DD HH:mm',
                calendar:{
                    persian:{
                        locale: 'fa'
                    }
                },navigator:{
                    scroll:{
                        enabled:false
                    }
                } ,
                timePicker:{
                    enabled : true
                }
            });
        }

    </script>
@endsection
