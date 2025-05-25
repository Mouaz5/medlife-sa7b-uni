<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        return response()->json(
            ApiFormatter::success('Colleges retrieved successfully', $colleges)
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id'
        ]);

        $college = College::query()->create($request->all());
        return response()->json(
            ApiFormatter::success('College created successfully', $college)
        );
    }


    public function show($id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        return response()->json(
            ApiFormatter::success('College retrieved successfully', $college)
        );
    }


    public function update(Request $request, $id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id'
        ]);

        $college->update([
            'name' => isset($request->name) ? $request->name : $college->name,
            'university_id' => isset($request->university_id) ? $request->university_id : $college->university_id
        ]);

        return response()->json(
            ApiFormatter::success('College retrieved successfully', $college)
        );
    }


    public function destroy($id)
    {
        $college = College::query()->find($id);

        if (!$college) {
            return response()->json(
                ApiFormatter::notFound('collage not found'),
                ApiFormatter::HTTP_NOT_FOUND
            );
        }

        $college->delete();

        return response()->json(
            ApiFormatter::success('College deleted successfully')
        );
    }
}
