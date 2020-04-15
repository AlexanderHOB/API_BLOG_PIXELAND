<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Post;
use Illuminate\Http\Request;

class PostReaderController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }
    public function index(Post $post)
    {
        $this->allowedAdminAction();
        $readers = $post->actions()->with('reader')->get()->pluck('reader')->unique('id')->values();
        return $this->showAll($readers);
    }

}
