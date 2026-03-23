# Bug Report — Code Review (March 23, 2026)

Covers: `laravel-starter` (core), `module-manager`, `laravel-cube`, `laravel-jodit`.

---

## laravel-starter (Core)

### Critical

**BUG 1 ✅ FIXED — `UserController::destroy()` — super-admin / self-delete guard never fires**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** `$id` from the URL is a `string`. The guard uses `===` against `int` literals: `Auth::user()->id === $id || $id === 1` — both comparisons are always `false` in PHP 8. Any admin can delete themselves or the super-admin (user ID 1).
- **Fix:** Use `==` or cast: `(int) $id === 1`.

---

### High

**BUG 2 ✅ FIXED — `UserController::update()` — role-lock on user #1 bypassed**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** Same type mismatch: `if ($id === 1)` is always `false` (string vs int), so user #1's roles are synced from arbitrary form input instead of being locked to `['super admin']`.
- **Fix:** `if ((int) $id === 1)`.

**BUG 3 ✅ FIXED — `SocialLoginController::findOrCreateUser()` — returns `RedirectResponse` then crashes `Auth::login()`**
- **File:** `app/Http/Controllers/Auth/SocialLoginController.php`
- **Issue:** When a social account has no email, the method returns a `RedirectResponse`. The caller immediately passes it to `Auth::login()`, throwing a `TypeError` at runtime. The redirect is also lost.
- **Fix:** Throw an exception inside `findOrCreateUser()` and catch it in `handleProviderCallback()`.

**BUG 4 ✅ FIXED — `UserController::userProviderDestroy()` — undefined variable causes fatal error**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** When the user ID doesn't match the provider's owner, the code fires `event(new UserUpdated($$module_name_singular))` where `$$module_name_singular = $user` is never defined in that method, producing `ErrorException: Undefined variable $user`.
- **Fix:** Remove the `event()` call from that error path.

**BUG 5 ✅ FIXED — `UserController::userProviderDestroy()` — missing authorization check**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** The method name is absent from `Authorizable::$abilities`, so the trait skips its gate check. The method itself has no `can()` check — any authenticated backend user can unlink social providers from any account.
- **Fix:** Add `if (! Auth::user()->can('edit_users')) { abort(403); }` at the top of the method.

**BUG 6 ✅ FIXED — `UserLoginSuccess` event — plain-text password serialized into the job queue**
- **File:** `app/Events/Auth/UserLoginSuccess.php`
- **Issue:** `prepareRequestData()` stores `$request->all()`, which includes the `password` field. This is passed to async queue listeners, writing the plain-text password to the job store (Redis/DB).
- **Fix:** Use `$request->except(['password', 'password_confirmation'])`.

**BUG 7 ✅ FIXED — `UserAccountCreated` notification — plain-text password sent in email**
- **File:** `app/Notifications/UserAccountCreated.php`
- **Issue:** The notification emails `'Password: '.$request['password']` to the user. Passwords must never be transmitted in plaintext (OWASP A02 / CWE-312).
- **Fix:** Remove the password line; provide a password-reset link instead.

**BUG 8 — `BackendBaseController::store()` / `update()` — mass-assign raw `$request->all()`**
- **File:** `app/Http/Controllers/Backend/BackendBaseController.php`
- **Issue:** No validation is performed before `Model::create($request->all())` or `$record->update($request->all())`. Sensitive columns like `created_by`, `status`, and `published_at` can be overwritten by crafted requests. All subclasses that don't override these methods inherit the vulnerability.
- **Fix:** Validate in concrete controllers before delegating to the base.

---

### Medium

**BUG 9 ✅ FIXED — `NotificationsController::show()` — notifications never marked as read**
- **File:** `app/Http/Controllers/Backend/NotificationsController.php`
- **Issue:** `if ($notification->read_at === '')` — `read_at` is `null` when unread (cast to `datetime`), never `''`. The condition is always false; `read_at` is never updated.
- **Fix:** `if ($notification->read_at === null)`.

