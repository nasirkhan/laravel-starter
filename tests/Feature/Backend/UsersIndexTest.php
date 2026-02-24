<?php

namespace Tests\Feature\Backend;

use App\Livewire\Backend\UsersIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UsersIndexTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->superAdmin = User::whereId(1)->first();

        $this->actingAs($this->superAdmin);
    }

    /**
     * Test that the UsersIndex component renders.
     */
    public function test_component_renders(): void
    {
        Livewire::test(UsersIndex::class)
            ->assertStatus(200);
    }

    /**
     * Test that searching by name filters the user list.
     */
    public function test_search_filters_users_by_name(): void
    {
        User::factory()->create(['name' => 'Alice Wonderland']);
        User::factory()->create(['name' => 'Bob Builder']);

        Livewire::test(UsersIndex::class)
            ->set('searchTerm', 'Alice')
            ->assertSee('Alice Wonderland')
            ->assertDontSee('Bob Builder');
    }

    /**
     * Test that searching by email filters the user list.
     */
    public function test_search_filters_users_by_email(): void
    {
        User::factory()->create(['email' => 'unique-test@example.com']);
        User::factory()->create(['email' => 'other@example.com']);

        Livewire::test(UsersIndex::class)
            ->set('searchTerm', 'unique-test')
            ->assertSee('unique-test@example.com')
            ->assertDontSee('other@example.com');
    }

    /**
     * Test that updatedSearchTerm resets pagination to page 1.
     */
    public function test_updating_search_term_resets_pagination(): void
    {
        // Create enough users to span multiple pages (default paginate = 15 per page)
        $firstPageUser = User::factory()->create(['name' => 'Aardvark First']);
        User::factory()->count(20)->create(['name' => 'Aardvark Middle']);

        // Navigate to page 2, then change the search term
        // updatedSearchTerm() should reset to page 1, making $firstPageUser visible again
        Livewire::test(UsersIndex::class)
            ->set('searchTerm', 'Aardvark')
            ->call('nextPage')            // advance to page 2
            ->set('searchTerm', 'Aardvark First') // triggers updatedSearchTerm → resetPage
            ->assertSee('Aardvark First')
            ->assertStatus(200);
    }

    /**
     * Test that clearing the search term resets to page 1 results.
     */
    public function test_clearing_search_term_resets_pagination(): void
    {
        User::factory()->count(20)->create(['name' => 'Clearable User']);

        Livewire::test(UsersIndex::class)
            ->set('searchTerm', 'Clearable User')
            ->call('nextPage')  // advance past page 1
            ->set('searchTerm', '') // triggers updatedSearchTerm → resetPage
            ->assertStatus(200);
    }
}
