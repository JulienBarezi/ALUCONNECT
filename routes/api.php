<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\likeController;
use App\Http\Controllers\opportunityController;
use App\Http\Controllers\postController;
use App\Http\Controllers\userController;
// use App\Http\Controllers\profilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Authentication apis

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'tag' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    return User::create([
        'name' => $data['name'],
        'tag' => $data['tag'],
        'email' => $data['email'],
        'profile' => 'user-profile.png',
        'password' => Hash::make($data['password']),
    ]);
});

Route::post('/login', function (Request $request) {
    // $data = $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required|min:8'
    // ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response([
            'message' => 'These credentials do not match our records.',
            'errors' => [
                "email" => false,
                "password" => false
            ]
        ], 404);
    }
    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response($response, 201);
});

Route::post('/logout', function (Request $request) {
    $user = User::where('id', $request->id)->first();
    $user->tokens()->where('tokenable_id', $request->id)->delete();
    return response()->json('Logged Out!');
});

Route::middleware('auth:sanctum')->post('/edit-profile', [userController::class, 'update']);

Route::middleware('auth:sanctum')->get('/posts/{id}', [postController::class, 'show']);
Route::middleware('auth:sanctum')->get('/posts/category/{id}', [postController::class, 'showbyCategory']);
Route::middleware('auth:sanctum')->get('/profile/posts', [postController::class, 'showAuthuserPosts']);
Route::middleware('auth:sanctum')->get('/posts/profile/category/{id}', [postController::class, 'showAuthuserPostsByCat']);


Route::middleware('auth:sanctum')->post('/like/{id}', [likeController::class, 'like']);
Route::middleware('auth:sanctum')->post('/unlike/{id}', [likeController::class, 'unlike']);

Route::middleware('auth:sanctum')->get('/opportunities/category/{id}', [opportunityController::class, 'showbyCategory']);
Route::middleware('auth:sanctum')->get('/profile/opportunities', [opportunityController::class, 'showAuthuserOpps']);
Route::middleware('auth:sanctum')->get('/opportunities/profile/category/{id}', [opportunityController::class, 'showAuthuserOppsByCat']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'categories' => categoryController::class,
        'posts' => postController::class,
        'opportunities' => opportunityController::class,
        'likes' => likeController::class,
        'users' => userController::class,
        'comments' => commentController::class
    ]);
});
