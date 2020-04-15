<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Reader;
use Illuminate\Http\Request;

class ReaderWritterController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,reader')->only('index');

    }
    public function index(Reader $reader)
    {
        $writters = $reader->actions()->with('post.writter')->get()->pluck('post.writter')->unique('id')->values();
        return $this->showAll($writters);
    }

   
}