**BUG 10 ✅ FIXED — `NewRegistrationNotification` / `NewRegistrationNotificationForSocial` — verification email never sent**
- **Files:** `app/Notifications/NewRegistrationNotification.php`, `app/Notifications/NewRegistrationNotificationForSocial.php`
- **Issue:** `if ($user->email_verified_at === '')` — same null vs empty-string issue. New unverified users always receive the generic "thank you" email, never the email-verification link.
- **Fix:** `if ($user->email_verified_at === null)`.

**BUG 11 ✅ FIXED — `Register` Livewire component — verification email never dispatched**
- **File:** `app/Livewire/Auth/Register.php`
- **Issue:** `event(new Registered($user))` is commented out. `App\Events\Frontend\UserRegistered` has no listeners. New registrations never receive a verification email even though `User` implements `MustVerifyEmail`.
- **Fix:** Restore `event(new Registered($user))`.

**BUG 12 ✅ FIXED — `UserController::block()` / `unblock()` — check wrong permission**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** Route middleware gates on `can:block_users`, but the controller body checks `can:delete_users`. A user holding only `block_users` is improperly rejected with 403.
- **Fix:** Change both methods to check `can:block_users`.

**BUG 13 ✅ FIXED — `UserController::userProviderDestroy()` — operator precedence makes validation check wrong**
- **File:** `app/Http/Controllers/Backend/UserController.php`
- **Issue:** `if (! $user_provider_id > 0 || ! $user_id > 0)` parses as `(! $user_provider_id) > 0` because `!` binds tighter than `>`. Negative IDs bypass the guard.
- **Fix:** `if (! ($user_provider_id > 0) || ! ($user_id > 0))`.

---

## module-manager

**BUG 1 ✅ FIXED — `ModuleBuildCommand::enableModule()` — `array_merge(null, ...)` crash on malformed JSON**
- **File:** `src/Commands/ModuleBuildCommand.php`
- **Issue:** `json_decode()` returns `null` on malformed `modules_statuses.json`. `array_merge(null, [...])` throws `TypeError` in PHP 8.
- **Fix:** `$decoded = json_decode($content, true); if (! is_array($decoded)) { $decoded = []; }`.

**BUG 2 ✅ FIXED — `ModuleDetectUpdatesCommand` — `{$module}` never interpolated (single quotes)**
- **File:** `src/Commands/ModuleDetectUpdatesCommand.php`
- **Issue:** The output hint uses single quotes: `'...{$module}...'`. The module name is never substituted; the user sees the literal string `{$module}`.
- **Fix:** Change to double quotes.

**BUG 3 ✅ FIXED — `ModulePublishCommand::updateModuleStatus()` — cache not cleared after publish**
- **File:** `src/Commands/ModulePublishCommand.php`
- **Issue:** Writes to `modules_statuses.json` but never calls `Cache::forget('module_statuses')`. The 1-hour cache retains stale data. (`module:enable`/`module:disable` both clear it correctly.)
- **Fix:** Add `Cache::forget('module_statuses')` after the file write.

**BUG 4 ✅ FIXED — `ModuleRemoveCommand::removeModuleFromStatus()` — cache not cleared after removal**
- **File:** `src/Commands/ModuleRemoveCommand.php`
- **Issue:** Same as BUG 3 above. Deleted modules continue booting for up to 1 hour after removal.
- **Fix:** Add `Cache::forget('module_statuses')` at the end of `removeModuleFromStatus()`.

**BUG 5 ✅ FIXED — `AuthPermissionsCommand` — over-broad `LIKE '%posts'` can delete other modules' permissions**
- **File:** `src/Commands/AuthPermissionsCommand.php`
- **Issue:** The pattern `'%'.$this->getNameArgument()` matches anything ending in the module name (e.g. `view_testposts`), potentially deleting permissions from other modules.
- **Fix:** `Permission::whereIn('name', $this->generatePermissions())->delete()`.

**BUG 6 ✅ FIXED — `ModuleGenerateTestCommand` — always writes generated tests into `vendor/`**
- **File:** `src/Commands/ModuleGenerateTestCommand.php`
- **Issue:** Tests are written to `vendor/nasirkhan/module-manager/src/Modules/{name}/Tests/` which is overwritten by every `composer update`. All generated tests are silently lost.
- **Fix:** Write to `Modules/{name}/Tests/` (the published path) when it exists; fall back to the vendor path otherwise.

