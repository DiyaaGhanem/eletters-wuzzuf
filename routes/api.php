<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CorporateController;
use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\InterviewStatusController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::middleware(['api', 'jwtMiddleware'])->group(function () {
    /**************************************** Category Routes ***************************************************/
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('category/create', [CategoryController::class, 'createCategory']);
    Route::post('category/update', [CategoryController::class, 'updateCategory']);
    Route::post('category/delete', [CategoryController::class, 'softDeleteCategory']);
    Route::post('category/restore', [CategoryController::class, 'restoreCategory']);
    Route::get('category/show', [CategoryController::class, 'getCategoryById']);

    /**************************************** Corporates Routes ***************************************************/
    Route::get('/corporates', [CorporateController::class, 'index']);
    Route::post('corporate/create', [CorporateController::class, 'createCorporate']);
    Route::post('corporate/update', [CorporateController::class, 'updateCorporate']);
    Route::post('corporate/delete', [CorporateController::class, 'softDeleteCorporate']);
    Route::post('corporate/restore', [CorporateController::class, 'restoreCorporate']);
    Route::get('corporate/show', [CorporateController::class, 'getCorporateById']);

    /**************************************** Jobs Routes ***************************************************/
    Route::get('/jobs', [JobController::class, 'index']);
    Route::post('job/create', [JobController::class, 'createJob']);
    Route::post('job/update', [JobController::class, 'updateJob']);
    Route::post('job/delete', [JobController::class, 'softDeleteJob']);
    Route::post('job/restore', [JobController::class, 'restoreJob']);
    Route::get('job/show', [JobController::class, 'getJobById']);

    /**************************************** Applications Routes ***************************************************/
    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::post('application/create', [ApplicationController::class, 'createApplication']);
    Route::post('application/update', [ApplicationController::class, 'updateApplication']);
    Route::post('application/delete', [ApplicationController::class, 'softDeleteApplication']);
    Route::post('application/restore', [ApplicationController::class, 'restoreApplication']);
    Route::get('application/show', [ApplicationController::class, 'getApplicationById']);

    /**************************************** Reviews Routes ***************************************************/
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::post('review/create', [ReviewController::class, 'createReview']);
    Route::post('review/update', [ReviewController::class, 'updateReview']);
    Route::post('review/delete', [ReviewController::class, 'softDeleteReview']);
    Route::post('review/restore', [ReviewController::class, 'restoreReview']);
    Route::get('review/show', [ReviewController::class, 'getReviewById']);

    /**************************************** Interviews Routes ***************************************************/
    Route::get('/interviews', [InterviewController::class, 'index']);
    Route::post('interview/create', [InterviewController::class, 'createInterview']);
    Route::post('interview/update', [InterviewController::class, 'updateInterview']);
    Route::post('interview/delete', [InterviewController::class, 'softDeleteInterview']);
    Route::post('interview/restore', [InterviewController::class, 'restoreInterview']);
    Route::get('interview/show', [InterviewController::class, 'getInterviewById']);

    /**************************************** Interview Statuses Routes ***************************************************/
    Route::get('/interview-statuses', [InterviewStatusController::class, 'index']);
    Route::post('interview-status/create', [InterviewStatusController::class, 'createInterviewStatus']);
    Route::post('interview-status/update', [InterviewStatusController::class, 'updateInteriewStatus']);
    Route::post('interview-status/delete', [InterviewStatusController::class, 'softDeleteInteriewStatus']);
    Route::post('interview-status/restore', [InterviewStatusController::class, 'restoreInteriewStatus']);
    Route::get('interview-status/show', [InterviewStatusController::class, 'getInteriewStatusById']);
});
