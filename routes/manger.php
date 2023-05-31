<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|Route::get('/', function () {
 return Redirect::to(Config::get('app.default_language'));
    return view('welcome');
});
*/


Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\Manger\Auth')->group(static function () {
        Route::get('/manger/login', 'LoginController@showLoginForm')->name('manger/login');

        Route::post('/manger/login', 'LoginController@login');

        Route::any('/manger/logout', 'LoginController@logout')->name('manger/logout');

        Route::get('/manger/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('manger/password/showForgotForm');
        Route::post('/manger/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/manger/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('manger/password/showResetForm');
        Route::post('/manger/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/manger/activation/{token}', 'ActivationController@activate')->name('manger/activation/activate');
    });
    Route::prefix('manger')->namespace('App\Http\Controllers\Manger')->group(function () {
        // Route::post('/manger/wysiwyg-media','WysiwygMediaUploadController@upload')->name('manger/admin-ui::wysiwyg-upload');
        Route::post('/upload', 'FileUploadController@upload')->name('manger.upload');
        Route::get('/view', 'FileViewController@view')->name('manger.media::view');
    });
});
Route::middleware(['web', 'auth:' . config('manger-auth.defaults.guard')])->group(static function () {
    Route::namespace('App\Http\Controllers\Manger')->group(static function () {
        Route::get('/manger', 'AdminHomepageController@index')->name('manger');

    });
});



