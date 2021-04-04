<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChampionshipController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getData(Request $request)
    {
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
                    'home' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ],
                [
                    'home' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ],
                [
                    'home' => 'Zenit',
                    'pts' => 10,
                    'p' => 2,
                    'w' => 2,
                    'd' => 2,
                    'l' => 2,
                    'gd' => 2,
                ]
            ]
        ];

        return [
            'status' => true,
            'data' => $data,
        ];
    }
}
