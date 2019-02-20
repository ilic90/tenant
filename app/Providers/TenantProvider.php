<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TenantProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    public function patka($website)
    {
        $environment = $this->app->make(\Hyn\Tenancy\Environment::class);

        // Retrieve your website

        // Now switch the environment to a new tenant.
        $environment->tenant($website);
    }
}
