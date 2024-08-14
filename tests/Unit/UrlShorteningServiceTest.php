<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Exceptions\UrlCannotBeSavedException;
use App\Http\Exceptions\UrlNotFoundException;
use App\Services\RedisService;
use App\Services\RedisServiceInterface;
use App\Services\UrlShorteningService;
use App\Services\UrlShorteningServiceInterface;
use Hashids\HashidsInterface;
use Illuminate\Support\Facades\Redis;
use Mockery;
use Tests\TestCase;

class UrlShorteningServiceTest extends TestCase
{
    private HashidsInterface $hashids;
    private RedisServiceInterface $redis;
    private UrlShorteningServiceInterface $service;

    public function test_create_short_url_returns_correct_value(): void
    {
        $this->hashids->shouldReceive('encode')->andReturn('MA');

        $url = 'http://www.thisisalongdomain.com/with/some/parameters?and=here_too';
        $shortUrl = (new UrlShorteningService($this->hashids, $this->redis))
            ->createShortUrl($url);

        $this->assertEquals('http://short.url/MA', $shortUrl);
    }

    public function test_create_short_url_throws_exception_when_cannot_save_url(): void
    {
        $this->hashids->shouldReceive('encode')->andReturn('MA');
        $this->expectException(UrlCannotBeSavedException::class);

        $redis = Mockery::mock(RedisServiceInterface::class);
        $redis->shouldReceive('get')->andReturn(1);
        $redis->shouldReceive('save')->andThrow(new UrlCannotBeSavedException());

        $url = 'http://www.thisisalongdomain.com/with/some/parameters?and=here_too';
        (new UrlShorteningService($this->hashids, $redis))
            ->createShortUrl($url);
    }

    public function test_get_original_url_returns_correct_value(): void
    {
        $originalUrl = 'http://www.thisisalongdomain.com/with/some/parameters?and=here_too';
        $this->hashids->shouldReceive('decode')->andReturn([1]);
        Redis::set(1, $originalUrl);

        $shortUrl = 'http://short.url/MA';
        $url = (new UrlShorteningService($this->hashids, $this->redis))
            ->getOriginalUrl($shortUrl);

        $this->assertEquals($originalUrl, $url);
    }

    public function test_get_original_url_throws_exception_when_no_url_found(): void
    {
        $this->hashids->shouldReceive('decode')->andReturn([1]);
        $this->expectException(UrlNotFoundException::class);

        $url = 'http://short.url/MA';
        (new UrlShorteningService($this->hashids, $this->redis))
            ->getOriginalUrl($url);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Redis::flushDB();
        $this->hashids = Mockery::mock(HashidsInterface::class);
        $this->redis = new RedisService();
    }
}
