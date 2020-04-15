<?php

namespace App\Http\Controllers\Post;

use App\Post;
use App\User;
use App\Action;
use App\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ApiController;
use App\Transformers\ActionTransformer;
use App\Http\Requests\PostReaderActionStoreRequest;

class PostReaderActionController extends ApiController
{
    public function __construct(){
        parent::__construct();
        
        $this->middleware('transform.input:'.ActionTransformer::class)->only(['store']);


    }
  
    public function store(PostReaderActionStoreRequest $request,Post $post, User $reader)
    {
        if (Gate::allows('create-action', $reader)) {
            if(!$post->isAvailable()){
                return $this->errorResponse('El post no esta disponible',409);
            }
            if($post->actions()->where([['reader_id','=',$reader->id],['type',Action::ACTION_REACTION]])->count() >=1 && $request->type ==Action::ACTION_REACTION ){
                $action = $post->actions()->where([['reader_id','=',$reader->id],['type',Action::ACTION_REACTION]])->first();
                $action->content= $request->content;
                $action->save();
                return $this->showOne($action);
            }
            if($post->actions()->where([['reader_id','=',$reader->id],['type',Action::ACTION_SCORE]])->count() >=1 && $request->type ==Action::ACTION_SCORE ){
                $action = $post->actions()->where([['reader_id','=',$reader->id],['type',Action::ACTION_SCORE]])->first();
                $action->content= $request->content;
                $action->save();
                return $this->showOne($action);
    
            }
    
            $action = Action::create([
                'type'      =>  $request->type,
                'content'   =>  $request->content,
                'reader_id' =>  $reader->id,
                'post_id'   =>  $post->id,
            ]);
            return $this->showOne($action,201);
          } else {
            return $this->errorResponse("No tienes permisos necesarios para realizar esta acción",403);
          }
        
        
    }

   
    public function update(Request $request, Post $post)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Reader $reader ,Action $action)
    {
        if (Gate::allows('create-action', $reader)) {

            if(!$action->reader_id == $reader->id){
                return $this->errorResponse("El lector no es dueño de este comentario",409);
            }   

            $action->delete();
            return $this->showOne($action);
        } else {
            return $this->errorResponse("No tienes permisos necesarios para realizar esta acción",403);
          }

    }
}
