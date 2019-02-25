<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class ExpressionControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Fetch all expressions test
     *
     * @dataProvider getExpressionsProvider
     */
    public function testFetchAll($expectedStructure, $expectedHttpResponse)
    {
        $response = $this->get(route('get-expressions'));

        $response->assertStatus($expectedHttpResponse);
        $response->assertJsonStructure($expectedStructure);
    }

    public function getExpressionsProvider()
    {
        $expression = [
            'data' => ['data', 'links' => ['self']]
        ];

        return array(
            array($expression, Response::HTTP_OK),
        );
    }
}
