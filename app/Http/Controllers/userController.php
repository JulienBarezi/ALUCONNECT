<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public function index(){
        $users = User::all();
        return response()->json($users);
    }

    public function show($id){
        $users = User::find($id);
        return response()->json($users);
    }

    public function update(Request $request){
        
        $id = Auth::user() -> id;
        $user = User::find($id);

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();

        if($request->file('avatar')){
            $file_name = 'aluconnect-' . $this->unique_code(9) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('uploads/images'), $file_name);
            $profile = $file_name;
        }

        else{
            $profile = 'user-profile.png';
        }
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'tag' => $request->input('tag'),
            'profile' => $profile
        ];
        $user->update($userData);
        $status = true;
        $message = $user;

        // response
        $response = [
            'status' => $status,
            'message' => $message,
        ];
        return response()->json($response);
    }
}
