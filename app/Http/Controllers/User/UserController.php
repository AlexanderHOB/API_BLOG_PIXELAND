<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends ApiController
{
    public function __construct(){
        $this->middleware('transform.input:'.UserTransformer::class)->only(['store','update']);
        $this->middleware('client.credentials')->only('store','resend');
        $this->middleware('auth:api')->except(['store','resend','verify']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }
    public function index()
    {
        $this->allowedAdminAction();
        $users = User::all();
        return $this->showAll($users);
    }

   
    public function store(Request $request)
    {
        $rules=[
            'name'  =>  'required',
            'lastname'  =>'required',
            'username'  =>  'required|unique:users',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required|min:6|confirmed',
            'image'     =>  'image',
        ];
        $this->validate($request,$rules);
        $field = $request->all();
        $field['password']  =   \bcrypt($request->password);
        $field['verified']  =   User::USER_NO_VERIFIED;
        $field['verification_token']    =   User::generateVerificationToken();
        $field['admin']     =   User::USER_NO_ADMIN;
        $field['writter']   =   User::USER_NO_WRITTER;
        $field['image']     =   User::USER_IMAGE_DEFAULT;
        if($request->has('image')){
            $field['image'] =   $request->image->store('','profile');
        }
        $user = User::create($field);
        return $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    public function update(Request $request, User $user)
    {
        $rules=[
            'name'  =>  'string|min:2',
            'lastname'  =>'string|min:2',
            'username'  =>  'unique:users,username,'.$user->id,
            'email'     =>  'email|unique:users,email,'.$user->id,
            'password'  =>  'min:6|confirmed',
            'image'     =>  'image',
            'admin'     =>  'in:'. User::USER_NO_ADMIN .','. User::USER_ADMIN,
            'writter'   =>  'in:'. User::USER_NO_WRITTER .','. User::USER_WRITTER,
        ];
        $this->validate($request,$rules);
        if($request->has('name')){
            $user->name=$request->name;
        }
        if($request->has('lastname')){
            $user->lastname=$request->lastname;
        }
        if($request->has('username') && $user->username!=$request->username){
            $user->username = $request->username;
        }
        if($request->hasFile('image')){
            Storage::disk('profile')->delete($user->image);
            $user->image = $request->image->store('','profile');
        }
        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::USER_NO_VERIFIED;
            $user->verification_token = User::generateVerificationToken();
            $user->email = $request->email;
        }
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }
        if($request->has('admin')){
            if(!$user->isVerified()){
                return $this->errorResponse('Unicamente los usuarios verificados cambiar su valor de administrador',409);
            }
            $user->admin = $request->admin;
        }
        if($request->has('writter')){
            if(!$user->isVerified()){
                return $this->errorResponse('Unicamente los usuarios verificados cambiar su rol a escritor',409);
            }
            $user->writter = $request->writter;
        }
        if(!$user->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }
        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Storage::disk('profile')->delete($user->image);
    
        $user->delete();
        return $this->showOne($user);
    }
    public function verify($token)
    {
        $user = User::where('verification_token',$token)->firstOrFail();

        $user->verified = User::USER_VERIFIED;

        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }
    public function resend(User $user)
    {
        if($user->isVerify()){
            return $this->errorResponse('Este usuario ya ha sido verificado',409);
        }
        retry(5,function() use ($user){
            Mail::to($user)->send(new UserCreated($user));
        },100);
        return $this->showMessage('El correo de verificación se ha reenviado');
    }
}
