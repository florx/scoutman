<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$monolog = Log::getMonolog();
$syslog = new \Monolog\Handler\SyslogHandler('papertrail');
$formatter = new \Monolog\Formatter\LineFormatter('%channel%.%level_name%: %message% %extra%');
$syslog->setFormatter($formatter);

$monolog->pushHandler($syslog);


Event::listen('illuminate.query', function($query)
{
    //var_dump($query);
});

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('youths', 'YouthController');
Route::resource('parents', 'ParentController');
Route::resource('surgeries', 'SurgeryController');

/* Comm */
Route::get('comm', 'CommController@index');
Route::post('comm', 'CommController@storeOptions');
Route::get('comm/recipients', 'CommController@recipients');
Route::post('comm/recipients', 'CommController@storeRecipients');
Route::get('comm/preview', 'CommController@preview');
Route::post('comm/send', 'CommController@send');

Route::get('comm/sms', 'CommController@sms');
Route::get('comm/sms/{sms}', 'CommController@smsView');
Route::get('comm/emails', 'CommController@emails');
Route::get('comm/emails/{emails}', 'CommController@emailView');

Route::get('delivery/sms', 'DeliveryController@sms');
Route::post('delivery/sms', 'DeliveryController@sms');

/* Badges */
Route::get('badges', 'BadgeController@index');
Route::get('badges/youthReport', 'BadgeController@youthReport');
Route::get('badges/youthReport/rerun', 'BadgeController@youthReportRerun');
Route::get('badges/{badges}', 'BadgeController@show');
Route::post('badges/{badges}', 'BadgeController@store');
Route::get('youths/{youths}/badges', 'BadgeController@indexYouthBadges');
Route::get('youths/{youths}/badges/massAssign', 'BadgeController@showYouthBadgesMassAssign');
Route::post('youths/{youths}/badges/massAssign', 'BadgeController@saveYouthBadgesMassAssign');
Route::get('youths/{youths}/badges/{badges}', 'BadgeController@showYouthBadges');
Route::post('youths/{youths}/badges/{badges}', 'BadgeController@storeYouthBadges');

Route::get('reports/verifyDetails', 'ReportController@verifyDetails');

Route::get('me/filter', 'MeController@filter');
Route::patch('me/filter', 'MeController@saveFilter');
Route::delete('me/filter', 'MeController@deleteFilter');
Route::get('me/tfa', 'MeController@getTfa');
Route::post('me/tfa', 'MeController@postTfa');