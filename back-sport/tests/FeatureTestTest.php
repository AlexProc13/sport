<?php

namespace Tests;

use Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FeatureTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /**
     *
     * @return void
     */
    public function testGetData()
    {
        $request = $this->json('get', '/api/getData');
        $request->seeJsonStructure([
            "status",
            "data" => [
                "table",
                "matches",
                "week",
                "season",
                "predictions",
            ],
        ]);
    }

    /**
     *
     * @return void
     */
    public function testNextWeek()
    {
        $request = $this->json('post', '/api/nextWeek');
        $request->seeJsonStructure([
            "status",
            "data" => [
                "table",
                "matches",
                "week",
                "season",
                "predictions",
            ],
        ]);
    }

    /**
     *
     * @return void
     */
    public function testPlayAll()
    {
        $request = $this->json('post', '/api/playAll');
        $request->seeJsonStructure([
            "status",
            "data" => [
                "table",
                "matches",
                "week",
                "season",
                "predictions",
            ],
        ]);
    }
}
