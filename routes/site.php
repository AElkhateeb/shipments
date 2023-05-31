<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Url;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|Route::get('/', function () {
    return view('welcome');
});
URL::defaults(['locale' => app('')]);
Route::get('/', function () {
    return Redirect::to(Config::get('app.default_language'));

});
و
*/
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'namespace'=>'App\Http\Controllers\Site'
    ],function () {
        Route::get('/', 'SiteController@index');
        Route::get('home','SiteController@index');
        Route::get('about','SiteController@about');
        Route::get('services','SiteController@services');
        Route::get('service/{id}','SiteController@service');
        Route::get('career','SiteController@career');
        Route::post('career','SiteController@apply');
        Route::post('client','SiteController@client');
        Route::get('pricing','SiteController@pricing');
        Route::get('contact','SiteController@contact');

});
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'namespace'=>'App\Http\Controllers\Site'
    ],function () {
        Route::group(['prefix' => 'shipping'], function () {
            Route::get('/', 'CartController@index')->name('site.cart.index');
            Route::get('/all', function () {return view('front.shipment-table');})->name('site.cart.all');
            Route::get('/summary', 'CartController@summary')->name('site.cart.summary');
            Route::get('/mini', function () {return view('front.miniCart');})->name('site.cart.mini');
            Route::post('/add/', 'CartController@add')->name('site.cart.add');
            Route::get('/remove/{rowId}', 'CartController@remove')->name('site.cart.remove');
            Route::post('/update/', 'CartController@update')->name('site.cart.update');
            Route::post('/update-all', 'CartController@postUpdateAll')->name('site.cart.update-all');
        });
        Route::group(['prefix' => 'checkout'], function () {
            Route::get('/', 'CheckoutController@index')->name('site.checkout');
            Route::get('/selectLocation/{locId}', 'CheckoutController@selectLocation')->name('selectLocation.checkout');
            Route::post('/account', 'CheckoutController@accountLocation')->name('accountLocation.checkout');
            Route::post('/account', 'CheckoutController@accountNoLocation')->name('accountNoLocation.checkout');
            Route::post('/loged','CheckoutController@loged')->name('loged.checkout');
        });
         
         
         
});


