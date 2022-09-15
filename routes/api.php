<?php


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoriesController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
//     $request->user()->currentAccessToken()->delete();
// });

Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    Auth::user()->tokens()->delete();
});

Route::post('/login', function (Request $request) {
    $credenciais = $request->only(['email', 'password']);
    if (Auth::attempt($credenciais) === false) {
        return response()->json('Unauthorized', 401);
    }
    ;
    $user = Auth::user();
    $token = $user->createToken('token');
    return response()->json($token);
});

//Rotas autenticadas

Route::middleware('auth:sanctum')->group(function () {
    //posts
    Route::post('/posts', [PostsController::class , 'store']);
    Route::delete('/posts/{id}', [PostsController::class , 'destroy']);
    Route::put('/posts/{id}', [PostsController::class , 'update']);

    //categorias
    Route::post('/categories', [CategoriesController::class , 'store']);
    Route::delete('/categories/{id}', [CategoriesController::class , 'destroy']);
    Route::put('/categories/{id}', [CategoriesController::class , 'update']);
});

//Rotas Públicas

//Posts
Route::get('/posts', [PostsController::class , 'index']);
Route::get('/posts/{id}', [PostsController::class , 'show']);

//Categorias
Route::get('/categories', [CategoriesController::class , 'index']);
Route::get('/categories/{id}/posts', [PostsController::class , 'show_post_by_category']);
