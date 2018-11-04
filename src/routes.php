<?php
Route::group(['middleware' => ['web','auth']], function () {

    Route::get('company', '\Amorim\Tenant\Controllers\CompanyController@index')->name('admin.company');
    Route::get('company/getdata', '\Amorim\Tenant\Controllers\CompanyController@getData')->name('admin.company.getdata');
    Route::get('company/fetchdata', '\Amorim\Tenant\Controllers\CompanyController@fetchData')->name('admin.company.fetchdata');
    Route::post('company/postdata', '\Amorim\Tenant\Controllers\CompanyController@postData')->name('admin.company.postdata');


});
