<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'name',
        'description'
    ];
    public $transformer = CategoryTransformer::class;
    
    protected $hidden =['pivot'];
    protected $dates = ['deleted_at'];
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
