<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'DashboardController@index')->name('admin.index');

        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingController@editShippingMethods')
                ->name('edit.shipping.methods');

            Route::put('shipping-methods/{id}', 'SettingController@updateShippingMethods')
                ->name('update.shipping.methods');
        });

        Route::get('/logout', 'LoginController@logout')->name('admin.logout');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
        });

        ################################## categories routes ######################################
        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/', 'MainCategoriesController@index')->name('admin.maincategories');
            Route::get('create', 'MainCategoriesController@create')->name('admin.maincategories.create');
            Route::post('store', 'MainCategoriesController@store')->name('admin.maincategories.store');
            Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.maincategories.edit');
            Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.maincategories.update');
            Route::get('delete/{id}', 'MainCategoriesController@delete')->name('admin.maincategories.delete');
        });
        ################################## End categories    #######################################

        ################################### subcategories routes ######################################
        Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', 'SubCategoriesController@index')->name('admin.subcategories');
            Route::get('create', 'SubCategoriesController@create')->name('admin.subcategories.create');
            Route::post('store', 'SubCategoriesController@store')->name('admin.subcategories.store');
            Route::get('edit/{id}', 'SubCategoriesController@edit')->name('admin.subcategories.edit');
            Route::post('update/{id}', 'SubCategoriesController@update')->name('admin.subcategories.update');
            Route::get('delete/{id}', 'SubCategoriesController@delete')->name('admin.subcategories.delete');
        });
        ################################## End subcategories    #######################################
    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('/login', 'LoginController@login')->name('admin.login');

        Route::post('/storeLogin', 'LoginController@storeLogin')->name('admin.store.login');
    });
});

