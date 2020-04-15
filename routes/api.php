<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
** Writters
*/
Route::resource('writters','Writter\WritterController',['only'=>['index','show']]);
Route::resource('writters.posts','Writter\WritterPostController',['except'=>['create','edit']]);
Route::resource('writters.readers','Writter\WritterReaderController',['only'=>['index']]);
Route::resource('writters.categories','Writter\WritterCategoryController',['only'=>['index']]);
Route::get('writter/{id}/myposts','Writter\WritterPostController@myPost');

/*
*   Readers
 */

Route::resource('readers','Reader\ReaderController',['only'=>['index','show']]);
Route::resource('readers.posts','Reader\ReaderPostController',['only'=>['index']]);
Route::resource('readers.writters','Reader\ReaderWritterController',['only'=>['index']]);
Route::resource('readers.categories','Reader\ReaderCategoryController',['only'=>['index']]);
Route::resource('readers.actions','Reader\ReaderActionController',['only'=>['index']]);



Route::resource('posts','Post\PostController',['only'=>['index','show']]);
Route::resource('posts.categories','Post\PostCategoryController',['only'=>['index','update','destroy']]);
Route::resource('posts.readers','Post\PostReaderController',['only'=>['index']]);
Route::resource('posts.actions','Post\PostActionController',['only'=>['index']]);

Route::resource('posts.readers.actions','Post\PostReaderActionController',['only'=>['store','destroy']]);



Route::resource('actions','Action\ActionController',['only'=>['index','show']]);


Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.posts','Category\CategoryPostController',['only'=>['index']]);
Route::resource('categories.writters','Category\CategoryWritterController',['only'=>['index']]);
Route::resource('categories.readers','Category\CategoryReaderController',['only'=>['index']]);





Route::resource('users','User\UserController',['except'=>['create','edit']]);



Route::name('verify')->get('users/verify/{token}','User\UserController@verify');
Route::name('resend')->get('users/{user}/resend','User\UserController@resend');


Route::post('oauth/token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');