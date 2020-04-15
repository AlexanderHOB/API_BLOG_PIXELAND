<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryWritterController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only('index');
    }
    public function index(Category $category)
    {
        $this->allowedAdminAction();

        $writters = $category->posts()->with('writter')->get()->pluck('writter')->unique('id')->values();

        return $this->showAll($writters);
    }

   
}
