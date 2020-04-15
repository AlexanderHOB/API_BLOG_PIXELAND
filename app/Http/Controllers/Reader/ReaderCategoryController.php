<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Reader;
use Illuminate\Http\Request;

class ReaderCategoryController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,reader')->only('index');
    }
    public function index(Reader $reader)
    {
        $categories  = $reader->actions()->with('post.categories')->get()->pluck('post.categories')->collapse()->unique('id')->values();
        return $this->showAll($categories);
    }

   
}
