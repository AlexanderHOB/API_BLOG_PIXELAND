
@component('mail::message')
    #Hola! {{$user->name . $user->lastname}}.
    Gracias por crear una cuenta. Por favor verificala usando el siguiente botón.
    @component('mail::button',['url'=>route('verify',$user->verification_token)])
        Confirmar Cuenta 
    @endcomponent
    Gracias. {{config('app.name')}}
@endcomponent