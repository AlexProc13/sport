<?php

namespace App\Services\PlayingSeason;

abstract class PlayingSeason
{
    abstract public function playAll();

    abstract public function nextWeek();

    abstract public function startSeason();
}
