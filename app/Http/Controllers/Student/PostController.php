<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('files')->latest()->get();
        return response()->json(
            ApiFormatter::success('Posts retrieved successfully.',
            PostResource::collection($posts))
        );
    }
    public function show(Post $post) {
        $post->load(['files']);
        return response()->json(
            ApiFormatter::success('Post retrieved successfully.', new PostResource($post))
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:10',
            'visibility' => 'required|in:public,private',
            'files' => 'required|array|nullable'
        ]);
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'student_id' => auth()->user()->student->id
        ]);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/posts', $fileName);
                PostFile::create([
                    'post_id' => $post->id,
                    'file' => 'posts/' . $fileName
                ]);
            }
        }
        return response()->json([
            ApiFormatter::success('Post created successfully.', $post->load(['files']))
        ]);

    }
    public function update(Request $request, Post $post) {
        if ($post->student_id !== auth()->user()->student->id) {
            abort(404, 'You are not authorized to update this post.');
        }
        $validated = $request->validate([
            'title' => 'sometimes|required|string|min:5',
            'description' => 'sometimes|required|string|min:10',
            'visibility' => 'sometimes|required|in:public,private',
            'files' => 'sometimes|array|nullable'
        ]);
        $validated = array_filter($validated, function($value) {
            return !is_null($value);
        });
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/posts', $fileName);
                PostFile::create([
                    'post_id' => $post->id,
                    'file' => 'posts/' . $fileName
                ]);
            }
        }
        $post->update($validated);
        return response()->json([
            ApiFormatter::success('Post updated successfully.', $post->load(['files']))
        ]);
    }
    public function destroy(Post $post) {
        if ($post->student_id !== auth()->user()->student->id) {
            abort(404, 'You are not authorized to delete this post.');
        }
        $post->delete();
        return response()->json(
            ApiFormatter::success('Post deleted successfully.')
        );
    }
}
