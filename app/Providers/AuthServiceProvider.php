<?php

namespace App\Providers;

use App\Models\User;
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
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->header('Authorization') ?? null;

            if ($token) {
                $user = User::where('remember_token', $token)->first();

                if (!empty($user)) {
                    $request->request->add(['userid' => $user->id]);
                }

                return $user;
            }
        });
    }
}
