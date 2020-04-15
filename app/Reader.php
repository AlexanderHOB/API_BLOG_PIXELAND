<?php

namespace App;

use App\Action;
use App\Scopes\ReaderScope;
use App\Transformers\ReaderTransformer;
use Illuminate\Database\Eloquent\Model;

class Reader extends User
{
    public $transformer = ReaderTransformer::class;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ReaderScope);
    }

    public function actions(){
        return $this->hasMany(Action::class);
    }
}
