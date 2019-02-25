<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\ExpressionTree;
use App\Services\ParserService;
use App\Services\ExpressionService;
use App\Http\Resources\Expression as ExpressionResource;
use App\Http\Resources\ExpressionsCollection;
use Illuminate\Support\Facades\DB;
use App\Expression;

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

    /**
     * Gets all expressions
     *
     * @param Request $request
     *
     * @return mixed A collection with all expressions in JSON format
     * @return Response HTTP 200 on success,
     * @return Response HTTP 400 on retrieval error,
     */
    public function fetchAll(Request $request)
    {
        return new ExpressionsCollection(Expression::paginate());
    }

    /**
     * Gets an expression by its id
     *
     * @param Request $request
     * @param integer $id Expression id
     *
     * @return mixed An expression in JSON format
     * @return Response HTTP 200 on success,
     * @return Response HTTP 400 on retrieval error,
     */
    public function fetchBy(Request $request, $id)
    {
        return new ExpressionResource(Expression::find($id));
    }

    /**
     * Creates a new expression(s)
     *
     * @param Request $request
     *
     * @return mixed An expression in JSON format
     * @return Response HTTP 200 on success,
     * @return Response HTTP 400 on retrieval error
     */
    public function create(Request $request)
    {
        $tree = new ExpressionTree();
        $xml = \Parser::xml($request->getContent());

        $expressionString = $this->parser->parse($xml['expression'], $tree);
        $s = $tree->traverse();

        try {
            $response = $this->expressionService->save($s);

            return response()->json([
                'data' => array(
                    'type' => 'expression',
                    'id' => $response->id,
                    'attributes' => array(
                        'expression' => $response->expression,
                        'result' => $response->result
                    )
                )
            ], Response::HTTP_CREATED);
        } catch (ExpressionCreationException $e) {
            return response()->json(['expression' => "Error while creating expression"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['expression' => "Error while creating expression"], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Updates an expression based on information in the request
     *
     * @param Request $request The validated information
     * @param integer $id Expression id
     * 
     * @return Response HTTP 200 on success,
     * @return Response HTTP 422 when invalid parameters,
     * @return Response HTTP 404 when non existing expression,
     * @return Response HTTP 400 on update error,
     */
    public function update(Request $request, $id)
    {
        $expression = DB::table('expressions')->where('id', $id);
        
        if ($expression->get()->isEmpty()) { 
            return response()->json(['message' => 'Expression not found'], Response::HTTP_NOT_FOUND); 
        }

        $tree = new ExpressionTree();
        $xml = \Parser::xml($request->getContent());

        $expressionString = $this->parser->parse($xml['expression'], $tree);

        try {
            $newExpression = $tree->traverse();
            $response = $this->expressionService->update($expression, $newExpression);

            return response()->json([
                    'data' => array(
                        'type' => 'expression',
                        'id' => $response->id,
                        'attributes' => array(
                            'expression' => $response->expression,
                            'result' => $response->result
                        )
                    )
                ], Response::HTTP_OK);
        } catch (ExpressionUpdateException $e) {
            return response()->json(['expression' => "Error while updating expression"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['expression' => "Error while updating expression"], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Deletes an expression
     *
     * @param Request $request The validated information
     * @param integer $id Expression id
     * 
     * @return Response HTTP 200 on success,
     * @return Response HTTP 422 when invalid parameters,
     * @return Response HTTP 404 when non existing expression,
     * @return Response HTTP 400 on update error,
     */
    public function delete(Request $request, $id)
    {
        $expression = Expression::find($id);
        
        if (null == $expression) { 
            return response()->json(['message' => 'Expression not found'], Response::HTTP_NOT_FOUND); 
        }

        try {
            $response = $this->expressionService->delete($expression);

            return response()->json(['expression' => "Expression deleted sucessfully"], Response::HTTP_OK);
        } catch (ExpressionDeleteException $e) {
            return response()->json(['expression' => "Error while deleting expression"], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json(['expression' => "Error while deleting expression"], Response::HTTP_BAD_REQUEST);
        }
    }
}
