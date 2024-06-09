<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        //
        $post=Post::all();
        return response()-> json($post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public static function create(Request $req)
    {
        //
        $post=new Post;
        $post->title=$req ->title;
        $post->description=$req ->description;

        $result=$post->save();

        if($result){
            return response()->json(['message'=>'Post added'],201);
        }else{
            return response()->json(['message'=>'Error while adding post'],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $post=Post::find($id);

        if(!empty($post)){
            return response()->json(['data'=>$post],201);
        }else{
            return response()->json(['message'=>'Post not found'],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $req,$id)
    {
        //
        $post =Post::find($id);
        $post->title=is_null($req->title) ? $post -> title: $req->title;
        $post->description=is_null($req->description) ? $post->description:$req->description;

        $result=$post->save();
        if($result){
            return response()->json(['message'=>'Post updated','data'=>$post],201);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        if(Post::where('id',$id)->exists()){
            $post=Post::find($id);
            $post->delete();

            return response()->json(['message'=>'Post deleted'],201);

        }else{
            return response()->json(['message'=>'Post not found'],404);

        }

    }
}
