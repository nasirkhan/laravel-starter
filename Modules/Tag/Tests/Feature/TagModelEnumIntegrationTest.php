<?php

namespace Modules\Tag\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Tag\Enums\TagStatus;
use Modules\Tag\Models\Tag;
use Tests\TestCase;

class TagModelEnumIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that Tag model correctly casts status to TagStatus enum.
     */
    public function test_tag_model_casts_status_to_enum(): void
    {
        $tag = Tag::factory()->create([
            'status' => TagStatus::Active,
        ]);

        $tag->refresh();

        // Verify the status is cast to the enum
        $this->assertInstanceOf(TagStatus::class, $tag->status);
        $this->assertEquals(TagStatus::Active, $tag->status);
        $this->assertEquals('Active', $tag->status->value);
    }

    /**
     * Test that Tag model active scope works with enum values.
     */
    public function test_tag_active_scope_works_with_enum(): void
    {
        // Create tags with different statuses
        Tag::factory()->create(['status' => TagStatus::Active]);
        Tag::factory()->create(['status' => TagStatus::Active]);
        Tag::factory()->create(['status' => TagStatus::Inactive]);
        Tag::factory()->create(['status' => TagStatus::Draft]);

        // Test active scope
        $activeTags = Tag::active()->get();

        // Should only return Active tags
        $this->assertGreaterThanOrEqual(2, $activeTags->count());

        foreach ($activeTags as $tag) {
            $this->assertEquals(TagStatus::Active, $tag->status);
        }
    }

    /**
     * Test that TagFactory works correctly with enum cases.
     */
    public function test_tag_factory_creates_valid_enum_status(): void
    {
        $tag = Tag::factory()->create();

        $this->assertInstanceOf(TagStatus::class, $tag->status);
        $this->assertContains($tag->status, TagStatus::cases());
    }

    /**
     * Test that all TagStatus enum values are valid.
     */
    public function test_tag_status_enum_values_are_correct(): void
    {
        $expectedValues = ['Active', 'Inactive', 'Draft'];
        $actualValues = TagStatus::getAllValues();

        $this->assertEquals($expectedValues, $actualValues);

        // Test each enum case
        $this->assertEquals('Active', TagStatus::Active->value);
        $this->assertEquals('Inactive', TagStatus::Inactive->value);
        $this->assertEquals('Draft', TagStatus::Draft->value);
    }

    /**
     * Test that TagStatus enum helper methods work correctly.
     */
    public function test_tag_status_enum_helper_methods(): void
    {
        $allValues = TagStatus::getAllValues();
        $allNames = TagStatus::getAllNames();
        $array = TagStatus::toArray();

        $this->assertEquals(['Active', 'Inactive', 'Draft'], $allValues);
        $this->assertEquals(['Active', 'Inactive', 'Draft'], $allNames);
        $this->assertEquals([
            'Active' => 'Active',
            'Inactive' => 'Inactive',
            'Draft' => 'Draft',
        ], $array);
    }

    /**
     * Test that Tag model works with string status values (backward compatibility).
     */
    public function test_tag_model_handles_string_status_values(): void
    {
        $tag = new Tag;
        $tag->name = 'Test Tag';
        $tag->slug = 'test-tag';
        $tag->description = 'Test description';
        $tag->status = 'Active'; // String value
        $tag->save();

        $tag->refresh();

        // Should be cast to enum
        $this->assertInstanceOf(TagStatus::class, $tag->status);
        $this->assertEquals(TagStatus::Active, $tag->status);
    }
}
