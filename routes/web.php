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






/* Auto-generated admin routes */


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('packages')->name('packages/')->group(static function() {
            Route::get('/',                                             'PackagesController@index')->name('index');
            Route::get('/create',                                       'PackagesController@create')->name('create');
            Route::post('/',                                            'PackagesController@store')->name('store');
            Route::get('/{package}/edit',                               'PackagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PackagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{package}',                                   'PackagesController@update')->name('update');
            Route::delete('/{package}',                                 'PackagesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('locations')->name('locations/')->group(static function() {
            Route::get('/',                                             'LocationsController@index')->name('index');
            Route::get('/create',                                       'LocationsController@create')->name('create');
            Route::post('/',                                            'LocationsController@store')->name('store');
            Route::get('/{location}/edit',                              'LocationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LocationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{location}',                                  'LocationsController@update')->name('update');
            Route::delete('/{location}',                                'LocationsController@destroy')->name('destroy');
            Route::get('/export',                                       'LocationsController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('shipment-items')->name('shipment-items/')->group(static function() {
            Route::get('/',                                             'ShipmentItemsController@index')->name('index');
            Route::get('/create',                                       'ShipmentItemsController@create')->name('create');
            Route::post('/',                                            'ShipmentItemsController@store')->name('store');
            Route::get('/{shipmentItem}/edit',                          'ShipmentItemsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ShipmentItemsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{shipmentItem}',                              'ShipmentItemsController@update')->name('update');
            Route::delete('/{shipmentItem}',                            'ShipmentItemsController@destroy')->name('destroy');
            Route::get('/export',                                       'ShipmentItemsController@export')->name('export');
        });
    });
});