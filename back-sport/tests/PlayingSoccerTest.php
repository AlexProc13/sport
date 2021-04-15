<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlayingSoccerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->json('POST', '/user', ['name' => 'Sally'])
            ->seeJson([
                'created' => true,
            ]);
    }
}
