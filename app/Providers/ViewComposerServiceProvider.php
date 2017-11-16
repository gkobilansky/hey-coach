<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['users.show'],
            'App\Http\ViewComposers\UserHeaderComposer'
        );
        view()->composer(
            ['athletes.show'],
            'App\Http\ViewComposers\AthleteHeaderComposer'
        );
        view()->composer(
            ['tasks.show'],
            'App\Http\ViewComposers\TaskHeaderComposer'
        );
        view()->composer(
            ['recruits.show'],
            'App\Http\ViewComposers\RecruitHeaderComposer'
        );
        view()->composer(
            ['invoices.show'],
            'App\Http\ViewComposers\InvoiceHeaderComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
