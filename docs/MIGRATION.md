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
- [x] Add `tom-select` to `package.json`
- [x] Remove `@coreui/coreui`, `simplebar`, `bootstrap` (kept only via CoreUI) from `package.json`
- [x] Remove `jquery` from `package.json` (replaced by Alpine.js, already present via Livewire)
- [x] Verify `flowbite`, `tailwindcss`, `@tailwindcss/vite` remain
- [x] Run `npm install` and confirm build passes

### Phase 2 — Backend CSS/JS Entry Point
- [x] Create `resources/css/app-backend.css` (Tailwind + Flowbite import, mirroring `app-frontend.css`)
- [x] Delete `resources/sass/app-backend.scss`, `_backend_custom.scss`, `_backend_variables.scss`
- [x] Update `vite.config.js`: replace `resources/sass/app-backend.scss` → `resources/css/app-backend.css`
- [x] Update `resources/js/app-backend.js`: remove CoreUI/jQuery/SimpleBar imports, add Tom Select + Flowbite init
- [x] Confirm `npm run build` produces clean backend bundle

### Phase 3 — New `laravel-admin` Package (Shell)
- [x] Create package skeleton at `laravel-starter-packages/laravel-admin`
- [x] Implement publishable `resources/views/layouts/admin.blade.php` (Flowbite/FluxUI style)
- [x] Implement `resources/views/includes/sidebar.blade.php` — config-driven nav items
- [x] Implement `resources/views/includes/header.blade.php` — breadcrumb, user menu, theme toggle
- [x] Create `config/admin.php` — nav structure, app name, branding
- [x] Register service provider, publish command
- [x] Add as path repository in `laravel-starter` `composer.json`
- [x] Publish and wire layout in `laravel-starter`

### Phase 4 — Backend View Migration (`laravel-starter`)
- [x] `backend/layouts/app.blade.php` — extend `laravel-admin::layouts.admin`
- [x] `backend/includes/header.blade.php` — replaced by package component
- [x] `backend/includes/sidebar.blade.php` — replaced by package component (nav config in `config/admin.php`)
- [x] `backend/includes/errors.blade.php` — Flowbite alert component
- [x] `backend/includes/action_column.blade.php` — Tailwind icon buttons
- [x] `backend/includes/user_actions.blade.php` — Tailwind
- [x] `backend/includes/user_roles.blade.php` — Tailwind badges/checkboxes
- [x] `backend/index.blade.php` — dashboard: stat cards (Flowbite), demo data section
- [x] `backend/users/index.blade.php` — replace with Livewire table component
- [x] `backend/users/index_datatable.blade.php` — deleted (replaced by Livewire table)
- [x] `backend/users/create.blade.php` — Tailwind form with Tom Select for roles
- [x] `backend/users/edit.blade.php` — same as create
- [x] `backend/users/show.blade.php` — Tailwind detail card
- [x] `backend/users/changePassword.blade.php` — Tailwind form
- [x] `backend/users/trash.blade.php` — Tailwind table with restore actions
- [x] `backend/roles/index.blade.php` — Tailwind table with pagination::tailwind
- [x] `backend/roles/create.blade.php` — Tailwind form, permission checkboxes
- [x] `backend/roles/edit.blade.php` — same as create
- [x] `backend/roles/show.blade.php` — Tailwind detail card
- [x] `backend/notifications/index.blade.php` — Tailwind list
- [x] `backend/notifications/show.blade.php` — Tailwind detail

