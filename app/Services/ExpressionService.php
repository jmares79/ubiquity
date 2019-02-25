<?php

namespace App\Services;

use App\Expression;
use App\Exceptions\ExpressionUpdateException;
use App\Exceptions\ExpressionCreationException;
use App\Exceptions\ExpressionDeleteException;
use Illuminate\Database\Query\Builder;

class ExpressionService
{
    /**
     * Creates a new expression
     *
     * @param string $expressionString
     *
     * @return mixed An expression fetched from the DB
     * 
     * @throws ExpressionCreationException On error while creating the expression
     */
    public function save($expressionString, $result)
    {
        try {
            $exp = new Expression;

            $exp->expression = $expressionString;
            $exp->result = $result;
            $exp->save();

            return $exp::select('id','expression', 'result')->where('id', $exp->id)->first();
        } catch (QueryException $e) {
            throw new ExpressionCreationException();
        }
    }

    /**
     * Updates an expression
     *
     * @param Builder $expression Expression to be updated
     * @param string $expressionString New data
     *
     * @return mixed An expression fetched from the DB
     *
     * @throws ExpressionUpdateException On error while updating the expression
     */
    public function update(Builder $expression, $newExpression)
    {
        try {
            $expression->update(['expression' => $newExpression]);

            return $expression->select(['id','expression', 'result'])->first();
        } catch (QueryException $e) {
            throw new ExpressionUpdateException();
        }
    }

    /**
     * Deletes an expression
     *
     * @param Expression $expression Expression to be deleted
     *
     * @throws ExpressionDeleteException On error while deleting the expression
     */
    public function delete(Expression $expression)
    {
        try {
            $expression->delete();
        } catch (QueryException $e) {
            throw new ExpressionDeleteException();
        }
    }
}