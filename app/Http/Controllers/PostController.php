<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    //@des get all posts
    //@route GET /api/post/
    //@access public
    public static function index()
    {
        $post=Post::all();
        return response()-> json($post);
    }

    //@des create new post
    //@route POST /api/post/
    //@access private
    public static function create(Request $req)
    {

        $user=auth()->user();
        if(!$user){
            return response()->json(['message'=>'Unauthorized!'],401);
        }

        $post=new Post;
        $post->title=$req ->title;
        $post->u_id=$user['id'];
        $post->description=$req ->description;

        $result=$post->save();

        if($result){
            return response()->json(['message'=>'Post added'],201);
        }else{
            return response()->json(['message'=>'Error while adding post'],500);
        }

    }


    //@des get one post
    //@route GET /api/post/{id}
    //@access public
    public function show($id)
    {

        $post=Post::find($id);

        if(!empty($post)){
            return response()->json(['data'=>$post],201);
        }else{
            return response()->json(['message'=>'Post not found'],404);
        }
    }

    //@des edit a post
    //@route PUT /api/post/{id}
    //@access private
    public function edit(Request $req,$id)
    {
        $user=auth()->user();
        if(!$user){
            return response()->json(['message'=>'Unauthorized!'],401);
        }

        $post =Post::find($id);

        if(!$post){
            return response()->json(['message'=>'Post not found!'],404);
        }

        if($user['id']!=$post['u_id']){
            return response()->json(['message'=>'Unauthorized!'],401);
        }



        $post->title=is_null($req->title) ? $post -> title: $req->title;
        $post->description=is_null($req->description) ? $post->description:$req->description;

        $result=$post->save();
        if($result){
            return response()->json(['message'=>'Post updated','data'=>$post],201);
        }

    }

    //@des delete a post
    //@route DELETE /api/post/{id}
    //@access private
    public function destroy($id)
    {
        $user=auth()->user();
        if(!$user){
            return response()->json(['message'=>'Unauthorized!'],401);
        }

        $post =Post::find($id);
        if(!$post){
            return response()->json(['message'=>'Post not found!'],404);
        }
        if($user['id']!=$post['u_id']){
            return response()->json(['message'=>'Unauthorized!'],401);
        }

        if(Post::where('id',$id)->exists()){
            $post=Post::find($id);
            $post->delete();

            return response()->json(['message'=>'Post deleted'],201);

        }else{
            return response()->json(['message'=>'Post not found'],404);

        }

    }
}
