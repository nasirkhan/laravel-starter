@livewire('menu-item-component')

{{-- Basic Information --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'menu_id';
            $field_lable = 'Menu';
            $field_placeholder = "-- Select Menu --";
            $required = "required";
            // This should be populated from controller with available menus
            $select_options = $menus ?? [];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'parent_id';
            $field_lable = 'Parent Item';
            $field_placeholder = "-- No Parent (Root Level) --";
            $required = "";
            // This should be populated from controller with available menu items
            $select_options = $parent_items ?? [];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select select2-parent')->attributes(["$required"]) }}
            <small class="form-text text-muted">Select parent item to create dropdown menu</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'type';
            $field_lable = 'Item Type';
            $field_placeholder = "-- Select Type --";
            $required = "required";
            $select_options = [
                'link' => 'Link',
                'dropdown' => 'Dropdown',
                'divider' => 'Divider',
                'heading' => 'Heading',
                'external' => 'External Link'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required", "onchange" => "toggleTypeFields(this.value)"]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = 'Display Name';
            $field_placeholder = 'e.g., Home, About Us, Contact';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'slug';
            $field_lable = label_case($field_name);
            $field_placeholder = 'e.g., home, about-us, contact';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'sort_order';
            $field_lable = 'Sort Order';
            $field_placeholder = '0';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->number($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["min" => "0", "$required"]) }}
            <small class="form-text text-muted">Lower numbers appear first</small>
        </div>
    </div>
</div>

{{-- Navigation Properties --}}
<div class="row" id="navigation-fields">
    <div class="col-12 mb-3">
        <h5>Navigation</h5>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'url';
            $field_lable = 'Direct URL';
            $field_placeholder = 'e.g., /about-us or https://external.com';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <small class="form-text text-muted">Use either URL or Route Name, not both</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'route_name';
            $field_label = 'Laravel Route Name';
            $field_placeholder = 'e.g., frontend.pages.about';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <small class="form-text text-muted">Laravel route name (preferred over direct URL)</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'route_parameters';
            $field_label = 'Route Parameters (JSON)';
            $field_placeholder = '{"id": 1, "slug": "example"}';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(2)->attributes(["$required"]) }}
            <small class="form-text text-muted">JSON format for route parameters</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'description';
            $field_label = 'Description/Tooltip';
            $field_placeholder = 'Brief description or tooltip text';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(2)->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- Display Properties --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Display Properties</h5>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'icon';
            $field_label = 'Icon Class';
            $field_placeholder = 'e.g., fas fa-home';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            <small class="form-text text-muted">FontAwesome or similar icon class</small>
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'badge_text';
            $field_label = 'Badge Text';
            $field_placeholder = 'New, Hot, 5';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'badge_color';
            $field_label = 'Badge Color';
            $field_placeholder = "-- Select Color --";
            $required = "";
            $select_options = [
                'primary' => 'Primary',
                'secondary' => 'Secondary',
                'success' => 'Success',
                'danger' => 'Danger',
                'warning' => 'Warning',
                'info' => 'Info',
                'light' => 'Light',
                'dark' => 'Dark'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php $field_name = 'opens_new_tab'; ?>
            <div class="form-check form-switch">
                {{ html()->checkbox($field_name, false, '1')->class('form-check-input')->id($field_name) }}
                {{ html()->label('Open in New Tab', $field_name)->class('form-check-label') }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'css_classes';
            $field_label = 'CSS Classes';
            $field_placeholder = 'nav-item active highlighted';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'html_attributes';
            $field_label = 'HTML Attributes (JSON)';
            $field_placeholder = '{"data-toggle": "tooltip", "title": "Click me"}';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(2)->attributes(["$required"]) }}
            <small class="form-text text-muted">Custom HTML attributes in JSON format</small>
        </div>
    </div>
</div>

