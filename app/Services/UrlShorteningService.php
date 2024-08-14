<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Exceptions\UrlCannotBeSavedException;
use App\Http\Exceptions\UrlNotFoundException;
use Hashids\HashidsInterface;

final readonly class UrlShorteningService implements UrlShorteningServiceInterface
{
    public function __construct(
        private HashidsInterface $hashids,
        private RedisServiceInterface $redis
    ) {
    }

    public function createShortUrl(string $url): string
    {
        $maxId = $this->getMaxId();
        $this->saveUrl($maxId, $url);

        return config('app.short_base_url') . $this->hashids->encode($maxId);
    }

    public function getOriginalUrl(string $url): string
    {
        $key = $this->hashids->decode(basename($url));

        return $this->getUrl(head($key));
    }

    private function getMaxId(): int
    {
        $maxId = (int) $this->redis->get('max_id') + 1;
        $this->redis->save('max_id', $maxId);

        return $maxId;
    }

    private function getUrl(int $key): string
    {
        $url = $this->redis->get($key);
        if (!$url) {
            throw new UrlNotFoundException("Url for key [{$key}] not found");
        }

        return $url;
    }

    private function saveUrl(int $id, string $url): true
    {
        $urlSaved = $this->redis->save($id, $url);
        if (!$urlSaved) {
            throw new UrlCannotBeSavedException(
                "Url [{$url}] for key [{$id}] cannot be saved"
            );
        }

        return $urlSaved;
    }
}
