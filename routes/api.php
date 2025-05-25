<?php

use App\Http\Controllers\Admin\CollegeController;
use App\Http\ControllersAdmin\UniversityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\Student\AccountController;
use App\Http\Controllers\Student\CertificatesController;
use App\Http\Controllers\Student\FollowController;
use App\Http\Controllers\Student\PrivacySettingsController;
use App\Http\Controllers\Student\SearchController;
use App\Http\Controllers\Student\SkillsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Start Auth
Route::post('register/otp', [AuthController::class, 'requestOTPForRegistration']);
Route::post('register/verify', [AuthController::class, 'verifyOTPForRegistration']);
Route::post('register/complete', [AuthController::class, 'completeRegistration']); // needs fixing

Route::post('login/otp', [AuthController::class, 'requestOTPForLogin']);
Route::post('login/verify', [AuthController::class, 'verifyOTPForLogin']);
//admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum','admin']], function () {
    // universities (delete,update,store)
    Route::apiResource('universities', UniversityController::class);
    //colleges(delete,update,store)
    Route::apiResource('colleges', CollegeController::class);
    // Get colleges for a specific university
    Route::get('universities/{university}/colleges', [UniversityController::class, 'colleges']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'student', 'middleware' => ['auth:sanctum','student']], function () {
    // Account
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'account']);
        Route::get('/{student}', [AccountController::class, 'getStudentAccount']);
        Route::patch('update', [AccountController::class, 'updateAccount']);
        Route::delete('delete', [AccountController::class, 'deleteAccount']);
    });
    // Search
    Route::group(['prefix' => 'search'], function () {
        Route::get('/', [SearchController::class, 'searchStudentAccount']);
    });
    // Skills
    Route::group(['prefix' => 'skills'], function () {
        Route::get('/', [SkillsController::class, 'index']);
        Route::get('/{student}', [SkillsController::class, 'getStudentSkills']);
        Route::post('/', [SkillsController::class, 'store']);
        Route::delete('/{skill}', [SkillsController::class, 'destroy']);
    });
    // Certificates
    Route::group(['prefix' => 'certificates'], function () {
        Route::get('/', [CertificatesController::class, 'getMyCertificates']);
        Route::get('{student}/student', [CertificatesController::class, 'getStudentCertificates']);
        Route::post('/', [CertificatesController::class, 'addCertificate']);
        Route::delete('/{certificate}', [CertificatesController::class, 'deleteCertificate']);
    });
    // Follow
    Route::group(['prefix' => 'followers'], function () {
        Route::get('/', [FollowController::class, 'index']);
        Route::get('/following', [FollowController::class, 'getMyFollowing']);
        Route::post('/{student}/follow', [FollowController::class, 'followStudent']);
        Route::post('/{student}/unfollow', [FollowController::class, 'unfollowStudent']);
    });
    // Privacy
    Route::group(['prefix' => 'privacy'], function () {
        Route::get('/', [PrivacySettingsController::class, 'index']);
        Route::patch('/', [PrivacySettingsController::class, 'update']);
    });
    Route::post('logout', [AuthController::class, 'logout']);
    // Get colleges for a specific university
    Route::get('universities/{university}/colleges', [UniversityController::class, 'colleges']);
    // universities (index,show)
    Route::apiResource('universities', UniversityController::class)->only(['index','show']);
    //colleges(show)
    Route::apiResource('colleges', CollegeController::class)->only(['show']);
});
Route::get('college/{id}/courses', [CoursesController::class, 'getAllCourses']);


