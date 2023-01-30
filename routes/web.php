<?php

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');


Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');
Route::get('schedule-run', function () {
    return Illuminate\Support\Facades\Artisan::call('schedule:run');
});
Route::get('migrate', function () {
    return Illuminate\Support\Facades\Artisan::call('migrate');
});

Route::get('/themeMode/{themeType?}', function ($themeType = 'true') {
    session()->put('dark-mode', $themeType);
    return $themeType;
})->name('themeMode');

Route::get('cron', 'FrontendController@cron')->name('cron');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Admin\LoginController@login')->name('login');
    Route::post('/logout', 'Admin\LoginController@logout')->name('logout');


    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');


    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');
        Route::get('/balance_refresh','Admin\DashboardController@refreshServerBalance')->name('balance.refresh');
        Route::get('push-notification-show', 'SiteNotificationController@showByAdmin')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAllByAdmin')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');
        Route::match(['get', 'post'], 'pusher-config', 'SiteNotificationController@pusherConfig')->name('pusher.config');



        Route::get('/profile', 'Admin\DashboardController@profile')->name('profile');
        Route::put('/profile', 'Admin\DashboardController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\DashboardController@password')->name('password');
        Route::put('/password', 'Admin\DashboardController@passwordUpdate')->name('passwordUpdate');



        Route::Post('/pay-a-debt/{id}', 'Admin\UsersController@payDebt')->name('pay-a-debt');

        Route::get('/users', 'Admin\UsersController@index')->name('users');
        Route::get('/users/search', 'Admin\UsersController@search')->name('users.search');
        Route::post('/users-active', 'Admin\UsersController@activeMultiple')->name('user-multiple-active');
        Route::post('/users-inactive', 'Admin\UsersController@inactiveMultiple')->name('user-multiple-inactive');
        Route::get('/email-send', 'Admin\UsersController@sendMailUsers')->name('users.email-send');
        Route::post('/email-send', 'Admin\UsersController@sendMailUsersStore')->name('users.email-send.store');
        Route::get('/user/edit/{id}', 'Admin\UsersController@userEdit')->name('user-edit');
        Route::post('/user/update/{id}', 'Admin\UsersController@userUpdate')->name('user-update');
        Route::post('/user/password/{id}', 'Admin\UsersController@passwordUpdate')->name('userPasswordUpdate');
        Route::post('/user/balance-update/{id}', 'Admin\UsersController@userBalanceUpdate')->name('user-balance-update');
        Route::post('/user/sub-balance/{id}', 'Admin\UsersController@userSubBalance')->name('user-sub-balance');
        Route::get('/user/send-email/{id}', 'Admin\UsersController@sendEmail')->name('send-email');
        Route::post('/user/send-email/{id}', 'Admin\UsersController@sendMailUser')->name('user.email-send');
        Route::post('/user/loginAccount/{id}', 'Admin\UsersController@loginAccount')->name('user-loginAccount');

        Route::get('payment/search', 'Admin\PaymentLogController@search')->name('payment.search');

        Route::get('/user/getService', 'Admin\UsersController@getService')->name('user.getService');
        Route::post('/user/setServiceRate', 'Admin\UsersController@setServiceRate')->name('user.setServiceRate');

        Route::get('/user/updateServiceRate', 'Admin\UsersController@updateServiceRate')->name('user.updateServiceRate');
        Route::get('/user/deleteServiceRate', 'Admin\UsersController@deleteServiceRate')->name('user.deleteServiceRate');

        Route::post('/user/keyGenerate/{id}', 'Admin\UsersController@keyGenerate')->name('user.keyGenerate');

        Route::get('/user/transaction/{id}', 'Admin\UsersController@transaction')->name('user.transaction');
        Route::get('/user/fundLog/{id}', 'Admin\UsersController@funds')->name('user.fundLog');


        Route::get('/get-user-name', 'Admin\OrderManageController@getUsername')->name('get.user-name');
        Route::get('/user/order/{id}', 'Admin\OrderManageController@userOrder')->name('user-order');
        Route::get('/user/order-search', 'Admin\OrderManageController@userOrderSearch')->name('user-order-search');
        Route::get('/user-order-service/{id}', 'Admin\OrderManageController@userServiceEdit')->name('user-service-edit');
        //user order


        Route::get('/usersOrderChangeStatus', 'Admin\OrderManageController@usersOrderChangeStatus')->name('usersOrderChangeStatus');

        Route::get('/users-order/awaiting', 'Admin\OrderManageController@awaitingMultiple')->name('user-order-multiple-awaiting');
        Route::get('/users-order/awaiting', 'Admin\OrderManageController@awaitingMultiple')->name('user-order-multiple-awaiting');
        Route::get('/users-order/pending', 'Admin\OrderManageController@pendingMultiple')->name('user-order-multiple-pending');
        Route::get('/users-order/processing', 'Admin\OrderManageController@processingMultiple')->name('user-order-multiple-processing');
        Route::get('/users-order/inprogress', 'Admin\OrderManageController@inProgressMultiple')->name('user-order-multiple-inprogress');
        Route::get('/users-order/completed', 'Admin\OrderManageController@completedMultiple')->name('user-order-multiple-completed');
        Route::get('/users-order/partial', 'Admin\OrderManageController@partialMultiple')->name('user-order-multiple-partial');
        Route::get('/users-order/canceled', 'Admin\OrderManageController@cancelledMultiple')->name('user-order-multiple-canceled');
        Route::get('/users-order/refunded', 'Admin\OrderManageController@refundedMultiple')->name('user-order-multiple-refunded');


        Route::get('/services', 'ServiceController@index')->name('service.show');
        Route::get('/search-service', 'ServiceController@search')->name('service-search');
        Route::post('/search-service/status/{id?}', 'ServiceController@statusChange')->name('service.status.change');
        Route::get('/price_refresh','ServiceController@priceRefresh')->name('price_refresh');

        Route::Post('/update_price','ServiceController@updatePrice')->name('update_price');

        Route::get('/service-active', 'ServiceController@serviceActive')->name('service-active');
        Route::get('/service-deActive', 'ServiceController@serviceDeActive')->name('service-deactive');
        Route::get('/service/{id}', 'ServiceController@edit')->name('service.edit');
        Route::post('/service/update', 'ServiceController@update')->name('service.update');
        Route::get('/get-service', 'ServiceController@getService')->name('get.service');
        Route::get('/service-multiple-active', 'ServiceController@activeMultiple')->name('service-multiple-active');
        Route::get('/service-multiple-deActive', 'ServiceController@deactiveMultiple')->name('service-multiple-deactive');
        Route::get('/service-multiple-delete', 'ServiceController@deleteMultiple')->name('service-multiple-delete');



        Route::get('/category-active', 'CategoryController@categoryActive')->name('category-active');
        Route::get('/category-deactive', 'CategoryController@categoryDeactive')->name('category-deactive');
        Route::get('/category/{id}', 'CategoryController@edit')->name('category.edit');
        Route::post('/category/update', 'CategoryController@update')->name('category.update');
        Route::get('/categories', 'CategoryController@index')->name('category.show');
        Route::post('/category/status/{id?}', 'CategoryController@statusChange')->name('category.status.change');
        Route::get('/get-category', 'CategoryController@show')->name('get.category');
        // search
        Route::get('/search-category', 'CategoryController@search')->name('category-search');
        Route::get('/category-multiple-active', 'CategoryController@activeMultiple')->name('category-multiple-active');
        Route::get('/category-multiple-deactive', 'CategoryController@deactiveMultiple')->name('category-multiple-deactive');



        Route::get('/debts', 'Admin\DebtController@index')->name('debt.show');
