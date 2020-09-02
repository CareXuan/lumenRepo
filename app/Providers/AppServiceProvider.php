<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Foundation\Modules\Repository\RepositoryHandle;
use App\Foundation\Modules\Pocket\PocketHandle;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rep', function () {
            return RepositoryHandle::instance();
        });

        $this->app->singleton('pocket',function (){
            return PocketHandle::instance();
        });
    }
}
