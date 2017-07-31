<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
    	// Here you may define how you wish users to be authenticated for your Lumen
    	// application. The callback which receives the incoming request instance
    	// should return either a User instance or null. You're free to obtain
    	// the User instance via an API token or any other method necessary.
    	$this->app['auth']->viaRequest('api', function ($request) {
    		$request = $this->app['request'];
    		if ($token = $request->headers->get('Api-Token')) {
    			return User::where('api_token', $token)->first();
    		}
    	});
    }
}
