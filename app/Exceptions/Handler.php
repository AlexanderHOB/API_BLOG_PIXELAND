<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$model} con el id especificado",404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse("El método especificado de la petición no es válido",405);
        }
        if($exception instanceof AuthenticationException){ #Autenticación
            if($this->isFronted($request)){
                return redirect()->guest('login');
            }
            return $this->errorResponse('No autentificado',401);
        }
        if($exception instanceof AuthorizationException){ #Autorizacion
            return $this->errorResponse('No cuenta con los permisos requeridos para ejecutar esta acción',403);
        }
        
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('No se encontro la URL especificada',404);
        }
        if($exception instanceof ThrottleRequestsException){
            return $this->errorResponse('Demasiados intentos en un tiempo corto',429);
            
        }
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
        if($exception instanceof QueryException){
            $codigo = $exception->errorInfo[1];
            if($codigo==1451){
                return $this->errorResponse("No se puede eliminar de forma permanente el recurso por que esta relacionado con algún otro",409);
            }
        }
        if($exception instanceof TokenMismatchException){

            return redirect()->back()->withInput($request->input());
        }
        
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponse("Falla Inesperada. Intente luego",500);
    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFronted($request)){
            return $request->ajax()? response()->json($errors,422): redirect()->back()->withInput($request->input)->withErrors($errors);
        }
        return $this->errorResponse($errors,422);
    }

    private function  isFronted($request)
    {

        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');

    }
}
