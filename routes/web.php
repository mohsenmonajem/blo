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

use App\Http\Middleware\checksession;
use App\Http\Middleware\updatestudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Student;

Route::get('/home/login','homeController@login');
Route::post('/modir/checkdata','modirsaytController@checkdata');
Route::get('/modir/dars','modirsaytController@createdars');
Route::post('/modir/savaedatadars','modirsaytController@savedatadars');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/system/login', 'homeController@login');
Route::post('/system/checklogin', 'homeController@checklogin');
Route::get('/home/register','homeController@register');
Route::post('/home/savedata','homeController@savedata');
Route::get('/system/checklogin','homeController@checklogin');
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'checksessioncookies'], function() {
    Route::get('/home/register','homeController@register');
    Route::post('/savedarsteacher','teacherController@savedarsteacher');
    Route::get('/home/update','homeController@update');
    Route::post('/home/updatedata','homeController@updatedata');
    Route::get('/teacher/takedars','teacherController@takedars');
     Route::get('/student/showclass','studentController@showclassview');
     Route::post('/teacher/saveclass','teacherController@saveclass');
    Route::get('/teacher/requestclass', 'teacherController@requestclass');
    Route::post('/getpayedars','teacherController@getpayedars');
    Route::post('/getstudentclass','studentController@getclassinformation');
    Route::post('/teacher/savedars/{id}','teacherController@savedars');
    Route::post('/sabtenam','studentController@sabtenam');
    Route::get('/teacher/showclassdetail','teacherController@showclass');
    Route::post('/getclassmember','teacherController@studentmember');
    Route::get('/student/sendteacher','studentController@demandteacher');
    Route::post('/getteacherdetail','teacherController@teacherdetail');
    Route::post('/savestudentdemand','studentController@savestudentdemand');
    Route::get('/teacher/showmessagegetdars','teacherController@showmessagegetdars');
    Route::post('/getnamestudent','teacherController@getnamestudent');
    Route::get('/teacher/showusermessage/{userid}/{darsid}','teacherController@getmessage');
    Route::get('/replyteacher','teacherController@replyteacher');
});



?>
