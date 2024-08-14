<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class EncodeResource extends JsonResource
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
            'encoded_url' => $this->resource['encoded_url'],
        ];
    }
}
