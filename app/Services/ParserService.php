<?php

namespace App\Services;

use App\Interfaces\ParserInterface;
use App\Utils\ExpressionTree;
use App\Utils\ExpressionNode;

/**
 * Class for implementing a Parsing service, in charge of executing the XML parsing 
 */
class ParserService implements ParserInterface
{
    protected $tree;
    protected $currentNode;
    protected $expressionRepresentations = array();

    protected $operators = array(
        'add' => '+',
        'minus' => '-',
        'multiply' => '*',
        'divide' => '/',
    );

    public function __construct()
    {
    }

    public function __destruct()
    {
        $this->tree = null;
    }

    /**
     * Parses the array of expressions fetched from the input XML 
     * 
     * @param array $expressions The array of parsed XML expressions in the indicated format of the test
     * 
     * @return array An array with the formula as a string of the parsed tree
     */
    public function parse($expressions)
    {
        foreach ($expressions as $key => $expression) {
            $this->tree = $this->createExpressionTree();

            $this->parseIndividualExpression($expression);

            $this->expressionRepresentations[] = $this->tree->traverse();
            $this->tree->cleanParsedExpression();
        }

        return $this->expressionRepresentations;
    }

    /**
     * Parses an individual expression from the array of XML expressions 
     * 
     * @param array $expression The array of a single XML expression
     * 
     * @return void Creates the Expression Tree in memory and uses it to create the arithmetic expression
     */
    protected function parseIndividualExpression($expression)
    {
        foreach ($expression as $type => $subExpression) {
            //Is operator
            if (array_key_exists($type, $this->operators)) {
                $item = $this->operators[$type];
                $node = $this->createExpressionNode($item);

                $this->tree->add($node);
                $this->tree->pushNode($node);

                $this->parseIndividualExpression($subExpression/*, $tree*/);
            } else if ($type == 'number' && !is_array($subExpression)) {
                $item = $subExpression;
                $node = $this->createExpressionNode($item);

                //As it's a number, and not an operator, we don't insert it in the current stack
                $this->tree->popCurrentNode();
                $this->tree->add($node);
            } else {
                $this->tree->popCurrentNode();

                $nodeLeft = $this->createExpressionNode($subExpression[0]); 
                $this->tree->add($nodeLeft);

                $nodeRight = $this->createExpressionNode($subExpression[1]); 
                $this->tree->add($nodeRight);
            }
        }
    }

    /**
     * Pseudo factory method for proper mocking of an Expression node
     */
    protected function createExpressionNode($item)
    {
        return new ExpressionNode($item);
    }

    /**
     * Pseudo factory method for proper mocking of an Expression tree
     */
    protected function createExpressionTree()
    {
        return new ExpressionTree();
    }
}
