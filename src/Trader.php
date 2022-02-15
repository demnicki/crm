<?php

namespace App;

class Trader
    /*
     * Autor: A. J. Demnicki <adamdemnicki@gmail.com>
     * Klasa z funkcjami do analizy statystycznej i ekonometrycznej.
     * */
{
// Liczy medianę.
    public function median(array $arr)
    {
        $count = count($arr);
        $middleval = floor(($count - 1) / 2);
        if ($count % 2) {
            $median = $arr[$middleval];
        } else {
            $low = $arr[$middleval];
            $high = $arr[$middleval + 1];
            $median = (($low + $high) / 2);
        }
        return $median;
    }

// Liczy dominanentę.
    public function dominant(array $arr)
    {
        $numbers = array();
        $quantity = array();

        for ($i = 0; $i < count($arr); $i++) {
            $temp = $arr[$i];
            $found = false;
            for ($j = 0; $j < count($numbers); $j++) {
                if ($numbers[$j] == $temp) {
                    $quantity[$j]++;
                    $found = true;
                    break;
                }
            }
            if ($found == false) {
                $numbers[count($numbers)] = $temp;
                $quantity[count($quantity)] = 1;
            }
        }
        $dominant = 0;
        $meter = 1;
        for ($i = 1; $i < count($numbers); $i++) {
            if ($quantity[$i] > $quantity[$dominant]) {
                $dominant = $i;
                $meter = 1;
            } else if ($quantity[$i] == $quantity[$dominant]) {
                ++$meter;
            }
        }
        if ($meter == 1)
            return $numbers[$dominant];
        else
            return 'Nie ma';
    }

// Liczy odchelenie standardowe.
    public function st_deviation(array $isarray)
    {
        $average = array_sum($isarray) / count($isarray);
        $sum = 0;
        foreach ($isarray as $item) {
            $sum = $sum + (($item - $average) * ($item - $average));
        };
        $st_deviation = sqrt($sum / count($isarray));
        return $st_deviation;
    }

// Liczy korelacji Pearsona.
    public function correlation(array $arrx, array $arry)
    {
        try {
            if (count($arrx) != count($arry)) {
                return -1;
            }
            $quotientyx = [];
            $squarex = [];
            $squarey = [];
            $nrow = count($arrx);
            $sumArrayx = array_sum($arrx);
            $sumArrayy = array_sum($arry);
            for ($i = 0, $cnt = count($arrx); $i < $cnt; $i++) {

                $quotientyx[$i] = $arrx[$i] * $arry[$i];
                $squarex[$i] = $arrx[$i] * $arrx[$i];
                $squarex[$i] = $arry[$i] * $arry[$i];

            }
            $sumQuotientyx = array_sum($quotientyx);
            $sumSquarex = array_sum($squarex);
            $sumSquarey = array_sum($squarex);
            $nomative = ($nrow * $sumQuotientyx) - ($sumArrayx * $sumArrayy);
            $genetiveL = (($nrow * $sumSquarex - ($sumArrayx * $sumArrayx)));
            $genetiveR = (($nrow * $sumSquarey - ($sumArrayy * $sumArrayy)));
            $genetive = sqrt(($genetiveL * $genetiveR));
            return $nomative / $genetive;
        }catch(DivisionByZeroError $e){
            return -1;
        }catch(ErrorException $e){
            return -1;
        }
    }
}