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

Auth::routes();


/*Log in*/
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
/*Email Verification*/
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
/*Success Registration*/
Route::get('/home/register/success', 'Auth\SuccessRegistrationController@successRegistration');

Route::get('/ticketmanagement','TransactionsController@manage');



Route::get('/', 'CustomerModuleControllers\CustomerNonUserHomeController@indexNonUser')->name('customermodule.non-user.index');
/***********************Super-Admin Module************************************/
/*****************************************************************************/
 Route::group(['middleware' => ['auth', 'super-admin']], function(){
    Route::get('/home/superadmin-dashboard', 'HomeController@index')->name('home');
    Route::post('/home/restoreDatabase','RestoreDatabaseController@restoreDatabase')->name('home.restoreDatabase');
    Route::resource('/home/ledger', 'DailyLedgerController');

    Route::resource('/home/announcements', 'AnnouncementsController');
    Route::resource('/home/route', 'RoutesController',[
        'except' => ['destroy', 'update', 'show', 'edit']
    ]);

    //Operators
    Route::resource('/home/operators', 'OperatorsController',[
        'except' => ['destroy']
    ]);
    Route::delete('/home/operators/{archivedOperator}','OperatorsController@destroy')->name('operators.destroy');

    Route::get('/home/operators/profile/{operator}','OperatorsController@showProfile')->name('operators.showProfile');

    /************ Drivers ******************************/
    Route::resource('/home/drivers', 'DriversController');

    //Adding a driver to a specific operator
    Route::get('/home/operators/{operator}/drivers/create', 'DriversController@createFromOperator')->name('drivers.createFromOperator');
    Route::post('/home/operators/{operator}/drivers/', 'DriversController@storeFromOperator')->name('drivers.storeFromOperator');

    //Adding a driver to a specific van
    Route::get('/home/vans/{vanNd}/drivers/create', 'DriversController@createFromVan')->name('drivers.createFromVan');
    Route::post('/home/vans/{vanNd}/drivers/', 'DriversController@storeFromVan')->name('drivers.storeFromVan');

    //Give the list of certain drivers
    Route::post('/listDrivers','VansController@listDrivers')->name('vans.listDrivers');
    /****************************************************/

    /************ Vans ******************************/
    Route::resource('/home/vans', 'VansController', [
        'except' => ['show']
    ]);
    //Creating Vans
    Route::get('/home/operators/{operator}/vans/create', 'VansController@createFromOperator')->name('vans.createFromOperator');
    Route::post('/home/operators/{operator}/vans', 'VansController@storeFromOperator')->name('vans.storeFromOperator');

    //Give the info of a van
    Route::post('/vanInfo','VansController@vanInfo')->name('vans.vanInfo');
    /****************************************************/

    /************ Settings ******************************/
    Route::resource('/home/settings/destinations', 'DestinationController', [
        'except' => ['index','show']
    ]);

    Route::resource('/home/settings/terminal', 'TerminalController', [
        'except' => ['index','show']
    ]);

    Route::resource('/home/settings/fees', 'FeesController', [
        'except' => ['index','show']
    ]);
    Route::resource('/home/settings/discounts', 'DiscountsController', [
        'except' => ['index', 'show']
    ]);

    Route::resource('/home/settings/tickets','TicketsController',[
        'except' => ['index','show']
    ]);
    Route::get('/home/settings', 'HomeController@settings')->name('settings.index');

     Route::post('/home/settings/changeFeature/{feature}', 'HomeController@changeFeatures')->name('settings.changeFeature');

    /****************************************************/

    /************ User Management ******************************/
    Route::get('/home/user-management', 'HomeController@usermanagement')->name('usermanagement.dashboard');

    Route::resource('/home/user-management/admin', 'AdminUserManagementController', [
        'except' => ['index','destroy'],
        'parameters' => ['admin' => 'admin_user']
    ]);
    Route::post('/home/user-management/admin/change-status', array('as' => 'changeAdminStatus','uses' => 'AdminUserManagementController@changeAdminStatus'));

    Route::resource('/home/user-management/driver', 'UserDriversManagementController', [
        'except' => ['index','store', 'create','edit','destroy'],
        'parameters' => ['driver' => 'driver_user']

    ]);
    Route::post('/home/user-management/drivers/change-status', array('as' => 'changeDriverStatus','uses' => 'UserDriversManagementController@changeDriverStatus'));

    Route::resource('/home/user-management/customer', 'CustomerUserManagementController', [
        'except' => ['index','store', 'create','edit','destroy'],
        'parameters' => ['customer' => 'customer_user']
    ]);
    Route::post('/home/user-management/customer/change-status', array('as' => 'changeCustomerStatus','uses' => 'CustomerUserManagementController@changeCustomerStatus'));
    /****************************************************/

    Route::resource('/home/test', 'TestController');
    Route::resource('/home/testing', 'TestingController');

    Route::resource('/home/reservations', 'ReservationsController', [
        'except' => ['show', 'edit']
    ]);

    Route::get('/home/archive', 'HomeController@archive')->name('archive.index');
    Route::get('/home/operatorVanDriver/{operator}', 'HomeController@vanDriver')->name('archive.vanDriver');
    Route::get('/home/archive/profile/{archive}','HomeController@showProfile')->name('archive.showProfile');
    Route::patch('/home/operators/{driver}/archiveDriver', 'DriversController@archiveDriver')->name('drivers.archiveDriver');
    Route::post('/home/operators/{archive}/archiveOperators', 'OperatorsController@archiveOperator')->name('operators.archiveOperator');
    Route::patch('/home/archive/operator/{archivedOperator}/restore','OperatorsController@restoreArchivedOperator')->name('operators.restoreArchivedOperator');
    Route::patch('/home/archive/driver/{archivedDriver}/restore','DriversController@restoreArchivedDriver')->name('driver.restoreArchivedDriver');


    Route::resource('/home/rental', 'RentalsController',[
        'except' => ['show','edit']
    ]);

    Route::resource('/home/admin/profile', 'ProfileController',[
        'except' => ['show','store', 'create', 'destroy']
    ]);

    Route::get('/findDestinationTerminal', 'ReservationsController@find');

    /* Trips */
    Route::resource('/home/trips', 'TripsController',[
        'except' => ['index','create','show','edit','update']
    ]);
    Route::get('/home/terminal', 'AdminCreateDriverReportController@chooseTerminal')->name('trips.admin.chooseDestination');
    Route::get('/home/terminal/{terminals}/create-report', 'AdminCreateDriverReportController@createReport')->name('trips.admin.createReport');
    Route::post('/home/terminal/{terminals}/create-report/store', 'AdminCreateDriverReportController@storeReport')->name('trips.admin.storeReport');

    /* Van Queue */
     //Only working routes are: index and destroy
     Route::resource('/home/vanqueue','VanQueueController',[
         'except' => ['create','show','edit','store','update']
     ]);
     Route::post('/home/vanqueue/{destination}/{van}/{member}', 'VanQueueController@store')->name('vanqueue.store');
     Route::patch('/home/vanqueue/changeDestination/{vanOnQueue}', 'VanQueueController@updateDestination')->name('vanqueue.updateDestination');
     Route::patch('/updateQueueNumber/{vanOnQueue}', 'VanQueueController@updateQueueNumber')->name('vanqueue.updateQueueNumber');
     Route::post('/specialUnitChecker','VanQueueController@specialUnitChecker')->name('vanqueue.specialUnitChecker');
     Route::patch('/home/trips/{vanOnQueue}', 'VanQueueController@updateRemarks')->name('vanqueue.updateRemarks');
     Route::get('/showConfirmationBox/{encodedQueue}','VanQueueController@showConfirmationBox');
     Route::get('/showConfirmationBoxOB/{encodedQueue}','VanQueueController@showConfirmationBoxOb');
     Route::get('/listSpecialUnits/{terminal}','VanQueueController@listSpecialUnits')->name('vanqueue.listSpecialUnits');
     Route::patch('/vanqueue', 'VanQueueController@updateVanQueue')->name('vanqueue.updateVanQueue');
     Route::patch('/putOnDeck/{vanOnQueue}','VanQueueController@putOnDeck')->name('vanqueue.putOnDeck');
     Route::post('/changeRemarksOB/{vanOnQueue}','VanQueueController@changeRemarksOB')->name('vanqueue.changeRemarksOB');
     Route::get('/listQueueNumbers/{terminal}','TripsController@listQueueNumbers')->name('vanqueue.listQueueNumbers');

     /* Transactions(Ticket) */
    Route::resource('/home/transactions', 'TransactionsController',[
        'except' => ['create','show','edit','update']
    ]);
    Route::patch('/home/transactions/{terminal}', 'TransactionsController@update')->name('transactions.update');
    Route::get('/listDestinations/{terminal}','TransactionsController@listDestinations')->name('transactions.listDestinations');
    Route::get('/listTickets/{destination}','TransactionsController@listTickets')->name('transactions.listTickets');
    Route::get('/listDiscountedTickets/{destination}','TransactionsController@listDiscountedTickets')->name('transactions.listDiscountedTickets');
    Route::patch('/updatePendingTransactions', 'TransactionsController@updatePendingTransactions')->name('transactions.updatePendingTransactions');
    Route::patch('/updateOnBoardTransactions', 'TransactionsController@updateOnBoardTransactions')->name('transactions.updateOnBoardTransactions');
    Route::get('/listSourceDrivers','TransactionsController@listSourceDrivers')->name('transactions.listSourceDrivers');
    Route::patch('/changeDriver/{trip}', 'TransactionsController@changeDriver')->name('transactions.changeDriver');
    Route::patch('/home/transactions/changeDestination/{transaction}','TransactionsController@changeDestination')->name('transactions.changeDestination');
    Route::get('/home/transactions/manageTickets','TransactionsController@manageTickets')->name('transactions.manageTickets');
    Route::patch('/home/transactions/refund/{transaction}','TransactionsController@refund')->name('transactions.refund');
    Route::patch('/multipleDelete','TransactionsController@multipleDelete')->name('transactions.multipleDelete');
    /********Archive ********/
    Route::patch('/home/vans/{van}/archiveVan', 'VansController@archiveVan')->name('vans.archiveVan');
    Route::get('/drivers/generatePDF', 'DriversController@generatePDF')->name('pdf.drivers');
    Route::get('/operators/generatePDF', 'OperatorsController@generatePDF')->name('pdf.operators');
    Route::get('/drivers/generatePerDriver/{driver}', 'DriversController@generatePerDriver')->name('pdf.perDriver');
    Route::get('/drivers/generatePerOperator/{operator}', 'OperatorsController@generatePerOperator')->name('pdf.perOperator');
    Route::get('/home/trip-log', 'TripsController@tripLog')->name('trips.tripLog');
    Route::get('/home/trip-log/{trip}', 'TripsController@viewTripLog')->name('trips.viewTripLog');
    Route::get('/home/driver-report', 'TripsController@driverReport')->name('trips.driverReport');
    Route::get('/home/driver-report/{trip}', 'TripsController@viewReport')->name('trips.viewReport');
    Route::patch('/home/driver-report/{trip}/accept', 'TripsController@acceptReport')->name('trips.acceptReport');
    Route::patch('/home/driver-report/{trip}/decline', 'TripsController@declineReport')->name('trips.declineReport');
    Route::resource('/home/ledger', 'LedgersController');
    Route::get('/home/general-ledger', 'LedgersController@generalLedger')->name('ledger.generalLedger');
    Route::get('/ledger/daily-ledger/generate-pdf', 'LedgersController@generatePDF')->name('pdf.ledger');
    Route::get('/home/listOfVans-pdf', 'VansController@generatePDF')->name('pdf.van');
    Route::get('/trip-log/pdf/{trip}', 'TripsController@generatePerTrip')->name('pdf.perTrip');
    Route::post('/home/general-ledger/date-range', 'LedgersController@dateRange')->name('ledger.filter');
    /*Account Settings - Change Password*/
    Route::get('/home/account-settings', 'SuperAdminChangePasswordController@viewAccountSettings')->name('accountSettings');
    Route::post('/checkCurrentPassAdmin', 'SuperAdminChangePasswordController@checkCurrentPassword')->name('checkPass');
    Route::patch('/home/account-settings/{superAdminid}/change-password', 'SuperAdminChangePasswordController@updatePassword')->name('superadminmodule.changePassword');
 });
