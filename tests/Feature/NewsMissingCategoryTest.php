<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class NewsMissingCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/news', [
            'language' => 'en',
            'limit' => 1
        ]);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('error.category')
        );
    }
}
