@extends('MainLayout')

@section('title')
    <title>
        گزارش های در حال تولید
    </title>

@endsection

@section('content')


    <div class="modal fade" id="headers_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">کلید های جستجو</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table  class="table table-striped text-right">
                        <tbody id="search_table">

                        </tbody>

                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div id="loader" style="position: fixed;z-index: 9999999;left: 0;right: 0;top: 0;bottom: 0;display: flex;justify-content: center;align-items: center;background: #ffffff61; display: none">
            <div class="spinner-border mx-auto d-block mb-3" style="width: 80px;height: 80px;color: #5e5e5e;"></div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose titleStyle">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="card-icon float-right ml-3 mr-0">
                                        <i class="material-icons">bar_chart</i>
                                    </div>
                                    <h4 class="card-title text-right font-weight-bold "> صف تولید گزارش ها </h4>
                                </div>
                                <div class="col-sm">
                                    <a href="{{Route("dashboard")}}" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissable text-right" style="font-size: 16px;color: #0a0a0a;margin: 15px" role="alert">
                                <button type="button" class="close" style="position: absolute;margin-left: 10px;margin-top: 5px" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>توجه: </strong> گزارش ها پس از ۷ روز بصورت خودکار حذف میشوند

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive table-striped">
                                <table  id="userInfo" class="table text-center">
                                    <thead class=" text-primary">
                                    <tr class="">
                                        <th >
                                            تاریخ ایجاد
                                        </th>
                                        <th >
                                            وضعیت پیشرفت
                                        </th>
                                        <th >
                                            کلید ها
                                        </th>
                                        <th >
                                            دانلود
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jobs as $job)
                                        <tr class="">
                                            <th style="direction: ltr">{{$job['date']}}</th>
                                            <th>
                                                @php
                                                    if ($job['current_page'] > 0 ){
                                                        echo round(($job['current_page'] * 100)/$job['total_pages']) . '%';
                                                    }else if ($job['current_page'] == -2){
                                                        echo 'در صف انتظار';
                                                    }else
                                                        echo 'در حال پردازش';
                                                @endphp
                                            </th>
                                            <th><button class="btn btn-info" onclick="show_headers(this)" data="{{$job['search_headers']}}" ><i class="fa fa-eye"></i>نمایش</button></th>
                                            <th>
                                                @if($job['finished'])
                                                    <button onclick="download({{$job['job_id']}})" class="btn btn-success">دانلود</button>
                                                @endif
                                            </th>

                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('AddJs')
<script>

    function show_headers(element){

        let json = JSON.parse(element.getAttribute("data"));

        let tbl = $("#search_table");
        tbl.empty();

        for (let key in json){
            tbl.append(
                '<tr><th>' +key+
                '</th>'+
                '<th>'+ json[key]+
                '</th></th>');
        }

        $('#headers_modal').modal('toggle')

    }

    function download(id){
        $.ajax({
            type:'POST',
            url:"{{Route('export_dl')}}",
            dataType:'json',
            data:{
                '_token ': "{{ csrf_token() }}",
                'job_id' : id ,
            },
            success:function(data) {
                console.log(data);
                window.open(data['link']);
            }
        });
    }

</script>
@endsection
