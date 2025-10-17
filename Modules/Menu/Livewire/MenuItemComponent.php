<?php

namespace Modules\Menu\Livewire;

use Livewire\Component;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuItemComponent extends Component
{
    // Form properties
    public $menu_id;

    public $parent_id;

    public $type = 'link';

    public $name;

    public $slug;

    public $sort_order = 0;

    public $url;

    public $route_name;

    public $route_parameters;

    public $description;

    public $icon;

    public $badge_text;

    public $badge_color;

    public $opens_new_tab = 0;

    public $css_classes;

    public $html_attributes;

    public $permissions = [];

    public $roles = [];

    public $status = 1;

    public $is_active = 1;

    public $is_visible = 1;

    public $locale;

    public $meta_title;

    public $custom_data;

    public $note;

    // Data for dropdowns
    public $menus = [];

    public $parent_items = [];

    public $available_permissions = [];

    public $available_roles = [];

    // Menu item being edited (if any)
    public $menuItem;

    public function mount($menuItem = null, $menu_id = null)
    {
        $this->menuItem = $menuItem;

        // If a menu_id is provided (for preselection), set it
        if ($menu_id && ! $this->menuItem) {
            $this->menu_id = $menu_id;
        }

        // Load dropdown data
        $this->loadDropdownData();

        // If editing, populate form with existing data
        if ($this->menuItem) {
            $this->populateFormFromMenuItem();
        }
    }

    public function updatedMenuId()
    {
        // Reset parent_id when menu changes
        $this->parent_id = null;

        // Load new parent items for the selected menu
        $this->loadParentItems();
    }

    public function updatedType()
    {
        // Clear navigation fields for divider and heading types
        if (in_array($this->type, ['divider', 'heading'])) {
            $this->url = '';
            $this->route_name = '';
            $this->route_parameters = '';
        }
    }

    protected function loadDropdownData()
    {
        // Load menus
        $this->menus = Menu::where('status', 1)
            ->where('is_active', true)
            ->pluck('name', 'id')
            ->toArray();

        // Load permissions
        $this->available_permissions = Permission::pluck('name', 'name')->toArray();

        // Load roles
        $this->available_roles = Role::pluck('name', 'name')->toArray();

        // Load parent items if menu is selected
        if ($this->menu_id) {
            $this->loadParentItems();
        }
    }

    protected function loadParentItems()
    {
        if ($this->menu_id) {
            $query = MenuItem::where('menu_id', $this->menu_id)
                ->where('is_active', true)
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->orderBy('name');

            // Exclude current item and its descendants if editing
            if ($this->menuItem) {
                $excludeIds = [$this->menuItem->id];

                // Get all descendant IDs to prevent circular references
                $descendants = $this->getDescendantIds($this->menuItem->id);
                $excludeIds = array_merge($excludeIds, $descendants);

                $query->whereNotIn('id', $excludeIds);
            }

            // Only allow items that can have children (not dividers)
            $query->where('type', '!=', 'divider');

            $this->parent_items = $query->pluck('name', 'id')->toArray();
        } else {
            $this->parent_items = [];
        }

        // Reset parent_id if it's no longer valid
        if ($this->parent_id && ! array_key_exists($this->parent_id, $this->parent_items)) {
            $this->parent_id = null;
        }
    }

    /**
     * Get all descendant IDs of a menu item to prevent circular references.
     */
    private function getDescendantIds($parentId, $depth = 0, $maxDepth = 10)
    {
        if ($depth >= $maxDepth) {
            return []; // Prevent infinite recursion
        }

        $descendants = [];
        $children = MenuItem::where('parent_id', $parentId)->pluck('id');

        foreach ($children as $childId) {
            $descendants[] = $childId;
            $descendants = array_merge($descendants, $this->getDescendantIds($childId, $depth + 1, $maxDepth));
        }

        return $descendants;
    }

    protected function populateFormFromMenuItem()
    {
        $this->menu_id = $this->menuItem->menu_id;

        // Load parent items for the selected menu first
        $this->loadParentItems();

        $this->parent_id = $this->menuItem->parent_id;
        $this->type = $this->menuItem->type ?? 'link';
        $this->name = $this->menuItem->name;
        $this->slug = $this->menuItem->slug;
        $this->sort_order = $this->menuItem->sort_order ?? 0;
        $this->url = $this->menuItem->url;
        $this->route_name = $this->menuItem->route_name;
        $this->route_parameters = $this->menuItem->route_parameters;
        $this->description = $this->menuItem->description;
        $this->icon = $this->menuItem->icon;
        $this->badge_text = $this->menuItem->badge_text;
        $this->badge_color = $this->menuItem->badge_color;
        $this->opens_new_tab = $this->menuItem->opens_new_tab ? 1 : 0;
        $this->css_classes = $this->menuItem->css_classes;
        $this->html_attributes = $this->menuItem->html_attributes;
        $this->permissions = $this->menuItem->permissions ?? [];
        $this->roles = $this->menuItem->roles ?? [];
        $this->status = $this->menuItem->status ?? 1;
        $this->is_active = $this->menuItem->is_active ? 1 : 0;
        $this->is_visible = $this->menuItem->is_visible ? 1 : 0;
        $this->locale = $this->menuItem->locale;
        $this->meta_title = $this->menuItem->meta_title;
        $this->custom_data = $this->menuItem->custom_data;
        $this->note = $this->menuItem->note;
    }

    public function resetForm()
    {
        $this->reset([
            'menu_id', 'parent_id', 'name', 'slug', 'sort_order', 'url',
            'route_name', 'route_parameters', 'description', 'icon',
            'badge_text', 'badge_color', 'css_classes', 'html_attributes',
            'permissions', 'roles', 'locale', 'meta_title',
            'custom_data', 'note',
        ]);

        // Reset to defaults
        $this->type = 'link';
        $this->status = 1;
        $this->is_active = 1;
        $this->is_visible = 1;
        $this->opens_new_tab = 0;
        $this->sort_order = 0;

        // Clear errors
        $this->resetErrorBag();

        // Reload dropdown data
        $this->loadDropdownData();
    }

    protected function rules()
    {
        $rules = [
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:link,dropdown,divider,heading,external',
            'status' => 'required|in:0,1,2',
            'sort_order' => 'nullable|integer|min:0',
            'url' => 'nullable|string|max:500',
            'route_name' => 'nullable|string|max:255',
            'route_parameters' => 'nullable|json',
            'html_attributes' => 'nullable|json',
            'custom_data' => 'nullable|json',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'badge_text' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:20',
            'css_classes' => 'nullable|string|max:500',
            'locale' => 'nullable|string|max:5',
            'meta_title' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
        ];

        // Add unique slug validation
        if ($this->slug) {
            $uniqueRule = 'unique:menu_items,slug';
            if ($this->menuItem) {
                $uniqueRule .= ','.$this->menuItem->id;
            }
            $rules['slug'] = $rules['slug'].'|'.$uniqueRule;
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        try {
            // Validate JSON fields
            $this->validateJsonFields();

            // Auto-generate slug if empty
            if (empty($this->slug) && ! empty($this->name)) {
                $this->slug = \Illuminate\Support\Str::slug($this->name);
            }

            $data = $this->prepareDataForSave();

            if ($this->menuItem) {
                // Update existing menu item
                $this->menuItem->update($data);
                $message = 'Menu Item "'.$this->name.'" updated successfully!';
                $route = 'backend.menuitems.show';
                $params = $this->menuItem->id;

                // Log the update
                logUserAccess('MenuItem Update | Id: '.$this->menuItem->id);
            } else {
                // Create new menu item
                $menuItem = MenuItem::create($data);
                $message = 'Menu Item "'.$this->name.'" created successfully!';
                $route = 'backend.menuitems.show';
                $params = $menuItem->id;

                // Log the creation
                logUserAccess('MenuItem Store | Id: '.$menuItem->id);
            }

            session()->flash('flash_success', $message);

            return redirect()->route($route, $params);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to show field errors
            throw $e;
        } catch (\Exception $e) {
            $this->addError('general', 'Error saving menu item: '.$e->getMessage());
            session()->flash('flash_danger', 'Error saving menu item: '.$e->getMessage());
        }
    }

    protected function validateJsonFields()
    {
        // Validate route_parameters as JSON
        if ($this->route_parameters && ! empty(trim($this->route_parameters))) {
            $decoded = json_decode($this->route_parameters, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('route_parameters', 'Route parameters must be valid JSON.');

                return;
            }
        }

        // Validate html_attributes as JSON
        if ($this->html_attributes && ! empty(trim($this->html_attributes))) {
            $decoded = json_decode($this->html_attributes, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('html_attributes', 'HTML attributes must be valid JSON.');

                return;
            }
        }

        // Validate custom_data as JSON
        if ($this->custom_data && ! empty(trim($this->custom_data))) {
            $decoded = json_decode($this->custom_data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('custom_data', 'Custom data must be valid JSON.');

                return;
            }
        }
    }

    protected function prepareDataForSave()
    {
        return [
            'menu_id' => $this->menu_id,
            'parent_id' => $this->parent_id ?: null,
            'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'sort_order' => $this->sort_order ?: 0,
            'url' => $this->url ?: null,
            'route_name' => $this->route_name ?: null,
            'route_parameters' => $this->route_parameters ?: null,
            'description' => $this->description ?: null,
            'icon' => $this->icon ?: null,
            'badge_text' => $this->badge_text ?: null,
            'badge_color' => $this->badge_color ?: null,
            'opens_new_tab' => (bool) $this->opens_new_tab,
            'css_classes' => $this->css_classes ?: null,
            'html_attributes' => $this->html_attributes ?: null,
            'permissions' => $this->permissions ?: null,
            'roles' => $this->roles ?: null,
            'status' => $this->status,
            'is_active' => (bool) $this->is_active,
            'is_visible' => (bool) $this->is_visible,
            'locale' => $this->locale ?: null,
            'meta_title' => $this->meta_title ?: null,
            'custom_data' => $this->custom_data ?: null,
            'note' => $this->note ?: null,
        ];
    }

    public function generateSlug()
    {
        if ($this->name) {
            $this->slug = \Illuminate\Support\Str::slug($this->name);
        }
    }

    public function updatedName()
    {
        // Auto-generate slug when name changes (only if slug is empty)
        if (empty($this->slug) && ! empty($this->name)) {
            $this->generateSlug();
        }
    }

    public function render()
    {
        return view('menu::livewire.menu-item-component');
    }
}
