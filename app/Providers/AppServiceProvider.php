<?php

namespace App\Providers;

use Google\Client;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {

            $client = new Client();
            $config = config('services.google');

            $client->setClientId($config['id']);
            $client->setClientSecret($config['secret']);
            $client->setRedirectUri($config['redirect_uri']);

            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Model::unguard();

        // Gate::define('admin', function (User $registeruser) {
        //     return $registeruser->email === 'dhruv@gmail.com';
        // });

        // Blade::if('admin', function () {
        //     return request()->user()?->can('admin');
        // });
    }
}
