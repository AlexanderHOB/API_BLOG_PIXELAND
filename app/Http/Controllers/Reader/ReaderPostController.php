<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Reader;
use Illuminate\Http\Request;

class ReaderPostController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,reader')->only('index');

    }
    public function index(Reader $reader)
    {
        $posts = $reader->actions()->with('post')->get()->pluck('post')->unique('id')->values();
        return $this->showAll($posts);
    }

}
