<?php

use App\Http\Controllers\API\Mobile\AuthController;
use App\Http\Controllers\API\Mobile\CoursesController;
use App\Http\Controllers\API\Mobile\PrivacySettingsController;
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

// End Auth
Route::get('college/{collage_id}/courses', [CoursesController::class, 'getAllCourses']);
Route::get('college/{collage_id}/courses/show/{id}', [CoursesController::class, 'show_course_by_id']);
Route::get('college/courses/store', [CoursesController::class, 'store_course']);
Route::get('college/courses/update', [CoursesController::class, 'store_course']);

//courses 
Route::prefix('course')->controller(CoursesController::class)->group(function () {
    Route::get('college/{collage_id}', "getAllCourses");
    Route::post('store', 'store_course');
    Route::put('update/{id}', 'update');
    Route::get('show_course_by_id/{collage_id}/{id}', 'show_course_by_id');
    Route::delete('destroy/{id}', 'destroy');
});


Route::middleware(['auth:sanctum'])->group(function () {
    //Auth
    Route::post('logout', [AuthController::class, 'logout']);

    // Get My Account
    Route::get('student/account', [StudentAccountController::class, 'getMyAccount']);
    // Get Student Account
    Route::get('student/{student}/account', [StudentAccountController::class, 'getStudentAccount']);
    // Search For Student
    Route::get('student/search', [StudentAccountController::class, 'searchStudentAccount']);
    // Delete Account
    Route::delete('student/account', [StudentAccountController::class, 'deleteAccount']);
    // Update Account
    Route::patch('student/account', [StudentAccountController::class, 'updateAccount']);

    // My Skills
    Route::get('student/skills', [StudentSkillsController::class, 'getMySkills']);
    // Add To My Skills
    Route::post('student/skills', [StudentSkillsController::class, 'addSkill']);
    // Delete From My Skills
    Route::delete('student/skills/{skill}', [StudentSkillsController::class, 'deleteSkill']);
    // Student Skills
    Route::get('student/{student}/skills', [StudentSkillsController::class, 'getStudentSkills']);

    // My Certificates
    Route::get('student/certificates', [StudentCertificatesController::class, 'getMyCertificates']);
    // Add To My Certificates
    Route::post('student/certificates', [StudentCertificatesController::class, 'addCertificate']);
    // Delete From My Certificates
    Route::delete('student/certificates/{certificate}', [StudentCertificatesController::class, 'deleteCertificate']);
    // Student Certificates
    Route::get('student/{student}/certificates', [StudentCertificatesController::class, 'getStudentCertificates']);

    // Get Privacy
    Route::get('student/privacy', [PrivacySettingsController::class, 'getPrivacySettings']);
    // Update Privacy
    Route::patch('student/privacy', [PrivacySettingsController::class, 'updatePrivacySettings']);


    // Get My Followers
    Route::get('student/followers', [StudentFollowController::class, 'getMyFollowers']);
    // Get My Following
    Route::get('student/following', [StudentFollowController::class, 'getMyFollowing']);
    // Follow Student
    Route::post('student/{student}/follow', [StudentFollowController::class, 'followStudent']);
    // UnFollow Student
    Route::post('student/{student}/unfollow', [StudentFollowController::class, 'unfollowStudent']);
});
// Get College Courses
