<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class likeController extends Controller
{
    public function index(){
        $likes = Like::all();

        foreach($likes as $key => $value){
            $user = User::where(['id' => $value->likeUserid])->get()->first();
            $post = Post::where(['id' => $value->likePostid])->get()->first();

            $likes[$key]->user = $user;
            $likes[$key]->post = $post;
        }

        return response()->json($likes);
    }

    public function like($id){
        $post = Post::find($id);
        return Like::create([
            'likeUserid' => Auth::id(),
            'likePostid' => $post->id
        ]);
    }

    public function unlike($id){
        $post = Post::find($id);

        Like::where('likeUserid', Auth::id())
        ->where('likePostid', $post->id)
        ->first()
        ->delete();

        return 1;
    }
}
