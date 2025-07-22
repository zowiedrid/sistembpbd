<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'link_maps' => 'required|url',
            'status' => 'required|in:permanen,sementara',
        ]);

        $post = Post::create($validatedData);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'link_maps' => 'required|url',
            'status' => 'required|in:permanen,sementara',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validatedData);

        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}
