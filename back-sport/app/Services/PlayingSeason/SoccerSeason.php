<?php

namespace App\Services\PlayingSeason;

use DB;
use App\Models\Game;

class SoccerSeason extends PlayingSeason
{
    public function getCurrentWeek()
    {
        //check is finish => to start
        //get current
        $teams = config('app.teams');
        //DB::beginTransaction();
        //$this->startSeason($teams);
        //$this->playingWeek();
        //get currency week

        //DB::commit();
        $a = $this->viewData();
//        dd(2);
//        return $a;
//        dd($a);
//
//        $this->playingWeek();
//        $latest = Game::latest()->first();
//        if ($latest) {
//            //create new season
//            $data = $this->startSeason();
//        } else {
//
//        }

        $data = [
            'week' => 2,
            'season' => 2,
            'predictions' => [
                [
                    'team' => 'Zenit',
                    'percent' => 20,
                ],
                [
                    'team' => 'Zenit',
                    'percent' => 20,
                ],
                [
                    'team' => 'Zenit',
                    'percent' => 20,
                ],
                [
                    'team' => 'Zenit',
                    'percent' => 20,
                ],

            ],
            'matches' => [
                [
                    'home' => 'Zenit',
                    'away' => 'Shaxtar',
                    'score' => '3 - 2',
                ],
                [
                    'home' => 'Zenit',
                    'away' => 'Shaxtar',
                    'score' => '3 - 2',
                ],
                [
                    'home' => 'Zenit',
                    'away' => 'Shaxtar',
                    'score' => '3 - 2',
                ]
            ],
            'table' => [
                [
                    'team' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ],
                [
                    'team' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ],
                [
                    'team' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ]
            ]
        ];

        return $data;
    }

    protected function viewData()
    {
        $game = Game::oldest()->where('status', config('app.statuses.open'))->first();
        dd($game);
        $finishedGames = Game::where('season', $game->season)
            ->where('season', $game->season)
            ->where('status', config('app.statuses.finished'))
            ->get();

        $finishedGames = Game::where('season', $game->season)
            ->where('season', $game->season)
            ->where('status', config('app.statuses.finished'))
            ->get();

        $table = [];
        foreach (config('app.teams') as $team) {
            $table[$team['id']] = [
                'tema' => $team['name'],
                'pts' => 0,
                'p' => 0,
                'w' => 0,
                'd' => 0,
                'l' => 0,
                'gd' => 0,
            ];
        }

        foreach ($finishedGames as $game) {
            $homePts = $game->score_home > $game->score_away ? 3 : 0;
            $awayPts = $game->score_away > $game->score_home ? 3 : 0;

            $homeP = 1;
            $awayP = 1;

            $homeW = $game->score_home > $game->score_away ? 1 : 0;
            $awayW = $game->score_away > $game->score_home ? 1 : 0;

            $homeD = $game->score_home == $game->score_away ? 1 : 0;
            $awayD = $game->score_away == $game->score_home ? 1 : 0;

            $homeL = $game->score_home < $game->score_away ? 1 : 0;
            $awayL = $game->score_away < $game->score_home ? 1 : 0;


            $homeGD = $game->score_home - $game->score_away;
            $awayGD = $game->score_away - $game->score_home;

            $table[$game->home_id]['pts'] = $table[$game->home_id]['pts'] + $homePts;
            $table[$game->home_id]['p'] = $table[$game->home_id]['p'] + $homeP;
            $table[$game->home_id]['w'] = $table[$game->home_id]['w'] + $homeW;
            $table[$game->home_id]['d'] = $table[$game->home_id]['d'] + $homeD;
            $table[$game->home_id]['l'] = $table[$game->home_id]['l'] + $homeL;
            $table[$game->home_id]['gd'] = $table[$game->home_id]['gd'] + $homeGD;

            $table[$game->away_id]['pts'] = $table[$game->away_id]['pts'] + $awayPts;
            $table[$game->away_id]['p'] = $table[$game->away_id]['p'] + $awayP;
            $table[$game->away_id]['w'] = $table[$game->away_id]['w'] + $awayW;
            $table[$game->away_id]['d'] = $table[$game->away_id]['d'] + $awayD;
            $table[$game->away_id]['l'] = $table[$game->away_id]['l'] + $awayL;
            $table[$game->away_id]['gd'] = $table[$game->away_id]['gd'] + $awayGD;
        }

        //sort by score
        //and same score analyses by goals
        return [
            'week' => $game->week,
            'season' => $game->season,
            'predictions' => $game->season,
            'matches' => $game->matches,
            'table' => $table,
        ];
    }

    public function playAll()
    {

    }

    public function nextWeek()
    {

    }

    protected function sorting($teams)
    {
        $shuffleTeams = $teams;
        shuffle($shuffleTeams);

        return Helper::roundRobinAlgorithm(array_values($shuffleTeams));
    }

    protected function startSeason($teams)
    {
        $games = $this->sorting($teams);
        //write to database
        $season = 1;
        $lastGame = Game::latest()->first();
        if (!is_null($lastGame)) {
            $season = $lastGame->season + 1;
        }

        //create games
        foreach ($games as $key => $gamesByWeek) {
            foreach ($gamesByWeek as $game) {
                Game::create([
                    'week' => $key + 1,
                    'season' => $season,
                    'home_id' => $game[0]['id'],
                    'away_id' => $game[1]['id'],
                    'status' => config('app.statuses.open'),
                ]);
            }
        }

        return true;
    }

    protected function playingWeek()
    {
        //get current week
        $game = Game::oldest()->where('status', config('app.statuses.open'))->first();
        $gamesByWeek = Game::where('season', $game->season)
            ->where('season', $game->season)
            ->where('week', $game->week)
            ->where('status', config('app.statuses.open'))
            ->get();

        foreach ($gamesByWeek as $gameByWeek) {
            $result = $this->analysis($gameByWeek->home_id, $gameByWeek->away_id);
            Game::where('id', $gameByWeek->id)->update([
                'score_home' => $result['home'],
                'score_away' => $result['away'],
                'status' => config('app.statuses.finished'),
            ]);
        }
    }

    protected function analysis($home, $away)
    {
        $homePower = rand(30, 60);
        $awayPower = 0;
        $homeLuck = 0;
        $awayLuck = 0;

        $luckWho = rand(0, 1);

        if ($luckWho == 0) {
            $homeLuck = rand(50, 159);
        } else {
            $awayLuck = rand(50, 150);
        }

        $teams = config('app.teams');

        $homeData = $teams[$home];
        $awayData = $teams[$away];

        $homeScore = $homeData['defense'] + $homeData['midfield'] + $homeData['attack'];
        $awayScore = $awayData['defense'] + $awayData['midfield'] + $awayData['attack'];

        $homeGeneral = $homeScore + $homePower + $homeLuck;
        $awayGeneral = $awayScore + $awayPower + $awayLuck;

        $diffGoals = (int)(($homeGeneral / 50) - ($awayGeneral / 50));
        $startGoals = rand(0, 2);

        $homeGoals = $startGoals;
        $awayGoals = $startGoals;
        if ($diffGoals > 0) {
            $homeGoals = $homeGoals + $diffGoals;
        } else {
            $awayGoals = $awayGoals + abs($diffGoals);
        }

        return [
            'home' => $homeGoals,
            'away' => $awayGoals,
        ];
    }

    protected function finishSeason()
    {

    }
}
