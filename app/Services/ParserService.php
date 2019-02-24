<?php

namespace App\Services;

use App\Interfaces\ParserInterface;

class ParserService implements ParserInterface
{
    protected $operators = array(
        'add' => '+',
        'minus' => '-',
        'multiply' => '*',
        'divide' => '/',
    );

    public function parse($expression, &$tree)
    {
        foreach ($expression as $key => $subExpression) {
            echo "\n";
            var_dump($key);
            var_dump($subExpression);
            echo "\n";

            if (array_key_exists($key, $this->operators)) {
                echo "$key EXISTS in operators with result {$this->operators[$key]}<br>";
                $item = $this->operators[$key];

                $tree->add($item);
                echo "TREE AFTER INSERTION:\n";
                var_dump($tree);
                echo "\n";
                $this->parse($subExpression, $tree);
            } else if ($key == 'number' && !is_array($subExpression)) {
                echo "IS A NUMBER WITH VALUE $subExpression\n";
                $item = $subExpression;

                $tree->add($item);
                echo "TREE AFTER INSERTION:\n";
                var_dump($tree);
                echo "\n";
            } else {
                echo "<pre>ARRAY OF 2 NUMBERS</pre>";
                var_dump($subExpression[0]);
                var_dump($subExpression[1]);

                $tree->add($subExpression[0]);
                $tree->add($subExpression[1]);
                echo "TREE AFTER INSERTION:\n";
                var_dump($tree);
                echo "\n";
            }

            if (is_array($subExpression)) {
                // $this->parse($subExpression);
            }
        }
    }
}