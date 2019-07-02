<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'AdminSiteController@index');
Route::get('/index.php', 'AdminSiteController@index');
Route::get('/about.php', 'AdminSiteController@about');
Route::get('/buyback.php', 'AdminSiteController@buyback');
Route::get('/checkin.php', 'AdminSiteController@checkin');
Route::get('/checkin_complete.php', 'AdminSiteController@checkin_complete');
Route::get('/checkin_list.php', 'AdminSiteController@checkin_list');
Route::get('/contact.php', 'AdminSiteController@contactPage');
Route::get('/inventory.php', 'AdminSiteController@inventory');
Route::get('/inventory_other_list.php', 'AdminSiteController@inventory_other_list');
Route::get('/listofreports.php', 'AdminSiteController@listofreports');
Route::get('/login.php', 'AdminSiteController@login');
Route::get('/nucleus/login.php', 'AdminSiteController@index');
Route::get('/phone_inventory_list.php', 'AdminSiteController@phone_inventory_list');
Route::get('/POS.php', 'AdminSiteController@POS');
Route::get('//wp-content/themes/Nucleus/promos/independent-retailers-guide.php', function(){
	return url('http://nucleuspos.com/nucsite/images/logo-red-bl.png');
});
Route::get('/pricing.php', 'AdminSiteController@pricingPage');
Route::get('/reportfeatures.php', 'AdminSiteController@reportfeatures');
Route::get('/signup.php', 'AdminSiteController@signup');
Route::get('/specialfeatures.php', 'AdminSiteController@specialfeatures');
Route::get('/specialorders.php', 'AdminSiteController@specialorders');
Route::get('/support.php', 'AdminSiteController@support');
Route::get('/ticket.php', 'AdminSiteController@ticket');
Route::get('/videos.php', 'AdminSiteController@videos');
Route::get('/videos.php/{vid}/{title}', 'AdminSiteController@videosDetail');
Route::get('/warranty.php', 'AdminSiteController@warranty');



Route::post('/contact/request', 'SubscriptionController@contactRequest');
Route::post('/request/demo', 'SubscriptionController@demoRequest');

/* subscribe billing start */
Route::get('/paypal/payment/execute-payment', 'SiteSettingController@index');
Route::get('/paypal/payment/execute-status/{status}', 'SiteSettingController@index');

Route::post('/new/signup', 'SubscriptionController@store');
Route::get('/paypal/create/plan', 'SubscriptionController@create_plan');
Route::get('/subscribe/paypal', 'SubscriptionController@paypalRedirect')->name('paypal.redirect');
Route::get('/subscribe/paypal/{userPlan}/return', 'SubscriptionController@paypalReturn')->name('paypal.return');

//P-3B251453H27638112BI57BBA
/* Subscribe billing end */

//auto signup //initiate/signup
Route::post('/initiate/signup', 'SignupController@initiateSingup');

//sync initiative
Route::get('/initiate/auto/sync', 'SignupController@autoSync');
Route::get('/initiate/json/sync', 'SignupController@jsonSync');
Route::get('/online/order', 'SignupController@onlineorder');

//paypal
Route::get('/initiate/account/paypal/{invoice_id}', 'SignupController@posPayPaypal');
Route::get('/initiate/paypal/{invoice_id}/{status}', 'SignupController@getPOSPaymentStatusPaypal');

//authorizenet
Route::post('/initiate/account/authorizenet/{invoice_id}','SignupController@AuthorizenetCardPayment');
Route::get('/authorize/net/payment/history','AuthorizeNetPaymentHistoryController@index');
Route::post('/authorize/net/payment/refund','InvoiceController@refund');
Route::post('/authorize/net/payment/void','InvoiceController@voidTransaction');

Route::post('/save/contact/query', 'AdminSiteController@contact');