**BUG 7 ✅ FIXED — `PostServiceProvider::registerCommands()` (and stub) — `Finder::in()` throws if `Console/` is absent**
- **Files:** `src/Modules/Post/Providers/PostServiceProvider.php`, `src/stubs/Providers/stubServiceProvider.stub.php`
- **Issue:** `Symfony\Component\Finder\Exception\DirectoryNotFoundException` is thrown on every request if any module's `Console/` directory was deleted or never created, preventing the app from booting.
- **Fix:** Add `if (! is_dir($consolePath)) { return; }` before `$finder->files()->in($consolePath)`.

**BUG 8 ✅ FIXED — 4 command files — hardcoded module list ignores dynamic modules**
- **Files:** `ModuleCheckMigrationsCommand.php`, `ModuleDetectUpdatesCommand.php`, `ModuleTrackMigrationsCommand.php`, `ModuleDependenciesCommand.php`
- **Issue:** All four "check-all" commands use `$modules = ['Post', 'Category', 'Tag', 'Menu']`. Every module beyond these four is silently ignored, defeating the purpose of a dynamic module manager.
- **Fix:** Read the actual module list from `modules_statuses.json` at runtime: `$modules = array_keys(json_decode(File::get(base_path('modules_statuses.json')), true) ?? [])`.

**BUG 9 ✅ FIXED — `MigrationTracker::getPendingMigrations()` — returns non-sequential keys**
- **File:** `src/Services/MigrationTracker.php`
- **Issue:** `array_filter()` preserves original array keys. A gap-keyed array serialises with `json_encode()` as a JSON object (`{"0":"a.php","2":"c.php"}`) instead of a JSON array (`["a.php","c.php"]`).
- **Fix:** Wrap with `array_values(array_filter(...))`.

**BUG 10 ✅ FIXED — `ModulePublishCommandTest` — `modules_statuses.json` not restored in `tearDown()`**
- **File:** `tests/Feature/ModulePublishCommandTest.php`
- **Issue:** Tests that write to `modules_statuses.json` don't reset it in `tearDown()`. Stale data pollutes subsequent test runs.
- **Fix:** Add `File::put(base_path('modules_statuses.json'), '{}')` to `tearDown()`.

---

## laravel-cube

**BUG 1 ✅ FIXED — `header-block.blade.php` — `@props` snake_case names never match camelCase PHP properties**
- **File:** `resources/views/components/frontend/header-block.blade.php`
- **Issue:** PHP constructor injects `$subTitle` and `$preTitle`. The template declares `@props(["sub_title" => "", "pre_title" => ""])`. These names never match, so the content is always empty.
- **Fix:** Use `subTitle`/`preTitle` throughout the template.

**BUG 2 ✅ FIXED — `header-block.blade.php` — unconditional `@include("frontend.includes.messages")` throws if view is absent**
- **File:** `resources/views/components/frontend/header-block.blade.php`
- **Fix:** Change to `@includeIf("frontend.includes.messages")`.

**BUG 3 ✅ FIXED — `modal/tailwind.blade.php` — incomplete `$maxWidthClass` map shadows PHP value for `3xl`–`5xl`**
- **File:** `resources/views/components/ui/modal/tailwind.blade.php`
- **Issue:** The local map covers only `sm`–`2xl`. Passing `3xl`, `4xl`, or `5xl` silently falls back to `2xl`, overwriting the correct PHP-computed value.
- **Fix:** Extend the map to include `3xl`, `4xl`, `5xl`, or simply use the PHP-computed `$maxWidthClass` variable.

**BUG 4 ✅ FIXED — `flash-message.blade.php` — `$message["level"]` leaked to user in `else` branch**
- **File:** `resources/views/components/frontend/flash-message.blade.php`
- **Issue:** Unrecognised flash levels print the raw level key visibly on screen (likely a debug leftover).
- **Fix:** Remove `{{ $message["level"] }}` from the `else` branch.

