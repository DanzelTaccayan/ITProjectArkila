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
 Route::group(['middleware' => ['auth', 'super-admin', 'prevent-back']], function(){
    Route::resource('/getting-started/setup', 'SetupController',[
        'except' => ['create', 'show']
    ]);
    Route::group(['middleware' => ['getting-started']], function(){
        Route::get('/home/superadmin-dashboard', 'HomeController@index')->name('home');
    Route::post('/home/restoreDatabase','RestoreDatabaseController@restoreDatabase')->name('home.restoreDatabase');
    Route::resource('/home/ledger', 'DailyLedgerController');

    Route::resource('/home/announcements', 'AnnouncementsController');
    Route::resource('/home/route', 'RoutesController',[
        'except' => ['create', 'show']
    ]);
    Route::resource('/home/ticket-management', 'TicketManagementController');
    Route::patch('/home/ticket-management/{ticket_management}/updateDiscount', 'TicketManagementController@updateDiscount');

    

    Route::get('/home/bookingfee/{bookingfee}/edit', 'FeesController@editBooking')->name('bookingfee.edit');

    Route::get('/home/route/create', 'RoutesController@createRoute')->name('route.create');
    Route::get('/home/terminal/create', 'RoutesController@createTerminal')->name('terminalCreate.create');
    // Route::post('/home/terminal/store', 'RoutesController@storeTerminal')->name('terminalCreate.update');
    // Route::post('/home/route/store', 'RoutesController@storeRoute')->name('route.update');

    //Operators
    Route::resource('/home/operators', 'OperatorsController',[
        'except' => ['destroy']
    ]);

    /************ Drivers ******************************/
    Route::resource('/home/drivers', 'DriversController',[
        'except' => ['show']
    ]);
    Route::get('/home/drivers/{generalDriver}', 'DriversController@show')->name('drivers.show');
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
    
    //Check if the driver has already a van
    Route::post('/checkDriverVan', 'VansController@checkDriverVan')->name('checkDriverVan');

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

    Route::get('/adminNotifications', 'HomeController@notifications')->name('admin.getNotifs');
    Route::get('/markAsRead', 'HomeController@markAsRead')->name('admin.markAsRead');
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
        'except' => ['edit']
    ]);

    Route::get('/home/booking-rules', 'BookingRulesController@index')->name('bookingRules.index');
    Route::get('/home/reservation/customer/{reservation}', 'ReservationsController@showReservation')->name('reservation.showReservation');

    Route::get('/home/reservations/walk-in/{reservation}', 'ReservationsController@walkInReservation')->name('reservation.walk-in');
    Route::post('/home/reservations/walk-in/store', 'ReservationsController@storeWalkIn')->name('reservation.walk-in-store');
    Route::patch('/home/reservations/refund/{reservation}', 'ReservationsController@refund')->name('reservation.refund');
    Route::patch('/home/reservations/payment/{reservation}', 'ReservationsController@payment')->name('reservation.payment');

    Route::resource('/home/rental', 'RentalsController',[
        'except' => ['edit']
    ]);
    Route::patch('/home/rental/{rental}/updateStatus', 'RentalsController@updateStatus')->name('rental.updateStatus');

    Route::resource('/home/company-profile', 'ProfileController',[
        'except' => ['show','store', 'create', 'destroy']
    ]);

    Route::get('/findDestinationTerminal', 'ReservationsController@find');

    /* Trips */
    Route::resource('/home/trips', 'TripsController',[
        'except' => ['index','create','show','edit','update']
    ]);
    Route::get('/home/terminal', 'AdminCreateDriverReportController@chooseTerminal')->name('trips.admin.chooseDestination');
    Route::get('/home/terminal/{terminals}/{destination}/create-report', 'AdminCreateDriverReportController@createReport')->name('trips.admin.createReport');
    Route::post('/home/terminal/{terminals}/{destination}create-report/store', 'AdminCreateDriverReportController@storeReport')->name('trips.admin.storeReport');

    /* Van Queue */
     //Only working routes are: index and destroy
     Route::resource('/home/vanqueue','VanQueueController',[
         'except' => ['create','show','edit','store','update']
     ]);
     Route::post('/home/vanqueue/{destination}/{van}/{member}', 'VanQueueController@store')->name('vanqueue.store');
     Route::patch('/home/vanqueue/changeDestination/{vanOnQueue}', 'VanQueueController@updateDestination')->name('vanqueue.updateDestination');
     Route::patch('/updateQueueNumber/{vanOnQueue}', 'VanQueueController@updateQueueNumber')->name('vanqueue.updateQueueNumber');
     Route::post('/specialUnitChecker','VanQueueController@specialUnitChecker')->name('vanqueue.specialUnitChecker');
     Route::patch('/home/vanqueue/{vanOnQueue}/updateRemarks', 'VanQueueController@updateRemarks')->name('vanqueue.updateRemarks');
     Route::get('/showConfirmationBox/{encodedQueue}','VanQueueController@showConfirmationBox');
     Route::get('/showConfirmationBoxOB/{encodedQueue}','VanQueueController@showConfirmationBoxOb');
     Route::patch('/vanqueue', 'VanQueueController@updateVanQueue')->name('vanqueue.updateVanQueue');
     Route::patch('/putOnDeck/{vanOnQueue}','VanQueueController@putOnDeck')->name('vanqueue.putOnDeck');
     Route::post('/changeRemarksOB/{vanOnQueue}','VanQueueController@changeRemarksOB')->name('vanqueue.changeRemarksOB');
     Route::patch('/moveToSpecialUnit/{vanOnQueue}','VanQueueController@moveToSpecialUnit')->name('vanqueue.moveToSpecialUnit');
     /* Transactions(Ticket) */
    Route::get('/home/transactions', 'TransactionsController@index')->name('transactions.index');
    Route::delete('/home/transactions/{ticket}', 'TransactionsController@destroy')->name('transactions.destroy');
    Route::post('/home/transactions/{destination}', 'TransactionsController@store')->name('transactions.store');
    Route::patch('/home/transactions/{destination}', 'TransactionsController@depart')->name('transactions.depart');
    Route::patch('/updatePendingTransactions', 'TransactionsController@updatePendingTransactions')->name('transactions.updatePendingTransactions');
    Route::patch('/updateOnBoardTransactions', 'TransactionsController@updateOnBoardTransactions')->name('transactions.updateOnBoardTransactions');
    Route::get('/listSourceDrivers','TransactionsController@listSourceDrivers')->name('transactions.listSourceDrivers');
    Route::patch('/changeDriver/{vanOnQueue}', 'TransactionsController@changeDriver')->name('transactions.changeDriver');
    Route::get('/home/transactions/managetickets','TransactionsController@manageTickets')->name('transactions.manageTickets');
    Route::patch('/home/transactions/refund/{ticket}','TransactionsController@refund')->name('transactions.refund');
    Route::patch('/multipleRefund','TransactionsController@multipleRefund')->name('transactions.multipleRefund');
    Route::patch('/home/transactions/lost/{ticket}','TransactionsController@lost')->name('transactions.lost');
    Route::patch('/home/transactions/multipleLost','TransactionsController@multipleLost')->name('transactions.multipleLost');
    Route::delete('/multipleDelete','TransactionsController@multipleDelete')->name('transactions.multipleDelete');
    //Selected Tickets
    Route::post('/selectTicket/{destination}','TransactionsController@selectTicket')->name('transactions.selectTicket');
    Route::delete('/selectTicket/{selectedTicket}','TransactionsController@deleteSelectedTicket')->name('transactions.selectedTicket');
    Route::delete('/selectedLastTicket/{destination}','TransactionsController@deleteLastSelectedTicket')->name('transactions.selectedTicket');
    /********Archive ********/
    Route::get('/home/archive', 'ArchiveController@archive')->name('archive.index');
    Route::get('/home/archive/drivers', 'ArchiveController@showAllArchivedDriver')->name('archive.showAllArchivedDriver');
    Route::get('/home/archive/vans','ArchiveController@showAllArchivedVans')->name('archive.showAllArchivedVans');
    Route::get('/home/archive/profile/{archivedOperator}','ArchiveController@showArchivedProfileOperator')->name('archive.showArchivedProfileOperator');
    Route::patch('/home/vans/{van}/archiveVan', 'ArchiveController@archiveVan')->name('vans.archiveVan');
    Route::patch('/home/archive/{operator}/archiveOperators', 'ArchiveController@archiveOperator')->name('operators.archiveOperator');
    Route::patch('/home/archive/{driver}/archiveDrivers', 'ArchiveController@archiveDriver')->name('drivers.archiveDriver');
    Route::patch('/home/archive/operator/{archivedOperator}/restore','ArchiveController@restoreArchivedOperator')->name('operators.restoreArchivedOperator');
    Route::patch('/home/archive/driver/{archivedDriver}/restore','ArchiveController@restoreArchivedDriver')->name('drivers.restoreArchivedDriver');

    /**** Generate PDF ****/
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
    /*View Live Queue*/
    Route::get('/live-queue', 'ViewLiveVanQueueController@index')->name('ticketmanagement.queue');
    Route::get('/getVanQueue', 'ViewLiveVanQueueController@getVanQueue')->name('ticketmanagement.getVanQueue');    
    });
 });
