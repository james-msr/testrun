<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsLowLimitTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/news', [
            'category' => 'tech',
            'language' => 'en',
            'limit' => 0
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('error.limit')
        );
    }
}
