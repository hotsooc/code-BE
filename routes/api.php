<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
use App\Models\PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//page
Route::get('page/all', [PageController::class, 'index']);

//section
Route::post('section/get-by-page', [SectionController::class, 'index']);

//component
Route::post('component/get-by-section', [ComponentController::class, 'index']);

//class
Route::post('class/high-light', [ClassController::class, 'getHighlightClasses']);
