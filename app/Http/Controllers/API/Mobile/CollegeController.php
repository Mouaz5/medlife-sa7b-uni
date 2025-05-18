<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        return response()->json($colleges);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $college = College::query()->create($request->all());
            return response()->json($college, 201);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'College name already exists for this university',
                    'errors' => [
                        'name' => ['The college name must be unique within this university']
                    ]
                ], 422);
            }

            return response()->json([
                'message' => 'An error occurred while creating the college'
            ], 500);
        }
    }


    public function show($id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(['message' => 'College not found'], 404);
        }

        return response()->json($college);
    }


    public function update(Request $request, $id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(['message' => 'College not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'university_id' => 'sometimes|required|exists:universities,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $college->update([
            'name' => isset($request->name) ? $request->name : $college->name,
            'university_id' => isset($request->university_id) ? $request->university_id : $college->university_id
        ]);

        return response()->json($college);
    }


    public function destroy($id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(['message' => 'College not found'], 404);
        }

        $college->delete();

        return response()->json(['message' => 'College deleted successfully']);
    }
}
