<?php
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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



Route::get('send-mail', function () {
   
  $details = [
      'title' => 'Mail from Online Web Tutor',
      'body' => 'Test mail sent by Laravel 8 using SMTP.'
  ];
 
  Mail::to('krishnapawar90906@gmail.com')->send(new \App\Mail\MyTestMail($details));
 
  dd("Email is Sent, please check your inbox.");
});

Route::get('/home', function () {
     return view('welcome');
})->name('home');;
// Route::get('/signup', function () {
//     return view('admin.auth.signup');
// });
// Route::group(['middleware' =>Authenticate::class ], function () {
// Auth::routes();
// Route::middleware(['auth', 'is_verify_email'])->group(function(){
//     Route::get('/',[App\Http\Controllers\HomeController::class,'home'])->name('home');
//     Route::get('/dasboard',[App\Http\Controllers\HomeController::class,'index'])->name('dasboard');
//     Route::post('/imgstore',[App\Http\Controllers\HomeController::class,'imgstore'])->name('imgstore');
//     Route::post('/likesore',[App\Http\Controllers\HomeController::class,'likesore'])->name('likesore');
//     Route::get('/logout',[App\Http\Controllers\UserController::class,'logout']);

// });

// Route::get('/',[App\Http\Controllers\HomeController::class,'home'])->name('home');




// Route::namespace('Auth')->group(function () {
//Route::get('/home',[App\Http\Controllers\UserController::class,'home'])->name('home');
Route::middleware(['guest'])->group(function(){
    // Route::get('/login',[App\Http\Controllers\UserController::class,'login'])->name('login');
    Route::post('/loginchack',[App\Http\Controllers\UserController::class,'loginchack'])->name('loginchack');

    Route::get('/signup',[App\Http\Controllers\UserController::class,'signup']);
    Route::post('/signupstore',[App\Http\Controllers\UserController::class,'signupstore'])->name('signupstore');
    Route::get('/otpcheck',[App\Http\Controllers\UserController::class,'otpcheck'])->name('otpcheck');
    
    
    // Route::post('/sendOtp', [
    //     'middleware' => 'checkSession',
    //     'uses'=>'App\Http\Controllers\UserController@sendOtp'
    // ]);
    
    // Route::post('/verifyOtp', [
    //     'middleware' => 'checkSession',
    //     'uses'=>'App\Http\Controllers\UserController@verifyOtp'
    // ]);  
});

/* New Added Routes */
//Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware(['auth', 'is_verify_email']); 
Route::get('account/verify/{token}', [App\Http\Controllers\UserController::class, 'verifyAccount'])->name('user.verify'); 
 
Route::post('user/logour',[App\Http\Controllers\LoginController::class, 'userlogout'])->name('admin.userlogout');
Route::group(['prefix' => 'admin'], function() {
	Route::group(['middleware' => 'admin.guest'], function(){
		Route::view('/login','admin.auth.login')->name('admin.login');
        Route::view('/sendotp','admin.auth.sendotp')->name('admin.sendotp');
		Route::post('/login',[App\Http\Controllers\AdminController::class, 'authenticate'])->name('admin.auth');
        Route::post('/sendotp',[App\Http\Controllers\AdminController::class, 'sendotp'])->name('admin.sendotpemail');
    });
	
	Route::group(['middleware' => 'admin.auth'], function(){
		Route::get('/dashboard',[App\Http\Controllers\DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
        
	});
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

