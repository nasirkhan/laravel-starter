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
        // Layout components live in the cube package (symlinked to vendor)
        $cubePackagePath = 'vendor/nasirkhan/laravel-cube/resources/views/components/backend/layouts';

        $formsToCheck = [
            // Backend edit forms
            'resources/views/backend/users/edit.blade.php',
            'resources/views/backend/roles/edit.blade.php',

            // Backend create forms
            'resources/views/backend/users/create.blade.php',
            'resources/views/backend/roles/create.blade.php',

            // Layout components (in cube package)
            $cubePackagePath.'/edit.blade.php',
            $cubePackagePath.'/create.blade.php',
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
     *
     * Note: Module forms (Post, Category, Tag, Menu) have been moved to module-manager package
     * and should be tested within their respective module test suites.
     */
    public function test_modular_forms_inherit_cancel_button_fix(): void
    {
        // Module forms have been moved to module-manager package
        // They should be tested in their respective module test suites
        $this->markTestSkipped('Module forms moved to module-manager package - test in module test suites');
    }

    /**
     * Test that the return-back button component is safe.
     */
    public function test_return_back_button_component_is_safe(): void
    {
        // The button component lives in the cube package (symlinked to vendor)
        $returnBackComponent = base_path('vendor/nasirkhan/laravel-cube/resources/views/components/backend/buttons/return-back.blade.php');
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
        // The button component lives in the cube package (symlinked to vendor)
        $cancelComponent = base_path('vendor/nasirkhan/laravel-cube/resources/views/components/backend/buttons/cancel.blade.php');
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
