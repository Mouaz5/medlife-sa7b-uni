<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the feedbacks for a course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Course $course)
    {
        $feedbacks = $course->feedbacks()->with('author')->latest()->get();

        return response()->json(
            ApiFormatter::success(
                'Feedbacks retrieved successfully.',
                $feedbacks
            )
        );
    }

    /**
     * Display the specified feedback.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Feedback $feedback)
    {
        $feedback->load(['author', 'course', 'questions']);

        return response()->json(
            ApiFormatter::success(
                'Feedback retrieved successfully.',
                $feedback
            )
        );
    }

    /**
     * Store answers for a given feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Feedback $feedback)
    {
        $student = Auth::user()->student;

        // Check if student has already submitted feedback
        $existingAnswer = FeedbackAnswer::where('student_id', $student->id)
            ->where('feedback_id', $feedback->id)
            ->exists();

        if ($existingAnswer) {
            return response()->json(ApiFormatter::error('You have already submitted feedback.'), 409);
        }

        if ($feedback->type === 'q&a') {
            $validator = Validator::make($request->all(), [
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|exists:feedback_questions,id',
                'answers.*.answer' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(ApiFormatter::error('Validation Error', $validator->errors()), 422);
            }

            $answersData = [];
            foreach ($request->answers as $answer) {
                $question = $feedback->questions()->find($answer['question_id']);
                if (!$question) {
                    return response()->json(ApiFormatter::error('Invalid question ID.', ['question_id' => 'Question ' . $answer['question_id'] . ' does not belong to this feedback.']), 422);
                }

                $answersData[] = [
                    'student_id' => $student->id,
                    'feedback_id' => $feedback->id,
                    'feedback_question_id' => $answer['question_id'],
                    'answer' => $answer['answer'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            FeedbackAnswer::insert($answersData);

        } elseif ($feedback->type === 'text') {
            $validator = Validator::make($request->all(), [
                'answer' => 'required|string|min:10',
            ]);

            if ($validator->fails()) {
                return response()->json(ApiFormatter::error('Validation Error', $validator->errors()), 422);
            }

            FeedbackAnswer::create([
                'student_id' => $student->id,
                'feedback_id' => $feedback->id,
                'answer' => $request->answer,
            ]);
        } else {
            return response()->json(ApiFormatter::error('Unsupported feedback type.'), 400);
        }

        return response()->json(
            ApiFormatter::success('Feedback submitted successfully.')
        );
    }
}
