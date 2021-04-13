<?php

namespace App\Http\Controllers;

use DB;
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
        //
    }

    public function getData(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        $latest = Game::oldest()->where('status', config('app.statuses.open'))->first();

        if (!$latest) {
            //create new season
            DB::beginTransaction();
            $playingSeasonService->startSeason();
            $playingSeasonService->nextWeek();
            DB::commit();
        }

        $viewData = $viewSport->getCurrentWeek();
        return [
            'status' => true,
            'data' => $viewData,
        ];
    }

    public function nextWeek(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        $latest = Game::oldest()->where('status', config('app.statuses.open'))->first();
        DB::beginTransaction();
        if (!$latest) {
            //create new season
            $playingSeasonService->startSeason();

        }
        $playingSeasonService->nextWeek();
        DB::commit();

        $viewData = $viewSport->getCurrentWeek();
        return [
            'status' => true,
            'data' => $viewData,
        ];
    }

    public function playAll(Request $request, PlayingSeason $playingSeasonService, ViewSport $viewSport)
    {
        $latest = Game::oldest()->where('status', config('app.statuses.open'))->first();
        DB::beginTransaction();
        if (!$latest) {
            //create new season
            $playingSeasonService->startSeason();

        }

        $playingSeasonService->playAll();
        DB::commit();
        $viewData = $viewSport->getCurrentWeek();
        return [
            'status' => true,
            'data' => $viewData,
        ];
    }
}
