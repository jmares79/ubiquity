<?php

namespace App\Utils;

use App\Utils\ExpressionNode;

/**
 * Class for implementing an Expression tree for parsing the XML expressions
 */
class ExpressionTree
{
    protected $root;
    protected $current;

    /**
     * @var array $currentStack Array for holding the current node to be checked for insertion
     */
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

    /**
     * Adds a node to the Expression tree
     * 
     * @param ExpressionNode $node Node to be inserted
     * 
     * @return void Adds a node into the tree
     */
    public function add(ExpressionNode $node)
    {
        // echo "ADDING NODE\n";
        // var_dump($node);
        // echo "\n";

        if ($this->isEmpty()) {
            // echo "ROOT LOADED:\n";

            $this->root = $node;
            $this->current = $this->root;

            // var_dump($this->root);
            // echo "\n";
        } else {
            $this->insertNode($node, $this->current);
        }
    }

    /**
     * Inserts a node to the Expression tree according to some specific insertion rules
     * 
     * @param ExpressionNode $node Node to be inserted
     * @param $subtree Subtree where the node has to be inserted
     * 
     * @return void Adds a node into the tree
     */
    protected function insertNode(ExpressionNode $node, &$subtree)
    {
        // echo "SUBTREE\n";
        // var_dump($subtree);
        // echo "\n";

        if ($subtree == null) {
            $subtree = $node;
        } else {
            if ($subtree->left == null) {
                // echo "ABOUT TO INSERT NODE:\n";
                // var_dump($node);

                // echo "\n";
                // echo "INSERTING IT IN LEFT SUBTREE OF:\n";
                // var_dump($subtree);
                // echo "\n";

                $this->insertNode($node, $subtree->left);
            } else if ($subtree->right == null) {
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

    /**
     * Traverses the tree for printing the string formula of an XML expression
     * 
     * @return string An expression in string format
     */
    public function traverse() 
    {
        $this->root->dump();

        return $this->root->getParsedExpression();
    }

    public function cleanParsedExpression()
    {
        $this->root->cleanParsedExpression();
    }
}