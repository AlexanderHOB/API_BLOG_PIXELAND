<?php

namespace App;

use App\Post;
use App\Scopes\WritterScope;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\WritterTransformer;

class Writter extends User
{
    public $transformer = WritterTransformer::class;

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new WritterScope);

    }
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
