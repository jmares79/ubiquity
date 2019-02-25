<?php

namespace App\Services;

use App\Interfaces\ParserInterface;
use App\Utils\ExpressionTree;
use App\Utils\ExpressionNode;

class ParserService implements ParserInterface
{
    protected $tree;
    protected $currentNode;
    // protected $currentStack = array();

    protected $operators = array(
        'add' => '+',
        'minus' => '-',
        'multiply' => '*',
        'divide' => '/',
    );

    public function __construct()
    {
        $this->tree = new ExpressionTree();
    }

    public function __destruct()
    {
        $this->tree = null;
    }

    public function parse($expression/*, &$tree*/)
    {
        foreach ($expression as $type => $subExpression) {
            echo "\n";
            var_dump($type);
            var_dump($subExpression);
            echo "\n";

            //Is operator
            if (array_key_exists($type, $this->operators)) {
                echo "$type EXISTS in operators with result {$this->operators[$type]}\n";
                $item = $this->operators[$type];
                $node = new ExpressionNode($item);

                $this->tree->add($node);
                $this->tree->pushNode($node);

                echo "TREE AFTER INSERTION:\n";
                var_dump($this->tree);
                echo "\n";

                $this->parse($subExpression/*, $tree*/);
            } else if ($type == 'number' && !is_array($subExpression)) {
                echo "IS A NUMBER WITH VALUE $subExpression\n";
                $item = $subExpression;
                $node = new ExpressionNode($item);

                //As it's a number, and not an operator, we don't insert it in the current stack
                $this->tree->popCurrentNode();
                $this->tree->add($node);
                echo "TREE AFTER INSERTION:\n";
                var_dump($this->tree);
                echo "\n";
            } else {
                echo "ARRAY OF 2 NUMBERS:\n";
                var_dump($subExpression[0]);
                var_dump($subExpression[1]);

                $this->tree->popCurrentNode();

                $nodeLeft = new ExpressionNode($subExpression[0]); 
                $this->tree->add($nodeLeft);

                $nodeRight = new ExpressionNode($subExpression[1]); 
                $this->tree->add($nodeRight);
                
                echo "TREE AFTER INSERTION:\n";
                var_dump($this->tree);
                echo "\n";
            }
        }
    }

    public function traverse()
    {
        return $this->tree->traverse();
    }
}