<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Redirect;

class CreateRedirectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creation of redirect with valid URL.
     *
     * @return void
     */
    public function test_create_redirect_with_valid_url()
    {
        $response = $this->post(route('redirects.store'), [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $this->assertCount(1, Redirect::all());
    }

    /**
     * Test creation of redirect with invalid URL.
     *
     * @dataProvider invalidUrlProvider
     * @return void
     */
    public function test_create_redirect_with_invalid_url($url)
    {
        $response = $this->post(route('redirects.store'), [
            'url' => $url,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();

        $this->assertCount(0, Redirect::all());
    }

    /**
     * Data provider for invalid URLs.
     *
     * @return array
     */
    public function invalidUrlProvider()
    {
        return [
            ['invalid-url'], 
            ['http://invalid-url.com'], 
            ['https://localhost'], 
            ['https://example.com?key='], 
        ];
    }
}