### Phase 5 — Livewire Backend Components (custom `LwTable`, no rappasoft)
> **Note:** `rappasoft/laravel-livewire-tables` is incompatible with Livewire v4 — not used.
> Instead, a thin `LwTable` abstract base class lives in `nasirkhan/laravel-cube`.
- [x] Create `src/Livewire/LwTable.php` in `laravel-cube` — abstract base with search, sort, per-page, pagination (Tailwind theme)
- [x] Create `resources/views/components/lw-table.blade.php` in `laravel-cube` — search bar + per-page selector + loading overlay + pagination footer
- [x] Create `resources/views/components/lw-table-th.blade.php` in `laravel-cube` — sortable `<th>` with active/inactive sort icons
- [x] Register `cube::lw-table` and `cube::lw-table-th` in `CubeServiceProvider`
- [x] Refactor `app/Livewire/Backend/UsersIndex.php` to extend `LwTable`, remove redundant `WithPagination`/`$paginationTheme`/`$searchTerm`
- [x] Migrate `resources/views/livewire/backend/users-index.blade.php` to Tailwind using `<x-cube::lw-table>` and `<x-cube::lw-table-th>`
- [x] Create `app/Livewire/Backend/RolesIndex.php` extending `LwTable`
- [x] Create `resources/views/livewire/backend/roles-index.blade.php`
- [x] Update `resources/views/backend/roles/index.blade.php` to use `<livewire:backend.roles-index />`
- [x] Remove jQuery DataTables files from `public/vendor/datatable/`
- [x] Remove Select2/Selectize from `public/vendor/` (replaced by Tom Select)

### Phase 6 — `laravel-cube` Package Updates
- [x] Add `LwTable` base Livewire component (thin wrapper/config above Rappasoft, or standalone)
- [x] Add `TomSelect` Blade component (`<x-cube::tom-select>`)
- [x] Add shared Tailwind form field components (`<x-cube::input>`, `<x-cube::select>`, `<x-cube::textarea>`)
- [x] Add Flowbite alert/flash component (`<x-cube::alert>`)
- [x] Update `tailwind.config` source paths if needed for new components
- [x] Bump package version

### Phase 7 — Frontend Visual Refresh (`laravel-starter`)
> The frontend already uses Tailwind v4 + Flowbite. This phase is visual polish — not a framework migration. Do not touch PHP logic, routes, or Livewire component classes.

**Layout shell:**
- [x] `resources/views/frontend/layouts/app.blade.php` — add `scroll-smooth` to `<html>`; add `antialiased font-sans text-gray-900 dark:text-white` to `<body>`; add `min-h-screen` to `<main>` so footer stays at bottom on short pages

**Header:**
- [x] `frontend/includes/header.blade.php` — make `<nav>` sticky: replaced static `bg-white shadow-md` with `sticky top-0 z-40 bg-white/90 backdrop-blur-md dark:bg-gray-900/90`
- [x] Add Alpine scroll-aware shadow: `x-data="{ scrolled: false }"` + `window.addEventListener('scroll', ...)` → toggle `shadow-md` only when scrolled past 8px
- [x] Style auth CTAs: Register → filled blue button (`bg-blue-600 text-white hover:bg-blue-700`); Login → outlined (`border border-gray-300 rounded-lg`)
- [x] Add `transition-all duration-200` to the `<nav>` element

**Footer:**
- [x] `frontend/includes/footer.blade.php` — changed bg to `bg-gray-50 dark:bg-gray-900`; added `border-t border-gray-200 dark:border-gray-700`
- [x] Expanded inner container to `max-w-7xl`; adjusted padding to `py-12 sm:py-16 sm:px-8`
- [x] Added copyright bar at the bottom: `© {{ now()->year }} {{ app_name() }}`

**Auth layout — fix two broken things:**
- [x] `resources/views/layouts/auth.blade.php` — replaced `bg-background` (undefined CSS variable) with `bg-gray-50 dark:bg-gray-950`
- [x] Removed `@fluxScripts` (FluxUI remnant) — `partials.head` already loads Vite assets
- [x] Added visible app name text below the logo mark for context

**CSS / design tokens:**
- [x] `resources/css/app-frontend.css` — added smooth dark-mode color transitions and base font stack

**Testing:**
- [ ] Sticky header: scroll down on `/` — confirm blur + shadow appear, disappear on scroll-to-top
- [ ] Auth pages: `/login`, `/register`, `/forgot-password` — confirm no `bg-background` undefined var, no missing FluxUI script
- [ ] Dark mode toggle on frontend persists across `wire:navigate` page transitions
- [ ] Mobile view: hamburger opens/closes, footer copyright visible

