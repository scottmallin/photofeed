<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|max:4096|mimes:jpg,png,mp4'
        ]);

        $filePath = $request->file('file_path')->store('public/postmedia');

        return Post::create([
            'file_path' => $filePath,
            'caption' => request('caption'),
            'user_id' => auth()->id()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id);
    }

    public function getUserPosts($id)
    {
        $user = User::find($id);
        $posts = $user->posts()->get();

        return json_encode($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userId = auth()->id();
        $post = Post::find($id);

        if ($userId == $post->user_id) {
            $post->update([
                'caption' => request('caption')
            ]);

            return $post;
        }

        return response([
            'message' => 'Edit your own post'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::destroy($id);
    }
}
