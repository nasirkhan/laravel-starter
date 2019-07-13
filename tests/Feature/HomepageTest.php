<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * Home Page visiting.
     *
     * @test
     */
    public function visit_home_page()
    {
        $response = $this->get('/');

        $response->assertSeeText(app_name());

        $response->assertStatus(200);
    }

}