### Phase 8 — `module-manager` Scaffold Update
> Stubs live in `src/stubs/` (not `src/Commands/stubs/`). Generator command: `ModuleBuildCommand.php`.
- [x] Locate stub files — found in `src/stubs/Resources/views/backend/stubViews/` and `frontend/stubViews/`
- [x] Update `index.blade.stub.php` — Flowbite table, inline SVG icon buttons (edit/show/delete), Tailwind pagination footer
- [x] Update `form.blade.stub.php` — replaced Bootstrap `.form-control`/`.form-select`/`.form-group` with Tailwind inputs; removed `x-library.select2` (replaced by Tom Select global init); handles `old()` + edit pre-fill
- [x] Update `index_datatable.blade.stub.php` — removed jQuery DataTable + `datatables.min.js/css` assets; replaced with server-side Tailwind table (same pattern as `index.blade.stub.php` but fewer columns); added comment explaining the legacy context
- [x] Update `frontend/stubViews/index.blade.stub.php` — fixed Bootstrap `d-flex justify-content-center w-100` → `flex justify-center`
- [x] Update `routes/web.stub.php` — removed `index_list` and `index_data` DataTable API routes
- [x] No version field in `module-manager/composer.json` — version is managed by git tags; tag a new release after testing
- [x] Remove `yajra/laravel-datatables-oracle` from `module-manager/composer.json` require block (no generated view uses DataTables anymore); run `composer update` in laravel-starter
- [x] Test by generating a sample module: `php artisan module:build TestItem` — verify generated views use Tailwind classes, no Bootstrap remnants, no DataTable assets referenced

### Phase 9 — Cleanup & Final Audit
- [x] Remove `resources/sass/` directory entirely
- [x] Remove unused public vendor assets (`jquery/`, `select2/`, `datatable/`, `selectize/`)
- [x] Search entire codebase for Bootstrap classes (`btn-primary`, `form-control`, `col-md-`, `d-flex`, etc.) — fix any missed
- [x] Search for any remaining `$()` jQuery calls — replace or remove
- [x] Run full build (`npm run build`) — confirm no warnings about missing chunks
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

Context: The frontend already uses Tailwind v4 + Flowbite. This is a visual polish pass, not a
framework migration. Do NOT change any PHP files, route names, Livewire component classes, or
controller logic.

Read these files before making any changes:
- resources/views/frontend/layouts/app.blade.php
- resources/views/frontend/includes/header.blade.php
- resources/views/frontend/includes/footer.blade.php
- resources/views/layouts/auth.blade.php
- resources/css/app-frontend.css


─── 1. LAYOUT SHELL ──────────────────────────────────────────────────────────

File: resources/views/frontend/layouts/app.blade.php

a) On the <html> tag, add the class: scroll-smooth

b) On the <body> tag, add classes: antialiased font-sans text-gray-900 dark:text-white

c) On the <main> tag, add class: min-h-screen
   (keeps the footer anchored to the bottom on short-content pages)


─── 2. HEADER ────────────────────────────────────────────────────────────────

File: resources/views/frontend/includes/header.blade.php

a) Sticky + frosted glass:
   The current <nav> has these classes: "border-b-2 border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900"
   Replace with:
   "sticky top-0 z-40 border-b border-gray-200/60 bg-white/90 backdrop-blur-md transition-all duration-200 dark:border-gray-700/60 dark:bg-gray-900/90"
   (Removes static shadow-md — shadow will be toggled by Alpine on scroll)

b) Scroll-aware shadow:
   Add Alpine attributes to the <nav> element:
     x-data="{ scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 8 })"
     :class="scrolled ? 'shadow-md' : 'shadow-none'"

