<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryPostController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only('index');
    }
    public function index(Category $category)
    {
        $posts= $category->posts;
        return $this->showAll($posts);
    }

}
