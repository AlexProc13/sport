<?php

namespace App\Services\ViewSport;

abstract class ViewSport {

    abstract public function getCurrentWeek();

    abstract protected function getPredictions($teams);
}
