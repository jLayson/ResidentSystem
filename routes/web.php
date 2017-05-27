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

// User auth intercept
Route::get('/home', function () {
	if(Auth::user()->account_type == 0){
		return view('userhome');
	}elseif(Auth::user()->account_type == 1){
		return view('securityhome');
	}elseif(Auth::user()->account_type == 2){
		return view('adminhome');	
	}
});

// Resident /profile actions
Route::get('/viewprofile', 'ResidentProfileController@userViewProfile');
Route::post('/editprofile', 'ResidentProfileController@userEditProfile');

//Resident /report actions
Route::get('/filereport', 'ReportController@retrieveReportNatures');
Route::get('/userviewreports', 'ReportController@userViewSubmittedReports');
Route::post('/submitreport', 'ReportController@userFileReport');

//Resident /visitor actions
Route::get('/userviewnotifications', 'VisitorNotificationController@userViewSubmittedNotifications');
Route::post('/submitvisitornotification', 'VisitorNotificationController@userAddNotification');
Route::get('/filevisitornotification', function() {
	return view('visitorform');
});
Route::get('/editnotification/{id}', 'VisitorNotificationController@userEditNotificationForm');
Route::post('/submiteditnotification', 'VisitorNotificationController@userEditNotification');
Route::get('/deletenotification/{id}', 'VisitorNotificationController@userDeleteNotification');


//Admin /profile actions
Route::get('/listprofiles/{offset}', 'ResidentProfileController@adminViewListProfiles');
Route::get('/adminviewprofile/{id}', 'ResidentProfileController@adminViewProfile');

//Admin /visitor actions
Route::get('/listnotifications/{offset}', 'VisitorNotificationController@adminViewAllNotifications');
Route::get('/listpending/{offset}', 'VisitorNotificationController@adminViewPendingNotifications');
Route::get('/verifynotification/{id}', 'VisitorNotificationController@adminVerifyNotification');

//Admin /report actions
Route::get('/listreports/{offset}', 'ReportController@adminListReports');

//Admin /guest actions
Route::get('/guestform', 'GuestController@addGuestForm');
Route::post('/addguest', 'GuestController@addGuestRecord');
Route::get('/listguests/{offset}', 'GuestController@listGuestRecord');
Route::get('/guestdeparture/{id}', 'GuestController@updateGuestDeparture');


//PDF Export /resident
Route::get('/export/resident', 'PdfExportController@residentExport');

//PDF Export /report
Route::get('/export/report', 'PdfExportController@reportExport');

//PDF Export /Visitor Notification
Route::get('/export/visitor/notification', 'PdfExportController@visitorNotifExport');
