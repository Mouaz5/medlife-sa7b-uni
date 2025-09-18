<?php

use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Student\AccountController;
use App\Http\Controllers\Student\CertificatesController;
use App\Http\Controllers\Student\ComplaintController;
use App\Http\Controllers\Student\CourseController;
use App\Http\Controllers\Student\FollowController;
use App\Http\Controllers\Student\LectureController;
use App\Http\Controllers\Student\LectureUploadController;
use App\Http\Controllers\Student\PostController;
use App\Http\Controllers\Student\PrivacySettingsController;
use App\Http\Controllers\Student\SearchController;
use App\Http\Controllers\Student\SkillsController;
use Illuminate\Support\Facades\Route;

Route::post('register/otp', [AuthController::class, 'requestOTPForRegistration']);
Route::post('register/verify', [AuthController::class, 'verifyOTPForRegistration']);
Route::post('register/complete', [AuthController::class, 'completeRegistration']);

Route::post('login', [AuthController::class, 'login']);
//admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum','admin']], function () {
    // universities (delete,update,store)
    Route::apiResource('universities', UniversityController::class);
    //colleges(delete,update,store)
    Route::apiResource('colleges', CollegeController::class);
    // Get colleges for a specific university
    Route::get('universities/{university}/colleges', [UniversityController::class, 'colleges']);

    // Admin Academic Guidance
    Route::group(['prefix' => 'academic-guidance'], function () {
        Route::post('/course/{course}', [App\Http\Controllers\Admin\AcademicGuidanceController::class, 'store']);
        Route::delete('/{academicGuidance}', [App\Http\Controllers\Admin\AcademicGuidanceController::class, 'destroy']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'student', 'middleware' => ['auth:sanctum','student']], function () {
    // Account
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'account']);
        Route::get('/{student}', [AccountController::class, 'getStudentAccount']);
        Route::post('update', [AccountController::class, 'updateAccount']);
        Route::delete('delete', [AccountController::class, 'deleteAccount']);
    });
    // Search
    Route::group(['prefix' => 'search'], function () {
        Route::get('/', [SearchController::class, 'searchStudentAccount']);
    });
    // Skills
    Route::group(['prefix' => 'skills'], function () {
        Route::get('/', [SkillsController::class, 'index']);
        Route::get('/my-skills', [SkillsController::class, 'mySkills']);
        Route::get('students/{student}', [SkillsController::class, 'getStudentSkills']);
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
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::post('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
    });
    Route::group(['prefix' => 'complaints'], function () {
        Route::get('/', [ComplaintController::class, 'index']);
        Route::get('/types', [ComplaintController::class, 'getComplaintTypes']);
        Route::get('/{complaint}', [ComplaintController::class, 'show']);
        Route::post('/send', [ComplaintController::class, 'store']);
        Route::put('/{complaint}', [ComplaintController::class, 'update']);
        Route::delete('/{complaint}', [ComplaintController::class, 'destroy']);
    });
    // Privacy
    Route::group(['prefix' => 'privacy'], function () {
        Route::get('/', [PrivacySettingsController::class, 'index']);
        Route::patch('/', [PrivacySettingsController::class, 'update']);
    });
    // courses
    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/my-courses', [CourseController::class, 'myCourses']);
        Route::get('/{course}', [CourseController::class, 'show']);

        // lectures
        Route::group(['prefix' => '{course}'], function () {
            Route::get('/lectures', [LectureController::class, 'index']);
            Route::get('/slides', [LectureController::class, 'slides']);
            Route::get('/audios', [LectureController::class, 'audios']);
            Route::get('/summaries', [LectureController::class, 'summaries']);
            Route::get('/academic-guidance', [LectureController::class, 'academicGuidance']);
            Route::get('/announcements', [LectureController::class, 'announcements']);
            Route::get('/correction-scales', [LectureController::class, 'correctionScales']); 
        });
    });

    // Individual File Details and Downloads
    Route::group(['prefix' => 'files'], function () {
        // Get individual file details
        Route::get('/slides/{slide}', [LectureController::class, 'getSlide']);
        Route::get('/audios/{audio}', [LectureController::class, 'getAudio']);
        Route::get('/summaries/{summary}', [LectureController::class, 'getSummary']);
        
        // Download files
        Route::get('/slides/{slide}/download', [LectureController::class, 'downloadSlide']);
        Route::get('/audios/{audio}/download', [LectureController::class, 'downloadAudio']);
        Route::get('/summaries/{summary}/download', [LectureController::class, 'downloadSummary']);
    });

    // Lecture File Uploads
    Route::group(['prefix' => 'lectures'], function () {
        // Upload routes for lecture files
        Route::post('/{lecture}/upload/slides', [LectureUploadController::class, 'uploadSlides']);
        Route::post('/{lecture}/upload/audios', [LectureUploadController::class, 'uploadAudios']);
        Route::post('/{lecture}/upload/summaries', [LectureUploadController::class, 'uploadSummaries']);
        Route::post('/{lecture}/upload/handouts', [LectureUploadController::class, 'uploadHandouts']);
        
        // Delete routes for lecture files
        Route::delete('/slides/{slide}', [LectureUploadController::class, 'deleteSlide']);
        Route::delete('/audios/{audio}', [LectureUploadController::class, 'deleteAudio']);
        Route::delete('/summaries/{summary}', [LectureUploadController::class, 'deleteSummary']);
        Route::delete('/handouts/{handout}', [LectureUploadController::class, 'deleteHandout']);
    });
    
    // Feedback
    Route::group(['prefix' => 'feedbacks'], function () {
        Route::get('/course/{course}', [App\Http\Controllers\Student\FeedbackController::class, 'index']);
        Route::get('/{feedback}', [App\Http\Controllers\Student\FeedbackController::class, 'show']);
        Route::post('/{feedback}/submit', [App\Http\Controllers\Student\FeedbackController::class, 'store']);
    });
    
    // Academic Guidance
    Route::group(['prefix' => 'academic-guidance'], function () {
        Route::get('/', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'index']);
        Route::post('/', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'store']);
        Route::post('/{academicGuidance}', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'update']);
        Route::delete('/{academicGuidance}', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'destroy']);
        Route::get('/course/{course}', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'getCourseGuidance']);
        Route::post('/filter/type', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'filterByType']);
        Route::post('/filter/date', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'filterByDate']);
        Route::post('/{academicGuidance}/vote', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'vote']);
        Route::get('/{academicGuidance}/vote-stats', [App\Http\Controllers\Student\AcademicGuidanceController::class, 'getVoteStats']);
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

Route::get('register/colleges', [App\Http\Controllers\AuthController::class, 'getCollegesForRegistration']);
Route::get('register/courses', [App\Http\Controllers\AuthController::class, 'getCoursesForRegistration']);
Route::get('register/study-years', [App\Http\Controllers\AuthController::class, 'getStudyYearsForRegistration']);
Route::get('register/specializations', [App\Http\Controllers\AuthController::class, 'getSpecializationsForRegistration']);
