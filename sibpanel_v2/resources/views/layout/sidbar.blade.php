<div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/sidebar-3.jpg">
    <div style="z-index: 100;position: absolute;left: 22px;top: 7px;  " class="navbar-wrapper">
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-just-icon btn-primary btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
            </button>
        </div>
        <a class="navbar-brand" href="javascript:;"> </a>
    </div>
    <button class="navbar-toggler" style="position: absolute;" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar mt-1"></span>
        <span class="navbar-toggler-icon icon-bar mt-1"></span>
        <span class="navbar-toggler-icon icon-bar mt-1"></span>
    </button>


    <div class="logo">

        <a href="http://www.creative-tim.com" class="simple-text logo-mini">

        </a>
        <a href="/" class="simple-text logo-normal">
            {{ config('app.PROJECT_NAME') }}
        </a></div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{asset('')}}assets/img/faces/card-profile1-square.jpg" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                  {{ session('UserInfo')['first_name']  . " "  . session('UserInfo')['last_name'] }}
{{--                <b class="caret"></b>--}}
              </span>
                </a>
               {{-- <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> MP </span>
                                <span class="sidebar-normal"> پروفایل من  </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> EP </span>
                                <span class="sidebar-normal"> ویرایش پروفایل </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> تنظیمات </span>
                            </a>
                        </li>
                    </ul>
                </div>--}}
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item ">
                <a class="nav-link" href="/">
                    <i class="material-icons">dashboard</i>
                    <p> داشبورد </p>
                </a>
            </li>
            @php
                $ReportUrl = ['Report','transaction'] ;
            @endphp
            <li class="nav-item @if(in_array(Route::current()->getName(),$ReportUrl))  active  @endif">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">receipt_long</i>
                    <p> گزارش ها
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse  @if(in_array(Route::current()->getName(),$ReportUrl))  show  @endif" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item @if(Route::is("Report") && !str_contains( url()->full() , '?')) )  active  @endif">
                            <a class="nav-link" href="{{Route('Report')}}">
                                <span class="sidebar-mini">  <i class="material-icons">assignment</i> </span>
                                <span class="sidebar-normal"> گزارش تجمیعی </span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::is("transaction") && !str_contains( url()->full() , '?')) )  active  @endif  ">
                            <a class="nav-link" href="{{Route('transaction')}}">
                                <span class="sidebar-mini">  <i class="material-icons">article</i> </span>
                                <span class="sidebar-normal"> ریز تراکنش ها </span>
                            </a>
                        </li>
                        @if(session('UserInfo')['presell'])
                            <li class="nav-item @if(Route::is("Report") && str_contains( url()->full() , '?')) )  active  @endif">
                                <a class="nav-link" href="{{Route('Report')."?reportType=1"}}">
                                    <span class="sidebar-mini"> <i class="material-icons">assignment</i> </span>
                                    <span class="sidebar-normal"> گزارش تجمیعی پیش فروش </span>
                                </a>
                            </li>
                            <li class="nav-item @if(Route::is("transaction*") && str_contains(url()->full() , '?') )  active  @endif">
                                <a class="nav-link" href="{{Route('transaction')."?reportType=1"}}">
                                    <span class="sidebar-mini"><i class="material-icons">article</i></span>
                                    <span class="sidebar-normal"> ریز تراکنش های پیش فروش </span>
                                </a>
                            </li>
                        @endif
                        {{--<li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/register.html">
                                <span class="sidebar-mini"> RP </span>
                                <span class="sidebar-normal"> Register Page </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/lock.html">
                                <span class="sidebar-mini"> LSP </span>
                                <span class="sidebar-normal"> Lock Screen Page </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/user.html">
                                <span class="sidebar-mini"> UP </span>
                                <span class="sidebar-normal"> User Profile </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/pages/error.html">
                                <span class="sidebar-mini"> E </span>
                                <span class="sidebar-normal"> Error Page </span>
                            </a>
                        </li>--}}
                    </ul>
                </div>
            </li>
            @php
            $serviceUrl = ['places','stateMg','voucherTypeList','voucherText' , 'UserManager' , 'group_times' ] ;
            @endphp
            <li class="nav-item @if(in_array(Route::current()->getName(),$serviceUrl))  active  @endif">
                <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
                    <i class="material-icons">apps</i>
                    <p>   خدمات
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if(in_array(Route::current()->getName(),$serviceUrl))  show  @endif" id="componentsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{Route('terminals')}}">
                                <span class="sidebar-mini"> <i class="material-icons">dvr</i> </span>
                                <span class="sidebar-normal"> مدیریت ترمینال ها </span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::current()->getName() === 'places' )  active  @endif">
                            <a class="nav-link" href="{{Route('places')}}">
                                <span class="sidebar-mini"> <i class="material-icons">room</i> </span>
                                <span class="sidebar-normal"> مدیریت مکان ها  </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="#" data-toggle="modal" data-target="#deleteVoucher" class="nav-link" >
                                <span class="sidebar-mini"> <i class="material-icons">backspace</i>   </span>
                                <span class="sidebar-normal"> باطل کردن بلیت </span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::current()->getName() === 'stateMg' )  active  @endif">
                            <a class="nav-link" href="{{Route('stateMg')}}">
                                <span class="sidebar-mini"> <i class="material-icons">location_city</i> </span>
                                <span class="sidebar-normal"> مدیریت استان ها و شهر ها </span>
                            </a>
                        </li>
                        <li class="nav-item  @if(Route::current()->getName() === 'voucherTypeList' )  active  @endif">
                            <a class="nav-link" href="{{Route('voucherTypeList')}}">
                                <span class="sidebar-mini"> <i class="material-icons">confirmation_number</i> </span>
                                <span class="sidebar-normal"> مدیریت نوع بلیت </span>
                            </a>
                        </li>
                        <li class="nav-item @if(Route::current()->getName() === 'voucherText' )  active  @endif ">
                            <a class="nav-link" href="{{Route('voucherText')}}">
                                <span class="sidebar-mini"> <i class="material-icons">format_size</i> </span>
                                <span class="sidebar-normal"> مدیریت متن بلیت </span>
                            </a>
                        </li>
                        <li class="nav-item  @if(Route::current()->getName() === 'UserManager' )  active  @endif">
                            <a class="nav-link" href="{{Route('UserManager')}}">
                                <span class="sidebar-mini">  <i class="material-icons">group</i>  </span>
                                <span class="sidebar-normal"> مدیریت کاربران </span>
                            </a>
                        </li>
                        <li class="nav-item  @if(Route::current()->getName() === 'group_times' )  active  @endif">
                            <a class="nav-link" href="{{Route('group_times')}}">
                                <span class="sidebar-mini"> <i class="material-icons"> watch_later </i>  </span>
                                <span class="sidebar-normal"> مدیریت سانس ها </span>
                            </a>
                        </li>
                        <li class="nav-item  @if(Route::current()->getName() === 'alerts' )  active  @endif">
                            <a class="nav-link" href="{{Route('alerts')}}">
                                <span class="sidebar-mini"> <i class="material-icons"> notifications_active </i>  </span>
                                <span class="sidebar-normal"> مدیریت اعلان ها </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
           {{-- <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#formsExamples">
                    <i class="material-icons">content_paste</i>
                    <p>خروج
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="formsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/forms/regular.html">
                                <span class="sidebar-mini"> RF </span>
                                <span class="sidebar-normal"> Regular Forms </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/forms/extended.html">
                                <span class="sidebar-mini"> EF </span>
                                <span class="sidebar-normal"> Extended Forms </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/forms/validation.html">
                                <span class="sidebar-mini"> VF </span>
                                <span class="sidebar-normal"> Validation Forms </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/forms/wizard.html">
                                <span class="sidebar-mini"> W </span>
                                <span class="sidebar-normal"> Wizard </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
                    <i class="material-icons">grid_on</i>
                    <p> Tables
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="tablesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/tables/regular.html">
                                <span class="sidebar-mini"> RT </span>
                                <span class="sidebar-normal"> Regular Tables </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/tables/extended.html">
                                <span class="sidebar-mini"> ET </span>
                                <span class="sidebar-normal"> Extended Tables </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/tables/datatables.net.html">
                                <span class="sidebar-mini"> DT </span>
                                <span class="sidebar-normal"> DataTables.net </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#mapsExamples">
                    <i class="material-icons">place</i>
                    <p> Maps
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="mapsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/maps/google.html">
                                <span class="sidebar-mini"> GM </span>
                                <span class="sidebar-normal"> Google Maps </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/maps/fullscreen.html">
                                <span class="sidebar-mini"> FSM </span>
                                <span class="sidebar-normal"> Full Screen Map </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="../examples/maps/vector.html">
                                <span class="sidebar-mini"> VM </span>
                                <span class="sidebar-normal"> Vector Map </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
            <li class="nav-item ">
                <a class="nav-link" href="{{Route('logout')}}">
                    <i class="material-icons">login</i>
                    <p> خروج </p>
                </a>
            </li>
          {{--  <li class="nav-item ">
                <a class="nav-link" href="../examples/charts.html">
                    <i class="material-icons">timeline</i>
                    <p> Charts </p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="../examples/calendar.html">
                    <i class="material-icons">date_range</i>
                    <p> Calendar </p>
                </a>
            </li>--}}
        </ul>
    </div>
</div>
<div class="modal fade" id="deleteVoucher" tabindex="-1" role="dialog" aria-labelledby="testLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{Route('CancelVoucher')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  font-weight-bold" id="testLabel"> حذف بلیت </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row mt-3">
                        <div class="col-sm-12">
                            <h5 class="text-right"> برای حذف بلیت شماره بلیت مورد نظر را وارد کنید: </h5>
                            <input name="voucher_number" type="text" class="form-control" placeholder="شماره بلیت">
                        </div>
                    </div>

                </div>
                <div class="modal-footer mt-4">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن </button>--}}
                    <button type="submit" class="btn px-5  btn-danger ml-0 mr-auto"> حذف </button>
                </div>
            </div>
        </form>

    </div>
</div>
