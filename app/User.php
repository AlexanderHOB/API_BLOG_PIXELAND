<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes,HasApiTokens;
    /*VARIABLES */
    const USER_VERIFIED='1';
    const USER_NO_VERIFIED='0';
    const USER_ADMIN = 'true';
    const USER_NO_ADMIN = 'false';
    const USER_WRITTER = 'true';
    const USER_NO_WRITTER='false';
    const USER_IMAGE_DEFAULT ='assets/images/profiles/demo.png';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="users";
    protected $dates = ['deleted_at'];
    public $transformer = UserTransformer::class;
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'username',
        'image',
        'password',
        'verified',
        'verification_token',
        'writter',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function isVerified(){
        return $this->verified == User::USER_VERIFIED;
    }
    public function isWritter(){
        return $this->writter == User::USER_WRITTER;
    }
    public function isAdmin(){
        return $this->admin == USER::USER_ADMIN;
    }
    public static function generateVerificationToken(){
        return Str::random(40); 
    }

    //Mutadores - Accesores
    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }
    public function getNameAttribute($valor){
        return \ucwords($valor);
    }
    public function setLastnameAttribute($valor)
    {
        $this->attributes['lastname']   = strtolower($valor);
    }
    public function getLastnameAttribute($valor)
    {
        return ucwords($valor);
    }
    public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }
    
}
