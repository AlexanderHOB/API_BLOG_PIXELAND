<?php

namespace App\Transformers;

use App\Action;
use League\Fractal\TransformerAbstract;

class ActionTransformer extends TransformerAbstract
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
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Action $action)
    {
        return [
            'identificador'     =>      (int)$action->id,
            'type'              =>      (string)$action->type,
            'content'           =>      (string)$action->content,
            'autor'             =>      (int)$action->reader_id,
            'post'              =>      (int)$action->post_id,
            'fechaCreacion'         =>  (string)$action->created_at,
            'fechaActualizacion'    =>  (string)$action->updated_at,
            'fechaEliminacion'      =>  isset($action->deleted_at)  ? (string)$action->deleted_at : null,
            'links' =>  [
                [
                    'self'  =>  'self',
                    'href'  =>  route('actions.show',$action->id),
                ],
                [
                   'rel'    =>  'reader',
                   'href'   =>  route('readers.show',$action->reader_id) 
                ],
                [
                    'rel'   =>  'post',
                    'href'  =>  route('posts.show',$action->post_id)
                ]
                
            ],
        ];
    }
    public static function originalAttributes($index){
        $attributes = [
            'identificador'     =>      'id',
            'tipo'              =>      'type',
            'contenido'         =>      'content',
            'autor'             =>      'reader_id',
            'post'              =>      'post_id',
            'fechaCreacion'         =>  'created_at',
            'fechaActualizacion'    =>  'updated_at',
            'fechaEliminacion'      =>  'delete_at',
        ];
        return isset($attributes[$index])? $attributes[$index]:null;
    }
    public static function transformAttribute($index){
        $attributes = [
               'id'             =>  'identificador',
               'type'           =>  'tipo',
               'content'        =>  'contenido',
               'reader_id'      =>  'autor',
               'post_id'        =>  'post',
               'created_at'     =>  'fechaCreacion',
               'updated_at'     =>  'fechaActualizacion',
               'delete_at'      =>  'fechaEliminacion',

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
