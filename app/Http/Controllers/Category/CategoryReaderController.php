<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class CategoryReaderController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }
    public function index(Category $category)
    {
        $this->allowedAdminAction();

        $readers = $category->posts()->with('actions.reader')->get()->pluck('actions')->collapse()->pluck('reader')->unique('id')->values();

        return $this->showAll($readers);
    }

    
}
