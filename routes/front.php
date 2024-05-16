<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath',]
    ], function() {

    Route::group(['namespace' => 'Site',], function () {
        Route::get('/', 'HomeController@home')->name('home')->middleware('VerifyUser');
        route::get('products-by-category/{slug}', 'CategoryController@productsByCat')
            ->name('get.products.by.cat');
        route::get('product/{slug}', 'ProductController@getProductDetails')->name('get.product.details');

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'CartController@getIndex')->name('site.cart.index');
            Route::post('/cart/add/{slug?}', 'CartController@postAdd')->name('site.cart.add');
            Route::post('/update/{slug}', 'CartController@postUpdate')->name('site.cart.update');
            Route::post('/update-all', 'CartController@postUpdateAll')->name('site.cart.update-all');
        });
    });

    Route::group(['namespace' => 'Site', 'middleware' => ['auth:web', 'VerifyUser'], 'prefix' => 'user'], function () {
        Route::get('/profile', function () {
            return 'profile';
        });
    });

    Route::group(['namespace' => 'Site', 'middleware' => 'auth:web'], function () {
        Route::post('/verify-user', 'VerificationCodeController@verify')->name('verify-user');
        Route::get('/verify', 'VerificationCodeController@verification')->name('verification.form');

        Route::group(['prefix' => 'user-wishlist'], function () {
            Route::post('wishlist', 'WishlistController@store')->name('wishlist.store');
            Route::delete('wishlist', 'WishlistController@destroy')->name('wishlist.destroy');
            Route::get('wishlist/products', 'WishlistController@index')->name('user.wishlist');
        });
    });
});










