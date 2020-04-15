<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Reader;
use Illuminate\Http\Request;

class ReaderActionController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,reader')->only('index');

    }
    public function index(Reader $reader)
    {
        $actions = $reader->actions;
        return $this->showAll($actions);
    }

   
}
