<?php

use App\Http\Controllers\Api\ApplicantController;
use App\Http\Controllers\Api\ApplicantEducationController;
use App\Http\Controllers\Api\ApplicantExperienceController;
use App\Http\Controllers\Api\ApplicantLanguagesController;
use App\Http\Controllers\Api\ApplicantSkillsController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CorporateController;
use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\InterviewStatusController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SkillController;
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

/**************************************** Category Routes ***************************************************/
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('category/create', [CategoryController::class, 'createCategory']);
Route::post('category/update', [CategoryController::class, 'updateCategory']);
Route::post('category/delete', [CategoryController::class, 'softDeleteCategory']);
Route::post('category/restore', [CategoryController::class, 'restoreCategory']);
Route::get('category/show', [CategoryController::class, 'getCategoryById']);

/**************************************** Skill Routes ***************************************************/
Route::get('/skills', [SkillController::class, 'index']);
Route::post('skill/create', [SkillController::class, 'createSkill']);
Route::post('skill/update', [SkillController::class, 'updateSkill']);
Route::post('skill/delete', [SkillController::class, 'deleteSkill']);
Route::get('skill/show', [SkillController::class, 'getSkillById']);

/**************************************** Corporates Routes ***************************************************/
Route::get('/corporates', [CorporateController::class, 'index']);
Route::post('corporate/update', [CorporateController::class, 'updateCorporate']);
Route::get('corporate/show', [CorporateController::class, 'getCorporateById']);
Route::get('/get-corporate-by-userId', [CorporateController::class, 'getCorporateByUserId']);
Route::get('/get-corporate-jobs-by-corporateId', [CorporateController::class, 'getCorporateJobsByCorperateId']);

/**************************************** Jobs Routes ***************************************************/
Route::get('/jobs', [JobController::class, 'index']);
Route::get('job/show', [JobController::class, 'getJobById']);
Route::get('/get-applications-by-jobId', [JobController::class, 'getApplicationsByJobId']);


Route::middleware(['api', 'jwtMiddleware'])->group(function () {
    // Route::middleware(['api'])->group(function () {


    /**************************************** Language Routes ***************************************************/
    Route::get('/languages', [LanguageController::class, 'index']);
    Route::post('language/create', [LanguageController::class, 'createLanguage']);
    Route::post('language/update', [LanguageController::class, 'updateLanguage']);
    Route::post('language/delete', [LanguageController::class, 'deleteLanguage']);
    Route::get('language/show', [LanguageController::class, 'getLanguageById']);


    /**************************************** Corporates Routes ***************************************************/
    // Route::get('/corporates', [CorporateController::class, 'index']);
    Route::post('corporate/create', [CorporateController::class, 'createCorporate']);
    // Route::post('corporate/update', [CorporateController::class, 'updateCorporate']);
    Route::post('corporate/delete', [CorporateController::class, 'softDeleteCorporate']);
    Route::post('corporate/restore', [CorporateController::class, 'restoreCorporate']);
    // Route::get('corporate/show', [CorporateController::class, 'getCorporateById']);

    /**************************************** Jobs Routes ***************************************************/
    // Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs-count', [JobController::class, 'jobsCount']);
    Route::post('job/create', [JobController::class, 'createJob']);
    Route::post('job/update', [JobController::class, 'updateJob']);
    Route::post('job/delete', [JobController::class, 'softDeleteJob']);
    Route::post('job/restore', [JobController::class, 'restoreJob']);
    // Route::get('job/show', [JobController::class, 'getJobById']);

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

    /**************************************** Applicants Routes ***************************************************/
    Route::get('/applicants', [ApplicantController::class, 'index']);
    Route::post('applicant/create', [ApplicantController::class, 'createApplicant']);
    Route::post('applicant/update', [ApplicantController::class, 'updateApplicant']);
    Route::post('applicant/delete', [ApplicantController::class, 'softDeleteApplicant']);
    Route::post('applicant/restore', [ApplicantController::class, 'restoreApplicant']);
    Route::get('applicant/show', [ApplicantController::class, 'getApplicantById']);
    Route::get('get-applicant-cv-by-userId', [ApplicantController::class, 'getApplicantCVByUserID']);
    Route::get('get-applicant-by-userId', [ApplicantController::class, 'getApplicantByUserId']);

    /**************************************** Education Routes ***************************************************/
    Route::get('/educations', [ApplicantEducationController::class, 'index']);
    Route::get('/get-educations-by-applicant', [ApplicantEducationController::class, 'getEducationsByApplicant']);
    Route::get('/get-educations-by-userId', [ApplicantEducationController::class, 'getEducationsByUserID']);
    Route::post('education/create', [ApplicantEducationController::class, 'createEducation']);
    Route::post('education/update', [ApplicantEducationController::class, 'updateEducation']);
    Route::post('education/delete', [ApplicantEducationController::class, 'softDeleteEducation']);
    Route::post('education/restore', [ApplicantEducationController::class, 'restoreEducation']);
    Route::get('education/show', [ApplicantEducationController::class, 'getEducationById']);

    /**************************************** Experiences Routes ***************************************************/
    Route::get('/experience', [ApplicantExperienceController::class, 'index']);
    Route::get('/get-experinces-by-applicant', [ApplicantExperienceController::class, 'getExperiencesByApplicant']);
    Route::get('/get-experinces-by-userId', [ApplicantExperienceController::class, 'getExperiencesByUserID']);
    Route::post('experience/create', [ApplicantExperienceController::class, 'createExperience']);
    Route::post('experience/update', [ApplicantExperienceController::class, 'updateExperience']);
    Route::post('experience/delete', [ApplicantExperienceController::class, 'softDeleteExperience']);
    Route::post('experience/restore', [ApplicantExperienceController::class, 'restoreExperience']);
    Route::get('experience/show', [ApplicantExperienceController::class, 'getExperienceById']);

    /**************************************** Applicant Languages Routes ***************************************************/
    Route::get('/applicant-languages', [ApplicantLanguagesController::class, 'index']);
    Route::get('/get-applicant-languages-by-applicant', [ApplicantLanguagesController::class, 'getApplicantLanguagesByApplicant']);
    Route::get('/get-applicant-languages-by-userId', [ApplicantLanguagesController::class, 'getApplicantLanguagesByUserID']);
    Route::post('applicant-language/create', [ApplicantLanguagesController::class, 'createApplicantLanguage']);
    Route::post('applicant-language/update', [ApplicantLanguagesController::class, 'updateApplicantLanguage']);
    Route::post('applicant-language/delete', [ApplicantLanguagesController::class, 'deleteApplicantLanguage']);
    Route::get('applicant-language/show', [ApplicantLanguagesController::class, 'getApplicantLanguageById']);

    /**************************************** Applicant Skills Routes ***************************************************/
    Route::get('/applicant-skills', [ApplicantSkillsController::class, 'index']);
    Route::get('/get-applicant-skills-by-applicant', [ApplicantSkillsController::class, 'getApplicantSkillsByApplicant']);
    Route::get('/get-applicant-skills-by-userId', [ApplicantSkillsController::class, 'getApplicantSkillsByUserID']);
    Route::post('applicant-skill/create', [ApplicantSkillsController::class, 'createApplicantSkill']);
    Route::post('applicant-skill/update', [ApplicantSkillsController::class, 'updateApplicantSkill']);
    Route::post('applicant-skill/delete', [ApplicantSkillsController::class, 'deleteApplicantSkill']);
    Route::get('applicant-skill/show', [ApplicantSkillsController::class, 'getApplicantSkillById']);
});
