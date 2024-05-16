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

        #################################### brands routes ######################################
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', 'BrandsController@index')->name('admin.brands');
            Route::get('create', 'BrandsController@create')->name('admin.brands.create');
            Route::post('store', 'BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}', 'BrandsController@delete')->name('admin.brands.delete');
        });
        ################################## End brands    #######################################

        #################################### tags routes ######################################
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'tagsController@index')->name('admin.tags');
            Route::get('create', 'tagsController@create')->name('admin.tags.create');
            Route::post('store', 'tagsController@store')->name('admin.tags.store');
            Route::get('edit/{id}', 'tagsController@edit')->name('admin.tags.edit');
            Route::post('update/{id}', 'tagsController@update')->name('admin.tags.update');
            Route::get('delete/{id}', 'tagsController@delete')->name('admin.tags.delete');
        });
        ################################## End tags    #######################################

        ################################## products routes ######################################
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'ProductsController@index')->name('admin.products');
            Route::get('general-information', 'ProductsController@create')
                ->name('admin.products.general.create');
            Route::post('store-general-information', 'ProductsController@store')
                ->name('admin.products.general.store');

            Route::get('price/{id}', 'ProductsController@getPrice')->name('admin.products.price');
            Route::post('price', 'ProductsController@saveProductPrice')->name('admin.products.price.store');

            Route::get('stock/{id}', 'ProductsController@getStock')
                ->name('admin.products.stock');
            Route::post('stock', 'ProductsController@saveProductStock')
                ->name('admin.products.stock.store');

            Route::get('images/{id}', 'ProductsController@addImages')->name('admin.products.images');
            Route::post('images', 'ProductsController@saveProductImages')
                ->name('admin.products.images.store');
            Route::post('images/db', 'ProductsController@saveProductImagesDB')
                ->name('admin.products.images.store.db');
        });
        ################################## products brands    #######################################

        #################################### attributes routes ######################################
        Route::group(['prefix' => 'attributes'], function () {
            Route::get('/', 'AttributesController@index')->name('admin.attributes');
            Route::get('create', 'AttributesController@create')->name('admin.attributes.create');
            Route::post('store', 'AttributesController@store')->name('admin.attributes.store');
            Route::get('edit/{id}', 'AttributesController@edit')->name('admin.attributes.edit');
            Route::post('update/{id}', 'AttributesController@update')->name('admin.attributes.update');
            Route::get('delete/{id}', 'AttributesController@delete')->name('admin.attributes.delete');
        });
        ################################## End attributes    #######################################

        #################################### attr Options routes ######################################
        Route::group(['prefix' => 'attr_options'], function () {
            Route::get('/', 'AttrOptionsController@index')->name('admin.attr_options');
            Route::get('create', 'AttrOptionsController@create')->name('admin.attr_options.create');
            Route::post('store', 'AttrOptionsController@store')->name('admin.attr_options.store');
            Route::get('edit/{id}', 'AttrOptionsController@edit')->name('admin.attr_options.edit');
            Route::post('update/{id}', 'AttrOptionsController@update')->name('admin.attr_options.update');
            Route::get('delete/{id}', 'AttrOptionsController@delete')->name('admin.attr_options.delete');
        });
        ################################## End attr Options    #######################################

        ##################################### sliders routes ######################################
        Route::group(['prefix' => 'sliders'], function () {
            Route::get('/', 'SlidersController@create')->name('admin.sliders.images');
            Route::post('images', 'SlidersController@saveSliderImages')
                ->name('admin.sliders.images.store');
            Route::post('images/db', 'SlidersController@saveSliderImagesDB')
                ->name('admin.sliders.images.store.db');
        });
        ################################## End sliders    #######################################
    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('/login', 'LoginController@login')->name('admin.login');

        Route::post('/storeLogin', 'LoginController@storeLogin')->name('admin.store.login');
    });
});

