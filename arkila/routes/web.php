<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

//Made by Randall

//Route::get('/randall', 'VansController@index')
//Route::resource('/driver-test', 'DriverViewTestController');
Route::get('/randall', 'RandallController@index');

Route::get('/driver-profile', function(){
    return view('drivermodule.report.driverReport');
});


Route::get('/driver-profile', function(){
    return view('drivermodule.report.driverReport');
});
Route::get('/login', 'LoginTestController@index');


Route::get('/driver-profile', function(){
    return view('drivermodule.report.driverReport');
});

Route::get('/teo', function(){
    return view('rental.newcreate');
});



Route::resource('/angelo', 'EmailtestController');

Route::get('/dixon', 'TripsController@index');

Route::get('/demo', function(){
  return new App\Mail\ResetPasswordMail();
});


Route::get('/', function () {
    return view('welcome');


});
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('home/ledger', 'DailyLedgerController');

Route::resource('home/announcements', 'AnnouncementsController');


//Operators
Route::resource('home/operators', 'OperatorsController');
Route::get('home/operators/profile/{operator}','OperatorsController@showProfile')->name('operators.showProfile');

/************ Drivers ******************************/
Route::resource('home/drivers', 'DriversController');
Route::patch('home/drivers/{driver}/archive', 'DriversController@archiveDelete')->name('drivers.archiveDelete');

//Adding a driver to a specific operator
Route::get('home/operators/{operator}/drivers/create', 'DriversController@createFromOperator')->name('drivers.createFromOperator');
Route::post('home/operators/{operator}/drivers/', 'DriversController@storeFromOperator')->name('drivers.storeFromOperator');

//Adding a driver to a specific van
Route::get('home/vans/{vanNd}/drivers/create', 'DriversController@createFromVan')->name('drivers.createFromVan');
Route::post('home/vans/{vanNd}/drivers/', 'DriversController@storeFromVan')->name('drivers.storeFromVan');

//Give the list of certain drivers
Route::post('/listDrivers','VansController@listDrivers')->name('vans.listDrivers');
/****************************************************/

/************ Vans ******************************/
Route::resource('home/vans', 'VansController', [
    'except' => ['show']
]);
//Creating Vans
Route::get('home/operators/{operator}/vans/create', 'VansController@createFromOperator')->name('vans.createFromOperator');
Route::post('home/operators/{operator}/vans', 'VansController@storeFromOperator')->name('vans.storeFromOperator');

//Give the info of a van
Route::post('/vanInfo','VansController@vanInfo')->name('vans.vanInfo');
/****************************************************/

/************ Settings ******************************/
Route::resource('home/settings/destinations', 'DestinationController', [
	'except' => ['index']
]);

Route::resource('home/settings/terminal', 'TerminalController', [
	'except' => ['index']
]);

Route::resource('home/settings/fees', 'FeesController', [
    'except' => ['index',]
]);
Route::resource('home/settings/discounts', 'DiscountsController', [
    'except' => ['index']
]);
Route::get('home/settings', 'HomeController@settings');
/****************************************************/

/************ User Management ******************************/
Route::get('home/user-management', 'HomeController@usermanagement');

Route::resource('home/user-management/admin', 'AdminUserManagementController', [
	'except' => ['index','destroy'],
	'parameters' => ['admin' => 'admin_user']
]);
Route::post('home/user-management/admin/change-status', array('as' => 'changeAdminStatus','uses' => 'AdminUserManagementController@changeAdminStatus'));

//Route::get('password/reset/{token}/{email}', array('as' => 'getResetPass', 'uses' => 'Auth\ResetPasswordController@showResetForm'));
//Route::post('password/reset', array('as' => 'resetPass', 'uses' => 'Auth\ResetPasswordController@reset'));

//Route::patch('home/user-management/admin/{admin_user}/{token}', 'AdminUserManagementController@update');

Route::resource('home/user-management/driver', 'UserDriversManagementController', [
	'except' => ['index','store', 'create','edit','destroy'],
	'parameters' => ['driver' => 'driver_user']

]);
Route::post('home/user-management/drivers/change-status', array('as' => 'changeDriverStatus','uses' => 'UserDriversManagementController@changeDriverStatus'));

Route::resource('home/user-management/customer', 'CustomerUserManagementController', [
	'except' => ['index','store', 'create','edit','destroy'],
	'parameters' => ['customer' => 'customer_user']
]);
Route::post('home/user-management/customer/change-status', array('as' => 'changeCustomerStatus','uses' => 'CustomerUserManagementController@changeCustomerStatus'));
/****************************************************/

Route::resource('home/test', 'TestController');
Route::resource('home/testing', 'TestingController');
Route::resource('home/reservations', 'ReservationsController');

Route::get('home/archive', 'HomeController@archive');

Route::resource('home/rental', 'RentalsController');
Route::resource('home/triptest', 'TripsController');


/* Trips */
Route::post('home/trips/{destination}/{van}/{driver}', 'TripsController@store')->name('trips.store');
Route::resource('home/trips', 'TripsController',[
    'except' =>['store']
]);
Route::post('/vanqueue', 'TripsController@updateVanQueue')->name('trips.updateVanQueue');


/********Archive ********/
Route::patch('home/vans/{van}/archiveVan', 'VansController@archiveDelete')->name('vans.archiveDelete');

/*************************************Driver Module****************************/

/********************Dashboard************************/
Route::group(['middleware' => ['auth', 'driver']], function(){
  Route::get('home/driver-dashboard', 'DriverModuleControllers\DriverHomeController@index')->name('drivermodule.dashboard');
  Route::get('home/view-queue', 'DriverModuleControllers\ViewVanQueueController@showVanQueue')->name('drivermodule.viewQueue');
  Route::get('home/view-announcement', 'DriverModuleControllers\ViewAnnouncementsController@showAnnouncement')->name('drivermodule.viewAnnouncement');
});

Route::get('home/try', 'PassController@index');


Route::get('home/profile', 'DriverModuleControllers\DriverProfileController@index');
/******************************************************/

/******************************************************************************/
