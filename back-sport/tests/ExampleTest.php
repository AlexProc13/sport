<?php

use App\Services\PlayingSeason\Helper;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UnitTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testRoundRobinAlgorithm()
    {
        //to do
        $teams = config('app.teams');
        $shuffleTeams = $teams;
        shuffle($shuffleTeams);

        foreach (range(1, 6) as $number) {
            $week = mt_rand(0, 5);
            $games = Helper::roundRobinAlgorithm(array_values($shuffleTeams));
            $compare = [];
            foreach ($games[$week] as $weekGame) {
                //to do
                foreach ($weekGame as $match) {
                    $compare[] = $match['id'];
                }
            }

            $compare = array_unique($compare);
            $this->assertEquals(count($teams), count($compare));
        }
    }
}
