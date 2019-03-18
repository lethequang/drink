<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    Route::post('upload', 'UploadController@index')->name('upload');
    Route::post('upload-images', 'UploadController@images')->name('upload-images');

    Route::middleware(['check.permissions'])->group(function () {

        Route::get('slide-show/search', 'SlideShowController@search')->name('slide-show.search');
        Route::resource('slide-show', 'SlideShowController');

        Route::get('partner/search', 'PartnerController@search')->name('partner.search');
        Route::resource('partner', 'PartnerController');

        Route::get('support/search', 'SupportController@search')->name('support.search');
        Route::resource('support', 'SupportController');

        Route::get('contact/search', 'ContactController@search')->name('contact.search');
        Route::resource('contact', 'ContactController');

        Route::get('manufacturer/search', 'ManufacturerController@search')->name('manufacturer.search');
        Route::resource('manufacturer', 'ManufacturerController');

        Route::get('product-category/search', 'ProductCategoryController@search')->name('product-category.search');
        Route::get('product-category/ajax-get-category-by-manufacturer/{manufacturer_id}', 'ProductCategoryController@ajaxGetCategoryByManufacturer')->name('product-category.ajax_get_category_by_manufacturer');
        Route::resource('product-category', 'ProductCategoryController');


        Route::get('asset-feature/search', 'AssetFeatureController@search')->name('asset-feature.search');
        Route::resource('asset-feature', 'AssetFeatureController');
        Route::post('asset-feature/ajax-active', 'AssetFeatureController@ajaxActive')->name('asset-feature.ajax_active');
        Route::post('asset-feature/ajax-inactive', 'AssetFeatureController@ajaxInactive')->name('asset-feature.ajax_inactive');
        Route::post('asset-feature/ajax-delete', 'AssetFeatureController@ajaxDelete')->name('asset-feature.ajax_delete');


        Route::get('asset-feature-variant-search', 'AssetFeatureVariantController@search')->name('asset-feature-variant.search');
        Route::resource('asset-feature-variant', 'AssetFeatureVariantController');
        Route::get('asset-feature-variant/ajax-disable-feature/{id}', 'AssetFeatureVariantController@getAjaxDisableFeature');
        Route::post('asset-feature-variant/ajax-active', 'AssetFeatureVariantController@ajaxActive')->name('asset-feature-variant.ajax_active');
        Route::post('asset-feature-variant/ajax-inactive', 'AssetFeatureVariantController@ajaxInactive')->name('asset-feature-variant.ajax_inactive');
        Route::post('asset-feature-variant/ajax-delete', 'AssetFeatureVariantController@ajaxDelete')->name('asset-feature-variant.ajax_delete');
        Route::post('asset-feature-variant/ajax-create/{from}/{to}/{feature_id}', 'AssetFeatureVariantController@storeAjax');
        Route::post('asset-feature-variant/ajax-create/{feature_id}', 'AssetFeatureVariantController@storeAjax2');
        Route::post('asset-feature-variant/get-price/{id}', 'AssetFeatureVariantController@getPrice');

        Route::get('asset-category-search', 'AssetCategoryController@search')->name('asset-category.search');
        Route::resource('asset-category', 'AssetCategoryController');
        Route::post('asset-category/ajax-active', 'AssetCategoryController@ajaxActive')->name('asset-category.ajax_active');
        Route::post('asset-category/ajax-inactive', 'AssetCategoryController@ajaxInactive')->name('asset-category.ajax_inactive');
        Route::post('asset-category/ajax-delete', 'AssetCategoryController@ajaxDelete')->name('asset-category.ajax_delete');


        Route::get('asset/search', 'AssetController@search')->name('asset.search');
        Route::post('asset/loadDistrict/{id}', 'AssetController@getDistrict');
        Route::post('asset/loadWard/{id}', 'AssetController@getWard');
        Route::post('asset/loadAssetFeatureVariant/{id}', 'AssetController@getAssetFeatureVariant');
        Route::post('asset/loadAssetCategory/{id}', 'AssetController@getAssetCategory');
        Route::resource('asset', 'AssetController');
        Route::post('asset/ajax-active', 'AssetController@ajaxActive')->name('asset.ajax_active');
        Route::post('asset/ajax-inactive', 'AssetController@ajaxInactive')->name('asset.ajax_inactive');
        Route::post('asset/ajax-rented', 'AssetController@ajaxRented')->name('asset.ajax_rented');
        Route::post('asset/ajax-delete', 'AssetController@ajaxDelete')->name('asset.ajax_delete');
        Route::post('asset/loadAssetByAssetCategory/{id}', 'AssetController@getAssetByCategory');
        Route::post('asset/loadPrice/{id}', 'AssetController@getPrice');
        Route::post('asset/loadDescription/{id}', 'AssetController@getDescription');

        // Quang
        Route::get('asset-ajax/load-all-asset', 'AssetController@getAllAsset')->name('asset.get-all');

        Route::resource('promotion', 'PromotionController');
        Route::get('promotion/search', 'PromotionController@search')->name('promotion.search');
        Route::resource('promotion-feature-variant', 'PromotionFeatureVariantController');
        Route::get('promotion-feature-variant/search', 'PromotionFeatureVariantController@search')->name('promotion-feature-variant.search');
        Route::resource('promotion-feature', 'PromotionFeatureController');
        Route::get('promotion-feature/search', 'PromotionFeatureController@search')->name('promotion-feature.search');

        Route::get('promotion-feature-variant/ajax-disable-feature/{id}', 'PromotionFeatureVariantController@getAjaxDisableFeature');
        Route::post('promotion-feature-variant/ajax-create/{from}/{to}/{feature_id}', 'PromotionFeatureVariantController@storeAjax');


        Route::get('order/search', 'OrderController@search')->name('order.search');
        Route::post('order/loadDistrict/{id}', 'OrderController@getDistrict');
        Route::post('order/loadWard/{id}', 'OrderController@getWard');
        Route::post('order/loadAssetFeatureVariant/{id}', 'OrderController@getAssetFeatureVariant');
        Route::post('order/loadAssetCategory/{id}', 'OrderController@getAssetCategory');
        Route::resource('order', 'OrderController');
        Route::post('order/ajax-active', 'OrderController@ajaxActive')->name('order.ajax_active');
        Route::post('order/ajax-inactive', 'OrderController@ajaxInactive')->name('order.ajax_inactive');
        Route::post('order/ajax-rented', 'OrderController@ajaxRented')->name('order.ajax_rented');
        Route::post('order/ajax-delete', 'OrderController@ajaxDelete')->name('order.ajax_delete');
        Route::get('order/{id}/detail', 'OrderController@detail')->name('order.detail');
        Route::post('customers/loadInfoCustomer/{id}', 'CustomerController@getInfoCustomer');



        Route::get('product/import', 'ProductController@import')->name('product.import');
        Route::post('product/import', 'ProductController@store_import');
        Route::get('product/search', 'ProductController@search')->name('product.search');
        Route::post('product/ajax-active', 'ProductController@ajaxActive')->name('product.ajax_active');
        Route::post('product/ajax-inactive', 'ProductController@ajaxInactive')->name('product.ajax_inactive');
        Route::post('product/ajax-delete', 'ProductController@ajaxDelete')->name('product.ajax_delete');
        Route::resource('product', 'ProductController');

        Route::get('warehouse/import', 'WarehouseController@import')->name('warehouse.import');
        Route::post('warehouse/import', 'WarehouseController@store_import');
        Route::get('warehouse/search', 'WarehouseController@search')->name('warehouse.search');
        Route::resource('warehouse', 'WarehouseController');





        Route::get('article-craw/{id}', 'ArticleController@getCraw')->name('article.craw');
        Route::get('list-craw', 'ArticleController@listCraw')->name('article.lits.craw');
        Route::get('article/search/craw', 'ArticleController@showListCraw')->name('article.search.craw');
        Route::post('article/crawler', 'ArticleController@postCraw')->name('article.crawler');


        Route::get('article/search', 'ArticleController@search')->name('article.search');
        Route::get('article/ajax-data', 'ArticleController@getAjaxData')->name('article.ajaxData');
        Route::post('article/ajax-active', 'ArticleController@ajaxActive')->name('article.ajax_active');
        Route::post('article/ajax-inactive', 'ArticleController@ajaxInactive')->name('article.ajax_inactive');
        Route::post('article/ajax-delete', 'ArticleController@ajaxDelete')->name('article.ajax_delete');
        Route::resource('article', 'ArticleController');

        Route::post('article/synchronized', 'SynchronizedController@postSynchronized')->name('synchronized.crawler');
        Route::post('asset/synchronized', 'SynchronizedController@postSynchronizedAsset')->name('synchronized.crawler.asset');
        Route::post('asset-api/synchronized', 'SynchronizedController@postSynchronizedAssetApi')->name('synchronized.crawler.asset.api');

        Route::get('banner/search', 'BannerController@search')->name('banner.search');
        Route::post('banner/ajax-active', 'BannerController@ajaxActive')->name('banner.ajax_active');
        Route::post('banner/ajax-inactive', 'BannerController@ajaxInactive')->name('banner.ajax_inactive');
        Route::post('banner/ajax-delete', 'BannerController@ajaxDelete')->name('banner.ajax_delete');
        Route::resource('banner', 'BannerController');


        CRUD::resource('menu-item', 'MenuItemCrudController');

        Route::post('upload', 'UploadController@index')->name('upload');

        Route::resource('users', 'UserController');
        Route::post('users/ajax-delete', 'ArticleController@destroy')->name('article.destroy');
        Route::get('users/profile', 'UserController@profile')->name('users.profile');
        Route::put('users/profile', 'UserController@profile_update');
        Route::get('users/change-password', 'UserController@change_password')->name('users.change-password');
        Route::post('users/change-password', 'UserController@change_password_store');
        Route::get('users/reset-password/{id}', 'UserController@showResetPassword')->name('users.show-reset-password');
        Route::post('users/reset-password/{id}', 'UserController@postResetPassword');
        Route::get('users/search', 'UserController@search')->name('users.search');
        Route::post('users/ajax-active', 'UserController@ajaxActive')->name('users.ajax_active');
        Route::post('users/ajax-inactive', 'UserController@ajaxInactive')->name('users.ajax_inactive');
        Route::post('users/ajax-delete', 'UserController@ajaxDelete')->name('users.ajax_delete');
        Route::post('users/get-combogrid-data', 'UserController@getCombogridData')->name('users.get-combogrid-data');


        Route::resource('customers', 'CustomerController');
        Route::post('customers/ajax-delete', 'CustomerController@destroy')->name('customers.destroy');
        Route::get('customers/profile', 'CustomerController@profile')->name('customers.profile');
        Route::put('customers/profile', 'CustomerController@profile_update');
        Route::get('customers/change-password', 'CustomerController@change_password')->name('customers.change-password');
        Route::post('customers/change-password', 'CustomerController@change_password_store');
        Route::get('customers/reset-password/{id}', 'CustomerController@showResetPassword')->name('customers.show-reset-password');
        Route::post('customers/reset-password/{id}', 'CustomerController@postResetPassword');
        Route::get('customers/search', 'CustomerController@search')->name('customers.search');
        Route::post('customers/ajax-active', 'CustomerController@ajaxActive')->name('customers.ajax_active');
        Route::post('customers/ajax-inactive', 'CustomerController@ajaxInactive')->name('customers.ajax_inactive');
        Route::post('customers/ajax-delete', 'CustomerController@ajaxDelete')->name('customers.ajax_delete');
        Route::post('customers/get-combogrid-data', 'CustomerController@getCombogridData')->name('customers.get-combogrid-data');

        Route::group(['prefix' => 'roles'], function () {
            Route::post('add-users', 'RolesController@add_users')->name('roles.add-users');
            Route::delete('/{role_id}/remove-user/{user_id}', 'RolesController@remove_user')->name('roles.remove-user');
            Route::get('/', 'RolesController@getShowAll')->name('roles.index');
            Route::get('ajax-data', 'RolesController@getAjaxData')->name('roles.search');
            Route::get('add', 'RolesController@getAdd')->name('roles.create');
            Route::get('detail/{id}', 'RolesController@detail');
            Route::post('add', 'RolesController@postAdd');
            Route::get('edit/{id}', 'RolesController@getEdit')->name('roles.edit');
            Route::post('edit/{id}', 'RolesController@postEdit');
            Route::delete('delete/{id}', 'RolesController@destroy')->name('roles.delete');
        });

        Route::group(['prefix' => 'customer-roles'], function () {
            Route::post('add-customer', 'CustomerRolesController@add_users')->name('customer-roles.add-users');
            Route::delete('/{role_id}/remove-user/{user_id}', 'CustomerRolesController@remove_user')->name('customer-roles.remove-user');
            Route::get('/', 'CustomerRolesController@getShowAll')->name('customer-roles.index');
            Route::get('ajax-data', 'CustomerRolesController@getAjaxData')->name('customer-roles.search');
            Route::get('add', 'CustomerRolesController@getAdd')->name('customer-roles.create');
            Route::get('detail/{id}', 'CustomerRolesController@detail');
            Route::post('add', 'CustomerRolesController@postAdd');
            Route::get('edit/{id}', 'CustomerRolesController@getEdit')->name('customer-roles.edit');
            Route::post('edit/{id}', 'CustomerRolesController@postEdit');
            Route::delete('delete/{id}', 'CustomerRolesController@destroy')->name('customer-roles.delete');
        });
    });
}); // this should be the absolute last line of this file
