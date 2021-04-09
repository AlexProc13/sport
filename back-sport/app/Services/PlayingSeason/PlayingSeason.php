<?php

namespace App\Services\PlayingSeason;

abstract class PlayingSeason {

    abstract public function getCurrentWeek();

    abstract public function playAll();

    abstract public function nextWeek();

    abstract protected function sorting($teams);

    abstract protected function startSeason($teams);

    abstract protected function finishSeason();
}
