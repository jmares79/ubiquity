<?php

namespace App\Utils;

use App\Utils\ExpressionNode;

class ExpressionTree
{
    protected $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function isEmpty()
    {
        return $this->root == null;
    }

    public function add($item)
    {
        $node = new ExpressionNode($item);

        if ($this->isEmpty()) {
            echo "<pre> ROOT LOADED:<br>";
            $this->root = $node;
            // var_dump($this);
            echo "</pre>";
        } else {
            $this->insertNode($node, $this->root);
        }
    }

    protected function insertNode($node, &$subtree)
    {
        echo "<pre> INSERTING NODE node in subtree:";
        var_dump($node);
        var_dump($subtree);
        var_dump($this);
        echo "</pre>";

        if ($subtree == null) {
            $subtree = $node;
        } else {
            if ($subtree->left == null) {
                $this->insertNode($node, $subtree->left);
            } else {
                $this->insertNode($node, $subtree->right);
            }
            
        }

        // if ($subtree->left == null) {
        //     $subtree->left = $node;
        // } else {
        //     $subtree->right = $node;
        // }


        echo "<pre> AFTER INSERTION:";
        var_dump($this);
        echo "</pre>";
    }
}