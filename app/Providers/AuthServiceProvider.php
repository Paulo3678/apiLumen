<?php

namespace App\Providers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\DataBase;
use App\Models\UserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.
        $userFactory = new UserFactory();


        $this->app['auth']->viaRequest('api', function (Request $request) use ($userFactory) {
            if (!$request->hasHeader("Authorization")) {
                return null;
            }
            $authoHeader = $request->header("Authorization");
            $token = str_replace("Bearer ", "", $authoHeader);
            $tokenData = JWT::decode($token, new Key(env('TOKEN_KEY'), 'HS256'));
            

            $user = $userFactory->findById(intval($tokenData->userId));
            if(!$user){
                return null;
            }
            return $user;

            // if ($request->input('api_token')) {
            //     return User::where('api_token', $request->input('api_token'))->first();
            // }
        });
    }
}
