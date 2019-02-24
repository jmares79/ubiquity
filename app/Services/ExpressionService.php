<?php

namespace App\Services;

use App\Expression;

class ExpressionService
{
    public function __construct()
    {

    }

    public function save($expressionString)
    {
        try {
            $exp = new Expression;

            $exp->expression = $expressionString;
            $exp->save();

            return $exp::select('id AS expressionId', 'expression', 'created_at AS date');
        } catch (QueryException $e) {
            throw new Exception();
        }
    }
}