**BUG 5 ✅ FIXED — `flash-message.blade.php` — `{{ session()->forget() }}` used incorrectly; `{!! !!}` bodies are potential XSS**
- **File:** `resources/views/components/frontend/flash-message.blade.php`
- **Issue:** `session()->forget()` returns void; wrapping in `{{ }}` echoes null. Flash message bodies output with `{!! !!}` are an XSS vector if user-controlled content can reach the flash store.
- **Fix:** Replace with `@php session()->forget("flash_notification") @endphp`. Audit flash body sources and use `{{ }}` if content may be user-supplied.

**BUG 6 ✅ FIXED — `validation-errors.blade.php` — Bootstrap-only classes, no Tailwind variant**
- **File:** `resources/views/components/frontend/validation-errors.blade.php`
- **Issue:** Hardcoded `alert alert-danger` (Bootstrap) and Font Awesome 4 icon classes (`fa fa-exclamation-triangle`) are invisible / non-functional in Tailwind projects.
- **Fix:** Add `HasFramework` support and provide a Tailwind `.blade.php` variant.

**BUG 7 ✅ FIXED — `section-show-table.blade.php` — multiple failures**
- **File:** `resources/views/components/backend/section-show-table.blade.php`
- **Issues:**
  1. `$data->getTableColumns()` throws `BadMethodCallException` if the method doesn't exist on the model.
  2. `label_case()` and `show_column_value()` are undefined helpers — `Error: Call to undefined function`.
  3. `<x-library.lightbox />` is not registered anywhere in `CubeServiceProvider` — throws `InvalidArgumentException`.
- **Fixes:** Guard `getTableColumns()` with `method_exists()`; document or stub the helper requirements; guard the lightbox include with `@if(View::exists(...))`.

**BUG 8 ✅ FIXED — `page-wrapper.blade.php` — unconditional `@include` for external views**
- **File:** `resources/views/components/backend/page-wrapper.blade.php`
- **Issue:** `@include("flash::message")` (requires `laracasts/flash`) and `@include("backend.includes.errors")` (host-app view) throw `ViewNotFoundException` if either is absent.
- **Fix:** Use `@includeIf(...)` for both.

**BUG 9 ✅ FIXED — `section-header.blade.php` — route guard checks `.create` but link targets `.trashed`**
- **File:** `resources/views/components/backend/section-header.blade.php`
- **Issue:** `Route::has("backend.$module_name.create")` guards a link to `route("backend.$module_name.trashed")`. If `.trashed` doesn't exist, `route()` throws a `RouteNotFoundException`.
- **Fix:** Change to `Route::has("backend.$module_name.trashed")`.

**BUG 10 ✅ FIXED — `badge/tailwind.blade.php` — `wrap-break-word` is not a valid Tailwind class**
- **File:** `resources/views/components/ui/badge/tailwind.blade.php`
- **Issue:** `wrap-break-word` does not exist in Tailwind v3 or v4.
- **Fix:** Replace with `break-words`.

**BUG 11 ✅ FIXED — `nav-link/tailwind.blade.php` — ignores config-driven `$classes`, hardcodes v3 `focus:outline-none`**
- **File:** `resources/views/components/navigation/nav-link/tailwind.blade.php`
- **Issue:** The template ignores the PHP-computed `$classes` property (populated from config) and hardcodes its own class string using `focus:outline-none` (deprecated in Tailwind v4; config uses `focus:outline-hidden`). Config customisation has no effect.
- **Fix:** Use the PHP-computed `$classes` variable or read from the same config keys.

**BUG 12 ✅ FIXED — `Input::getClasses()` — Tailwind config path has no fallback; returns `null`**
- **File:** `src/View/Components/Forms/Input.php`
- **Issue:** `config('cube.tailwind.forms.input')` has no fallback, returning `null` if the key is absent. This produces malformed HTML (`class=""`). The Bootstrap path correctly provides a fallback.
- **Fix:** Add a fallback: `config('cube.tailwind.forms.input', 'border-gray-300 rounded-md ...')`.

---

