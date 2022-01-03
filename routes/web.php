<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Order_ClientController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\usersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 


        Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function(){
       
            Route::resource('users',usersController::class);

            Route::get('users.delete{id}',[usersController::class,'delete'])->name('users.delete');

            Route::resource('categories',CategoryController::class);

            Route::get('categories.delete{id}',[CategoryController::class,'delete'])->name('categories.delete');
  
            Route::resource('products',ProductController::class);

            Route::get('products.delete{id}',[ProductController::class,'delete'])->name('products.delete');

            Route::resource('clients',ClientController::class);

            Route::get('clients.delete{id}',[ClientController::class,'delete'])->name('clients.delete');

            Route::resource('clients.orders',Order_ClientController::class);

            Route::get('clients/orders/delete{id}',[Order_ClientController::class,'delete'])->name('clients.orders.delete');

           // Route::resource('orders',OrdersController::class);

           Route::get('/orders/index',[OrdersController::class,'index'])->name('orders.index');


            Route::get('/orders/products{id}',[OrdersController::class,'products']);

            Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');

            Route::post('/profile/update/{id}',[ProfileController::class,'update'])->name('profile.update');

            Route::get('/profile/change/password',[ProfileController::class,'change_password_page'])->name('profile.change.password');

            Route::post('/profile/change/password/process',[ProfileController::class,'change_password_process'])->name('profile.change.password.process');


            


        });
     
        
        Route::get('/', function () {
            return view('index');
        })->middleware('auth');

    });
    

   // Auth::routes(['register' => false]);






//Route::get('/dashboard', function () {
  //  return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
