<?php

namespace App\Http\Controllers\Post;

use App\Post;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class PostActionController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only('index');
    }
    public function index(Post $post)
    {
        $actions = $post->actions;
        return $this->showAll($actions);
    }

    
}
