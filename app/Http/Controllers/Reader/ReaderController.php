<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Reader;
use Illuminate\Http\Request;

class ReaderController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,reader')->only('show');

    }
    public function index()
    {
        $this->allowedAdminAction();
        $readers = Reader::all();
        return $this->showAll($readers);
    }
    public function show(Reader $reader)
    {
        return $this->showOne($reader);
    }
    
}
