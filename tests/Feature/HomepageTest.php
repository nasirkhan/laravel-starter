<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Home Page visiting
     *
     * @test
     */
    public function visit_home_page()
    {
        $response = $this->get('/');
        $response->assertSeeText(app_name());

        $response->assertStatus(200);
    }

    /**
     * Homepage footer text
     *
     * @test
     */
    public function check_home_page_footer_text()
    {
        $response = $this->get('/');
        $response->assertSeeText('Built with ♥ by');
    }
}
