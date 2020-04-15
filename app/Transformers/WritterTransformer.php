<?php

namespace App\Transformers;

use App\Writter;
use League\Fractal\TransformerAbstract;

class WritterTransformer extends TransformerAbstract
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
    public function transform(Writter $writter)
    {
        return [
            'identificador'         =>  (int)$writter->id,
            'nombre'                =>  (string)$writter->name,
            'apellidos'             =>  (string)$writter->lastname,
            'nickname'              =>  (string)$writter->username,
            'correo'                =>  (string)$writter->email,
            'imagen'                =>  (string)$writter->image,
            'esVerificado'          =>  (int)$writter->verified,
            'fechaCreacion'         =>  (string)$writter->created_at,
            'fechaActualizacion'    =>  (string)$writter->updated_at,
            'fechaEliminacion'      =>  isset($writter->deleted_at)  ? (string)$writter->deleted_at : null,
            'links' =>  [
                [
                    'self'  =>  'self',
                    'href'  =>  route('writters.show',$writter->id),
                ],
                [
                    'rel'   =>  'writter.categories',
                    'href'  =>  route('writters.categories.index',$writter->id),
                ],
                [
                    'rel'   =>  'writter.posts',
                    'href'  =>  route('writters.posts.index',$writter->id),
                ],
                [
                    'rel'   =>  'writter.readers',
                    'href'  =>  route('writters.readers.index',$writter->id),
                ],
                
            ],
        ];
    }
    public static function originalAttributes($index){
        $attributes=[
            'identificador'         =>  'id',
            'nombre'                =>  'name',
            'apellidos'             =>  'lastname',
            'nickname'              =>  'username',
            'correo'                =>  'email',
            'imagen'                =>  'image',
            'esVerificado'          =>  'verified',
            'fechaCreacion'         =>  'created_at',
            'fechaActualizacion'    =>  'updated_at',
            'fechaEliminacion'      =>  'delete_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformAttribute($index){
        $attributes = [
               'id'         => 'identificador'        ,
               'name'       => 'nombre'               ,
               'lastname'   =>  'apellidos'            ,
               'username'   => 'nickname'             ,
               'email'      =>'correo'               ,
               'image'      =>'imagen'               ,
               'verified'   => 'esVerificado'         ,
               'created_at' => 'fechaCreacion'        ,
               'updated_at' =>'fechaActualizacion'   ,
               'delete_at'  =>'fechaEliminacion'     ,

        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
