<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class commentController extends Controller
{
    public function index(){
        $comments = Comment::all();
        foreach($comments as $key => $value){
            $user = User::where(['id' => $value->commentUserid])->get()->first();
            $post = Post::where(['id' => $value->commentPostid])->get()->first();

            $comments[$key]->user = $user;
            $comments[$key]->post = $post;
        }

        return response()->json($comments);
    }

    public function show($postid){
        $comments = Comment::where('commentPostid', $postid)->get();
        foreach($comments as $key => $value){
            $user = User::where(['id' => $value->commentUserid])->get()->first();
            $comments[$key]->user = $user;
        }

        return response()->json($comments);
    }

    public function store(Request $request){
        Validator::make($request->all(), [
            'commentContent' => 'required',
        ])->validate();
        try{
            $createComment = new Comment([
                'commentUserid' => $request->input('commentUserid'),
                'commentPostid' => $request->input('commentPostid'),
                'commentContent' => $request->input('commentContent'),
                'commentedTime' => $request->input('commentedTime'),
            ]);

            $createComment->save();
            $status = true;
            $message = 'Comment created successfully';
        }

        catch (Exception $e) {
            $status = false;
            $message = $e->getMessage();
        }

        // response
        $response = [
            'status' => $status,
            'message' => $message,
        ];
        return response()->json($response);
    }
}
