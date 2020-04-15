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
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Auth::routes();

Route::get('/', 'AdminSiteController@index');
Route::get('/question', 'AdminSiteController@question');
Route::get('/blog', 'AdminSiteController@blog');
Route::get('/blog/{detail}', 'AdminSiteController@blogDetail');
Route::post('/save/blog/comment', 'AdminSiteController@saveComment');
Route::get('/pricing', 'AdminSiteController@pricing');
Route::get('/videos', 'AdminSiteController@videos');
Route::get('/video', 'AdminSiteController@videos');
Route::get('/hardware', 'AdminSiteController@hardware');
Route::post('/hardware', 'AdminSiteController@hardwarePurchase');
Route::get('/purchase/package/{packageid}', 'AdminSiteController@pricingSet');


Route::get('/business-pos-system', 'AdminSiteController@bps');
Route::get('/simple-cash-register', 'AdminSiteController@scr');
Route::get('/retail-store', 'AdminSiteController@retailStore');

//auto signup //initiate/signup
Route::post('/initiate/signup', 'SignupPackageController@initiateSingup');

//sync initiative
Route::get('/initiate/auto/sync', 'SignupPackageController@autoSync');
Route::get('/initiate/json/sync', 'SignupPackageController@jsonSync');
Route::get('/online/order', 'SignupPackageController@onlineorder');

//paypal
Route::get('/initiate/account/paypal/{invoice_id}', 'SignupPackageController@posPayPaypal');
Route::get('/initiate/paypal/{invoice_id}/{status}', 'SignupPackageController@getPOSPaymentStatusPaypal');

//authorizenet
Route::post('/initiate/account/cardpointee','SignupPackageController@cardpointeeCapture');
Route::post('/initiate/account/authorizenet/{invoice_id}','SignupPackageController@AuthorizenetCardPayment');
Route::get('/authorize/net/payment/history','AuthorizeNetPaymentHistoryController@index');
Route::post('/authorize/net/payment/refund','InvoiceController@refund');
Route::post('/authorize/net/payment/void','InvoiceController@voidTransaction');

Route::post('/save/contact/query', 'AdminSiteController@contact');

