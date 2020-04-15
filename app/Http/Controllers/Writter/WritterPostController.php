<?php

namespace App\Http\Controllers\Writter;

use App\Post;
use App\User;
use App\Writter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Transformers\PostTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WritterPostController extends ApiController
{
    public function __construct(){
        $this->middleware('auth:api')->only(['store','update','myPost']);
        $this->middleware('transform.input:'.PostTransformer::class)->only(['store','update']);
        $this->middleware('can:view,writter')->only(['store','update','destroy']);  //FIX
        //index middleware de credentials
    }
    public function index(Writter $writter)
    {
        $posts = $writter->posts()->PostsAvailables(Post::POST_AVAILABLE)->get();
        return $this->showAll($posts);
    }
    //observar todos los post invluido los de status no activo
    public function myPost($id){
        $writter=Writter::findOrFail($id);
        if(Gate::allows('action-writter', $writter)){
            $posts = $writter->posts;
            return $this->showAll($posts);
        }else{
         throw new AuthorizationException('Esta accion no es permitida');
        }
    }
    public function store(Request $request,User $writter)
    {
        $rules=[
            'title' =>  'required|min:3|string',
            'brief' =>  'required|min:3',
            'content'   =>  'required|min:3',
            'media'     =>  'url',
            'status'    =>  'in:'.Post::POST_AVAILABLE .', ' . Post::POST_NO_AVAILABLE,
        ];
        $this->validate($request, $rules);
        if(!$writter->isWritter()){
            return $this->errorResponse('El usuario debe tener permisos de escritor',409);
        }
        if(!$writter->isVerified()){
            return $this->errorResponse('El usuario debe verificar su correo electrónico',409);
        }
        $data = $request->all();
        $data['status'] =   Post::POST_NO_AVAILABLE;
        $data['writter_id'] =   $writter->id;
        $data['media']  =  'default.webp';
        if($request->has('media')){
            $data['media'] = $request->media;
        }
        $post = Post::create($data);
        
        return $this->showOne($post,201);

    }

    public function update(Request $request, Writter $writter,Post $post)
    {
        $rules=[
            'title' =>  'min:3|string',
            'content'   =>  'string',
            'media'     =>  'url',
            'status'    =>  'in:'.Post::POST_AVAILABLE .', ' . Post::POST_NO_AVAILABLE,
        ];
        $this->validate($request,$rules);
        $this->verifyWritter($writter,$post);
        $post->fill($request->only('title','content','brief','media'));
        if($request->has('status')){
            $post->status = $request->status;
            if($post->isAvailable() && $post->categories()->count()==0){
                return $this->errorResponse('El post requiere de al menos una categoría para estar activo',409);
            }
        }
        if($post->isClean()){
            return $this->errorResponse('Se debe cambiar al menos un valor del producto para actualizar',422);
        }
        $post->save();
        return $this->showOne($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Writter  $writter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Writter $writter, Post $post)
    {
        $this->verifyWritter($writter,$post);
        $post->delete();
        return $this->showOne($post);
    }
    protected function verifyWritter(Writter $writter, Post $post)
    {
        if($writter->id != $post->writter_id){
            throw new HttpException(422,'El escritor especificado no es dueño del post');
        }
    }
   
}
