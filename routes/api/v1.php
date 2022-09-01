<?php

use App\Http\Controllers\API\V1\IssueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| V1 API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * -------------------------------------------------------------------
 *  Issues API Routes
 * -------------------------------------------------------------------
 *
 * These are routes that are used add and view user issues.
 *
 */
Route::middleware('auth:sanctum')
    ->get('/issues', [IssueController::class, 'index']);

Route::middleware('auth:sanctum')
    ->post('/issues', [IssueController::class, 'store']);
