<?php

namespace Tests\Feature;

use Tests\TestCase;

class TMASignsTest extends TestCase
{
    /**
     * Test if TMASigns page returns successful response
     */
    public function test_the_tmasigns_page_returns_a_successful_response(): void
    {
        $response = $this->get('/tmasigns');

        $response->assertStatus(200);
    }

    /**
     * Test if TMASigns page returns successful response
     */
    public function test_the_tmasigns_api_returns_a_successful_response(): void
    {
        $postdata = [
            'format' => 'tga',
            'shouldOutputZip' => true,
            'size' => 4,
            'options' => [
                'subtextlocation' => 'bottom',
                'offsetText' => 0,
                'offsetSubtext' => 0,
                'outlineModifier' => 0,
            ],
            'text' => 'Hello, world!',
            'subtext' => 'Subtext example',
        ];

        $response = $this->postJson('/api/tmasigns', $postdata);

        $response->assertHeader('Content-Type', 'application/zip')->assertStatus(200);
    }
}
