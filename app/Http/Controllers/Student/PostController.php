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
        $posts = Post::with('files')->get();
        return PostResource::collection($posts);
    }
    public function show(Post $post) {
        if ($post->student_id !== auth()->user()->student->id) {
            abort(404, 'You are not authorized to view this post.');
        }
        $post->load(['files']);
        return new PostResource($post);
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
    public function update(Post $post, Request $request) {

    }
    public function destroy(Post $post) {
        if ($post->student_id !== auth()->user()->student->id) {
            abort(404, 'You are not authorized to delete this post.');
        }
        $post->delete();
        return response()->json([
            ApiFormatter::success('Post deleted successfully.')
        ]);
    }
}
