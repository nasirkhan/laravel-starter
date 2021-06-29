<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

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
