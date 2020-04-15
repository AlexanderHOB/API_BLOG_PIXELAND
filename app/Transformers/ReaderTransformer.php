<?php

namespace App\Transformers;

use App\Reader;
use League\Fractal\TransformerAbstract;

class ReaderTransformer extends TransformerAbstract
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
    public function transform(Reader $reader)
    {
        return [
            'identificador'         =>  (int)$reader->id,
            'nombre'                =>  (string)$reader->name,
            'apellidos'             =>  (string)$reader->lastname,
            'nickname'              =>  (string)$reader->username,
            'correo'                =>  (string)$reader->email,
            'imagen'                =>  (string)$reader->image,
            'esVerificado'          =>  (int)$reader->verified,
            'fechaCreacion'         =>  (string)$reader->created_at,
            'fechaActualizacion'    =>  (string)$reader->updated_at,
            'fechaEliminacion'      =>  isset($reader->deleted_at)  ? (string)$reader->deleted_at : null,
            'links' =>  [
                [
                    'self'  =>  'self',
                    'href'  =>  route('readers.show',$reader->id),
                ],
                [
                    'rel'   =>  'reader.categories',
                    'href'  =>  route('readers.categories.index',$reader->id),
                ],
                [
                    'rel'   =>  'reader.posts',
                    'href'  =>  route('readers.posts.index',$reader->id),
                ],
                [
                    'rel'   =>  'reader.writters',
                    'href'  =>  route('readers.writters.index',$reader->id),
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
