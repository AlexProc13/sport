<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getData(Request $request, PlayingSeason $playingSeasonService)
    {
        //to do service  and inject
        //get currency active season
        //if season is finished => start new
        //if not return current week

        $data = $playingSeasonService->getCurrentWeek();

        return [
            'status' => true,
            'data' => [
                'week' => $data['week'],
                'season' => $data['season'],
                'predictions' => $data['predictions'],
                'matches' => $data['matches'],
                'table' => $data['table'],
            ],
        ];
    }

    public function nextWeek(Request $request)
    {

    }

    public function playAll(Request $request)
    {

    }
}
