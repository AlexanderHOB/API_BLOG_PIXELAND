<?php

namespace App\Http\Controllers\Writter;

use App\Http\Controllers\ApiController;
use App\Writter;
use Illuminate\Http\Request;

class WritterController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('can:view,writter')->only('show');
    }
    public function index()
    {
        $this->allowedAdminAction();
        $writters = Writter::all();
        return $this->showAll($writters);
    }

    public function show(Writter $writter)
    {
        return $this->showOne($writter);
    }

   }
