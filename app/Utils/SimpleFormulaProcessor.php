<?php

namespace App\Utils;

class SimpleFormulaProcessor
{
    /**
     * Cleans and trims a math formula just and return its result after evaluation using eval (For it to be safe)
     */
    public static function calculateFromString($formula)
    {
        $formula = trim($formula);
        $formula = preg_replace ('[^0-9\+-\*\/\(\) ]', '', $formula);

        return eval('return '. $formula . ';');
    }
}
