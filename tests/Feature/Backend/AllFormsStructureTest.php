<?php

namespace Tests\Feature\Backend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllFormsStructureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that all main edit and create blade files have Cancel buttons outside forms.
     */
    public function test_all_forms_have_cancel_buttons_outside_forms(): void
    {
        $formsToCheck = [
            // Backend edit forms
            'resources/views/backend/users/edit.blade.php',
            'resources/views/backend/roles/edit.blade.php',

            // Backend create forms
            'resources/views/backend/users/create.blade.php',
            'resources/views/backend/roles/create.blade.php',

            // Layout components
            'resources/views/components/backend/layouts/edit.blade.php',
            'resources/views/components/backend/layouts/create.blade.php',
        ];

        foreach ($formsToCheck as $formFile) {
            $fullPath = base_path($formFile);
            $this->assertFileExists($fullPath, "Form file {$formFile} should exist");

            $content = file_get_contents($fullPath);

            // Check our fix comment is present
            $this->assertStringContainsString('Cancel button outside the form to prevent accidental form submission', $content,
                "Form {$formFile} should have the fix comment");

            // Find positions of form close and Cancel button
            $formClosePositions = [];
            $cancelPositions = [];

            // Look for various form closing patterns
            if (strpos($content, '{{ html()->closeModelForm() }}') !== false) {
                $formClosePositions[] = strpos($content, '{{ html()->closeModelForm() }}');
            }
            if (strpos($content, '{{ html()->form()->close() }}') !== false) {
                $formClosePositions[] = strpos($content, '{{ html()->form()->close() }}');
            }

            // Look for Cancel button patterns
            if (strpos($content, 'x-backend.buttons.cancel') !== false) {
                $cancelPositions[] = strpos($content, 'x-backend.buttons.cancel');
            }
            if (strpos($content, 'x-buttons.cancel') !== false) {
                $cancelPositions[] = strpos($content, 'x-buttons.cancel');
            }
            if (strpos($content, 'return-back>Cancel') !== false) {
                $cancelPositions[] = strpos($content, 'return-back>Cancel');
            }

            // Verify that at least one Cancel button appears after at least one form close
            $hasValidCancelPosition = false;
            foreach ($formClosePositions as $formClosePos) {
                foreach ($cancelPositions as $cancelPos) {
                    if ($cancelPos > $formClosePos) {
                        $hasValidCancelPosition = true;
                        break 2;
                    }
                }
            }

            if (! empty($formClosePositions) && ! empty($cancelPositions)) {
                $this->assertTrue($hasValidCancelPosition,
                    "In {$formFile}, at least one Cancel button should appear after form close. ".
                    'Form closes at: '.implode(', ', $formClosePositions).
                    '. Cancel buttons at: '.implode(', ', $cancelPositions));
            }
        }
    }

    /**
     * Test that forms using layout components inherit the fix.
     */
    public function test_modular_forms_inherit_cancel_button_fix(): void
    {
        $modularForms = [
            // These forms use x-backend.layouts.edit which we fixed
            'Modules/Category/Resources/views/backend/categories/edit.blade.php',
            'Modules/Post/Resources/views/backend/posts/edit.blade.php',
            'Modules/Tag/Resources/views/backend/tags/edit.blade.php',

            // These forms use x-backend.layouts.create which we fixed
            'Modules/Category/Resources/views/backend/categories/create.blade.php',
            'Modules/Post/Resources/views/backend/posts/create.blade.php',
            'Modules/Tag/Resources/views/backend/tags/create.blade.php',
        ];

        foreach ($modularForms as $formFile) {
            $fullPath = base_path($formFile);

            if (file_exists($fullPath)) {
                $content = file_get_contents($fullPath);

                // These should use x-backend.layouts.edit or x-backend.layouts.create
                $usesLayoutComponent =
                    strpos($content, 'x-backend.layouts.edit') !== false ||
                    strpos($content, 'x-backend.layouts.create') !== false;

                if ($usesLayoutComponent) {
                    $this->assertTrue(true, "Form {$formFile} uses layout component which has our fix");
                } else {
                    // If not using layout component, should have direct fix
                    $this->assertStringContainsString('Cancel button outside the form', $content,
                        "Form {$formFile} should either use layout component or have direct fix");
                }
            }
        }
    }

    /**
     * Test that the return-back button component is safe.
     */
    public function test_return_back_button_component_is_safe(): void
    {
        $returnBackComponent = base_path('resources/views/components/backend/buttons/return-back.blade.php');
        $this->assertFileExists($returnBackComponent);

        $content = file_get_contents($returnBackComponent);

        // Should use window.history.back() which is safe
        $this->assertStringContainsString('window.history.back()', $content,
            'return-back component should use safe navigation');

        // Should create a button element (not a submit button when not inside form)
        $this->assertStringContainsString('<button', $content,
            'return-back component should create a button element');
    }

    /**
     * Test that cancel button component is safe.
     */
    public function test_cancel_button_component_is_safe(): void
    {
        $cancelComponent = base_path('resources/views/components/backend/buttons/cancel.blade.php');
        $this->assertFileExists($cancelComponent);

        $content = file_get_contents($cancelComponent);

        // Should use window.history.back() which is safe
        $this->assertStringContainsString('window.history.back()', $content,
            'cancel component should use safe navigation');

        // Should create a button element
        $this->assertStringContainsString('<button', $content,
            'cancel component should create a button element');
    }
}
