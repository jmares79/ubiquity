<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ExpressionTree;
use App\Services\ParserService;
use App\Services\ExpressionService;

/**
 *  Controller to handle request to expression handling 
 */
class ExpressionController extends Controller
{
    protected $tree;
    protected $parser;

    public function __construct(ParserService $parserService, ExpressionService $expressionService)
    {
        $this->parser = $parserService;
        $this->expressionService = $expressionService;
    }

    public function fetchAll(Request $request)
    {
        // var_dump($request);
        die("KK");
    }

    public function create(Request $request)
    {
        $tree = new ExpressionTree();
        $xml = \Parser::xml($request->getContent());

        $expressionString = $this->parser->parse($xml['expression'], $tree);
        $s = $tree->traverse();

        $this->expressionService->save($s);

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
