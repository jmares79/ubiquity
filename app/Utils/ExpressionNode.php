<?php

namespace App\Utils;

class ExpressionNode
{
    public $value;
    public $left;
    public $right;

    static public $parsedExpression;

    public function __construct($item)
    {
        $this->value = $item;
        $this->left = null;
        $this->right = null;
    }

    public function setValue($item)
    {
        $this->value = $item;
    }

    public function setLeft($left)
    {
        $this->left = $left;
    }

    public function setRight($right)
    {
        $this->right = $right;
    }

    public function getLeft()
    {
        return $this->left;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function getParsedExpression()
    {
        return self::$parsedExpression;
    }

    public function dump()
    {
        if ($this->left !== null) {
            $this->left->dump();
        }

        echo "<pre>NODE:";
        var_dump($this->value);
        echo "</pre>";
        self::$parsedExpression .= $this->value;

        if ($this->right !== null) {
            $this->right->dump();
        }
    }
}
