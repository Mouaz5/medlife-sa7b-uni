<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrivacySettings\UpdatePrivacySettingsRequest;
use App\Http\Resources\PrivacySettingResource;
use Illuminate\Support\Facades\Auth;

class PrivacySettingsController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $student = $user->student;
        $privacySettings = $student->privacySettings;

        return response()->json(
            ApiFormatter::success(
                'Privacy Settings Retrived Successfully',
                new PrivacySettingResource($privacySettings)
            )
        );
    }

    public function update(UpdatePrivacySettingsRequest $request)
    {
        $user = Auth::user();

        $student = $user->student;
        $privacySetting = $student->privacySettings;

        if (!$privacySetting) {
            return response()->json(['message' => 'Privacy settings not found.'], 404);
        }

        if ($request->has('show_posts')) {
            $privacySetting->show_posts = $request['show_posts'];
        }

        if ($request->has('profile_visibility')) {
            $privacySetting->profile_visibility = $request['profile_visibility'];
        }

        $privacySetting->save();

        return response()->json(
            ApiFormatter::success(
                'Privacy Settings Updated Successfully',
                $privacySetting
            )
        );
    }
}