Route::middleware(['auth:' . config('manger-auth.defaults.guard')])->group(static function () {
    Route::prefix('manger')->namespace('App\Http\Controllers\Manger')->name('manger/')->group(static function() {
        ################################  profile ######################################
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
        ################################  user ######################################

        Route::prefix('employee-admin')->name('employee-admin/')->group(static function() {
            Route::get('/',                                             'EmployeeAdminsController@index')->name('index');
            Route::get('/create',                                       'EmployeeAdminsController@create')->name('create');
            Route::post('/',                                            'EmployeeAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'EmployeeAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'EmployeeAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'EmployeeAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'EmployeeAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'EmployeeAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
        Route::prefix('shipper-admin')->name('shipper-admin/')->group(static function() {
            Route::get('/',                                             'ShipperAdminsController@index')->name('index');
            Route::get('/create',                                       'ShipperAdminsController@create')->name('create');
            Route::post('/',                                            'ShipperAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'ShipperAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'ShipperAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'ShipperAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'ShipperAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'ShipperAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
        Route::prefix('account-admin')->name('account-admin/')->group(static function() {
            Route::get('/',                                             'AccountAdminsController@index')->name('index');
            Route::get('/create',                                       'AccountAdminsController@create')->name('create');
            Route::post('/',                                            'AccountAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AccountAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AccountAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AccountAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'AccountAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AccountAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
        ################################  website ######################################
        Route::prefix('clients')->name('clients/')->group(static function() {
            Route::get('/',                                             'ClientsController@index')->name('index');
            Route::get('/create',                                       'ClientsController@create')->name('create');
            Route::post('/',                                            'ClientsController@store')->name('store');
            Route::get('/{client}/edit',                                'ClientsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ClientsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{client}',                                    'ClientsController@update')->name('update');
            Route::delete('/{client}',                                  'ClientsController@destroy')->name('destroy');
            Route::get('/export',                                       'ClientsController@export')->name('export');
        });
        ################################  system ######################################
        Route::prefix('shipments')->name('shipments/')->group(static function() {
            Route::get('/',                                             'ShipmentsController@index')->name('index');
            Route::get('/create',                                       'ShipmentsController@create')->name('create');
            Route::post('/',                                            'ShipmentsController@store')->name('store');
            Route::get('/{shipment}/edit',                              'ShipmentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ShipmentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{shipment}',                                  'ShipmentsController@update')->name('update');
            Route::delete('/{shipment}',                                'ShipmentsController@destroy')->name('destroy');
            Route::get('/export',                                       'ShipmentsController@export')->name('export');
        });
        Route::prefix('places')->name('places/')->group(static function() {
            Route::get('/',                                             'PlacesController@index')->name('index');
            Route::get('/create',                                       'PlacesController@create')->name('create');
            Route::post('/',                                            'PlacesController@store')->name('store');
            Route::get('/{place}/edit',                                 'PlacesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PlacesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{place}',                                     'PlacesController@update')->name('update');
            Route::delete('/{place}',                                   'PlacesController@destroy')->name('destroy');
            Route::get('/export',                                       'PlacesController@export')->name('export');
        });
        Route::prefix('roads')->name('roads/')->group(static function() {
            Route::get('/',                                             'RoadsController@index')->name('index');
            Route::get('/create',                                       'RoadsController@create')->name('create');
            Route::post('/',                                            'RoadsController@store')->name('store');
            Route::get('/{road}/edit',                                  'RoadsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RoadsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{road}',                                      'RoadsController@update')->name('update');
            Route::delete('/{road}',                                    'RoadsController@destroy')->name('destroy');
            Route::get('/export',                                       'RoadsController@export')->name('export');
        });
        Route::prefix('payment-methods')->name('payment-methods/')->group(static function() {
            Route::get('/',                                             'PaymentMethodsController@index')->name('index');
            Route::get('/create',                                       'PaymentMethodsController@create')->name('create');
            Route::post('/',                                            'PaymentMethodsController@store')->name('store');
            Route::get('/{paymentMethod}/edit',                         'PaymentMethodsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PaymentMethodsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{paymentMethod}',                             'PaymentMethodsController@update')->name('update');
            Route::delete('/{paymentMethod}',                           'PaymentMethodsController@destroy')->name('destroy');
        });
        Route::prefix('wallets')->name('wallets/')->group(static function() {
            Route::get('/',                                             'WalletsController@index')->name('index');
            Route::get('/create',                                       'WalletsController@create')->name('create');
            Route::post('/',                                            'WalletsController@store')->name('store');
            Route::get('/{wallet}/edit',                                'WalletsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'WalletsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{wallet}',                                    'WalletsController@update')->name('update');
            Route::delete('/{wallet}',                                  'WalletsController@destroy')->name('destroy');
        });
        Route::prefix('withdrawals')->name('withdrawals/')->group(static function() {
            Route::get('/',                                             'WithdrawalsController@index')->name('index');
            Route::get('/create',                                       'WithdrawalsController@create')->name('create');
            Route::post('/',                                            'WithdrawalsController@store')->name('store');
            Route::get('/{withdrawal}/edit',                            'WithdrawalsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'WithdrawalsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{withdrawal}',                                'WithdrawalsController@update')->name('update');
            Route::delete('/{withdrawal}',                              'WithdrawalsController@destroy')->name('destroy');
            Route::get('/export',                                       'WithdrawalsController@export')->name('export');
        });
        Route::prefix('branches')->name('branches/')->group(static function() {
            Route::get('/',                                             'BranchesController@index')->name('index');
            Route::get('/create',                                       'BranchesController@create')->name('create');
            Route::post('/',                                            'BranchesController@store')->name('store');
            Route::get('/{branch}/edit',                                'BranchesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BranchesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{branch}',                                    'BranchesController@update')->name('update');
            Route::delete('/{branch}',                                  'BranchesController@destroy')->name('destroy');
            Route::get('/export',                                       'BranchesController@export')->name('export');
        });
        Route::prefix('receiveres')->name('receiveres/')->group(static function() {
            Route::get('/',                                             'ReceiveresController@index')->name('index');
            Route::get('/create',                                       'ReceiveresController@create')->name('create');
            Route::post('/',                                            'ReceiveresController@store')->name('store');
            Route::get('/{receivere}/edit',                             'ReceiveresController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ReceiveresController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{receivere}',                                 'ReceiveresController@update')->name('update');
            Route::delete('/{receivere}',                               'ReceiveresController@destroy')->name('destroy');
            Route::get('/export',                                       'ReceiveresController@export')->name('export');
        });
        ################################  translations ######################################
        Route::get('/translations', 'TranslationsController@index');
        Route::get('/translations/export', 'TranslationsController@export')->name('translations/export');
        Route::post('/translations/import', 'TranslationsController@import')->name('translations/import');
        Route::post('/translations/import/conflicts', 'TranslationsController@importResolvedConflicts')->name('translations/import/conflicts');
        Route::post('/translations/rescan', 'RescanTranslationsController@rescan');
        Route::post('/translations/{translation}', 'TranslationsController@update');
    });
});


