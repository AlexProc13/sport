<?php

return [
    'sports' => [
        'soccer' => 1,
    ],
    'leagues' => [
        'simple_group' => [
            'id' => 1,
            'teams' => [1, 2, 3, 4]
        ],
    ],
    'statuses' => [
        'open' => 1,
        'finished' => 2
    ],
    'teams' => [
        1 => [
            'id' => 1,
            'league_id' => 1,
            'name' => 'Zenit',
            'defense' => 60,
            'midfield' => 64,
            'attack' => 77,
        ],
        2 => [
            'id' => 2,
            'league_id' => 1,
            'name' => 'Manchester',
            'defense' => 77,
            'midfield' => 88,
            'attack' => 88,
        ],
        3 => [
            'id' => 3,
            'league_id' => 1,
            'name' => 'liverpool',
            'defense' => 90,
            'midfield' => 88,
            'attack' => 70,
        ],
        4 => [
            'id' => 4,
            'league_id' => 1,
            'name' => 'Barsa',
            'defense' => 88,
            'midfield' => 88,
            'attack' => 88,
        ],
    ],
];
