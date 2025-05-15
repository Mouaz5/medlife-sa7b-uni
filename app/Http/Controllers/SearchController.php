<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchStudentAccount(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'message' => 'Search string is required.',
            ], 400);
        }

        $query = trim($query);

        $name_parts = array_filter(explode(' ', $query));

        $matching = [];

        foreach ($name_parts as $name) {
            $student_ids = Student::whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$name}%"])
                ->pluck('id')
                ->toArray();

            $matching[] = $student_ids;
        }

        $common_ids = array_shift($matching);
        foreach ($matching as $ids) {
            $common_ids = array_intersect($common_ids, $ids);
        }

        $students = Student::whereIn('id', $common_ids)->get();

        return response()->json([
            'message' => $students->isEmpty() ? 'No students found' : 'Students found successfully.',
            'data' => $students,
        ]);
    }
}
