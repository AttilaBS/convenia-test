<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GenericResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string>
     */
    public function toArray(Request $request): array
    {

        return [
            'message' => $this['message'],
            'status' => $this['status'],
        ];
    }
}
