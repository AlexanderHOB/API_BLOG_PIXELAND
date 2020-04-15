<?php

namespace App\Providers;

use App\User;
use App\Reader;
use App\Writter;
use Carbon\Carbon;
use App\Policies\UserPolicy;
use App\Policies\ReaderPolicy;
use Laravel\Passport\Passport;
use App\Policies\WritterPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Reader::class => ReaderPolicy::class,
        Writter::class => WritterPolicy::class,
        User::class => UserPolicy::class

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('action-writter',function($user,$writter){
            return $user->id === $writter->id;
        });

        Gate::define('create-action', function ($user, $reader) {
            return $user->id === $reader->id;
          });
        Gate::define('admin-action',function($user){
            return $user->isAdmin();
        });
        

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDay(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        
    }
}
