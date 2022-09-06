<?php


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoriesController;
use App\Models\Category;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);
Route::post('/posts', [PostsController::class, 'store']);
Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
Route::put('/posts/{id}', [PostsController::class, 'update']);

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{id}/posts',[PostsController::class, 'show_post_by_category']);
Route::post('/categories', [CategoriesController::class, 'store']);
Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);
Route::put('/categories/{id}', [CategoriesController::class, 'update']);