/*****************************************************************************/
/*****************************************************************************/



/*************************************Driver Module****************************/
/******************************************************************************/
Route::group(['middleware' => ['auth', 'driver']], function(){
  /*Driver Dashboard*/
  Route::get('/home/driver-dashboard', 'DriverModuleControllers\DriverHomeController@index')->name('drivermodule.index');
  /*AJAX GET for queue and announcements*/
  Route::get('/home/view-vanqueue', 'DriverModuleControllers\ViewVanQueueController@showVanQueue')->name('drivermodule.vanQueue');
  Route::get('/home/view-announcement', 'DriverModuleControllers\ViewAnnouncementsController@showAnnouncement')->name('drivermodule.indexAnnouncements');
  /*Driver Profile*/
  Route::get('/home/profile', 'DriverModuleControllers\DriverProfileController@showDriverProfile')->name('drivermodule.profile.driverProfile');
  Route::post('/home/profile', 'DriverModuleControllers\DriverProfileController@changeNotificationStatus')->name('drivermodule.notification');
  /*Change Password*/
  Route::patch('/home/profile/change-password/{driverid}', 'DriverModuleControllers\DriverProfileController@updatePassword')->name('drivermodule.changePassword');
  Route::post('home/profile/change-password', 'DriverModuleControllers\DriverProfileController@checkCurrentPassword')->name('drivermodule.checkCurrentPassword');
  /*Create Report*/
  Route::get('/home/choose-terminal', 'DriverModuleControllers\CreateReportController@chooseTerminal')->name('drivermodule.report.driverChooseDestination');
  Route::get('/home/create-report/{terminals}', 'DriverModuleControllers\CreateReportController@createReport')->name('drivermodule.createReport');
  Route::post('/home/create-report/{terminal}/store', 'DriverModuleControllers\CreateReportController@storeReport')->name('drivermodule.storeReport');
  /*Trip Log*/
  Route::get('/home/view-trips', 'DriverModuleControllers\TripLogController@viewTripLog')->name('drivermodule.triplog.driverTripLog');
  Route::get('/home/view-trips/{trip}', 'DriverModuleControllers\TripLogController@viewSpecificTrip')->name('drivermodule.triplog.driverTripDetails');
  /*View Rentals*/
  Route::get('/home/view-rentals', 'DriverModuleControllers\ViewRentalsController@viewRentals')->name('drivermodule.rentals.rental');
  Route::patch('/home/view-rentals/{rental}', 'DriverModuleControllers\ViewRentalsController@updateRental')->name('drivermodule.updateRental');
  /*Help*/
  Route::get('/home/driver/help', 'DriverModuleControllers\ViewDriverHelpController@viewDriverHelp')->name('drivermodule.help.driverHelp');
  /*Notifications*/
  Route::get('/home/notifications', 'DriverModuleControllers\ShowNotificationsControllers@index')->name('drivermodule.notifications');
  Route::get('/driverNotifications', 'DriverModuleControllers\ShowNotificationsControllers@notifications')->name('drivermodule.getNotifs');
  Route::get('/markAsRead', 'DriverModuleControllers\ShowNotificationsControllers@markAsRead')->name('drivermodule.markAsRead');
});
/******************************************************************************/
/******************************************************************************/
//Route::get('/home/try', 'PassController@index');