## laravel-jodit

**BUG 1 ✅ FIXED — `routes/web.php` — `Route::any()` allows CSRF-unprotected GET mutations** *(Critical Security)*
- **File:** `routes/web.php`
- **Issue:** `Route::any()` accepts GET requests which bypass Laravel's CSRF middleware. An attacker can embed `<img src="/jodit/connector?action=remove&name=file.jpg">` to delete files belonging to a logged-in user.
- **Fix:** Change to `Route::post()`.

**BUG 2 ✅ FIXED — `JoditConnectorController::actionUpload()` — SVG bypass allows stored XSS** *(High Security)*
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** SVG is included in `allowed_mimes` but image sanitization is explicitly skipped for SVG files. An uploaded SVG containing `<script>` or `onload=` executes in the browser when fetched.
- **Fix:** Remove `svg` from `allowed_mimes`, or add SVG-specific sanitization that strips `<script>` tags and event attributes.

**BUG 3 ✅ FIXED — `JoditConnectorController::resolveInstanceConfig()` — `directory` parameter overrides `base_path` with no jail check** *(High Security)*
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** The `directory` request parameter completely replaces `$this->basePath` with any authenticated user-supplied value (as long as it doesn't contain `..`). Users can browse or upload to arbitrary storage directories.
- **Fix:** Validate that the resolved path starts with the configured `base_path` before accepting it.

**BUG 4 ✅ FIXED — `actionRename()` / `actionMove()` — always fail for directories**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** `Storage::exists()` is an alias for `fileExists()` in Flysystem v3, returning `false` for directories. Renaming or moving a folder always returns "File not found". (`actionRemove()` correctly uses `directoryExists()`.)
- **Fix:** Add `|| Storage::disk($this->disk)->directoryExists($oldPath)` to the existence check.

**BUG 5 ✅ FIXED — `actionRename()` / `actionCreate()` / `actionMove()` — failed operations silently report success**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** The return values of `Storage::move()`, `Storage::makeDirectory()`, and `Storage::move()` are ignored. Any permissions failure or name collision reports `success: true` to the client.
- **Fix:** Check the boolean return of each call and return `$this->error(...)` on failure.

**BUG 6 ✅ FIXED — `actionUpload()` — `storeAs()` failure ignored; non-existent file URL returned**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** `$file->storeAs(...)` returns `false` on failure. The code does not check this and adds the calculated (but never-written) path to the response.
- **Fix:** Check the return value: `if ($stored === false) { return $this->error('Failed to store the uploaded file.'); }`.

**BUG 7 ✅ FIXED — `actionResize()` / `actionCrop()` — uncaught exceptions on non-image files**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** Neither method validates that the target is actually an image before calling `Image::read()`. Passing a PDF or ZIP produces an unhandled `DecoderException` (500 response).
- **Fix:** Wrap `Image::read()` in a `try/catch (\Throwable $e)` and return `$this->error('Could not read image file.')`.

**BUG 8 ✅ FIXED — `ensureDirectory()` — uses `exists()` instead of `directoryExists()`**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** `Storage::exists()` returns `false` for existing directories, causing a redundant `makeDirectory()` call on every request. On object-storage drivers this generates an unnecessary API call.
- **Fix:** Replace `exists()` with `directoryExists()`.

**BUG 9 ✅ FIXED — `actionCrop()` — silently uses 100px fallback when `width`/`height` is 0**
- **File:** `src/Http/Controllers/JoditConnectorController.php`
- **Issue:** `$image->crop($width ?: 100, $height ?: 100, ...)` silently crops to an arbitrary 100×100 when either dimension is 0, destroying content without any error.
- **Fix:** Validate that `$width > 0 && $height > 0` and return `$this->error('Width and height are required for crop.')` if not.

---

## Summary

| Package | Critical | High | Medium/Low |
|---|---|---|---|
| laravel-starter | 1 | 5 | 7 |
| module-manager | 0 | 4 | 6 |
| laravel-cube | 0 | 0 | 0 |
| laravel-jodit | 1 | 4 | 4 |
| **Total** | **2** | **17** | **25** |
