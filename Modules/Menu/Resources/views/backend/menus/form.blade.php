{{-- Basic Information --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = 'e.g., Header Menu, Footer Menu';
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
            $field_placeholder = 'e.g., header-menu, footer-menu';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'location';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select location --";
            $required = "required";
            $select_options = [
                'frontend-header' => 'Frontend Header',
                'frontend-footer' => 'Frontend Footer',
                'admin-sidebar' => 'Admin Sidebar',
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'description';
            $field_lable = label_case($field_name);
            $field_placeholder = 'Brief description of this menu';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(3)->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'note';
            $field_lable = 'Admin Notes';
            $field_placeholder = 'Internal notes for administrators';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->rows(3)->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- Display & Theme --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'theme';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select theme --";
            $required = "";
            $select_options = [
                'default' => 'Default',
                'bootstrap' => 'Bootstrap',
                'minimal' => 'Minimal',
                'dark' => 'Dark Theme',
                'custom' => 'Custom'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'css_classes';
            $field_lable = 'CSS Classes';
            $field_placeholder = 'e.g., navbar navbar-expand-lg';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'locale';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select language --";
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
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- Access Control --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Access Control</h5>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'is_public';
            $field_lable = 'Public Menu';
            $field_placeholder = "-- Select visibility --";
            $required = "";
            $select_options = [
                '1' => 'Yes - Allow guests to see this menu',
                '0' => 'No - Require authentication'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
            <small class="form-text text-muted">Control guest access to this menu</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'permissions';
            $field_lable = 'Required Permissions';
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
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name . '[]', $select_options)->class('form-select select2-permissions')->multiple()->attributes(["$required"]) }}
            <small class="form-text text-muted">Users must have these permissions to see the menu</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'roles';
            $field_lable = 'Required Roles';
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
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name . '[]', $select_options)->class('form-select select2-roles')->multiple()->attributes(["$required"]) }}
            <small class="form-text text-muted">Users must have one of these roles to see the menu</small>
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
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select status --";
            $required = "required";
            $select_options = [
                '1' => 'Published',
                '0' => 'Disabled',
                '2' => 'Draft'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'is_active';
            $field_lable = 'Active Status';
            $field_placeholder = "-- Select status --";
            $required = "";
            $select_options = [
                '1' => 'Yes - Menu is active',
                '0' => 'No - Menu is inactive'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'is_visible';
            $field_lable = 'Visibility';
            $field_placeholder = "-- Select visibility --";
            $required = "";
            $select_options = [
                '1' => 'Yes - Menu is visible',
                '0' => 'No - Menu is hidden'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

{{-- Menu Settings (JSON) --}}
<div class="row">
    <div class="col-12 mb-3">
        <h5>Advanced Settings</h5>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'settings[max_depth]';
            $field_lable = 'Maximum Depth';
            $field_placeholder = '3';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->number($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["min" => "1", "max" => "10", "$required"]) }}
            <small class="form-text text-muted">Maximum nesting level for menu items</small>
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'settings[cache_duration]';
            $field_lable = 'Cache Duration (minutes)';
            $field_placeholder = '60';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->number($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["min" => "0", "$required"]) }}
            <small class="form-text text-muted">How long to cache this menu (0 = no cache)</small>
        </div>
    </div>
</div>

<x-library.select2 />
