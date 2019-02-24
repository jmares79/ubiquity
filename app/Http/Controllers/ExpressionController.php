<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExpressionTree;

/**
 *  Controller to handle request to expression handling 
 */
class ExpressionController extends Controller
{
    protected $tree;

    public function __construct()
    {
        $this->tree = new ExpressionTree();
    }

    public function fetchAll(Request $request)
    {
        // var_dump($request);
        die("KK");
    }

    public function create(Request $request)
    {
        $xml = \Parser::xml($request->getContent());
        $this->parse($xml['expression']);
        
        die("CREATE");
    }

    protected function parse($expression)
    {
        $operators = array(
            'add' => '+',
            'minus' => '-',
            'multiply' => '*',
            'divide' => '/',
        );

        foreach ($expression as $key => $subExpression) {
            var_dump($key);
            echo "--------------<br>";
            var_dump($subExpression);
            echo "--------------<br>";

            if (array_key_exists($key, $operators)) {
                echo "$key EXISTS in operators with result $operators[$key]<br>";
                $item = $operators[$key];

                $this->tree->add($item);
                $this->parse($subExpression);
            } else if ($key == 'number' && !is_array($subExpression)) {
                $item = $subExpression;

                $this->tree->add($item);
            } else {
                //Array of numbers
                echo "<pre>ARRAY OF 2 NUMBERS</pre>";
                var_dump($subExpression[0]);
                var_dump($subExpression[1]);

                $this->tree->add($subExpression[0]);
                $this->tree->add($subExpression[1]);
            }

            if (is_array($subExpression)) {
                // $this->parse($subExpression);
            }
        }
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
