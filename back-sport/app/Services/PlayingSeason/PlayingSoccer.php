<?php

namespace App\Services\PlayingSeason;

use Log;
use App\Models\Game;

class PlayingSoccer extends PlayingSeason
{
    public function playAll()
    {
        $games = Game::select('week')->distinct()->where('status', config('app.statuses.open'))->get();

        foreach ($games as $game) {
            $this->playingWeek();
        }
    }

    public function nextWeek()
    {
        $this->playingWeek();
    }

    public function startSeason()
    {
        $teams = config('app.teams');
        $games = $this->sorting($teams);
        //write to database
        $season = 1;
        $lastGame = Game::latest('id')->first();

        if ($lastGame) {
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

    protected function sorting($teams)
    {
        $shuffleTeams = $teams;
        shuffle($shuffleTeams);

        return Helper::roundRobinAlgorithm(array_values($shuffleTeams));
    }

    protected function playingWeek()
    {
        //get current week
        $game = Game::oldest('id')->where('status', config('app.statuses.open'))->first();
        $gamesByWeek = Game::where('season', $game->season)
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
            $homeLuck = rand(50, 150);
        } else {
            $awayLuck = rand(50, 100);
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
}
