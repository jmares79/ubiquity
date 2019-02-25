<?php

namespace App\Services;

use App\Expression;
use App\Exceptions\ExpressionUpdateException;
use App\Exceptions\ExpressionCreationException;
use App\Exceptions\ExpressionDeleteException;
use Illuminate\Database\Query\Builder;

class ExpressionService
{
    public function save($expressionString)
    {
        try {
            $exp = new Expression;

            $exp->expression = $expressionString;
            $exp->save();

            return $exp::select('id','expression', 'result')->where('id', $exp->id)->first();
        } catch (QueryException $e) {
            throw new ExpressionCreationException();
        }
    }

    public function update(Builder $expression, $newExpression)
    {
        try {
            $expression->update(['expression' => $newExpression]);

            return $expression->select(['id','expression', 'result'])->first();
        } catch (QueryException $e) {
            throw new ExpressionUpdateException();
        }
    }

    public function delete(Expression $expression)
    {
        try {
            $expression->delete();
        } catch (QueryException $e) {
            throw new ExpressionDeleteException();
        }
    }
}