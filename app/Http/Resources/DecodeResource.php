<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DecodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, int|string>
     */
    public function toArray(Request $request): array
    {
        return [
            'url' => $request->get('url'),
            'decoded_url' => $this->resource['decoded_url'],
        ];
    }
}
