<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PlayingSeason\PlayingSeason;
use App\Services\PlayingSeason\SoccerSeason;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PlayingSeason::class, function ($app, $params) {
            //todo - depends by sport id
            $list = [
                'soccer' => SoccerSeason::class,
            ];
            return new $list['soccer'];
        });
    }

    public function provides()
    {
        //Deferred Providers
        return [PlayingSeason::class];
    }
}