{{-- Access Control --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Access Control</h5>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'permissions';
            $field_label = 'Required Permissions';
            $field_placeholder = 'Select permissions';
            $required = "";
            // You can populate this from your permissions system
            $select_options = [
                'view_backend' => 'View Backend',
                'edit_content' => 'Edit Content',
                'manage_users' => 'Manage Users',
                'manage_settings' => 'Manage Settings'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name . '[]', $select_options)->class('form-select select2-permissions')->multiple()->attributes(["$required"]) }}
            <small class="form-text text-muted">Users must have these permissions</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'roles';
            $field_label = 'Required Roles';
            $field_placeholder = 'Select roles';
            $required = "";
            // You can populate this from your roles system
            $select_options = [
                'super admin' => 'Super Admin',
                'admin' => 'Admin',
                'editor' => 'Editor',
                'user' => 'User'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name . '[]', $select_options)->class('form-select select2-roles')->multiple()->attributes(["$required"]) }}
            <small class="form-text text-muted">Users must have one of these roles</small>
        </div>
    </div>
</div>

{{-- Status & Visibility --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Status & Visibility</h5>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_label = 'Status';
            $field_placeholder = "-- Select Status --";
            $required = "required";
            $select_options = [
                '1' => 'Published',
                '0' => 'Disabled',
                '2' => 'Draft'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php $field_name = 'is_active'; ?>
            <div class="form-check form-switch">
                {{ html()->checkbox($field_name, true, '1')->class('form-check-input')->id($field_name) }}
                {{ html()->label('Active', $field_name)->class('form-check-label') }}
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php $field_name = 'is_visible'; ?>
            <div class="form-check form-switch">
                {{ html()->checkbox($field_name, true, '1')->class('form-check-input')->id($field_name) }}
                {{ html()->label('Visible', $field_name)->class('form-check-label') }}
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'locale';
            $field_label = 'Language';
            $field_placeholder = "-- Select Language --";
            $required = "";
            $select_options = [
                'en' => 'English',
                'es' => 'Spanish',
                'fr' => 'French',
                'de' => 'German',
                'ar' => 'Arabic',
                'hi' => 'Hindi'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- SEO Fields --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>SEO (Optional)</h5>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'meta_title';
            $field_label = 'Meta Title';
            $field_placeholder = 'Page title for SEO';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'meta_description';
            $field_label = 'Meta Description';
            $field_placeholder = 'Brief description for search engines';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(2)->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'meta_keywords';
            $field_label = 'Meta Keywords';
            $field_placeholder = 'keyword1, keyword2, keyword3';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- Additional Data & Notes --}}
<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'custom_data';
            $field_label = 'Custom Data (JSON)';
            $field_placeholder = '{"priority": "high", "category": "main"}';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(3)->attributes(["$required"]) }}
            <small class="form-text text-muted">Store additional custom properties in JSON format</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'note';
            $field_label = 'Admin Notes';
            $field_placeholder = 'Internal notes for administrators';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(3)->attributes(["$required"]) }}
        </div>
    </div>
</div>

<x-library.select2 />

<script>
function toggleTypeFields(type) {
    const navFields = document.getElementById('navigation-fields');
    
    if (type === 'divider' || type === 'heading') {
        // Hide navigation fields for dividers and headings
        navFields.style.display = 'none';
        // Clear URL and route fields
        document.querySelector('input[name="url"]').value = '';
        document.querySelector('input[name="route_name"]').value = '';
    } else {
        // Show navigation fields for links, dropdowns, and external links
        navFields.style.display = 'block';
    }
    
    // Set required fields based on type
    const urlField = document.querySelector('input[name="url"]');
    const routeField = document.querySelector('input[name="route_name"]');
    
    if (type === 'external') {
        urlField.setAttribute('required', 'required');
        routeField.removeAttribute('required');
    } else if (type === 'link') {
        // Either URL or route is acceptable, but not both required
        urlField.removeAttribute('required');
        routeField.removeAttribute('required');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    if (typeSelect && typeSelect.value) {
        toggleTypeFields(typeSelect.value);
    }
});
</script>