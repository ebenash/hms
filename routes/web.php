<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('homepage.home');
})->name('home.index');
Route::get('/about', function () {
    return view('homepage.about');
})->name('home.about');
Route::get('/contact', function () {
    return view('homepage.contact');
})->name('home.contact');

Route::get('/rooms', 'RoomTypesController@homepage_rooms')->name('home.rooms');
Route::get('/room/details/{id}', 'RoomTypesController@homepage_room_details')->name('home.roomdetails');
Route::get('/reservation', 'ReservationsController@homepage_reservation')->name('home.reservation');
Route::post('/reservation/store', 'ReservationsController@homepage_reservation_store')->name('home.reservation.store');

Route::get('/reservation/payment/{id}', 'CommonController@payStackPaymentApi')->name('paystack-payment-url');

Route::get('/gallery', function () {
    return view('homepage.gallery');
})->name('home.gallery');
Route::get('/offers', function () {
    return view('homepage.offers');
})->name('home.offers');

// Route::get('/', 'DashboardController@index')->name('dashboard');
Route::prefix('admin')->group(function(){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Auth::routes(['register'=>false]);
    Route::post('/guests/store', 'GuestsController@store')->name('guests-store');
    Route::post('/guests/update/{id}', 'GuestsController@update')->name('guests-update');
    Route::post('/guests/findguest/{search}', 'GuestsController@find_guest')->name('find-guest');
    Route::post('/roomtypes/store', 'RoomTypesController@store')->name('roomtypes-store');
    Route::post('/roomtypes/update/{id}', 'RoomTypesController@update')->name('roomtypes-update');
    Route::post('/reservations/store', 'ReservationsController@store')->name('reservations-store');
    Route::post('/reservations/update/{id}', 'ReservationsController@update')->name('reservations-update');
    Route::get('/reservations/calendar', 'ReservationsController@calendar')->name('reservations-calendar');
    Route::get('/reservations/today', 'ReservationsController@today')->name('reservations-today');
    Route::get('/reservations/tomorrow', 'ReservationsController@tomorrow')->name('reservations-tomorrow');
    Route::get('/reservations/requests', 'ReservationsController@requests')->name('reservations-requests');
    Route::get('/reservations/pending', 'ReservationsController@pending')->name('reservations-pending');
    Route::get('/reservations/confirmed', 'ReservationsController@confirmed')->name('reservations-confirmed');
    Route::get('/reservations/cancelled', 'ReservationsController@cancelled')->name('reservations-cancelled');
    Route::post('/reservations/filter', 'ReservationsController@filter')->name('reservations-filter');
    Route::get('/reservations/filter', 'ReservationsController@today')->name('reservations-filter-fallback');
    Route::get('/reservations/create/guest/{id}', 'ReservationsController@create_with_guest')->name('reservations-create-guest');
    Route::get('/reservations/request/{id}', 'ReservationsController@view_request')->name('reservations-view-request');
    Route::post('/reservations/request/update/{id}', 'ReservationsController@request_update')->name('reservations-update-request');
    Route::post('/notifications/unread', 'CommonController@notifications_unread')->name('notifications-unread');
    Route::post('/rooms/store', 'RoomsController@store')->name('rooms-store');
    Route::post('/rooms/update/{id}', 'RoomsController@update')->name('rooms-update');
    Route::post('/rooms/getrooms/{id}', 'RoomsController@get_rooms')->name('get-rooms');
    Route::post('/payments/store', 'PaymentsController@store')->name('payments-store');
    Route::get('/accounting/paystack-invoices', 'AccountingController@paystack_invoices')->name('paystack.invoices');
    Route::get('/accounting/other-sales', 'AccountingController@other_sales')->name('other.sales');
    Route::post('/accounting/sale/store', 'AccountingController@sale_store')->name('sale-store');
    Route::post('/accounting/sale/update/{id}', 'AccountingController@sale_update')->name('sale-update');
    Route::post('/accounting/sale/filter', 'AccountingController@sale_filter')->name('sale-filter');
    Route::get('/accounting/sale/filter', 'AccountingController@other_sales')->name('sale-filter-fallback');
    Route::delete('/accounting/sale/delete/{id}', 'AccountingController@sale_destroy')->name('sale-destroy');
    Route::get('/reports', 'ReportsController@index')->name('reports');
    Route::post('/reports', 'ReportsController@reportfilter')->name('reports-filter');
    Route::post('/reports/exportexcel', 'ReportsController@excelexport')->name('reports-excel');
    Route::post('/reports/exportpdf', 'ReportsController@pdfexport')->name('reports-pdf');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::get('/settings/{tab}', 'SettingsController@index')->name('settings-tab');
    Route::post('/settings/update/{id}', 'SettingsController@update')->name('update-settings');
    Route::post('/settings/theme/update', 'SettingsController@update_theme_setting')->name('update-theme');
    Route::get('/user/profile', 'Auth\UserController@profile')->name('user-profile');
    Route::put('/user/profile/update/{id}', 'Auth\UserController@update')->name('user-profile-update');
    Route::put('/user/password/update/{id}', 'Auth\UserController@update_password')->name('user-password-update');
    Route::post('/user/store', 'Auth\UserController@store')->name('user-store');
    Route::post('/user/update/{id}', 'Auth\UserController@update')->name('user-update');
    Route::post('/notifications/read/{id}', 'CommonController@handle_notification')->name('handle-notification');
    Route::post('/search', 'CommonController@global_search')->name('global-search');
    Route::get('/search', 'DashboardController@index')->name('global-search-fallback');
    Route::post('/hotel-phones/store', 'HotelNotificationPhonesController@store')->name('phone-store');
    Route::post('/hotel-phones/update/{id}', 'HotelNotificationPhonesController@update')->name('phone-update');
    Route::resource('hotel-phones','HotelNotificationPhonesController', [
        'names' => [
            'destroy' => 'phone-destroy',
        ]
    ]);
    Route::resource('guests','GuestsController', [
        'names' => [
            'index' => 'guests',
            'create' => 'guests-create',
            // 'store' => 'guests-store',
            'show' => 'guests-show',
            'edit' => 'guests-edit',
            // 'update' => 'guests-update',
            'destroy' => 'guests-destroy',
        ]
    ]);
    Route::resource('rooms','RoomsController', [
        'names' => [
            'index' => 'rooms',
            'create' => 'rooms-create',
            // 'store' => 'rooms-store',
            'show' => 'rooms-show',
            'edit' => 'rooms-edit',
            // 'update' => 'rooms-update',
            'destroy' => 'rooms-destroy',
        ]
    ]);
    Route::resource('reservations','ReservationsController', [
        'names' => [
            'index' => 'reservations',
            'create' => 'reservations-create',
            // 'store' => 'reservations-store',
            'show' => 'reservations-show',
            'edit' => 'reservations-edit',
            // 'update' => 'reservations-update',
            'destroy' => 'reservations-destroy',
        ]
    ]);
    Route::resource('roomtypes','RoomTypesController', [
        'names' => [
            'index' => 'roomtypes',
            'create' => 'roomtypes-create',
            // 'store' => 'roomtypes-store',
            'show' => 'roomtypes-show',
            'edit' => 'roomtypes-edit',
            // 'update' => 'roomtypes-update',
            'destroy' => 'roomtypes-destroy',
        ]
    ]);
    // Route::resource('accounting','AccountingController', [
    //     'names' => [
    //         // 'index' => 'accounting',
    //         // 'paystack_invoices' => 'paystack.invoices',
    //         // 'create' => 'accounting-create',
    //         // // 'store' => 'accounting-store',
    //         // 'show' => 'accounting-show',
    //         // 'edit' => 'accounting-edit',
    //         // // 'update' => 'accounting-update',
    //         // 'destroy' => 'accounting-destroy',
    //     ]
    // ]);
    Route::resource('users','Auth\UserController', [
        'names' => [
            'index' => 'users',
            'create' => 'users-create',
            // 'store' => 'users-store',
            'show' => 'users-show',
            'edit' => 'users-edit',
            // 'update' => 'users-update',
            'destroy' => 'users-destroy',
        ]
    ]);


    Route::get('/hms-uploads/{file}', [ function ($file) {

        $path = storage_path('app/public/uploads/'.$file);

        if (file_exists($path)) {
            return response()->file($path, []);
        }

        abort(404);

    }])->name('hms-uploads-file');

    Route::get('/hms-guest-identification/{file}', [ function ($file) {

        $path = storage_path('app/public/uploads/guestids/'.$file);

        if (file_exists($path)) {
            return response()->file($path, []);
        }

        abort(404);

    }])->name('hms-guest-identification');
});
