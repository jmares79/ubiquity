<?php

namespace App\Services;

use App\Expression;

class ExpressionService
{
    public function save($expressionString)
    {
        try {
            $exp = new Expression;

            $exp->expression = $expressionString;
            $exp->save();

            return $exp::select('id','expression')->where('id', $exp->id)->first();
        } catch (QueryException $e) {
            throw new Exception();
        }
    }
}