Route::group(['middleware' => 'auth'], function () { 

	Route::get('/home', 'SiteSettingController@index');

		Route::get('/admin-site', 'AdminSiteController@index');

		Route::get('/admin-site/setting', 'SiteSettingController@index');
		Route::post('/admin-site/setting/save', 'SiteSettingController@create');
		Route::post('/admin-site/setting/modify/{id}', 'SiteSettingController@update');
		Route::get('/admin-site/setting/edit/{id}', 'SiteSettingController@show');

		Route::get('/admin-site/about', 'AboutSiteController@index');
		Route::post('/admin-site/about/save', 'AboutSiteController@create');
		Route::post('/admin-site/about/modify/{id}', 'AboutSiteController@update');
		Route::get('/admin-site/about/edit/{id}', 'AboutSiteController@show');

		Route::get('/admin-site/features', 'FeatureController@index');
		Route::post('/admin-site/features/save', 'FeatureController@create');
		Route::post('/admin-site/features/modify/{id}', 'FeatureController@update');
		Route::get('/admin-site/features/edit/{id}', 'FeatureController@show');
		Route::get('/admin-site/features/delete/{id}', 'FeatureController@destroy');

		Route::get('/admin-site/dummy-proof', 'DummyProofController@index');
		Route::post('/admin-site/dummy-proof/save', 'DummyProofController@create');
		Route::post('/admin-site/dummy-proof/modify/{id}', 'DummyProofController@update');
		Route::get('/admin-site/dummy-proof/edit/{id}', 'DummyProofController@show');

		Route::get('/admin-site/retail', 'RetailController@index');
		Route::post('/admin-site/retail/save', 'RetailController@create');
		Route::post('/admin-site/retail/modify/{id}', 'RetailController@update');
		Route::get('/admin-site/retail/edit/{id}', 'RetailController@show');

		Route::get('/admin-site/price', 'PriceController@index');
		Route::post('/admin-site/price/save', 'PriceController@create');
		Route::post('/admin-site/price/modify/{id}', 'PriceController@update');
		Route::get('/admin-site/price/edit/{id}', 'PriceController@show');
		Route::get('/admin-site/price/delete/{id}', 'PriceController@destroy');


		Route::get('/admin-site/business-reports', 'BusinessReportController@index');
		Route::post('/admin-site/business-reports/save', 'BusinessReportController@create');
		Route::post('/admin-site/business-reports/modify/{id}', 'BusinessReportController@update');
		Route::get('/admin-site/business-reports/edit/{id}', 'BusinessReportController@show');

		Route::get('/admin-site/business-reports-features', 'BusinessReportFeatureController@index');
		Route::post('/admin-site/business-reports-features/save', 'BusinessReportFeatureController@create');
		Route::post('/admin-site/business-reports-features/modify/{id}', 'BusinessReportFeatureController@update');
		Route::get('/admin-site/business-reports-features/edit/{id}', 'BusinessReportFeatureController@show');
		Route::get('/admin-site/business-reports-features/delete/{id}', 'BusinessReportFeatureController@destroy');
		//Route::get('/admin-site/retail', 'AdminSiteController@retail');
		Route::get('/admin-site/plug-and-play', 'PlugnPlayController@index');
		Route::post('/admin-site/plug-and-play/save', 'PlugnPlayController@create');
		Route::post('/admin-site/plug-and-play/modify/{id}', 'PlugnPlayController@update');
		Route::get('/admin-site/plug-and-play/edit/{id}', 'PlugnPlayController@show');
		Route::get('/admin-site/plug-and-play/delete/{id}', 'PlugnPlayController@destroy');

		Route::get('/admin-site/plug-and-play-image', 'PlugnPlayImageController@index');
		Route::post('/admin-site/plug-and-play-image/save', 'PlugnPlayImageController@create');
		Route::post('/admin-site/plug-and-play-image/modify/{id}', 'PlugnPlayImageController@update');
		Route::get('/admin-site/plug-and-play-image/edit/{id}', 'PlugnPlayImageController@show');
		Route::get('/admin-site/plug-and-play-image/delete/{id}', 'PlugnPlayImageController@destroy');

		Route::get('/admin-site/slider', 'SliderController@index');
		Route::post('/admin-site/slider/save', 'SliderController@create');
		Route::post('/admin-site/slider/modify/{id}', 'SliderController@update');
		Route::get('/admin-site/slider/edit/{id}', 'SliderController@show');
		Route::get('/admin-site/slider/delete/{id}', 'SliderController@destroy');

		Route::get('/admin-site/footer-menu', 'FotterSeoLinkController@index');
		Route::post('/admin-site/footer-menu/save', 'FotterSeoLinkController@create');
		Route::post('/admin-site/footer-menu/modify/{id}', 'FotterSeoLinkController@update');
		Route::get('/admin-site/footer-menu/edit/{id}', 'FotterSeoLinkController@show');
		Route::get('/admin-site/footer-menu/delete/{id}', 'FotterSeoLinkController@destroy');

});