/*********************************Customer Module******************************/
/******************************************************************************/

Route::get('/about', 'CustomerModuleControllers\CustomerNonUserHomeController@aboutNonUser')->name('customermodule.non-user.about.customerAbout');
Route::get('/home/get-announcement', 'ViewAnnouncementsNonUserController@showAnnouncement')->name('index.getAnnouncements');
Route::get('/home/farelist', 'ViewVanQueueNonUserController@showQueue')->name('customermodule.non-user.fare-list.fareList');
Route::group(['middleware' => ['auth', 'customer']], function(){
    /*User Dashboard*/
    Route::get('/home', 'CustomerModuleControllers\CustomerUserHomeController@index')->name('customermodule.user.index');
    Route::get('/home/fare-list', 'CustomerModuleControllers\ViewQueueController@showVanQueue')->name('customermodule.user.fair_list.fairList');
    Route::get('/home/user/view-announcement', 'CustomerModuleControllers\ViewAnnouncementsController@showAnnouncement')->name('customermodule.user.indexAnnouncements');
    Route::get('/home/user/view-announcement/modal', 'CustomerModuleControllers\AnnouncementModalController@showModalAnnouncement')->name('customermodule.user.indexAnnouncementModal');
    Route::get('/home/view-announcements', 'CustomerModuleControllers\ViewAllAnnouncementsController@viewAnnouncements')->name('customermodule.user.indexAllAnnouncements');
    /**Services**/
    /*Rental*/
    Route::get('/home/create-rental', 'CustomerModuleControllers\MakeRentalController@createRental')->name('customermodule.user.rental.customerRental');
    Route::post('/home/create-rental', 'CustomerModuleControllers\MakeRentalController@storeRental')->name('customermodule.storeRental');
    /*Reservation*/
    Route::get('/home/create-reservation', 'CustomerModuleControllers\MakeReservationController@createReservation')->name('customermodule.user.reservation.customerReservation');
    Route::post('/home/create-reservation', 'CustomerModuleControllers\MakeReservationController@storeReservation')->name('customermodule.storeReservation');
    /*Transactions*/
    Route::get('/home/view-transactions', 'CustomerModuleControllers\ViewTransactionsController@viewTransactions')->name('customermodule.user.transactions.customerTransactions');
    Route::patch('/home/view-transactions/delete-rental/{rental}', 'CustomerModuleControllers\ViewTransactionsController@destroyRental')->name('customermodule.deleteRental');
    Route::patch('/home/view-transactions/cancel-rental/{rental}', 'CustomerModuleControllers\ViewTransactionsController@cancelRental')->name('customermodule.cancelRental');
    Route::delete('/home/view-transactions/delete-reservation/{reservation}', 'CustomerModuleControllers\ViewTransactionsController@destroyReservation')->name('customermodule.deleteReservation');
    /*Change Password*/
    Route::get('/home/change-password', 'CustomerModuleControllers\CustomerChangePasswordController@viewChangePassword')->name('customermodule.user.changepassword.index');
    Route::patch('/home/change-password/{customerId}', 'CustomerModuleControllers\CustomerChangePasswordController@updatePassword')->name('customermodule.changePassword');
    Route::post('/customerCheckPassword', 'CustomerModuleControllers\CustomerChangePasswordController@checkCurrentPassword')->name('customermodule.checkCurrentPassword');
    /*About*/
    Route::get('/home/about', 'CustomerModuleControllers\ViewAboutController@viewAbout')->name('customermodule.user.about.customerAbout');
    /*Help*/
    Route::get('/home/customer/help', 'CustomerModuleControllers\ViewHelpController@viewHelp')->name('customermodule.user.help.customerHelp');
    /*Notifications*/
    Route::get('/notifications', 'CustomerModuleControllers\ViewNotificationsController@notificaitons')->name('customermodule.notifications');
});
/******************************************************************************/
/******************************************************************************/
