<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identificador'         =>  (int)$user->id,
            'nombre'                =>  (string)$user->name,
            'apellidos'             =>  (string)$user->lastname,
            'nickname'              =>  (string)$user->username,
            'correo'                =>  (string)$user->email,
            'imagen'                =>  (string)url("assets/images/profiles/$user->image"),
            'esVerificado'          =>  (int)$user->verified,
            'esAdministrador'       =>  ($user->admin === 'true'),
            'esEscritor'            =>  ($user->writter === 'true'),
            'fechaCreacion'         =>  (string)$user->created_at,
            'fechaActualizacion'    =>  (string)$user->updated_at,
            'fechaEliminacion'      =>  isset($user->deleted_at)  ? (string)$user->deleted_at : null,
            'links' =>  [
                [
                    'self'  =>  'self',
                    'href'  =>  route('users.show',$user->id),
                ],
                
            ],

        ];
    }
    public static function originalAttributes($index)
    {
        $attributes = [

            'identificador'         =>  'id',
            'nombre'                =>  'name',
            'apellidos'             =>  'lastname',
            'nickname'              =>  'username',
            'correo'                =>  'email',
            'imagen'                =>  'image',
            'esVerificado'          =>  'verified',
            'esAdministrador'       =>  'admin',
            'esEscritor'            =>  'writter',
            'fechaCreacion'         =>  'created_at',
            'fechaActualizacion'    =>  'updated_at',
            'fechaEliminacion'      =>  'delete_at',
            'contrasena'            =>    'password',
            'contrasena_confirmada' =>      'password_confirmation',

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
               'admin'      =>'esAdministrador'      ,
               'writter'    =>'esEscritor'           ,
               'created_at' => 'fechaCreacion'        ,
               'updated_at' =>'fechaActualizacion'   ,
               'delete_at'  =>'fechaEliminacion'     ,
               'password'   =>'contrasena'           ,
               'password_confirmation' => 'contrasena_confirmada',



        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