//        Route::post('api-provider/status{id}', 'ApiProviderController@changeStatus')->name('provider.status');
//        Route::post('api-provider/priceUpdate/{id}', 'ApiProviderController@priceUpdate')->name('provider.priceUpdate');
//        Route::post('api-provider/balanceUpdate/{id}', 'ApiProviderController@balanceUpdate')->name('provider.balanceUpdate');
//
//        Route::post('/api-services', 'ApiProviderController@getApiServices')->name('api.services');
//        Route::post('/api-services/import', 'ApiProviderController@import')->name('api.service.import');
//        Route::post('/api-services/import/multi', 'ApiProviderController@importMulti')->name('api.service.import.multi');
//        // jquery autocomplete search
//        Route::get('/get-provider', 'ApiProviderController@providerShow')->name('get.provider');
//        //api provider multiple
//        Route::get('/apiprovider-multiple-active', 'ApiProviderController@activeMultiple')->name('apiprovider-multiple-active');
//        Route::get('/apiprovider-multiple-deactive', 'ApiProviderController@deActiveMultiple')->name('apiprovider-multiple-deactive');


        Route::get('/logo-seo', 'ControlController@logoSeo')->name('logo-seo');
        Route::put('/logoUpdate', 'ControlController@logoUpdate')->name('logoUpdate');
        Route::put('/seoUpdate', 'ControlController@seoUpdate')->name('seoUpdate');



        Route::any('/basic-controls', 'ControlController@index')->name('basic-controls');
        Route::post('/basic-controls', 'ControlController@updateConfigure')->name('basic-controls.update');

        Route::get('/color-settings', 'ControlController@colorSettings')->name('color-settings');
        Route::post('/color-settings', 'ControlController@colorSettingsUpdate')->name('color-settings.update');

        Route::get('/email-controls', 'EmailTemplateController@emailControl')->name('email-controls');
        Route::post('/email-controls', 'EmailTemplateController@emailConfigure')->name('email-controls.update');
        Route::post('/email-controls/action', 'EmailTemplateController@emailControlAction')->name('email-controls.action');
        Route::post('/email/test', 'EmailTemplateController@testEmail')->name('testEmail');



        Route::get('/order', 'OrderController@index')->name('order');
        Route::post('/order/status', 'OrderController@statusChange')->name('order.status.change');
        Route::get('/get-service', 'OrderController@getservice')->name('get.service');
        Route::get('/get-user', 'OrderController@getuser')->name('get.user');
        Route::get('/search-order', 'OrderController@search')->name('order-search');

        Route::get('/order/awaiting', 'OrderController@awaiting')->name('awaiting');
        Route::get('/order/pending', 'OrderController@pending')->name('pending');
        Route::get('/order/processing', 'OrderController@processing')->name('processing');
        Route::get('/order/progress', 'OrderController@progress')->name('progress');
        Route::get('/order/completed', 'OrderController@completed')->name('completed');
        Route::get('/order/partial', 'OrderController@partial')->name('partial');
        Route::get('/order/canceled', 'OrderController@canceled')->name('canceled');
        Route::get('/order/refunded', 'OrderController@refunded')->name('refunded');
        // transaction
        Route::get('/transaction', 'OrderController@transaction')->name('user-transaction');
        Route::get('/transaction-search', 'OrderController@transactionSearch')->name('transaction.search');
        // jquery autocomplete search
        Route::get('/get-trx-id-search', 'OrderController@gettrxidsearch')->name('get.trx-id-search');
        Route::get('/get-trx-user-search', 'OrderController@getTrxUserSearch')->name('get.trx-user-search');
        // search




        Route::post('/service', function (Request $request) {
            $parent_id = $request->cat_id;
            $services = Service::where('category_id', $parent_id)->where('service_status', 1)->get();
            return response()->json($services);
        })->name('service');




        /* ===== ADMIN Language SETTINGS ===== */
        Route::get('language', 'Admin\LanguageController@index')->name('language.index');
        Route::get('language/create', 'Admin\LanguageController@create')->name('language.create');
        Route::post('language/create', 'Admin\LanguageController@store')->name('language.store');

        Route::get('language/{language}', 'Admin\LanguageController@edit')->name('language.edit');
        Route::put('language/{language}', 'Admin\LanguageController@update')->name('language.update');
        Route::delete('language/{language}', 'Admin\LanguageController@delete')->name('language.delete');

        Route::get('/language/keyword/{id}', 'Admin\LanguageController@keywordEdit')->name('language.keywordEdit');
        Route::put('/language/keyword/{id}', 'Admin\LanguageController@keywordUpdate')->name('language.keywordUpdate');
        Route::post('/language/importJson', 'Admin\LanguageController@importJson')->name('language.importJson');

        Route::post('store-key/{id}', 'Admin\LanguageController@storeKey')->name('language.storeKey');
        Route::put('update-key/{id}', 'Admin\LanguageController@updateKey')->name('language.updateKey');
        Route::delete('delete-key/{id}', 'Admin\LanguageController@deleteKey')->name('language.deleteKey');


   });

});


