<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LectureTypeController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
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
Route::post('class/get-by-id', [ClassController::class, 'getById']);

//feedback
Route::post('feedback/all', [FeedbackController::class, 'index']);

//lecturer
Route::post('lecturer/all', [LecturerController::class, 'index']);

//news categories
Route::post('news-category/all', [NewsCategoryController::class, 'index']);

//news categories
Route::post('news/get-by-category', [NewsController::class, 'getByCategory']);
Route::post('news/get-by-slug', [NewsController::class, 'getBySlug']);
Route::post('news/get-related', [NewsController::class, 'getRelatedNews']);

//document type
Route::post('document-type/all', [DocumentTypeController::class, 'index']);

//lecture type
Route::post('lecture-type/all', [LectureTypeController::class, 'index']);

//document
Route::post('document/get-by-document-type', [DocumentController::class, 'getByDocumentType']);
Route::post('document/get-by-id', [DocumentController::class, 'getById']);

//lecture
Route::post('lecture/get-by-lecture-type', [LectureController::class, 'getByLectureType']);
Route::post('lecture/get-by-id', [LectureController::class, 'getById']);
