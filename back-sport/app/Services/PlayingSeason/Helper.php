<?php

namespace App\Services\PlayingSeason;

class Helper
{
    public static function combineWithoutRepetitions($comboOptions, $comboLength)
    {
        $combos = [];
        if ($comboLength === 1) {
            $combos = array_map(function ($comboOption) {
                return [$comboOption];
            }, $comboOptions);
        } else {
            foreach ($comboOptions as $optionIndex => $comboOption) {
                $sliceArray = array_slice($comboOptions, $optionIndex + 1);
                $smallerCombos = self::combineWithoutRepetitions($sliceArray, $comboLength - 1);

                foreach ($smallerCombos as $smallerCombo) {
                    array_push($combos, array_merge([$comboOption], $smallerCombo));
                }
            }
        }

        return $combos;
    }

    public static function roundRobinAlgorithm($teams, $repetitions = true)
    {
        $rounds = [];
        $countTeams = count($teams);
        // Check for even number or add a bye
        if (count($teams) % 2 != 0) {
            array_push($teams, "bye");
        }
        // Splitting the teams array into two arrays
        $away = array_splice($teams, (count($teams) / 2));
        $home = $teams;
        // The actual scheduling based on round robin
        for ($i = 0; $i < count($home) + count($away) - 1; $i++) {
            for ($j = 0; $j < count($home); $j++) {
                $rounds[$i][$j][0] = $home[$j];
                $rounds[$i][$j][1] = $away[$j];

                if ($repetitions) {
                    $rounds[($countTeams - 1) + $i][$j][0] = $away[$j];
                    $rounds[($countTeams - 1) + $i][$j][1] = $home[$j];
                }
            }
            // Check if total numbers of teams is > 2 otherwise shifting the arrays is not necessary
            if (count($home) + count($away) - 1 > 2) {
                $array_splice = array_splice($home, 1, 1);
                array_unshift($away, array_shift($array_splice));
                array_push($home, array_pop($away));
            }
        }

        ksort($rounds);
        return ($rounds);
    }
}