Route::group(['middleware' => 'auth'], function () { 
    
    Route::get('/dashboard','AdminSiteController@dashboard');
	Route::get('/crud', 'CrudController@crud')->name('crud');
	Route::post('/crud', 'CrudController@crudgenarate')->name('crudgenarate');

	//======================== Sitesetting Route Start ===============================//
	Route::get('/sitesetting/list','SitesettingController@show');
	Route::get('/sitesetting/create','SitesettingController@create');
	Route::get('/sitesetting/edit/{id}','SitesettingController@edit');
	Route::get('/sitesetting/delete/{id}','SitesettingController@destroy');
	Route::get('/sitesetting','SitesettingController@index');
	Route::get('/sitesetting/export/excel','SitesettingController@ExportExcel');
	Route::get('/sitesetting/export/pdf','SitesettingController@ExportPDF');
	Route::post('/sitesetting','SitesettingController@store');
	Route::post('/sitesetting/ajax','SitesettingController@ajaxSave');
	Route::post('/sitesetting/datatable/ajax','SitesettingController@datatable');
	Route::post('/sitesetting/update/{id}','SitesettingController@update');
	//======================== Sitesetting Route End ===============================//
	//======================== Slider Route Start ===============================//
	Route::get('/slider/list','SliderController@show');
	Route::get('/slider/create','SliderController@create');
	Route::get('/slider/edit/{id}','SliderController@edit');
	Route::get('/slider/delete/{id}','SliderController@destroy');
	Route::get('/slider','SliderController@index');
	Route::get('/slider/export/excel','SliderController@ExportExcel');
	Route::get('/slider/export/pdf','SliderController@ExportPDF');
	Route::post('/slider','SliderController@store');
	Route::post('/slider/ajax','SliderController@ajaxSave');
	Route::post('/slider/datatable/ajax','SliderController@datatable');
	Route::post('/slider/update/{id}','SliderController@update');
	//======================== Slider Route End ===============================//
	//======================== Features Route Start ===============================//
	Route::get('/features/list','FeaturesController@show');
	Route::get('/features/create','FeaturesController@create');
	Route::get('/features/edit/{id}','FeaturesController@edit');
	Route::get('/features/delete/{id}','FeaturesController@destroy');
	Route::get('/features','FeaturesController@index');
	Route::get('/features/export/excel','FeaturesController@ExportExcel');
	Route::get('/features/export/pdf','FeaturesController@ExportPDF');
	Route::post('/features','FeaturesController@store');
	Route::post('/features/ajax','FeaturesController@ajaxSave');
	Route::post('/features/datatable/ajax','FeaturesController@datatable');
	Route::post('/features/update/{id}','FeaturesController@update');
	//======================== Features Route End ===============================//
	//======================== Intragtedsolutions Route Start ===============================//
	Route::get('/intragtedsolutions/list','IntragtedsolutionsController@show');
	Route::get('/intragtedsolutions/create','IntragtedsolutionsController@create');
	Route::get('/intragtedsolutions/edit/{id}','IntragtedsolutionsController@edit');
	Route::get('/intragtedsolutions/delete/{id}','IntragtedsolutionsController@destroy');
	Route::get('/intragtedsolutions','IntragtedsolutionsController@index');
	Route::get('/intragtedsolutions/export/excel','IntragtedsolutionsController@ExportExcel');
	Route::get('/intragtedsolutions/export/pdf','IntragtedsolutionsController@ExportPDF');
	Route::post('/intragtedsolutions','IntragtedsolutionsController@store');
	Route::post('/intragtedsolutions/ajax','IntragtedsolutionsController@ajaxSave');
	Route::post('/intragtedsolutions/datatable/ajax','IntragtedsolutionsController@datatable');
	Route::post('/intragtedsolutions/update/{id}','IntragtedsolutionsController@update');
	//======================== Intragtedsolutions Route End ===============================//
	//======================== Joinsimplicity Route Start ===============================//
	Route::get('/joinsimplicity/list','JoinsimplicityController@show');
	Route::get('/joinsimplicity/create','JoinsimplicityController@create');
	Route::get('/joinsimplicity/edit/{id}','JoinsimplicityController@edit');
	Route::get('/joinsimplicity/delete/{id}','JoinsimplicityController@destroy');
	Route::get('/joinsimplicity','JoinsimplicityController@index');
	Route::get('/joinsimplicity/export/excel','JoinsimplicityController@ExportExcel');
	Route::get('/joinsimplicity/export/pdf','JoinsimplicityController@ExportPDF');
	Route::post('/joinsimplicity','JoinsimplicityController@store');
	Route::post('/joinsimplicity/ajax','JoinsimplicityController@ajaxSave');
	Route::post('/joinsimplicity/datatable/ajax','JoinsimplicityController@datatable');
	Route::post('/joinsimplicity/update/{id}','JoinsimplicityController@update');
	//======================== Joinsimplicity Route End ===============================//
	//======================== Videos Route Start ===============================//
	Route::get('/homevideos/list','VideosController@show');
	Route::get('/homevideos/create','VideosController@create');
	Route::get('/homevideos/edit/{id}','VideosController@edit');
	Route::get('/homevideos/delete/{id}','VideosController@destroy');
	Route::get('/homevideos','VideosController@index');
	Route::get('/homevideos/export/excel','VideosController@ExportExcel');
	Route::get('/homevideos/export/pdf','VideosController@ExportPDF');
	Route::post('/homevideos','VideosController@store');
	Route::post('/homevideos/ajax','VideosController@ajaxSave');
	Route::post('/homevideos/datatable/ajax','VideosController@datatable');
	Route::post('/homevideos/update/{id}','VideosController@update');
	//======================== Videos Route End ===============================//
	//======================== Package Route Start ===============================//
	Route::get('/package/list','PackageController@show');
	Route::get('/package/create','PackageController@create');
	Route::get('/package/edit/{id}','PackageController@edit');
	Route::get('/package/delete/{id}','PackageController@destroy');
	Route::get('/package','PackageController@index');
	Route::get('/package/export/excel','PackageController@ExportExcel');
	Route::get('/package/export/pdf','PackageController@ExportPDF');
	Route::post('/package','PackageController@store');
	Route::post('/package/ajax','PackageController@ajaxSave');
	Route::post('/package/datatable/ajax','PackageController@datatable');
	Route::post('/package/update/{id}','PackageController@update');
	//======================== Package Route End ===============================//
	//======================== Retail Route Start ===============================//
	Route::get('/retail/list','RetailController@show');
	Route::get('/retail/create','RetailController@create');
	Route::get('/retail/edit/{id}','RetailController@edit');
	Route::get('/retail/delete/{id}','RetailController@destroy');
	Route::get('/retail','RetailController@index');
	Route::get('/retail/export/excel','RetailController@ExportExcel');
	Route::get('/retail/export/pdf','RetailController@ExportPDF');
	Route::post('/retail','RetailController@store');
	Route::post('/retail/ajax','RetailController@ajaxSave');
	Route::post('/retail/datatable/ajax','RetailController@datatable');
	Route::post('/retail/update/{id}','RetailController@update');
	//======================== Retail Route End ===============================//
	//======================== Powerfulcapabilities Route Start ===============================//
	Route::get('/powerfulcapabilities/list','PowerfulcapabilitiesController@show');
	Route::get('/powerfulcapabilities/create','PowerfulcapabilitiesController@create');
	Route::get('/powerfulcapabilities/edit/{id}','PowerfulcapabilitiesController@edit');
	Route::get('/powerfulcapabilities/delete/{id}','PowerfulcapabilitiesController@destroy');
	Route::get('/powerfulcapabilities','PowerfulcapabilitiesController@index');
	Route::get('/powerfulcapabilities/export/excel','PowerfulcapabilitiesController@ExportExcel');
	Route::get('/powerfulcapabilities/export/pdf','PowerfulcapabilitiesController@ExportPDF');
	Route::post('/powerfulcapabilities','PowerfulcapabilitiesController@store');
	Route::post('/powerfulcapabilities/ajax','PowerfulcapabilitiesController@ajaxSave');
	Route::post('/powerfulcapabilities/datatable/ajax','PowerfulcapabilitiesController@datatable');
	Route::post('/powerfulcapabilities/update/{id}','PowerfulcapabilitiesController@update');
	//======================== Powerfulcapabilities Route End ===============================//
	//======================== Whatmakesbetter Route Start ===============================//
	Route::get('/whatmakesbetter/list','WhatmakesbetterController@show');
	Route::get('/whatmakesbetter/create','WhatmakesbetterController@create');
	Route::get('/whatmakesbetter/edit/{id}','WhatmakesbetterController@edit');
	Route::get('/whatmakesbetter/delete/{id}','WhatmakesbetterController@destroy');
	Route::get('/whatmakesbetter','WhatmakesbetterController@index');
	Route::get('/whatmakesbetter/export/excel','WhatmakesbetterController@ExportExcel');
	Route::get('/whatmakesbetter/export/pdf','WhatmakesbetterController@ExportPDF');
	Route::post('/whatmakesbetter','WhatmakesbetterController@store');
	Route::post('/whatmakesbetter/ajax','WhatmakesbetterController@ajaxSave');
	Route::post('/whatmakesbetter/datatable/ajax','WhatmakesbetterController@datatable');
	Route::post('/whatmakesbetter/update/{id}','WhatmakesbetterController@update');
	//======================== Whatmakesbetter Route End ===============================//
	//======================== Couldboostprofitability Route Start ===============================//
	Route::get('/couldboostprofitability/list','CouldboostprofitabilityController@show');
	Route::get('/couldboostprofitability/create','CouldboostprofitabilityController@create');
	Route::get('/couldboostprofitability/edit/{id}','CouldboostprofitabilityController@edit');
	Route::get('/couldboostprofitability/delete/{id}','CouldboostprofitabilityController@destroy');
	Route::get('/couldboostprofitability','CouldboostprofitabilityController@index');
	Route::get('/couldboostprofitability/export/excel','CouldboostprofitabilityController@ExportExcel');
	Route::get('/couldboostprofitability/export/pdf','CouldboostprofitabilityController@ExportPDF');
	Route::post('/couldboostprofitability','CouldboostprofitabilityController@store');
	Route::post('/couldboostprofitability/ajax','CouldboostprofitabilityController@ajaxSave');
	Route::post('/couldboostprofitability/datatable/ajax','CouldboostprofitabilityController@datatable');
	Route::post('/couldboostprofitability/update/{id}','CouldboostprofitabilityController@update');
	//======================== Couldboostprofitability Route End ===============================//
	//======================== Systemeasytouse Route Start ===============================//
	Route::get('/systemeasytouse/list','SystemeasytouseController@show');
	Route::get('/systemeasytouse/create','SystemeasytouseController@create');
	Route::get('/systemeasytouse/edit/{id}','SystemeasytouseController@edit');
	Route::get('/systemeasytouse/delete/{id}','SystemeasytouseController@destroy');
	Route::get('/systemeasytouse','SystemeasytouseController@index');
	Route::get('/systemeasytouse/export/excel','SystemeasytouseController@ExportExcel');
	Route::get('/systemeasytouse/export/pdf','SystemeasytouseController@ExportPDF');
	Route::post('/systemeasytouse','SystemeasytouseController@store');
	Route::post('/systemeasytouse/ajax','SystemeasytouseController@ajaxSave');
	Route::post('/systemeasytouse/datatable/ajax','SystemeasytouseController@datatable');
	Route::post('/systemeasytouse/update/{id}','SystemeasytouseController@update');
	//======================== Systemeasytouse Route End ===============================//

	//======================== Multipleemployeesaccess Route Start ===============================//
	Route::get('/multipleemployeesaccess/list','MultipleemployeesaccessController@show');
	Route::get('/multipleemployeesaccess/create','MultipleemployeesaccessController@create');
	Route::get('/multipleemployeesaccess/edit/{id}','MultipleemployeesaccessController@edit');
	Route::get('/multipleemployeesaccess/delete/{id}','MultipleemployeesaccessController@destroy');
	Route::get('/multipleemployeesaccess','MultipleemployeesaccessController@index');
	Route::get('/multipleemployeesaccess/export/excel','MultipleemployeesaccessController@ExportExcel');
	Route::get('/multipleemployeesaccess/export/pdf','MultipleemployeesaccessController@ExportPDF');
	Route::post('/multipleemployeesaccess','MultipleemployeesaccessController@store');
	Route::post('/multipleemployeesaccess/ajax','MultipleemployeesaccessController@ajaxSave');
	Route::post('/multipleemployeesaccess/datatable/ajax','MultipleemployeesaccessController@datatable');
	Route::post('/multipleemployeesaccess/update/{id}','MultipleemployeesaccessController@update');
	//======================== Multipleemployeesaccess Route End ===============================//
	//======================== Businesspossystem Route Start ===============================//
	Route::get('/businesspossystem/list','BusinesspossystemController@show');
	Route::get('/businesspossystem/create','BusinesspossystemController@create');
	Route::get('/businesspossystem/edit/{id}','BusinesspossystemController@edit');
	Route::get('/businesspossystem/delete/{id}','BusinesspossystemController@destroy');
	Route::get('/businesspossystem','BusinesspossystemController@index');
	Route::get('/businesspossystem/export/excel','BusinesspossystemController@ExportExcel');
	Route::get('/businesspossystem/export/pdf','BusinesspossystemController@ExportPDF');
	Route::post('/businesspossystem','BusinesspossystemController@store');
	Route::post('/businesspossystem/ajax','BusinesspossystemController@ajaxSave');
	Route::post('/businesspossystem/datatable/ajax','BusinesspossystemController@datatable');
	Route::post('/businesspossystem/update/{id}','BusinesspossystemController@update');
	//======================== Businesspossystem Route End ===============================//
	//======================== Coresoftwarecomponents Route Start ===============================//
	Route::get('/coresoftwarecomponents/list','CoresoftwarecomponentsController@show');
	Route::get('/coresoftwarecomponents/create','CoresoftwarecomponentsController@create');
	Route::get('/coresoftwarecomponents/edit/{id}','CoresoftwarecomponentsController@edit');
	Route::get('/coresoftwarecomponents/delete/{id}','CoresoftwarecomponentsController@destroy');
	Route::get('/coresoftwarecomponents','CoresoftwarecomponentsController@index');
	Route::get('/coresoftwarecomponents/export/excel','CoresoftwarecomponentsController@ExportExcel');
	Route::get('/coresoftwarecomponents/export/pdf','CoresoftwarecomponentsController@ExportPDF');
	Route::post('/coresoftwarecomponents','CoresoftwarecomponentsController@store');
	Route::post('/coresoftwarecomponents/ajax','CoresoftwarecomponentsController@ajaxSave');
	Route::post('/coresoftwarecomponents/datatable/ajax','CoresoftwarecomponentsController@datatable');
	Route::post('/coresoftwarecomponents/update/{id}','CoresoftwarecomponentsController@update');
	//======================== Coresoftwarecomponents Route End ===============================//
	//======================== Corehardwarecomponents Route Start ===============================//
	Route::get('/corehardwarecomponents/list','CorehardwarecomponentsController@show');
	Route::get('/corehardwarecomponents/create','CorehardwarecomponentsController@create');
	Route::get('/corehardwarecomponents/edit/{id}','CorehardwarecomponentsController@edit');
	Route::get('/corehardwarecomponents/delete/{id}','CorehardwarecomponentsController@destroy');
	Route::get('/corehardwarecomponents','CorehardwarecomponentsController@index');
	Route::get('/corehardwarecomponents/export/excel','CorehardwarecomponentsController@ExportExcel');
	Route::get('/corehardwarecomponents/export/pdf','CorehardwarecomponentsController@ExportPDF');
	Route::post('/corehardwarecomponents','CorehardwarecomponentsController@store');
	Route::post('/corehardwarecomponents/ajax','CorehardwarecomponentsController@ajaxSave');
	Route::post('/corehardwarecomponents/datatable/ajax','CorehardwarecomponentsController@datatable');
	Route::post('/corehardwarecomponents/update/{id}','CorehardwarecomponentsController@update');
	//======================== Corehardwarecomponents Route End ===============================//
	//======================== Simplecashregister Route Start ===============================//
	Route::get('/simplecashregister/list','SimplecashregisterController@show');
	Route::get('/simplecashregister/create','SimplecashregisterController@create');
	Route::get('/simplecashregister/edit/{id}','SimplecashregisterController@edit');
	Route::get('/simplecashregister/delete/{id}','SimplecashregisterController@destroy');
	Route::get('/simplecashregister','SimplecashregisterController@index');
	Route::get('/simplecashregister/export/excel','SimplecashregisterController@ExportExcel');
	Route::get('/simplecashregister/export/pdf','SimplecashregisterController@ExportPDF');
	Route::post('/simplecashregister','SimplecashregisterController@store');
	Route::post('/simplecashregister/ajax','SimplecashregisterController@ajaxSave');
	Route::post('/simplecashregister/datatable/ajax','SimplecashregisterController@datatable');
	Route::post('/simplecashregister/update/{id}','SimplecashregisterController@update');
	//======================== Simplecashregister Route End ===============================//
	//======================== Retailstore Route Start ===============================//
	Route::get('/retailstore/list','RetailstoreController@show');
	Route::get('/retailstore/create','RetailstoreController@create');
	Route::get('/retailstore/edit/{id}','RetailstoreController@edit');
	Route::get('/retailstore/delete/{id}','RetailstoreController@destroy');
	Route::get('/retailstore','RetailstoreController@index');
	Route::get('/retailstore/export/excel','RetailstoreController@ExportExcel');
	Route::get('/retailstore/export/pdf','RetailstoreController@ExportPDF');
	Route::post('/retailstore','RetailstoreController@store');
	Route::post('/retailstore/ajax','RetailstoreController@ajaxSave');
	Route::post('/retailstore/datatable/ajax','RetailstoreController@datatable');
	Route::post('/retailstore/update/{id}','RetailstoreController@update');
	//======================== Retailstore Route End ===============================//
	//======================== Keyfeature Route Start ===============================//
	Route::get('/keyfeature/list','KeyfeatureController@show');
	Route::get('/keyfeature/create','KeyfeatureController@create');
	Route::get('/keyfeature/edit/{id}','KeyfeatureController@edit');
	Route::get('/keyfeature/delete/{id}','KeyfeatureController@destroy');
	Route::get('/keyfeature','KeyfeatureController@index');
	Route::get('/keyfeature/export/excel','KeyfeatureController@ExportExcel');
	Route::get('/keyfeature/export/pdf','KeyfeatureController@ExportPDF');
	Route::post('/keyfeature','KeyfeatureController@store');
	Route::post('/keyfeature/ajax','KeyfeatureController@ajaxSave');
	Route::post('/keyfeature/datatable/ajax','KeyfeatureController@datatable');
	Route::post('/keyfeature/update/{id}','KeyfeatureController@update');
	//======================== Keyfeature Route End ===============================//

	//======================== Otherfeature Route Start ===============================//
	Route::get('/otherfeature/list','OtherfeatureController@show');
	Route::get('/otherfeature/create','OtherfeatureController@create');
	Route::get('/otherfeature/edit/{id}','OtherfeatureController@edit');
	Route::get('/otherfeature/delete/{id}','OtherfeatureController@destroy');
	Route::get('/otherfeature','OtherfeatureController@index');
	Route::get('/otherfeature/export/excel','OtherfeatureController@ExportExcel');
	Route::get('/otherfeature/export/pdf','OtherfeatureController@ExportPDF');
	Route::post('/otherfeature','OtherfeatureController@store');
	Route::post('/otherfeature/ajax','OtherfeatureController@ajaxSave');
	Route::post('/otherfeature/datatable/ajax','OtherfeatureController@datatable');
	Route::post('/otherfeature/update/{id}','OtherfeatureController@update');
	//======================== Otherfeature Route End ===============================//
	//======================== Pagesetting Route Start ===============================//
	Route::get('/pagesetting/list','PagesettingController@show');
	Route::get('/pagesetting/create','PagesettingController@create');
	Route::get('/pagesetting/edit/{id}','PagesettingController@edit');
	Route::get('/pagesetting/delete/{id}','PagesettingController@destroy');
	Route::get('/pagesetting','PagesettingController@index');
	Route::get('/pagesetting/export/excel','PagesettingController@ExportExcel');
	Route::get('/pagesetting/export/pdf','PagesettingController@ExportPDF');
	Route::post('/pagesetting','PagesettingController@store');
	Route::post('/pagesetting/ajax','PagesettingController@ajaxSave');
	Route::post('/pagesetting/datatable/ajax','PagesettingController@datatable');
	Route::post('/pagesetting/update/{id}','PagesettingController@update');
	//======================== Pagesetting Route End ===============================//
	//======================== Blogs Route Start ===============================//
	Route::get('/blogs/list','BlogsController@show');
	Route::get('/blogs/create','BlogsController@create');
	Route::get('/blogs/edit/{id}','BlogsController@edit');
	Route::get('/blogs/delete/{id}','BlogsController@destroy');
	Route::get('/blogs','BlogsController@index');
	Route::get('/blogs/export/excel','BlogsController@ExportExcel');
	Route::get('/blogs/export/pdf','BlogsController@ExportPDF');
	Route::post('/blogs','BlogsController@store');
	Route::post('/blogs/ajax','BlogsController@ajaxSave');
	Route::post('/blogs/datatable/ajax','BlogsController@datatable');
	Route::post('/blogs/update/{id}','BlogsController@update');
	//======================== Blogs Route End ===============================//
	//======================== Blogcomment Route Start ===============================//
	Route::get('/blogcomment/list','BlogcommentController@show');
	Route::get('/blogcomment/create','BlogcommentController@create');
	Route::get('/blogcomment/edit/{id}','BlogcommentController@edit');
	Route::get('/blogcomment/delete/{id}','BlogcommentController@destroy');
	Route::get('/blogcomment','BlogcommentController@index');
	Route::get('/blogcomment/export/excel','BlogcommentController@ExportExcel');
	Route::get('/blogcomment/export/pdf','BlogcommentController@ExportPDF');
	Route::post('/blogcomment','BlogcommentController@store');
	Route::post('/blogcomment/ajax','BlogcommentController@ajaxSave');
	Route::post('/blogcomment/datatable/ajax','BlogcommentController@datatable');
	Route::post('/blogcomment/update/{id}','BlogcommentController@update');
	//======================== Blogcomment Route End ===============================//
	//======================== Cardpointestoresetting Route Start ===============================//
	Route::get('/cardpointestoresetting/list','CardpointestoresettingController@show');
	Route::get('/cardpointestoresetting/create','CardpointestoresettingController@create');
	Route::get('/cardpointestoresetting/edit/{id}','CardpointestoresettingController@edit');
	Route::get('/cardpointestoresetting/delete/{id}','CardpointestoresettingController@destroy');
	Route::get('/cardpointestoresetting','CardpointestoresettingController@index');
	Route::get('/cardpointestoresetting/export/excel','CardpointestoresettingController@ExportExcel');
	Route::get('/cardpointestoresetting/export/pdf','CardpointestoresettingController@ExportPDF');
	Route::post('/cardpointestoresetting','CardpointestoresettingController@store');
	Route::post('/cardpointestoresetting/ajax','CardpointestoresettingController@ajaxSave');
	Route::post('/cardpointestoresetting/datatable/ajax','CardpointestoresettingController@datatable');
	Route::post('/cardpointestoresetting/update/{id}','CardpointestoresettingController@update');
	//======================== Cardpointestoresetting Route End ===============================//
	//======================== Cardpointe Route Start ===============================//
	Route::get('/cardpointe/list','CardpointeController@show');
	Route::get('/cardpointe/create','CardpointeController@create');
	Route::get('/cardpointe/edit/{id}','CardpointeController@edit');
	Route::get('/cardpointe/delete/{id}','CardpointeController@destroy');
	Route::get('/cardpointe','CardpointeController@index');
	Route::get('/cardpointe/export/excel','CardpointeController@ExportExcel');
	Route::get('/cardpointe/export/pdf','CardpointeController@ExportPDF');
	Route::post('/cardpointe','CardpointeController@store');
	Route::post('/cardpointe/ajax','CardpointeController@ajaxSave');
	Route::post('/cardpointe/datatable/ajax','CardpointeController@datatable');
	Route::post('/cardpointe/update/{id}','CardpointeController@update');
	//======================== Cardpointe Route End ===============================//

	//======================== Signuppackage Route Start ===============================//
	Route::get('/signuppackage/list','SignuppackageController@show');
	Route::get('/signuppackage/create','SignuppackageController@create');
	Route::get('/signuppackage/edit/{id}','SignuppackageController@edit');
	Route::get('/signuppackage/delete/{id}','SignuppackageController@destroy');
	Route::get('/signuppackage','SignuppackageController@index');
	Route::get('/signuppackage/export/excel','SignuppackageController@ExportExcel');
	Route::get('/signuppackage/export/pdf','SignuppackageController@ExportPDF');
	Route::post('/signuppackage','SignuppackageController@store');
	Route::post('/signuppackage/ajax','SignuppackageController@ajaxSave');
	Route::post('/signuppackage/datatable/ajax','SignuppackageController@datatable');
	Route::post('/signuppackage/update/{id}','SignuppackageController@update');
	//======================== Signuppackage Route End ===============================//


	//======================== Hardwarepackage Route Start ===============================//
	Route::get('/hardwarepackage/list', 'HardwarepackageController@show');
	Route::get('/hardwarepackage/create', 'HardwarepackageController@create');
	Route::get('/hardwarepackage/edit/{id}', 'HardwarepackageController@edit');
	Route::get('/hardwarepackage/delete/{id}', 'HardwarepackageController@destroy');
	Route::get('/hardwarepackage', 'HardwarepackageController@index');
	Route::get('/hardwarepackage/export/excel', 'HardwarepackageController@ExportExcel');
	Route::get('/hardwarepackage/export/pdf', 'HardwarepackageController@ExportPDF');
	Route::post('/hardwarepackage', 'HardwarepackageController@store');
	Route::post('/hardwarepackage/ajax', 'HardwarepackageController@ajaxSave');
	Route::post('/hardwarepackage/datatable/ajax', 'HardwarepackageController@datatable');
	Route::post('/hardwarepackage/update/{id}', 'HardwarepackageController@update');
	//======================== Hardwarepackage Route End ===============================//
	//======================== Purchasehardware Route Start ===============================//
	Route::get('/purchasehardware/list', 'PurchasehardwareController@show');
	Route::get('/purchasehardware/create', 'PurchasehardwareController@create');
	Route::get('/purchasehardware/edit/{id}', 'PurchasehardwareController@edit');
	Route::get('/purchasehardware/delete/{id}', 'PurchasehardwareController@destroy');
	Route::get('/purchasehardware', 'PurchasehardwareController@index');
	Route::get('/purchasehardware/export/excel', 'PurchasehardwareController@ExportExcel');
	Route::get('/purchasehardware/export/pdf', 'PurchasehardwareController@ExportPDF');
	Route::post('/purchasehardware', 'PurchasehardwareController@store');
	Route::post('/purchasehardware/ajax', 'PurchasehardwareController@ajaxSave');
	Route::post('/purchasehardware/datatable/ajax', 'PurchasehardwareController@datatable');
	Route::post('/purchasehardware/update/{id}', 'PurchasehardwareController@update');
//======================== Purchasehardware Route End ===============================//
	
});


//======================== Youtubevideogallery Route Start ===============================//
Route::get('/youtubevideogallery/list','YoutubevideogalleryController@show');
Route::get('/youtubevideogallery/create','YoutubevideogalleryController@create');
Route::get('/youtubevideogallery/edit/{id}','YoutubevideogalleryController@edit');
Route::get('/youtubevideogallery/delete/{id}','YoutubevideogalleryController@destroy');
Route::get('/youtubevideogallery','YoutubevideogalleryController@index');
Route::get('/youtubevideogallery/export/excel','YoutubevideogalleryController@ExportExcel');
Route::get('/youtubevideogallery/export/pdf','YoutubevideogalleryController@ExportPDF');
Route::post('/youtubevideogallery','YoutubevideogalleryController@store');
Route::post('/youtubevideogallery/ajax','YoutubevideogalleryController@ajaxSave');
Route::post('/youtubevideogallery/datatable/ajax','YoutubevideogalleryController@datatable');
Route::post('/youtubevideogallery/update/{id}','YoutubevideogalleryController@update');
//======================== Youtubevideogallery Route End ===============================//