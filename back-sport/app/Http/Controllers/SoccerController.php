<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Services\ViewSport\ViewSport;
use App\Services\PlayingSeason\PlayingSeason;

class SoccerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //set type of sport for service provider
        config(['typeSport' => 'soccer']);
    }

    public function getData(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        DB::beginTransaction();
        //to do queue for parallel queries (to do middleware)
        User::where('id', config('app.user.id'))->lockForUpdate()->first();
        $latest = Game::oldest('id')->where('status', config('app.statuses.open'))->first();
        if (!$latest) {
            //create new season
            //to do queue for parallel queries
            $playingSeasonService->startSeason();
            $playingSeasonService->nextWeek();
        }

        $viewData = $viewSport->getCurrentWeek();
        DB::commit();
        return [
            'status' => true,
            'data' => $viewData,
        ];
    }

    public function nextWeek(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        DB::beginTransaction();
        //to do queue for parallel queries (to do middleware)
        User::where('id', config('app.user.id'))->lockForUpdate()->first();

        $latest = Game::oldest('id')->where('status', config('app.statuses.open'))->first();
        if (!$latest) {
            //create new season
            $playingSeasonService->startSeason();
        }

        $playingSeasonService->nextWeek();

        $viewData = $viewSport->getCurrentWeek();
        DB::commit();

        return [
            'status' => true,
            'data' => $viewData,
        ];
    }

    public function playAll(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        DB::beginTransaction();
        //to do queue for parallel queries (to do middleware)
        User::where('id', config('app.user.id'))->lockForUpdate()->first();
        $latest = Game::oldest('id')->where('status', config('app.statuses.open'))->first();

        if (!$latest) {
            //create new season
            $playingSeasonService->startSeason();
        }

        $playingSeasonService->playAll();

        $viewData = $viewSport->getCurrentWeek();
        DB::commit();

        return [
            'status' => true,
            'data' => $viewData,
        ];
    }
}
