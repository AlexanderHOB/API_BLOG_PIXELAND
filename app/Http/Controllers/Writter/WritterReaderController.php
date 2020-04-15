<?php

namespace App\Http\Controllers\Writter;

use App\Http\Controllers\ApiController;
use App\Writter;
use Illuminate\Http\Request;

class WritterReaderController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,writter')->only('index');
    }
    public function index(Writter $writter)
    {
        $readers = $writter->posts()->with('actions.reader')->get()->pluck('actions')->collapse()->pluck('reader')->unique('id')->values();

        return $this->showAll($readers);
    }

   
}
