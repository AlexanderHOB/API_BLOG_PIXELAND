<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    protected $attributes=[
        'identificador'         =>  'id',
        'titulo'                =>  'title',
        'resumen'               =>  'brief',
        'contenido'             =>  'content',
        'imagen'                =>  'image',
        'status'                =>  'status',
        'esVerificado'          =>  'verified',
        'fechaCreacion'         =>  'created_at',
        'fechaActualizacion'    =>  'updated_at',
        'fechaEliminacion'      =>  'delete_at',
    ];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'identificador'     =>  (int)$post->id,
            'titulo'            =>  (string)$post->title,
            'resumen'           =>  (string)$post->brief,
            'contenido'         =>  (string)$post->content,
            'media'            =>  (string)$post->media,
            'status'            =>  (string)$post->status,
            'escritor'          =>  (int)$post->writter_id,
            'fechaCreacion'         =>  (string)$post->created_at,
            'fechaActualizacion'    =>  (string)$post->updated_at,
            'fechaEliminacion'      =>  isset($post->deleted_at)  ? (string)$post->deleted_at : null,
            'links' =>  [
                [
                    'self'  =>  'self',
                    'href'  =>  route('posts.show',$post->id),
                ],
                [
                    'rel'   =>  'post.categories',
                    'href'  =>  route('posts.categories.index',$post->id),
                ],
                [
                    'rel'   =>  'post.readers',
                    'href'  =>  route('posts.readers.index',$post->id),
                ],
                [
                    'rel'   =>  'post.actions',
                    'href'  =>  route('posts.actions.index',$post->id),
                ],
                [
                    'rel'   =>  'writter',
                    'href'  =>  route('writters.show',$post->writter_id),
                ]
                ],
            ];
    }

    public static function originalAttributes($index){
        $attributes=[
            'identificador'         =>  'id',
            'titulo'                =>  'title',
            'resumen'               =>  'brief',
            'contenido'             =>  'content',
            'media'                 =>  'media',
            'estatus'                =>  'status',
            'fechaCreacion'         =>  'created_at',
            'fechaActualizacion'    =>  'updated_at',
            'fechaEliminacion'      =>  'delete_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    public static function transformAttribute($index){
        $attributes = [
               'id'             =>  'identificador',
               'title'          =>  'titulo',
               'brief'          =>  'resumen',
               'content'        =>  'contenido',
               'media'          =>  'media',
               'status'         =>  'estado',
               'created_at'     =>  'fechaCreacion',
               'updated_at'     =>  'fechaActualizacion',
               'delete_at'      =>  'fechaEliminacion',

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
