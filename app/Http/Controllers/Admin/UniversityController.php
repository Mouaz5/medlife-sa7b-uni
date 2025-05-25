<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{

    public function index()
    {
        $universities = University::all();
        return response()->json(
            ApiFormatter::success('Universites retrived', $universities)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:universities'
        ]);

        $university = University::query()->create($request->only('name'));

        return response()->json(
            ApiFormatter::success('University Created Successfully', $university)
        );
    }

    public function show($id)
    {
        $university = University::query()->find($id);

        if (!$university) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        return response()->json(
            ApiFormatter::success('university', $university)
        );
    }

    public function update(Request $request, $id)
    {
        $university = University::query()->find($id);

        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:universities'
        ]);

        $university->update($request->all());

        return response()->json(
            ApiFormatter::success('University Updated Successfully', $university)
        );
    }

    public function destroy($id)
    {
        $university = University::query()->find($id);

        if (!$university) {
            return response()->json(
                ApiFormatter::notFound()
            );
        }

        $university->delete();

        return response()->json(
            ApiFormatter::success('University Deleted Successfully')
        );
    }
    public function colleges($universityId)
    {
        $university = University::with('colleges')->find($universityId);

        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        if ($university->colleges->isEmpty()) {
            return response()->json([
                'message' => 'This university has no colleges yet',
                'university' => [
                    'id' => $university->id,
                    'name' => $university->name
                ]
            ], 200);
        }

        return response()->json($university->colleges);
    }
}