Route::middleware('Maintenance')->group(function () {
    Route::get('/user', 'Auth\LoginController@showLoginForm')->name('login');

    Auth::routes(['verify' => true,'register' => false]);


//    Route::group(['middleware' => ['guest']], function () {
//        Route::get('register/{sponsor?}', 'Auth\RegisterController@sponsor')->name('register.sponsor');
//    });


    Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/check', 'VerificationController@check')->name('check');
        Route::get('/resend_code', 'VerificationController@resendCode')->name('resendCode');
        Route::post('/mail-verify', 'VerificationController@mailVerify')->name('mailVerify');
        Route::post('/sms-verify', 'VerificationController@smsVerify')->name('smsVerify');
        Route::post('/twoFA-Verify', 'VerificationController@twoFAverify')->name('twoFA-Verify');

        Route::middleware('userCheck')->group(function () {

            Route::get('/dashboard', 'HomeController@index')->name('home');



            //transaction
            Route::get('/transaction', 'HomeController@transaction')->name('transaction');
            Route::get('/transaction-search', 'HomeController@transactionSearch')->name('transaction.search');

            Route::get('/profile', 'HomeController@profile')->name('profile');
            Route::post('/updateProfile', 'HomeController@updateProfile')->name('updateProfile');
            Route::put('/updateInformation', 'HomeController@updateInformation')->name('updateInformation');
            Route::post('/updatePassword', 'HomeController@updatePassword')->name('updatePassword');




            //order
            Route::resource('order', 'User\OrderController');
            Route::get('/orders', 'User\OrderController@search')->name('order.search');
            Route::post('/order/status', 'User\OrderController@statusChange')->name('order.status.change');
            Route::get('/orders/{status}', 'User\OrderController@statusSearch')->name('order.status.search');
            Route::get('/mass/orders', 'User\OrderController@massOrder')->name('order.mass');
            Route::post('/mass/orders', 'User\OrderController@masOrderStore')->name('order.mass.store');
            Route::get('/get-service', 'ServiceController@getservice')->name('get.service');

            //order search
            Route::get('/services', 'User\ServiceController@index')->name('service.show');
            Route::get('/service-search', 'User\ServiceController@search')->name('service.search');
            Route::get('/services/{id}', 'User\ServiceController@service')->name('services.show');



            Route::post('/service', function (Request $request) {
                $parent_id = $request->cat_id;
                $services = Service::where('category_id', $parent_id)->where('service_status', 1)->get();
                return response()->json($services);
            })->name('service');


            Route::get('push-notification-show', 'SiteNotificationController@show')->name('push.notification.show');
            Route::get('push.notification.readAll', 'SiteNotificationController@readAll')->name('push.notification.readAll');
            Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');

            Route::get('/user-service', 'User\OrderController@userservice')->name('service_id');

        });
    });

    Route::match(['get', 'post'], 'success', 'PaymentController@success')->name('success');
    Route::match(['get', 'post'], 'failed', 'PaymentController@failed')->name('failed');
    Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', 'PaymentController@gatewayIpn')->name('ipn');


    Route::get('/language/{code?}', 'FrontendController@language')->name('language');
    Route::get('/', 'User\ServiceController@index')->middleware('auth')->name('home');




});




