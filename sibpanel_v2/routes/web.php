<?php

use App\Api\Api;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes Created By AmirHosseinAghaee
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Login Routes
Route::post('/login' , 'AuthController@login')->name('login');
Route::get('/login' ,'AuthController@loginPage' )->name('login');
//--------------------------------


Route::middleware(['CheckLogin'])->group(function () {

    // OTP Route
    Route::get('/otp' , 'AuthController@otpIndex')->name('otp');

    Route::middleware(['otp'])->group(function () {

        // loading Route
        Route::post('/locationCache' , 'LoadingController@locationCache')->name('locationCache');
        Route::post('/ServiceList' , 'LoadingController@ServiceList')->name('ServiceList');
        Route::post('/ProvinceList' , 'LoadingController@ProvinceList')->name('ProvinceList');
        Route::post('/SellerUserListCashe' , 'LoadingController@SellerUserList')->name('SellerUserListCashe');
        Route::post('/SaleTypeListCashe' , 'LoadingController@SaleTypeList')->name('SaleTypeListCashe');
        Route::post('/VoucherTypeListCashe' , 'LoadingController@VoucherTypeList')->name('VoucherTypeListCashe');
        Route::post('/GetInfoCashe' , 'LoadingController@GetInfo')->name('GetInfoCashe');
        Route::post('/GetVoucherTextCashe' , 'LoadingController@GetVoucherText')->name('GetVoucherTextCashe');

        // home Dashboard
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('loading' , 'LoadingController@index')->name('loading');
        // terminals Route
        Route::get('/terminals' , 'terminalController@index' )->name('terminals');
        Route::post('/AddClearingAccount/{id}' , 'terminalController@AddClearingAccount' )->name('AddClearingAccount');
        Route::get('/terminalInfo/{id}' , 'terminalController@TerminalInfo' )->name('terminalInfo');
        Route::get('/TerminalLocationList/{id}' , 'terminalController@TerminalLocationList' )->name('TerminalLocationList');
        Route::post('/AssignTerminal/{id}' , 'terminalController@AssignTerminal' )->name('AssignTerminal');
        Route::post('/EditAssignTerminal/{id}' , 'terminalController@EditAssignTerminal' )->name('EditAssignTerminal');

        // Location or Place Route
        Route::get('/places' , 'LocationController@index' )->name('places');
        Route::post('/AddLocation' , 'LocationController@AddLocation')->name('AddLocation');
        Route::post('/EditLocation/{id}' , 'LocationController@EditLocation')->name('EditLocation');
        Route::post('/DeleteLocation/{id}' , 'LocationController@DeleteLocation')->name('DeleteLocation');
        Route::post('/LocationActivation' ,'LocationController@LocationActivation' )->name('LocationActivation');
        Route::post('/PosPrintActivation' ,'LocationController@PosPrintActivation' )->name('PosPrintActivation');
        Route::post('/QRActivation' ,'LocationController@QRActivation' )->name('QRActivation');
        Route::get('/citizenPanel/{id}' , 'LocationController@citizenPanel')->name('citizenPanel');
        Route::get('/getLocationFilter' , 'LocationController@getLocationFilter')->name('getLocationFilter');
        Route::post('/GetVoucherTextLoc'  , 'LocationController@GetVoucherText' )->name('GetVoucherTextLoc');

        // Citizen
        Route::post('/FullDescription/{id}' , 'LocationController@FullDescription')->name('FullDescription');
        Route::post('/ShortDescription/{id}' , 'LocationController@ShortDescription')->name('ShortDescription');
        Route::post('/AddLatLong/{id}' , 'LocationController@AddLatLong')->name('AddLatLong');
        Route::post('/AddMainPicture/{id}' , 'LocationController@AddMainPicture')->name('AddMainPicture');
        Route::post('/AddLogoPicture/{id}' , 'LocationController@AddLogoPicture')->name('AddLogoPicture');
        Route::post('/AddGalleryPicture/{id}' , 'LocationController@AddGalleryPicture')->name('AddGalleryPicture');
        Route::post('/AddMainEventPicture/{id}' , 'LocationController@AddMainEventPicture')->name('AddMainEventPicture');
        Route::get('/imageRemove/{id?}' , 'LocationController@imageRemove')->name('imageRemove');

        // services Route
        Route::get('/GetService/{id}' ,'LocationController@GetService' )->name('GetService');
        Route::get('/VoucherInfoList/{service_id}/{location_id}' ,'LocationController@VoucherInfoList' )->name('VoucherInfoList');
        Route::post('/AddService/{location_id}' ,'LocationController@AddService' )->name('AddService');
        Route::post('/EditService/{service_id}/{location_id}' ,'LocationController@EditService' )->name('EditService');
        Route::post('/DeleteService/{service_id}' ,'LocationController@DeleteService' )->name('DeleteService');
        Route::post('/ServiceActivation' ,'LocationController@ServiceActivation' )->name('ServiceActivation');
        Route::post('/AddServicePicture/{id?}' ,'LocationController@AddServicePicture' )->name('AddServicePicture');

        // Voucher Route
        Route::post('/AddVoucherInfo/{service_id}/{location_id}' ,'LocationController@AddVoucherInfo' )->name('AddVoucherInfo');
        Route::post('/EditVoucherInfo/{service_id}/{location_id}/{id}' ,'LocationController@EditVoucherInfo' )->name('EditVoucherInfo');
        Route::post('/CancelVoucher' ,'VoucherController@CancelVoucher' )->name('CancelVoucher');
        Route::get('/voucherTypeList'  , 'VoucherController@VoucherTypeList' )->name('voucherTypeList');
        Route::post('/AddVoucherType'  , 'VoucherController@AddVoucherType' )->name('AddVoucherType');
        Route::post('/EditVoucherType/{id}'  , 'VoucherController@EditVoucherType' )->name('EditVoucherType');
        Route::post('/AddVoucherPicture/{id?}' ,'LocationController@AddVoucherPicture' )->name('AddVoucherPicture');

        //VoucherText
        Route::get('/DeleteVoucherText/{id}'  , 'VoucherController@DeleteVoucherText' )->name('DeleteVoucherText');
        Route::get('/voucherText'  , 'VoucherController@GetVoucherText' )->name('voucherText');
        Route::post('/AddVoucherText'  , 'VoucherController@AddVoucherText' )->name('AddVoucherText');
        Route::post('/EditVoucherText/{id}'  , 'VoucherController@EditVoucherText' )->name('EditVoucherText');

        //UserManagment
        Route::get('/UserManager'  , 'UserManagerController@index' )->name('UserManager');
        Route::get('/setUserPermission/{id?}'  , 'UserManagerController@setUserPermission' )->name('setUserPermission');
        Route::post('/RegisterUser'  , 'UserManagerController@RegisterUser' )->name('RegisterUser');
        Route::post('/AssignPermission'  , 'UserManagerController@AssignPermission' )->name('AssignPermission');
        Route::post('/EditUser/{id?}'  , 'UserManagerController@RegisterUser' )->name('EditUser');
        Route::post('/GetUserInfo'  , 'UserManagerController@GetUserInfo' )->name('GetUserInfo');
        Route::post('/getUserWithFilter'  , 'UserManagerController@getUserWithFilter' )->name('getUserWithFilter');
        Route::post('/getUserWithAlphabet'  , 'UserManagerController@getUserWithAlphabet' )->name('getUserWithAlphabet');
        Route::post('/UserActivation'  , 'UserManagerController@UserActivation' )->name('UserActivation');


        //Report Route
        Route::get('/Report' , 'ReportController@index')->name('Report');
        Route::post('/CityList'  , 'ReportController@CityList' )->name('CityList');
        Route::post('/location_list'  , 'ReportController@location_list' )->name('location_list');
        Route::post('/ServiceListReport'  , 'ReportController@ServiceList' )->name('ServiceListReport');
        Route::post('/ReportTerminalLocationList'  , 'ReportController@TerminalLocationList' )->name('ReportTerminalLocationList');
        Route::get('/GetStat'  , 'ReportController@GetStat' )->name('GetStat');
        Route::get('/GetTransaction'  , 'ReportController@GetTransaction' )->name('GetTransaction');

        // Transaction Route
        Route::get('/transaction' ,'ReportController@transaction')->name('transaction');
        Route::get('/transactionToExcel' ,'ReportController@transactionToExcel')->name('transactionToExcel');

        // Place & Province Route
        Route::get('/stateMg' , 'provinceController@index')->name('stateMg');
        Route::get('/cityMg/{id}'  , 'provinceController@CityList' )->name('cityMg');
        Route::post('/AddProvince'  , 'provinceController@AddProvince' )->name('AddProvince');
        Route::post('/EditProvince/{id}'  , 'provinceController@EditProvince' )->name('EditProvince');
        Route::post('/AddCity/{id}'  , 'provinceController@AddCity' )->name('AddCity');
        Route::post('/EditCity/{id}'  , 'provinceController@EditCity' )->name('EditCity');

        // Sans Route
        Route::get('/group_times' , 'SeanceController@group_times')->name('group_times');
        Route::post('/apply_edit_group_time' , 'SeanceController@edit_time_group')->name('apply_edit_group_time');
        Route::get('/add_group_time' , 'SeanceController@add_group_time_index')->name('add_group_time_index');
        Route::post('/add_group_time' , 'SeanceController@add_group_time')->name('add_group_time');
        Route::post('/edit_group_time' , 'SeanceController@edit_group_time_index')->name('edit_group_time');
        Route::post('/edit_group_time_apply' , 'SeanceController@edit_group_time')->name('edit_group_time_apply');


        //Alert Route
        Route::get('/alerts' , 'AlertController@index')->name('alerts');
        Route::post('/getAlert' , 'AlertController@getAlert')->name('getAlert');
        Route::post('/AddAlert' , 'AlertController@AddAlert')->name('AddAlert');
        Route::get('/DeleteAlert/{id}' , 'AlertController@DeleteAlert')->name('DeleteAlert');
        Route::get('/EditAlert/{id}' , 'AlertController@EditAlert')->name('EditAlert');

        // presel Route
        Route::get('/presellManger' , 'presellController@index')->name('presellManger');
        Route::post('/GetAccountProvince' , 'presellController@GetAccountProvince')->name('GetAccountProvince');
        Route::post('/SetAccountSetting/{id?}' , 'presellController@SetAccountSetting')->name('SetAccountSetting');

    });

});

Route::get('/test' , 'AuthController@test');
Route::get('/testrem' , 'AuthController@testrem');
Route::get('/logout' , 'AuthController@logout')->name('logout');



