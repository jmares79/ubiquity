<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\ExpressionTree;
use App\Services\ParserService;
use App\Services\ExpressionService;
use App\Expression;
use App\Http\Resources\Expression as ExpressionResource;
use App\Http\Resources\ExpressionsCollection;

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
        return new ExpressionsCollection(Expression::paginate());
    }

    public function fetchBy(Request $request, $id)
    {
        return new ExpressionResource(Expression::find($id));
    }

    public function create(Request $request)
    {
        $tree = new ExpressionTree();
        $xml = \Parser::xml($request->getContent());

        $expressionString = $this->parser->parse($xml['expression'], $tree);
        $s = $tree->traverse();

        $response = $this->expressionService->save($s);

        return response()->json([
            'data' => array(
                'type' => 'expression',
                'id' => $response->id,
                'attributes' => array(
                    'expression' => $response->expression,
                    'result' => 0
                )
            )
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        die("UPDATING");
    }

    public function delete(Request $request, $id)
    {
        die("DELETING");
    }

}
