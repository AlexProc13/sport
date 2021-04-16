<?php

namespace App\Services\ViewSport;

use App\Models\Game;

class ViewSoccer extends ViewSport
{
    public function getCurrentWeek()
    {
        return $this->viewData();
    }

    protected function viewData()
    {
        $fistOpenGame = Game::oldest('id')->where('status', config('app.statuses.open'))->first();
        
        //to do
        if (!$fistOpenGame) {
            $latestGame = Game::latest('id')->where('status', config('app.statuses.finished'))->first();
            $week = $latestGame->week;
            $season = $latestGame->season;
        } else {
            $week = $fistOpenGame->week - 1;
            $season = $fistOpenGame->season;
        }

        $finishedGames = Game::where('season', $season)
            ->where('status', config('app.statuses.finished'))
            ->get();

        $table = [];
        $teams = config('app.teams');
        foreach ($teams as $team) {
            $table[$team['id']] = [
                'team_id' => $team['id'],
                'team' => $team['name'],
                'pts' => 0,
                'p' => 0,
                'w' => 0,
                'd' => 0,
                'l' => 0,
                'gd' => 0,
            ];
        }

        $spPairs = '@@';
        $pairGames = [];

        foreach ($finishedGames as $game) {
            $homePts = $game->score_home > $game->score_away ? 3 : 0;
            $awayPts = $game->score_away > $game->score_home ? 3 : 0;

            $homeDPts = $game->score_home == $game->score_away ? 1 : 0;
            $awayDPts = $game->score_away == $game->score_home ? 1 : 0;

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

            $table[$game->home_id]['pts'] = $table[$game->home_id]['pts'] + $homePts + $homeDPts;
            $table[$game->home_id]['p'] = $table[$game->home_id]['p'] + $homeP;
            $table[$game->home_id]['w'] = $table[$game->home_id]['w'] + $homeW;
            $table[$game->home_id]['d'] = $table[$game->home_id]['d'] + $homeD;
            $table[$game->home_id]['l'] = $table[$game->home_id]['l'] + $homeL;
            $table[$game->home_id]['gd'] = $table[$game->home_id]['gd'] + $homeGD;

            $table[$game->away_id]['pts'] = $table[$game->away_id]['pts'] + $awayPts + $awayDPts;
            $table[$game->away_id]['p'] = $table[$game->away_id]['p'] + $awayP;
            $table[$game->away_id]['w'] = $table[$game->away_id]['w'] + $awayW;
            $table[$game->away_id]['d'] = $table[$game->away_id]['d'] + $awayD;
            $table[$game->away_id]['l'] = $table[$game->away_id]['l'] + $awayL;
            $table[$game->away_id]['gd'] = $table[$game->away_id]['gd'] + $awayGD;

            //pair game and check
            $pairGames[$game->home_id . $spPairs . $game->away_id] = $game->score_home . $spPairs . $game->score_away;
        }

        //matches
        $matches = [];
        $separator = '-';
        $pattern = "%s $separator %s";

        $lastPairs = Game::latest('id')
            ->where('season', $season)
            ->where('week', $week)
            ->where('status', config('app.statuses.finished'))->get();

        foreach ($lastPairs as $lastPair) {
            $matches[] = [
                'home' => $teams[$lastPair->home_id]['name'],
                'away' => $teams[$lastPair->away_id]['name'],
                'score' => sprintf($pattern, $lastPair->score_home, $lastPair->score_away),
            ];
        }
        //matches

        //sort by score
        usort($table, function ($a, $b) use ($pairGames, $spPairs) {
            if ($a['pts'] == $b['pts']) {
                //compare goals who played two games
                if (isset($pairGames[$a['team_id'] . $spPairs . $b['team_id']]) and isset($pairGames[$b['team_id'] . $spPairs . $a['team_id']])) {
                    //compare goals
                    $getScoreFirst = explode($spPairs, $pairGames[$a['team_id'] . $spPairs . $b['team_id']]);
                    $teamA = $getScoreFirst[0];
                    $teamB = $getScoreFirst[1] * 2;
                    $getScoreSecond = explode($spPairs, $pairGames[$b['team_id'] . $spPairs . $a['team_id']]);
                    $teamA = $teamA + $getScoreSecond[0] * 2;
                    $teamB = $teamB + $getScoreSecond[1];
                    return ($teamA > $teamB) ? 1 : -1;
                }
                return 0;
            }
            return ($a['pts'] < $b['pts']) ? 1 : -1;
        });
        //sort by score

        return [
            'table' => $table,
            'matches' => $matches,
            'week' => $week,
            'season' => $season,
            'predictions' => $this->getPredictions($table),
        ];
    }

    protected function getPredictions($table)
    {
        //to do - do by pts
        $predictions = [];
        $total = array_sum(array_map(function ($item) {
            return $item['pts'];
        }, $table));

        foreach ($table as $item) {
            $predictions[] = [
                'percent' => (int)(($item['pts'] * 100) / $total),
                'team' => $item['team'],
            ];
        }

        usort($predictions, function ($a, $b) {
            if ($a['percent'] == $b['percent']) {
                return 0;
            }
            return ($a['percent'] > $b['percent']) ? -1 : 1;
        });

        return $predictions;
    }
}
