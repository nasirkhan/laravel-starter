# UI Migration: Bootstrap/CoreUI → Tailwind CSS + Flowbite

**Goal:** Replace the backend CoreUI/Bootstrap stack with Tailwind v4 + Flowbite. Improve the frontend visual layout. Extract reusable UI into packages. Keep `laravel-starter` as a clean app skeleton.

**Backend target aesthetic:** [FluxUI](https://fluxui.dev) — clean sidebar, breadcrumbs, card-based content, generous whitespace.
**Frontend target aesthetic:** Modern Flowbite-based layout with improved typography, spacing, and components.

**Do not change:** route structure, controllers, Livewire component logic, or database layer.

---

## Packages Involved

| Package | Role in Migration |
|---|---|
| `laravel-starter` | App core — views, routes, config |
| `nasirkhan/laravel-cube` | Add: Livewire table base, Tom Select blade component, shared Tailwind CSS primitives |
| `nasirkhan/module-manager` | Update: scaffold stubs to generate Tailwind/Flowbite views instead of Bootstrap |
| `nasirkhan/laravel-admin` *(new)* | Backend shell: Tailwind/Flowbite layout, sidebar, header, config-driven nav |

---

## Checklist

### Phase 0 — Preparation
- [ ] Read and understand current `vite.config.js`, `package.json`, `tailwind.config.ts`
- [ ] Audit all `public/vendor/` dependencies (datatable, select2, jquery, selectize) — confirm none needed after migration
- [ ] Confirm `rappasoft/laravel-livewire-tables` v3 supports Livewire v4 (check GitHub releases)
- [ ] Review Flowbite admin layout examples at flowbite.com/blocks/marketing/header and sidebar
- [ ] Review FluxUI layout structure at fluxui.dev

### Phase 1 — npm Dependency Swap
- [ ] Add `tom-select` to `package.json`
- [ ] Remove `@coreui/coreui`, `simplebar`, `bootstrap` (kept only via CoreUI) from `package.json`
- [ ] Remove `jquery` from `package.json` (replaced by Alpine.js, already present via Livewire)
- [ ] Verify `flowbite`, `tailwindcss`, `@tailwindcss/vite` remain
- [ ] Run `npm install` and confirm build passes

### Phase 2 — Backend CSS/JS Entry Point
- [ ] Create `resources/css/app-backend.css` (Tailwind + Flowbite import, mirroring `app-frontend.css`)
- [ ] Delete `resources/sass/app-backend.scss`, `_backend_custom.scss`, `_backend_variables.scss`
- [ ] Update `vite.config.js`: replace `resources/sass/app-backend.scss` → `resources/css/app-backend.css`
- [ ] Update `resources/js/app-backend.js`: remove CoreUI/jQuery/SimpleBar imports, add Tom Select + Flowbite init
- [ ] Confirm `npm run build` produces clean backend bundle

### Phase 3 — New `laravel-admin` Package (Shell)
- [ ] Create package skeleton at `laravel-starter-packages/laravel-admin`
- [ ] Implement publishable `resources/views/layouts/admin.blade.php` (Flowbite/FluxUI style)
- [ ] Implement `resources/views/includes/sidebar.blade.php` — config-driven nav items
- [ ] Implement `resources/views/includes/header.blade.php` — breadcrumb, user menu, theme toggle
- [ ] Create `config/admin.php` — nav structure, app name, branding
- [ ] Register service provider, publish command
- [ ] Add as path repository in `laravel-starter` `composer.json`
- [ ] Publish and wire layout in `laravel-starter`

### Phase 4 — Backend View Migration (`laravel-starter`)
- [ ] `backend/layouts/app.blade.php` — extend `laravel-admin::layouts.admin`
- [ ] `backend/includes/header.blade.php` — replaced by package component
- [ ] `backend/includes/sidebar.blade.php` — replaced by package component (nav config in `config/admin.php`)
- [ ] `backend/includes/errors.blade.php` — Flowbite alert component
- [ ] `backend/includes/action_column.blade.php` — Tailwind icon buttons
- [ ] `backend/includes/user_actions.blade.php` — Tailwind
- [ ] `backend/includes/user_roles.blade.php` — Tailwind badges/checkboxes
- [ ] `backend/index.blade.php` — dashboard: stat cards (Flowbite), demo data section
- [ ] `backend/users/index.blade.php` — replace with Livewire table component
- [ ] `backend/users/index_datatable.blade.php` — delete (replaced by Livewire table)
- [ ] `backend/users/create.blade.php` — Tailwind form with Tom Select for roles
- [ ] `backend/users/edit.blade.php` — same as create
- [ ] `backend/users/show.blade.php` — Tailwind detail card
- [ ] `backend/users/changePassword.blade.php` — Tailwind form
- [ ] `backend/users/trash.blade.php` — Tailwind table with restore actions
- [ ] `backend/roles/index.blade.php` — Livewire table or simple Tailwind table
- [ ] `backend/roles/create.blade.php` — Tailwind form, permission checkboxes
- [ ] `backend/roles/edit.blade.php` — same as create
- [ ] `backend/roles/show.blade.php` — Tailwind detail card
- [ ] `backend/notifications/index.blade.php` — Tailwind list
- [ ] `backend/notifications/show.blade.php` — Tailwind detail

### Phase 5 — Livewire Backend Components
- [ ] Install `rappasoft/laravel-livewire-tables` via Composer
- [ ] Refactor `app/Livewire/Backend/UsersIndex.php` to extend Rappasoft `DataTableComponent`
- [ ] Update `resources/views/livewire/backend/users-index.blade.php` accordingly
- [ ] Create `app/Livewire/Backend/RolesIndex.php` using same pattern
- [ ] Update `config/livewire.php` pagination theme from `bootstrap` → `tailwind`
- [ ] Remove jQuery DataTables files from `public/vendor/datatable/`
- [ ] Remove Select2/Selectize from `public/vendor/` (replaced by Tom Select)

### Phase 6 — `laravel-cube` Package Updates
- [ ] Add `LwTable` base Livewire component (thin wrapper/config above Rappasoft, or standalone)
- [ ] Add `TomSelect` Blade component (`<x-cube::tom-select>`)
- [ ] Add shared Tailwind form field components (`<x-cube::input>`, `<x-cube::select>`, `<x-cube::textarea>`)
- [ ] Add Flowbite alert/flash component (`<x-cube::alert>`)
- [ ] Update `tailwind.config` source paths if needed for new components
- [ ] Bump package version

### Phase 7 — Frontend Visual Refresh (`laravel-starter`)
- [ ] Audit `resources/views/frontend/layouts/app.blade.php` — header, footer structure
- [ ] Redesign `frontend/includes/header.blade.php` — sticky nav, mobile hamburger (Flowbite navbar), dark mode toggle
- [ ] Redesign `frontend/includes/footer.blade.php` — modern multi-column or minimal footer
- [ ] Update `resources/css/app-frontend.css` — add typography scale, spacing tokens if needed
- [ ] Review and update auth Livewire views (`login`, `register`, `forgot-password`, etc.) — centered card layout, Flowbite form inputs
- [ ] Update `frontend/includes/messages.blade.php` — Flowbite toast or inline alert
- [ ] Test dark mode across all frontend pages

### Phase 8 — `module-manager` Scaffold Update
- [ ] Locate stub files inside `module-manager` package (typically `src/Commands/stubs/`)
- [ ] Update `index.blade.php.stub` — Tailwind table, use `<x-cube::lw-table>` or Rappasoft
- [ ] Update `create.blade.php.stub` — Tailwind form, `<x-cube::input>`, `<x-cube::select>`
- [ ] Update `edit.blade.php.stub` — same as create
- [ ] Update `show.blade.php.stub` — Tailwind detail card
- [ ] Update `action_column.blade.php.stub` — Tailwind icon buttons
- [ ] Update generated controller stub if it references DataTables routes — remove, use Livewire component
- [ ] Bump package version, test by generating a sample module

### Phase 9 — Cleanup & Final Audit
- [ ] Remove `resources/sass/` directory entirely
- [ ] Remove unused public vendor assets (`jquery/`, `select2/`, `datatable/`, `selectize/`)
- [ ] Search entire codebase for Bootstrap classes (`btn-primary`, `form-control`, `col-md-`, `d-flex`, etc.) — fix any missed
- [ ] Search for any remaining `$()` jQuery calls — replace or remove
- [ ] Run full build (`npm run build`) — confirm no warnings about missing chunks
- [ ] Test all backend routes manually: users CRUD, roles CRUD, notifications, dashboard
- [ ] Test all frontend routes: home, auth flows, profile, social login
- [ ] Test dark mode on both backend and frontend
- [ ] Test mobile responsiveness on both

---

## Ordered Execution Prompts

Each prompt below is self-contained. Execute them in order. Do not skip ahead — later prompts depend on earlier ones being complete.

---

### PROMPT 1 — Audit & Dependency Preparation

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

1. Read package.json and vite.config.js.
2. Update package.json:
   - ADD to devDependencies: "tom-select": "^2.4.3"
   - REMOVE: "@coreui/coreui", "simplebar", "bootstrap", "jquery"
   - KEEP: "flowbite", "tailwindcss", "@tailwindcss/vite", "sass" (sass can be removed too since we drop SCSS)
3. Run: npm install
4. Confirm the build still passes with: npm run build
5. Report any peer dependency warnings.

Do not change any blade files or PHP files yet.
```

---

### PROMPT 2 — Backend CSS/JS Entry Point

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

1. Create resources/css/app-backend.css with this content:
   @import "tailwindcss";
   @import "flowbite/src/themes/default";
   @source "../../resources/views/backend";
   @source "../../node_modules/flowbite";
   @plugin "flowbite/plugin";

2. Rewrite resources/js/app-backend.js to:
   - Remove all CoreUI, jQuery, SimpleBar imports
   - Import Flowbite: import 'flowbite';
   - Import Tom Select CSS: import 'tom-select/dist/css/tom-select.css';
   - Import Tom Select: import TomSelect from 'tom-select';
   - Add Flowbite dark mode init (same pattern as app-frontend.js)
   - Export TomSelect on window for use in blade templates: window.TomSelect = TomSelect;

3. Update vite.config.js input array:
   - Replace 'resources/sass/app-backend.scss' with 'resources/css/app-backend.css'

4. Delete:
   - resources/sass/app-backend.scss
   - resources/sass/_backend_custom.scss
   - resources/sass/_backend_variables.scss

5. Run npm run build and confirm both app-backend and app-frontend bundles build cleanly.
```

---

### PROMPT 3 — Create `laravel-admin` Package Skeleton

```
Create a new Laravel package at c:\Users\Nasir Khan\Herd\laravel-starter-packages\laravel-admin

Package identity: nasirkhan/laravel-admin

Structure to create:
  src/
    AdminServiceProvider.php
  resources/
    views/
      layouts/
        admin.blade.php       (main backend shell)
      includes/
        sidebar.blade.php
        header.blade.php
        breadcrumb.blade.php
  config/
    admin.php                 (nav items, branding, theme settings)
  composer.json

Requirements for each file:

composer.json:
- name: nasirkhan/laravel-admin
- require: php ^8.2, illuminate/support ^11|^12
- autoload PSR-4: "Nasirkhan\\Admin\\" → "src/"
- extra.laravel: providers array with AdminServiceProvider

AdminServiceProvider.php:
- Loads config from config/admin.php
- Registers publishable views (tag: admin-views)
- Registers publishable config (tag: admin-config)

config/admin.php:
- 'name' => env('APP_NAME', 'Admin')
- 'logo' => null  (path to logo image)
- 'nav' => []     (array of nav items, each: label, route, icon, children[])
- 'theme' => 'light'   ('light' | 'dark' | 'system')

admin.blade.php (the shell layout):
- Clean FluxUI-style structure: fixed sidebar left, main content right
- Sidebar: logo/brand at top, nav items from config('admin.nav'), user avatar/name at bottom
- Header: page title slot, breadcrumb slot, action slot (right side)
- Main: scrollable content area with padding
- Use Flowbite sidebar component pattern (data-sidebar, data-drawer-target)
- Dark mode: class-based (same as Flowbite frontend pattern)
- Slots: @yield('title'), @yield('breadcrumb'), @yield('content'), @stack('scripts'), @stack('styles')
- Load backend CSS/JS via @vite(['resources/css/app-backend.css', 'resources/js/app-backend.js'])
- Include @livewireStyles and @livewireScripts

sidebar.blade.php:
- Renders config('admin.nav') recursively
- Active state detection via request()->routeIs()
- Icons: use Flowbite SVG icon slots or heroicons inline SVG

header.blade.php:
- Mobile hamburger toggle (triggers Flowbite sidebar)
- Page title
- Dark mode toggle button
- User dropdown (name, avatar, profile link, logout)

After creating all files, add the package as a path repository in laravel-starter's composer.json and run:
  composer require nasirkhan/laravel-admin:@dev
```

---

### PROMPT 4 — Wire `laravel-admin` into `laravel-starter`

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

1. Read the current resources/views/backend/layouts/app.blade.php to understand what it provides.

2. Replace resources/views/backend/layouts/app.blade.php with a version that:
   - Extends the published admin layout: @extends('admin::layouts.admin')
   - Passes the correct @section('title') and @section('content') blocks
   - Removes all inline CoreUI/Bootstrap HTML structure

3. Populate config/admin.php (publish it first if not done) with the current nav items from
   resources/views/backend/includes/sidebar.blade.php:
   - Dashboard → route('backend.dashboard'), icon: home
   - Users → route('backend.users.index'), icon: users
   - Roles → route('backend.roles.index'), icon: shield
   - Notifications → route('backend.notifications.index'), icon: bell

4. Delete resources/views/backend/includes/sidebar.blade.php (now handled by package).
   Delete resources/views/backend/includes/header.blade.php (now handled by package).

5. Update resources/views/backend/layouts/app.blade.php to use @stack('scripts') and
   @stack('styles') instead of the old @push patterns if they differ.

6. Load the app in the browser (php artisan serve) and verify the backend shell renders —
   sidebar visible, header visible, content area shows (even if styles are unstyled for now).
```

---

### PROMPT 5 — Migrate Backend Views (Users & Roles)

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

Read these files first to understand their current structure:
- resources/views/backend/users/index.blade.php
- resources/views/backend/users/create.blade.php
- resources/views/backend/users/edit.blade.php
- resources/views/backend/users/show.blade.php
- resources/views/backend/users/changePassword.blade.php
- resources/views/backend/users/trash.blade.php
- resources/views/backend/roles/index.blade.php
- resources/views/backend/roles/create.blade.php
- resources/views/backend/roles/edit.blade.php
- resources/views/backend/roles/show.blade.php

Rewrite each file replacing Bootstrap/CoreUI classes with Tailwind/Flowbite equivalents:

Bootstrap → Tailwind mapping to apply:
- .container → max-w-7xl mx-auto px-4
- .card → bg-white dark:bg-gray-800 rounded-lg shadow p-6
- .card-header → border-b border-gray-200 dark:border-gray-700 pb-4 mb-4
- .form-control / .form-select → Flowbite input class: block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white
- .btn.btn-primary → inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
- .btn.btn-secondary → (gray variant)
- .btn.btn-danger → (red variant)
- .table → Flowbite table pattern (w-full text-sm text-left text-gray-500 dark:text-gray-400)
- .badge → inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
- .alert-success / .alert-danger → Flowbite alert component
- d-flex, flex-between → flex, justify-between
- mb-3, mt-3 → mb-3, mt-3 (same in Tailwind)

For forms that use Select2 for role/permission selection, replace with:
  <select id="roles" name="roles[]" multiple data-tom-select>...</select>
  And in @push('scripts'): new TomSelect('#roles', { plugins: ['remove_button'] });

Delete: resources/views/backend/users/index_datatable.blade.php (no longer used)

After rewriting, verify no Bootstrap class names remain by searching each file for: btn-, form-control, form-select, card, col-md-, col-lg-, d-flex, mb-, mt- with Bootstrap context.
```

---

### PROMPT 6 — Migrate Backend Views (Shared Includes, Dashboard, Notifications)

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

Read and rewrite these files with Tailwind/Flowbite, using the same mapping from PROMPT 5:

1. resources/views/backend/includes/errors.blade.php
   → Flowbite dismissible alert: red background, list of validation error messages

2. resources/views/backend/includes/action_column.blade.php
   → Icon-only buttons (view/edit/delete) using Tailwind. Use SVG heroicons inline or
     Flowbite icon buttons. Keep the same @can() permission checks.

3. resources/views/backend/includes/user_actions.blade.php
   → Same pattern as action_column but for user-specific actions

4. resources/views/backend/includes/user_roles.blade.php
   → Tailwind checkbox group or badge list for displaying user roles

5. resources/views/backend/index.blade.php (Dashboard)
   → Flowbite stat cards at the top (total users, roles, notifications counts)
   → Keep the dashboard_demo_data include if present
   → Clean card grid layout: grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4

6. resources/views/backend/notifications/index.blade.php
   → Tailwind list with read/unread state styling
   → Flowbite badge for unread count

7. resources/views/backend/notifications/show.blade.php
   → Tailwind detail card

8. resources/views/backend/includes/show.blade.php (generic show partial if used)
   → Tailwind definition list or key-value card layout
```

---

### PROMPT 7 — Livewire Backend: Migrate UsersIndex to Rappasoft

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

1. Run: composer require rappasoft/laravel-livewire-tables
2. Publish config: php artisan vendor:publish --tag=livewire-tables-config

3. Read app/Livewire/Backend/UsersIndex.php to understand current search/pagination logic.

4. Rewrite app/Livewire/Backend/UsersIndex.php to extend:
   Rappasoft\LaravelLivewireTables\DataTableComponent
   
   Implement:
   - public Model $model = User::class;
   - configure(): set component options (pagination, per-page options)
   - columns(): define Name, Email, Role(s), Status, Created At, Actions columns
   - query(): return User::with('roles') base query
   - Actions column: view, edit, delete links/buttons using Tailwind

5. Delete resources/views/livewire/backend/users-index.blade.php
   (Rappasoft generates its own view — or publish and customize if needed)

6. Update config/livewire.php: change pagination_theme from 'bootstrap' to 'tailwind'

7. Create app/Livewire/Backend/RolesIndex.php using the same pattern for Role model.
   Columns: Name, Guard, Permissions count, Actions.

8. Update resources/views/backend/users/index.blade.php to use:
   <livewire:backend.users-index />
   (remove the old table HTML)

9. Update resources/views/backend/roles/index.blade.php similarly.

10. Test: browse /admin/users and /admin/roles — tables should render with search and pagination.
```

---

### PROMPT 8 — Frontend Visual Refresh

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

Read these files first:
- resources/views/frontend/layouts/app.blade.php
- resources/views/frontend/includes/header.blade.php
- resources/views/frontend/includes/footer.blade.php
- resources/views/frontend/includes/messages.blade.php
- resources/views/livewire/auth/login.blade.php
- resources/views/livewire/auth/register.blade.php

Then apply these improvements:

HEADER (resources/views/frontend/includes/header.blade.php):
- Use Flowbite navbar component: sticky top, transparent on scroll → white on scroll (JS class toggle)
- Logo left, nav links center/right, auth buttons right
- Mobile: hamburger menu with slide-down drawer (Flowbite collapse)
- Dark mode toggle button with sun/moon icon
- Active link state using request()->routeIs()

FOOTER (resources/views/frontend/includes/footer.blade.php):
- Modern minimal footer: brand + tagline left, nav links right
- Bottom bar: copyright, links
- Dark mode aware (dark:bg-gray-900 dark:text-gray-400)

MESSAGES (resources/views/frontend/includes/messages.blade.php):
- Replace any Bootstrap alerts with Flowbite dismissible alerts
- Support: success (green), error (red), warning (yellow), info (blue)
- Auto-dismiss after 4 seconds via Alpine: x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"

AUTH VIEWS — apply to login, register, forgot-password, reset-password, verify-email:
- Centered full-height layout: min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900
- Card: bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-md
- Flowbite form inputs with labels and error states
- Submit button: full-width, blue, loading state with wire:loading

LAYOUT (resources/views/frontend/layouts/app.blade.php):
- Ensure font is set (Inter or system-ui via Tailwind)
- Add scroll-smooth to html tag
- Confirm dark mode class on <html> is set correctly by the Flowbite JS already in app-frontend.js

Do not change route names, Livewire component PHP files, or any controller logic.
```

---

### PROMPT 9 — `laravel-cube` Package Updates

```
In the laravel-cube package at c:\Users\Nasir Khan\Herd\laravel-starter-packages\laravel-cube:

Read the existing package structure to understand current components.

Add the following Blade components (publishable via tag: cube-views):

1. resources/views/components/input.blade.php
   Props: name, label, type='text', value='', placeholder='', required=false, error=null
   Renders: label + Flowbite-styled input + error message if $error

2. resources/views/components/select.blade.php
   Props: name, label, options=[], selected=null, placeholder='Select...', multiple=false, tom-select=false
   Renders: label + <select> + if $tomSelect adds data-tom-select attribute
   Note: Tom Select init is handled globally in app-backend.js by querying [data-tom-select]

3. resources/views/components/textarea.blade.php
   Props: name, label, value='', rows=4, required=false, error=null
   Renders: label + Flowbite textarea + error

4. resources/views/components/alert.blade.php
   Props: type='info', dismissible=true, message
   Types: success, error, warning, info → map to Flowbite alert color variants
   Dismissible: x-data="{ show: true }" x-show="show" with close button

5. Add TomSelect auto-init to the package's JS utilities (if laravel-cube has a JS entry point)
   OR document in README that app-backend.js must init TomSelect on [data-tom-select] elements.

Bump the package version in composer.json.
Update laravel-starter's composer.json to use the new version (or @dev path).
Run: composer update nasirkhan/laravel-cube in laravel-starter.
```

---

### PROMPT 10 — `module-manager` Scaffold Stub Updates

```
In the module-manager package at c:\Users\Nasir Khan\Herd\laravel-starter-packages\module-manager:

1. Find all stub files (look in src/Commands/stubs/ or similar).
   List every .stub file found.

2. For each blade view stub, replace Bootstrap with Tailwind/Flowbite:

index.blade.php.stub:
- @extends('admin::layouts.admin') or the backend layout
- Use <livewire::{module-slug}-index /> instead of a static table
- Or render a Flowbite table with simple foreach if no Livewire component is generated

create.blade.php.stub and edit.blade.php.stub:
- Flowbite form layout
- Use <x-cube::input>, <x-cube::select>, <x-cube::textarea> for fields
- Submit button: Tailwind blue button
- Cancel link back to index

show.blade.php.stub:
- Flowbite card with definition list for each field
- Back button + edit button in header

action_column.blade.php.stub:
- Three icon buttons: view (eye), edit (pencil), delete (trash)
- Delete uses a Flowbite modal confirmation or a simple onclick confirm()
- Tailwind styling, @can() guards unchanged

3. If there is a Livewire component stub (for generated index components), update it to
   extend Rappasoft DataTableComponent instead of using WithPagination manually.

4. Update the generator command PHP file if it references 'bootstrap' pagination theme —
   change to 'tailwind'.

5. Test by generating a sample module in laravel-starter:
   php artisan module:make TestModule
   Then check generated views for correct Tailwind classes.

Bump the package version.
```

---

### PROMPT 11 — Cleanup & Final Audit

```
In the laravel-starter project at c:\Users\Nasir Khan\Herd\laravel-starter:

1. Delete these directories/files if they still exist:
   - resources/sass/ (entire directory)
   - public/vendor/datatable/
   - public/vendor/select2/
   - public/vendor/jquery/
   - public/vendor/selectize/

2. Search the entire resources/views/ directory for any remaining Bootstrap class usage:
   Search patterns: "btn-primary", "btn-secondary", "btn-danger", "btn-warning",
   "form-control", "form-select", "form-group", "card-header", "col-md-", "col-lg-",
   "col-sm-", "d-flex", "d-none", "d-block", "alert-success", "alert-danger",
   "text-muted", "badge badge-", "table-striped"
   Fix any remaining occurrences.

3. Search for jQuery usage: grep for "$(", "jQuery(", "$.ajax" in resources/js/ and
   resources/views/ — replace or remove.

4. Run: npm run build
   Confirm output shows only:
   - app-backend-*.css (Tailwind/Flowbite based, no Bootstrap)
   - app-backend-*.js (no CoreUI/jQuery chunks)
   - app-frontend-*.css
   - app-frontend-*.js
   Confirm NO chunks named: coreui, simplebar, bootstrap, jquery

5. Manual test checklist:
   - /admin — dashboard with stat cards
   - /admin/users — Livewire table with search and pagination
   - /admin/users/create — form with Tom Select for roles
   - /admin/roles — table
   - /admin/roles/create — form with permission checkboxes
   - /admin/notifications — list
   - Dark mode toggle on backend (persists on refresh)
   - / (frontend home) — header, footer, dark mode
   - /login, /register — centered card layout
   - Mobile view on all above

6. Run: php artisan pint
   Run: npm run build (final clean build)

7. Commit all changes with message:
   "refactor: migrate backend to Tailwind/Flowbite, improve frontend layout"
```

---

## Reference Links

- Flowbite admin sidebar: https://flowbite.com/docs/components/sidebar/
- Flowbite navbar: https://flowbite.com/docs/components/navbar/
- Flowbite tables: https://flowbite.com/docs/components/tables/
- Flowbite forms: https://flowbite.com/docs/components/forms/
- FluxUI layout reference: https://fluxui.dev
- Rappasoft Livewire Tables: https://github.com/rappasoft/laravel-livewire-tables
- Tom Select docs: https://tom-select.js.org/
- Tailwind v4 docs: https://tailwindcss.com/docs
