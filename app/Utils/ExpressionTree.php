<?php

namespace App\Utils;

use App\Utils\ExpressionNode;

class ExpressionTree
{
    protected $root;
    protected $current;
    protected $currentStack = array();

    public function __construct()
    {
        $this->root = null;
        $this->current = null;
    }

    public function __destruct()
    {
        $this->currentStack = null;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function isEmpty()
    {
        return $this->root == null;
    }

    public function pushNode(ExpressionNode $node)
    {
        array_push($this->currentStack, $node);
    }

    public function popCurrentNode()
    {
        $this->current = array_pop($this->currentStack);
    }

    public function add(ExpressionNode $node)
    {
        echo "ADDING NODE\n";
        var_dump($node);
        echo "\n";

        // $this->current = array_pop($this->currentStack);

        if ($this->isEmpty()) {
            echo "ROOT LOADED:\n";

            $this->root = $node;
            $this->current = $this->root;
            // array_push($this->currentStack, $this->root);

            var_dump($this->root);
            echo "\n";
        } else {
            $this->insertNode($node, $this->current);
        }
    }

    protected function insertNode($node, &$subtree)
    {
        echo "SUBTREE\n";
        var_dump($subtree);
        echo "\n";

        if ($subtree == null) {
            $subtree = $node;
        } else {
            if ($subtree->left == null) {
                echo "ABOUT TO INSERT NODE:\n";
                var_dump($node);

                echo "\n";
                echo "INSERTING IT IN LEFT SUBTREE OF:\n";
                var_dump($subtree);
                echo "\n";

                $this->insertNode($node, $subtree->left);
            } else if ($subtree->right == null) {
                echo "ABOUT TO INSERT NODE:\n";
                var_dump($node);
                echo "\n";
                echo "INSERTING IT IN RIGHT SUBTREE OF :\n";
                var_dump($subtree);
                echo "\n";

                $this->insertNode($node, $subtree->right);
            }
        }
    }

    public function traverse() 
    {
        $this->root->dump();

        return $this->root->getParsedExpression();
    }

    /**
     * Saves the tree to DB in an infix format string
     */
    public function save()
    {

    }
}