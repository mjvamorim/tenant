<?php

    Route::get('tenant/{company}', 'Amorim\Tenant\Controllers\TenantController@select')->name('selectcompany');