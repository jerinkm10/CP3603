<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [LoginController::class, 'getLogin']);
Route::get('/users', [HomeController::class, 'getUsers']);
Route::get('/login', [LoginController::class, 'getLogin']);
 
Route::post('/login',[LoginController::class, 'postLogin']);

Route::post('/',[LoginController::class, 'postLogin']);
Route::get('/form/getForms', [HomeController::class, 'getForms'])->name('form.getForms');
Route::get('/form/saveFilledForm', [HomeController::class, 'saveFilledForm'])->name('form.saveFilledForm');
Route::get('/form/getFilForm/{id}', [HomeController::class, 'getForm'])->name('form.getForm');
Route::post('/form/saveFormData', [HomeController::class, 'saveFormData']);
Route::group(['middleware' => 'userAuth'], function () {
    Route::get('/dashboard', [HomeController::class, 'home']);
    Route::post('/form/save', [HomeController::class, 'saveForm'])->name('form.saveForm');
    Route::get('/add-form', [HomeController::class, 'showForm'])->name('form.show');
    //Route::get('/form/getForms', [HomeController::class, 'getForms'])->name('form.getForms');
    Route::get('/form/getForm/{id}', [HomeController::class, 'getForm'])->name('form.getForm');
    Route::put('/form/updateForm', [HomeController::class, 'updateForm'])->name('form.updateForm');
    Route::delete('/form/deleteForm/{id}', [HomeController::class, 'deleteForm'])->name('form.deleteForm');
    Route::get('/logout', [LoginController::class, 'logoutUser']);
});
