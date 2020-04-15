<?php

namespace App\Http\Controllers\Action;

use App\Action;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ActionController extends ApiController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $this->allowedAdminAction();
        $actions = Action::all();
        return $this->showAll($actions);
    }

    public function show(Action $action)
    {
        $this->allowedAdminAction();
        return $this->showOne($action);
    }

   
}
