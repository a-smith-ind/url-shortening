<?php

declare(strict_types=1);

namespace App\Services;

interface UrlShorteningServiceInterface
{
    public function createShortUrl(string $url): string;

    public function getOriginalUrl(string $url): string;
}
