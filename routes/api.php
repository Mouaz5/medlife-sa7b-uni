<?php

use App\Http\Controllers\API\Mobile\AuthController;
use App\Http\Controllers\API\Mobile\CoursesController;
use App\Http\Controllers\API\Mobile\PrivacySettingsController;
use App\Http\Controllers\API\Mobile\SearchController;
use App\Http\Controllers\API\Mobile\StudentAccountController;
use App\Http\Controllers\API\Mobile\StudentCertificatesController;
use App\Http\Controllers\API\Mobile\StudentFollowController;
use App\Http\Controllers\API\Mobile\StudentSkillsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Start Auth
Route::post('register/otp', [AuthController::class, 'requestOTPForRegistration']);
Route::post('register/verify', [AuthController::class, 'verifyOTPForRegistration']);
Route::post('register/complete', [AuthController::class, 'completeRegistration']); // needs fixing

Route::post('login/otp', [AuthController::class, 'requestOTPForLogin']);
Route::post('login/verify', [AuthController::class, 'verifyOTPForLogin']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum','admin']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'student', 'middleware' => ['auth:sanctum','student']], function () {
    // Account
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [StudentAccountController::class, 'account']);
        Route::get('/{student}', [StudentAccountController::class, 'getStudentAccount']);
        Route::patch('update', [StudentAccountController::class, 'updateAccount']);
        Route::delete('delete', [StudentAccountController::class, 'deleteAccount']);
    });
    // Search
    Route::group(['prefix' => 'search'], function () {
        Route::get('/', [SearchController::class, 'searchStudentAccount']);
    });
    // Skills
    Route::group(['prefix' => 'skills'], function () {
        Route::get('/', [StudentSkillsController::class, 'index']);
        Route::get('/{student}', [StudentSkillsController::class, 'getStudentSkills']);
        Route::post('/', [StudentSkillsController::class, 'store']);
        Route::delete('/{skill}', [StudentSkillsController::class, 'destroy']);
    });
    // Certificates
    Route::group(['prefix' => 'certificates'], function () {
        Route::get('/', [StudentCertificatesController::class, 'getMyCertificates']);
        Route::get('{student}/student', [StudentCertificatesController::class, 'getStudentCertificates']);
        Route::post('/', [StudentCertificatesController::class, 'addCertificate']);
        Route::delete('/{certificate}', [StudentCertificatesController::class, 'deleteCertificate']);
    });
    // Follow
    Route::group(['prefix' => 'followers'], function () {
        Route::get('/', [StudentFollowController::class, 'index']);
        Route::get('/following', [StudentFollowController::class, 'getMyFollowing']);
        Route::post('/{student}/follow', [StudentFollowController::class, 'followStudent']);
        Route::post('/{student}/unfollow', [StudentFollowController::class, 'unfollowStudent']);
    });
    // Privacy
    Route::group(['prefix' => 'privacy'], function () {
        Route::get('/', [PrivacySettingsController::class, 'index']);
        Route::patch('/', [PrivacySettingsController::class, 'update']);
    });
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::get('college/{id}/courses', [CoursesController::class, 'getAllCourses']);
