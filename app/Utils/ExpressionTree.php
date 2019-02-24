<?php

namespace App\Utils;

use App\Utils\ExpressionNode;

class ExpressionTree
{
    protected $root;
    static protected $stringExpression = '';
    // protected $operators = array(
    //     'add' => '+',
    //     'minus' => '-',
    //     'multiply' => '*',
    //     'divide' => '/',
    // );

    public function __construct()
    {
        $this->root = null;
        // $this->stringExpression = '';
    }

    public function isEmpty()
    {
        return $this->root == null;
    }

    public function add($item)
    {
        $node = new ExpressionNode($item);

        if ($this->isEmpty()) {
            // echo "ROOT LOADED:\n";
            $this->root = $node;
            // var_dump($this->root);
            // echo "******************************\n";
        } else {
            $this->insertNode($node, $this->root);
        }
    }

    protected function insertNode($node, &$subtree)
    {
        if ($subtree == null) {
            $subtree = $node;
        } else {
            // if ($subtree->left == null) {
            //     $subtree->left = $node;
            // } else {
            //     $subtree->right = $node;
            // }

            if ($subtree->left == null) {
                // echo "ABOUT TO INSERT NODE:\n";
                // var_dump($node);
                // echo "\n";
                // echo "INSERTING IT IN LEFT SUBTREE OF:\n";
                // var_dump($subtree);
                // echo "\n";

                $this->insertNode($node, $subtree->left);
            } else if ($subtree->right == null){
                // echo "ABOUT TO INSERT NODE:\n";
                // var_dump($node);
                // echo "\n";
                // echo "INSERTING IT IN RIGHT SUBTREE OF :\n";
                // var_dump($subtree);
                // echo "\n";

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