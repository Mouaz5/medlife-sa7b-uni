<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrivacySettings\UpdatePrivacySettingsRequest;
use App\Http\Resources\PrivacySettingResource;
use Illuminate\Support\Facades\Auth;

class PrivacySettingsController extends Controller
{

    public function getPrivacySettings()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

        $student = $user->student;
        $privacySettings = $student->privacySettings;

        return response()->json([
            'message' => 'Privacy Settings Retrieved Successfully',
            'data' => new PrivacySettingResource($privacySettings)
        ]);
    }

    public function updatePrivacySettings(UpdatePrivacySettingsRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Account Not Found',
            ], 404);
        }

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

        return response()->json([
            'message' => 'Privacy settings updated successfully!',
            'data' => $privacySetting
        ]);
    }
}