/*****************************************************************************/
/*****************************************************************************/



/*************************************Driver Module****************************/
/******************************************************************************/
Route::group(['middleware' => ['auth', 'driver', 'prevent-back']], function(){
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
  //Route::get('/home/choose-terminal', 'DriverModuleControllers\CreateReportController@chooseTerminal')->name('drivermodule.report.driverChooseDestination');
  Route::get('/home/create-report', 'DriverModuleControllers\CreateReportController@createReport')->name('drivermodule.createReport');
  Route::post('/home/create-report/store', 'DriverModuleControllers\CreateReportController@storeReport')->name('drivermodule.storeReport');
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

Route::get('/about', 'CustomerModuleControllers\CustomerNonUserHomeController@aboutNonUser')->name('customermodule.aboutUsNonUser');
Route::get('/home/get-announcement', 'ViewAnnouncementsNonUserController@showAnnouncement')->name('index.getAnnouncements');
Route::get('/home/farelist', 'ViewVanQueueNonUserController@showQueue')->name('customermodule.non-user.fare-list.fareList');
Route::get('/routes/fare-list/', 'ViewFareListController@fareList')->name('customermodule.fareList');
Route::group(['middleware' => ['auth', 'customer', 'prevent-back']], function(){
    /*User Dashboard*/
    Route::get('/home', 'CustomerModuleControllers\CustomerUserHomeController@index')->name('customermodule.user.index');
    // Route::get('/home/fare-list', 'CustomerModuleControllers\ViewQueueController@showVanQueue')->name('customermodule.user.fair_list.fairList');
    Route::get('/home/user/view-announcement', 'CustomerModuleControllers\ViewAnnouncementsController@showAnnouncement')->name('customermodule.user.indexAnnouncements');
    Route::get('/home/user/view-announcement/modal', 'CustomerModuleControllers\AnnouncementModalController@showModalAnnouncement')->name('customermodule.user.indexAnnouncementModal');
    Route::get('/home/view-announcements', 'CustomerModuleControllers\ViewAllAnnouncementsController@viewAnnouncements')->name('customermodule.user.indexAllAnnouncements');
    /**Services**/
    /*Rental*/
    Route::patch('/home/rental/{rental}/cancelRental', 'CustomerModuleControllers\MakeRentalController@cancelRental')->name('rental.cancel');
    Route::get('/home/create-rental', 'CustomerModuleControllers\MakeRentalController@createRental')->name('customermodule.user.rental.customerRental')->middleware('online-rental');
    Route::post('/home/store-rental', 'CustomerModuleControllers\MakeRentalController@storeRental')->name('customermodule.storeRental')->middleware('online-rental');
    /*Reservation*/
    Route::post('/home/reservation/select-destination', 'CustomerModuleControllers\MakeReservationController@showDetails')->name('customermodule.showDetails')->middleware('online-reservation');
    Route::get('/home/reservation/show-reservations', 'CustomerModuleControllers\MakeReservationController@showDate')->name('customermodule.showDate')->middleware('online-reservation');
    Route::get('/home/receipt/{reservation}', 'CustomerModuleControllers\MakeReservationController@reservationPdf')->name('reservation.receipt');
    Route::get('/home/routes/fare-list', 'CustomerModuleControllers\MakeReservationController@fareList')->name('reservation.fareList');

    Route::get('/home/reservation/create-success/{transaction}', 'CustomerModuleControllers\MakeReservationController@reservationSuccess')->name('customermodule.success')->middleware('online-reservation');
    Route::get('/home/transactions/reservation/', 'CustomerModuleControllers\MakeReservationController@reservationTransaction')->name('customermodule.reservationTransaction')->middleware('online-reservation');
    Route::get('/home/transactions/rental/', 'CustomerModuleControllers\MakeRentalController@rentalTransaction')->name('customermodule.rentalTransaction')->middleware('online-reservation');

    Route::get('/home/reservation/create/{reservation}', 'CustomerModuleControllers\MakeReservationController@reservationCreate')->name('customermodule.createReservation')->middleware('online-reservation');
    Route::post('/home/reservation/create-request/{reservation}', 'CustomerModuleControllers\MakeReservationController@storeRequest')->name('customermodule.storeReservation')->middleware('online-reservation');
    Route::get('/home/create-reservation', 'CustomerModuleControllers\MakeReservationController@createReservation')->name('customermodule.user.reservation.customerReservation')->middleware('online-reservation');
    // Route::post('/home/create-reservation', 'CustomerModuleControllers\MakeReservationController@storeReservation')->name('customermodule.storeReservation')->middleware('online-reservation');
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
    Route::get('/customerNotifications', 'CustomerModuleControllers\ViewNotificationsController@notificaitons')->name('customermodule.notifications');
    Route::get('/markAsRead', 'CustomerModuleControllers\ViewNotificationsController@markAsRead')->name('customermodule.markAsRead');
});
/******************************************************************************/
/******************************************************************************/
