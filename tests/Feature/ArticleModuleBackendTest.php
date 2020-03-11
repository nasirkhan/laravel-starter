<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleModuleBackendTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Without login user can not access Posts list
     * and will redirect to Login
     *
     * @test
     */
    public function general_user_redirects_to_login_at_posts_list()
    {
        $response = $this->get('/admin/posts');

        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }

    /**
     * Super Admin can access Posts List
     *
     * @test
     */
    public function super_admin_can_access_posts_list()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/posts');

        $response->assertSeeText('Posts Data Table List');

        $response->assertStatus(200);
    }

    /**
     * Without login user can not access Categories list
     * and will redirect to Login
     *
     * @test
     */
    public function general_user_redirects_to_login_at_categories_list()
    {
        $response = $this->get('/admin/categories');

        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }

    /**
     * Super Admin can access Categories List
     *
     * @test
     */
    public function super_admin_can_access_categories_list()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/categories');

        $response->assertSeeText('Categories Data Table List');

        $response->assertStatus(200);
    }

    /**
     * Without login user can not access Tags list
     * and will redirect to Login
     *
     * @test
     */
    public function general_user_redirects_to_login_at_tags_list()
    {
        $response = $this->get('/admin/tags');

        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }

    /**
     * Super Admin can access Tags List
     *
     * @test
     */
    public function super_admin_can_access_tags_list()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/tags');

        $response->assertSeeText('Tags Data Table List');

        $response->assertStatus(200);
    }

    /**
     * Without login user can not access Comments list
     * and will redirect to Login
     *
     * @test
     */
    public function general_user_redirects_to_login_at_comments_list()
    {
        $response = $this->get('/admin/comments');

        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }

    /**
     * Super Admin can access Comments List
     *
     * @test
     */
    public function super_admin_can_access_comments_list()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/admin/comments');

        $response->assertSeeText('Comments Data Table List');

        $response->assertStatus(200);
    }
}
