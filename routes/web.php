<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect(route('login'));
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){

    /* dashboard Routes */
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /* Users Routes */
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('', [UserController::class, 'index'])
            ->name('index');
        Route::get('/new', [UserController::class, 'create'])
            ->name('create');
        Route::post('/new', [UserController::class, 'store'])
            ->name('store');
        Route::get('{user}', [UserController::class, 'show'])
            ->name('show');
        Route::put('{user}', [UserController::class, 'update'])
            ->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])
            ->name('destroy');
    });

    /* Systems Routes */
    Route::group(['prefix' => 'systems', 'as' => 'systems.'], function () {
        Route::get('', [SystemController::class, 'index'])
            ->name('index');
        Route::get('/new', [SystemController::class, 'create'])
            ->name('create');
        Route::post('/new', [SystemController::class, 'store'])
            ->name('store');
        Route::get('{system:slug}', [SystemController::class, 'show'])
            ->name('show');
        Route::put('{system}', [SystemController::class, 'update'])
            ->name('update');
        Route::delete('{system}', [SystemController::class, 'destroy'])
            ->name('destroy');
    });

    /* Issues Routes */
    Route::group(['prefix' => 'issues', 'as' => 'issues.'], function () {
        Route::get('', [IssueController::class, 'index'])
            ->name('index');
        Route::get('/filter', [IssueController::class, 'filter'])
            ->name('filter');
        Route::get('/new', [IssueController::class, 'create'])
            ->name('create');
        Route::post('/new', [IssueController::class, 'store'])
            ->name('store');
        Route::get('{issue}', [IssueController::class, 'show'])
            ->name('show');
        Route::put('{issue}', [IssueController::class, 'update'])
            ->name('update');
        Route::put('{issue}/assign', [IssueController::class, 'assign'])
            ->name('assign');
        Route::put('{issue}/reject', [IssueController::class, 'reject'])
            ->name('reject');
        Route::delete('{issue}', [IssueController::class, 'destroy'])
            ->name('destroy');
    });

});
