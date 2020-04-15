<?php

namespace App\Http\Controllers\Post;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PostController extends ApiCOntroller
{
    public function __construct(){
        $this->middleware('client.credentials')->only(['index','show']);
    }

    public function index()
    {
        $posts = Post::PostsAvailables(Post::POST_AVAILABLE)->get();
        return $this->showAll($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post->status == Post::POST_AVAILABLE? $this->showOne($post) : null;
    }

}
