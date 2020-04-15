<?php

namespace App;

use App\Post;
use App\Action;
use App\Reader;
use App\Transformers\ActionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;
    public $transformer = ActionTransformer::class;
    const ACTION_REACTION = 'reaction';
    const ACTION_COMMENT = 'comment';
    const ACTION_SCORE = 'score';
    const REACTION = [
        'like' ,
        'funny',
        'love' ,
        'surprised',
        'annoying' ,
        'sad'      ,
    ];
    const SCORES = ['1','2','3','4','5'];
    protected $dates = ['deleted_at'];

    protected $fillable=[
        'type',
        'content',
        'reader_id',
        'post_id'
    ];
    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function reader(){
        return $this->belongsTo(Reader::class);
    }
}
