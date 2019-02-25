<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Expression extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'expression' => $this->expression,
                'id' => $this->id,
                'result' => $this->result,
            ],
            'links' => [
                'self' => route('get-expression', ['id' => $this->id]),
            ],
        ];
    }
}