c) Register button — make it a filled CTA:
   Find the <a> tag that links to route('register'). Change its class from the current
   "inline-flex cursor-pointer items-center justify-center rounded-sm p-2 text-sm font-medium
    text-gray-900 hover:bg-gray-100 sm:px-4 sm:py-2 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white"
   To:
   "inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2
    text-sm font-medium text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500
    dark:hover:bg-blue-600 dark:focus:ring-blue-800"

d) Login button — make it outlined:
   Find the <a> tag that links to route('login'). Change its class to:
   "inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-300
    px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:text-white
    dark:hover:bg-gray-800"


─── 3. FOOTER ────────────────────────────────────────────────────────────────

File: resources/views/frontend/includes/footer.blade.php

a) On the <footer> element, change the class from:
   "bg-gray-100 px-4 py-6 sm:p-20 dark:bg-gray-800"
   To:
   "border-t border-gray-200 bg-gray-50 px-4 py-12 sm:px-8 sm:py-16 dark:border-gray-700 dark:bg-gray-900"

b) On the inner <div>, change from:
   "mx-auto max-w-5xl text-center"
   To:
   "mx-auto max-w-7xl text-center"

c) Add a copyright bar after the last @endif block (after show_credit), before </footer>:

   <div class="mx-auto mt-8 max-w-7xl border-t border-gray-200 pt-6 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
       &copy; {{ now()->year }} {{ app_name() }}. {{ __('All rights reserved.') }}
   </div>


─── 4. CSS / DESIGN TOKENS ──────────────────────────────────────────────────

File: resources/css/app-frontend.css

After the existing "@variant dark" line, append:

/* Base font stack */
html {
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
                 Roboto, 'Helvetica Neue', Arial, sans-serif;
}

/* Smooth dark-mode color transitions (excludes layout properties to avoid janky reflow) */
*, *::before, *::after {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}


─── 5. AUTH LAYOUT — fix two broken things ──────────────────────────────────

File: resources/views/layouts/auth.blade.php

Issue A: `bg-background` is an undefined CSS custom property — will render as transparent/wrong color.
Issue B: `@fluxScripts` is a FluxUI remnant — will fail with "undefined function" or inject a 404 script.

a) On <body>, change:
   class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900"
   To:
   class="min-h-screen bg-white antialiased dark:bg-gray-950"

b) Replace the outer wrapper <div> class — remove "bg-background":
   Change: class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10"
   To:     class="flex min-h-svh flex-col items-center justify-center gap-6 bg-gray-50 p-6 dark:bg-gray-950 md:p-10"

c) Remove @fluxScripts entirely.
   Check if resources/views/partials/head.blade.php already loads Vite assets — if YES, nothing more needed.
   If NO, add @vite(['resources/css/app-frontend.css', 'resources/js/app-frontend.js']) just before </body>.

d) After the existing <span class="sr-only"> app name, add a visible brand label:
   <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>


─── 6. VERIFY ────────────────────────────────────────────────────────────────

1. Run: npm run build — confirm no errors.

2. Open browser and check each page listed below. Look specifically for:

   / (frontend home)
   - Header is sticky — stays at top as you scroll down
   - Shadow appears once scrolled ~8px, disappears at top
   - Frosted glass effect visible when header overlaps content
   - Register button is blue/filled, Login button is outlined
   - Footer has border-top and copyright year

   /login and /register
   - Auth card renders on a gray-50/gray-950 background (no blinding white flash on dark mode)
   - No JavaScript 404 errors in browser console (confirms @fluxScripts is removed)
   - App name visible below logo mark

   Dark mode (toggle it on/off)
   - Color transitions are smooth (150ms), not jarring/instant
   - Header background shifts cleanly between light and dark variants
   - Footer transitions to dark:bg-gray-900

   Mobile (resize browser to ~375px)
   - Hamburger opens nav drawer
   - Register/Login buttons stack cleanly
   - Footer copyright bar readable

3. Open DevTools → Console: confirm zero "undefined CSS variable" warnings.
4. Open DevTools → Network: confirm no 404 for any FluxUI script.

Do not change any Livewire PHP components, route files, or controller files.
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
