<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class UrlShorteningControllerTest extends TestCase
{
    public function test_encode_returns_a_successful_response(): void
    {
        $data = [
            'url' => 'http://www.thisisalongdomain.com/with/some/parameters?and=here_too',
        ];

        $response = $this->postJson(route('encode'), $data);

        $response
            ->assertValid()
            ->assertOk();
    }

    public function test_decode_returns_a_successful_response(): void
    {
        $data = [
            'url' => 'http://short.url/MA',
        ];

        Redis::set(23, 'http://example.com/articles');
        $response = $this->postJson(route('decode'), $data);

        $response
            ->assertValid()
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        Redis::flushDB();
        $this->withoutMiddleware();
    }
}
