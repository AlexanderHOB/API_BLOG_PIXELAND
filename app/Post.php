<?php

namespace App;

use App\Action;
use App\Writter;
use App\Category;
use App\Transformers\PostTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    public $transformer = PostTransformer::class;
    const POST_AVAILABLE='true';
    const POST_NO_AVAILABLE='false';
    protected $fillable=[
        'title',
        'brief',
        'content',
        'media',
        'status',
        'writter_id'
    ];
    protected $dates = ['deleted_at'];
    protected $hidden = ['pivot'];

    public function isAvailable(){
        return $this->status == Post::POST_AVAILABLE;
    }
    public function writter(){
        return $this->belongsTo(Writter::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function actions(){
        return $this->hasMany(Action::class);
    }

    /*SCOPEs */
    public function scopePostsAvailables($query,$status){
        return $query->where('status',$status);
    }
}
