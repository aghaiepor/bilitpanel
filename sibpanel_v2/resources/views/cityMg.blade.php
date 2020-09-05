@extends('MainLayout')

@section('title')
    <title>
        مدیریت استان
    </title>
@endsection

@section('content')
    <div class="content">
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
                                    <h4 class="card-title text-right font-weight-bold "> اطلاعات شهر های موجود </h4>
                                </div>
                                <div class="col-sm">
                                    <span data-toggle="modal" id="statebtn" data-target="#test"  class="btn btn-success  mt-2 pr-1"><i class="material-icons"> add_circle_outline </i>  افزودن شهر</span>

                                    <a onclick="history.go(-1);" class="btn btn-dark  mt-2 pl-1"> بازگشت <i class="material-icons"> arrow_back </i>  </a>

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
                                            نام شهر
                                        </th>
                                        <th >
                                            ویرایش شهر
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0 @endphp
                                    @if(count($citys) == 0)
                                        <tr>
                                            <td colspan="2">
                                                <h6 class="text-center py-5"> شهری وجود ندارد !  </h6>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($citys as $city)
                                            <tr>
                                                <td>
                                                    {{$city['city_name']}}
                                                </td>
                                                <td>
                                                    <button data-toggle="modal" id="statebtn" data-target="#edit{{$i}}" type="button" rel="tooltip" class="btn TableEditBtn btn-success btn-simple">
                                                        <i class="material-icons">edit</i>
                                                        ویرایش
                                                    </button>
                                                    <div class="modal fade" id="edit{{$i}}" tabindex="-1" role="dialog" aria-labelledby="edit1Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <form action="{{Route('EditCity' , ['id' =>$city['id']])}}" method="post">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title " id="edit1Label"> ویرایش شهر </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-row mt-4">
                                                                            <div class="col-sm-6">
                                                                                <input name="city" value="{{$city['city_name']}}" autocomplete="off" type="text" class="form-control" id="nameStateFa" placeholder="نام  شهر">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <input name="city_english_name" value="{{$city['city_english_name']}}" autocomplete="off" type="text" class="form-control" id="nameStateEn" placeholder=" نام  شهر به انگلیسی">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer mt-4">
                                                                        {{--                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                                                                        <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> ویرایش </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <button type="button" rel="tooltip" class="btn TableEditBtn btn-danger btn-simple">
                                                        <i class="material-icons">close</i>
                                                        حدف
                                                    </button>
                                                </td>

                                            </tr>
                                            @php $i++ ; @endphp
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
<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('AddCity' , ['id' =>$ProvinceId ])}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="testLabel"> افزودن شهر </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-4">
                        <div class="col-sm text-right">
                            <label for=""> نام شهر </label>
                            <input name="city" autocomplete="off" type="text" class="form-control" id="nameStateFa" placeholder="نام  شهر">
                        </div>
                        <div class="col-sm text-right">
                            <label for=""> نام  شهر به انگلیسی </label>
                            <input name="city_english_name" autocomplete="off" type="text" class="form-control" id="nameStateEn" placeholder=" نام  شهر به انگلیسی">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    {{--                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">بستن </button>--}}
                    <button type="submit" class="btn btn-success px-5 ml-0 mr-auto"> افزودن </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
@section('AddJs')
 {{--   <script>
        $(document).ready(function () {
            $(document).on('click' , '#statebtn' , function () {
                setInterval(function () {
                    $('.modal-backdrop').remove();
                } , 250)
            });

        });
    </script>--}}

@endsection
