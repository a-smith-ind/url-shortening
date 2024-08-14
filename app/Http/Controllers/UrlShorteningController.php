<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Exceptions\UrlCannotBeSavedException;
use App\Http\Exceptions\UrlNotFoundException;
use App\Http\Requests\DecodeRequest;
use App\Http\Requests\EncodeRequest;
use App\Http\Resources\DecodeResource;
use App\Http\Resources\EncodeResource;
use App\Services\UrlShorteningServiceInterface;
use Illuminate\Http\JsonResponse;

final class UrlShorteningController extends Controller
{
    public function __construct(private readonly UrlShorteningServiceInterface $urlShorteningService)
    {
    }

    public function decode(DecodeRequest $request): JsonResponse
    {
        try {
            $decodedUrl = $this->urlShorteningService->getOriginalUrl($request->get('url'));
        } catch (UrlNotFoundException $e) {
            return response()->json([
                'error_message' => $e->getMessage(),
            ], 404);
        }

        return DecodeResource::make(['decoded_url' => $decodedUrl])->toResponse($request);
    }

    public function encode(EncodeRequest $request): JsonResponse
    {
        try {
            $encodedUrl = $this->urlShorteningService->createShortUrl($request->get('url'));
        } catch (UrlCannotBeSavedException $e) {
            return response()->json([
                'error_message' => $e->getMessage(),
            ], 422);
        }

        return EncodeResource::make(['encoded_url' => $encodedUrl])->toResponse($request);
    }
}
