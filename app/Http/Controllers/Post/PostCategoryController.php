<?php

namespace App\Http\Controllers\Post;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PostCategoryController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only('index');
        $this->middleware('auth:api')->except('index');

        $this->middleware('can:update,post')->only('update');
        $this->middleware('can:delete,post')->only('destroy');

    }

    public function index(Post $post)
    {
        $categories = $post->categories;
        return $this->showAll($categories);
    }


   
    public function update(Request $request, Post $post, Category $category)
    {
        $post->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($post->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Category $category)
    {
        if(!$post->categories()->find($category->id)){
            return $this->errorResponse('La categoría especificada no es una categoría del presente post',404);
        }
        $post->categories()->detach([$category->id]);

        return $this->showAll($post->categories);

    }
}
