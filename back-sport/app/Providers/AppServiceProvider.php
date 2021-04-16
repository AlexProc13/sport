<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use App\Services\PlayingSeason\PlayingSeason;
use App\Services\PlayingSeason\PlayingSoccer;
use App\Services\ViewSport\ViewSoccer;
use App\Services\ViewSport\ViewSport;

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
            $typeSport = config('typeSport');
            if (is_null($typeSport)) {
                throw new Exception('wrong type');
            }

            $list = [
                'soccer' => PlayingSoccer::class,
            ];

            return new $list[$typeSport]();
        });

        $this->app->bind(ViewSport::class, function ($app, $params) {

            $typeSport = config('typeSport');
            if (is_null($typeSport)) {
                throw new Exception('wrong type');
            }

            $list = [
                'soccer' => ViewSoccer::class,
            ];

            return new $list[$typeSport]();
        });
    }

    public function provides()
    {
        //Deferred Providers
        return [PlayingSeason::class];
    }
}
