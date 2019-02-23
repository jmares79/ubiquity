<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 *  Controller to handle request to expression handling 
 */
class ExpressionController extends Controller
{
    public function __construct()
    {
    }

    public function fetchAll(Request $request)
    {
        // var_dump($request);
        die("KK");
    }

    public function create(Request $request)
    {
        // $operators = array(
        //     'add' => '+',
        //     'minus' => '-',
        //     'multiply' => '*',
        //     'divide' => '/',
        // );
        // $prefixNotation = '';
        // $xml = \Parser::xml($request->getContent());

        // foreach ($xml['expression'] as $key => $expression) {
        //     echo "Expression No $key<br>";
        //     // var_dump($expression);
        //     foreach ($expression as $operator => $innerExpression) {
        //         $prefixNotation .= $operators[$operator];
        //         var_dump($operator);
        //         var_dump($innerExpression);
        //     }
        // }

        die("CREATE");
    }

    public function update(Request $request, $expressionId)
    {
        die("UPDATING");
    }

    public function delete(Request $request, $expressionId)
    {
        die("DELETING");
    }

}
