<?php

namespace App\Http\Controllers\Writter;

use App\Http\Controllers\ApiController;
use App\Writter;
use Illuminate\Http\Request;

class WritterCategoryController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,writter')->only('index');

    }
    public function index(Writter $writter)
    {
        $categories = $writter->posts()->with('categories')->get()->pluck('categories')->collapse()->unique('id')->values();
        return $this->showAll($categories);
    }

   
}
