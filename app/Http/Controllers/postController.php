<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class postController extends Controller
{

    public function index(){
        $posts = Post::orderBy('id', 'DESC')->get();
        foreach($posts as $key => $value){
            $user = User::where(['id' => $value->postUserid])->get()->first();
            $category = Category::where(['id' => $value->postCategoryid])->get()->first();
            $comments = Comment::where(['commentPostid' => $value->id])->get();
            //  $comments = Comment::addSelect(['user' => User::select('id')->whereColumn('id', 'comments.likeUserid')
            // ->orderBy('id', 'desc')])->where(['likePostid' => $value->id])->get();
            // $likes = Like::addSelect(['user' => User::select('id')->whereColumn('id', 'likes.likeUserid')
            // ->orderBy('id', 'desc')])->where(['likePostid' => $value->id])->get();

            $posts[$key]->user = $user;
            $posts[$key]->category = $category;
            $posts[$key]->comments = $comments;
        }

        return response()->json($posts);
    }

    public function showbyCategory($catid){
        $posts = Post::where('postCategoryid', $catid)->orderBy('id', 'DESC')->get();
        foreach($posts as $key => $value){
            $user = User::where(['id' => $value->postUserid])->get()->first();
            $comments = Comment::where(['commentPostid' => $value->id])->get();

            $posts[$key]->user = $user;
            $posts[$key]->comments = $comments;
        }

        return response()->json($posts);
    }

    public function showAuthuserPosts(){
        $id = Auth::user()->id;
        $posts = Post::where('postUserid', $id)->orderBy('id', 'DESC')->get();
        foreach($posts as $key => $value){
            $comments = Comment::where(['commentPostid' => $value->id])->get();
            $posts[$key]->comments = $comments;
        }

        return response()->json($posts);
    }

    public function showAuthuserPostsByCat($cat){
        $id = Auth::user()->id;
        $posts = Post::where('postCategoryid', $cat)->where('postUserid', $id)->orderBy('id', 'DESC')->get();
        foreach($posts as $key => $value){
            $comments = Comment::where(['commentPostid' => $value->id])->get();
            $posts[$key]->comments = $comments;
        }

        return response()->json($posts);
    }

    public function show($id){
        $post = Post::where('id', $id)->get();
        foreach($post as $key => $value){
            $user = User::where(['id' => $value->postUserid])->get()->first();
            $post[$key]->user = $user;
        }

        return response()->json($post);
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'postUserid' => 'required|integer',
            'postCategoryid' => 'required|integer',
            'postContent' => 'required',
            'postTime' => 'required|date',
        ])->validate();

        try{
            $createPost = new Post([
                'postUserid' => $request->input('postUserid'),
                'postCategoryid' => $request->input('postCategoryid'),
                'postContent' => $request->input('postContent'),
                'postTime' => $request->input('postTime'),
            ]);

            $createPost->save();
            $status = true;
            $message = 'Post created successfully';
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
