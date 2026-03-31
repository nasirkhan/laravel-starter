# Bug Report

> Generated: March 31, 2026

---

## laravel-starter (Core)

### 🔴 Critical

| # | File | Line | Issue |
|---|------|------|-------|
| 1 | `app/Http/Controllers/SocialLoginController.php` | ~135 | `new UserRegistered(request(), $user)` — passes `Request` as first arg; constructor only accepts `User`. Causes a **TypeError** on every social registration. |
| 2 | `app/Http/Controllers/UserController.php` | ~518 | `$user->name` accessed *before* `$user` is assigned (it's assigned a few lines later). Fatal error in PHP 8. |
| 3 | `app/Http/Controllers/UserController.php` | ~261, 274 | `$request->confirmed === 1` and `$request->email_credentials === 1` use strict comparison against a string. Always `false`. Email verification timestamp and credentials notification are never triggered. |

### 🟠 High (Security / Authorization)

| # | File | Line | Issue |
|---|------|------|-------|
| 4 | `app/Http/Controllers/UserController.php` | ~522 | Non-admin `destroy()` guard replaces `$id` with the attacker's own ID instead of aborting. End result: they delete themselves. Should be `abort(403)`. |
| 5 | `app/Http/Controllers/SocialLoginController.php` | ~24 | `redirectTo()` returns an unvalidated user-supplied URL — open redirect vulnerability. |
| 6 | `app/Http/Controllers/LanguageController.php` | ~10 | `$language` parameter accepted with no whitelist check. Arbitrary locale strings are stored in session and passed to `setlocale()`. |
| 7 | `app/Http/Controllers/RolesController.php` | ~258 | Loads all users + N role queries to count one role's members. Should be `User::role($role_name)->count()`. |

### 🟡 Medium (Null-safety / Logic)

| # | File | Line | Issue |
|---|------|------|-------|
| 8 | `app/Http/Controllers/UserController.php` | ~612 | `find()` result not null-checked before `->restore()`. Use `findOrFail()`. |
| 9 | `app/Http/Controllers/UserController.php` | ~654, 698 | Same `find()` without null check in `block()` and `unblock()`. |
| 10 | `app/Http/Controllers/RolesController.php` | ~290 | No `return` statement when `delete()` returns false — controller falls off end returning `null`. |
| 11 | `app/Observers/UserObserver.php` | ~26 | `$user->save()` inside `deleting()` fires the `saving` observer again, issuing a redundant `UPDATE` on a row about to be deleted. Use `User::withoutEvents()`. |
| 12 | `app/Http/Controllers/UserController.php` | ~450, 505 | Flash messages read `"'User' Updated"` — missing opening quote, output is `User' Updated Successfully`. |
| 13 | `app/Http/Controllers/UserController.php` | ~592 | `$request_data['password'] = $request_data['password']` — dead self-assignment. |
| 14 | `app/Http/Controllers/NotificationsController.php` | ~36 | `$this->module_model` set to `App\Models\User` instead of a Notification model. |

### 🔵 Low / Compatibility

| # | File | Line | Issue |
|---|------|------|-------|
| 15 | `app/Models/Notification.php` | ~29 | `SHOW COLUMNS FROM` is MySQL-only. Breaks on PostgreSQL/SQLite. |
| 16 | `app/Models/BaseModel.php` | ~84 | Backtick aliases in PostgreSQL branch (`` `Field` ``, `` `Type` ``) are MySQL syntax — invalid in PostgreSQL. |
| 17 | `app/Console/Commands/AppHealthCheckCommand.php` | ~59 | Direct `env()` call in a command — bypasses config cache. |

---

## module-manager

| # | File | Severity | Issue |
|---|------|----------|-------|
| 18 | `src/ModuleManager.php` | 🔴 Critical | The class body is empty. All facade calls (`ModuleManager::anything()`) throw `BadMethodCallException`. |
| 19 | `src/Commands/AuthPermissionsCommand.php` | 🔴 Critical | Hard-codes `use App\Models\Permission` — fatal `Class not found` if the app uses a different permission model. |
| 20 | `src/Commands/InsertDemoDataCommand.php` | 🔴 Critical | Hard-coded `use Modules\Comment\Models\Comment` causes fatal error if the Comment module is absent. |
| 21 | `src/Commands/InsertDemoDataCommand.php` | 🟠 High | `Auth::loginUsingId(1)` on an empty database silently returns null auth — breaks all subsequent seeding that relies on `Auth::user()`. |
| 22 | 4 command files | 🟠 High | `File::get('modules_statuses.json')` called without `File::exists()` guard. Crashes with unhandled `FileNotFoundException`. Affects: `ModuleCheckMigrationsCommand`, `ModuleDetectUpdatesCommand`, `ModuleDependenciesCommand`, `ModuleTrackMigrationsCommand`. |
| 23 | `src/Commands/ModulePublishCommand.php` | 🟡 Medium | `symfony/finder` used via inline FQCN but not in `require` — `Class not found` in non-dev installs. |
| 24 | Multiple commands | 🟡 Medium | `handle()` returns `null` instead of `self::SUCCESS` / `self::FAILURE`. `assertExitCode()` in tests is unreliable. |

---

## laravel-cube

| # | File | Severity | Issue |
|---|------|----------|-------|
| 25 | `src/View/Components/Ui/Button.php` | 🟡 Medium | `$size` property is completely ignored in Tailwind mode — all sizes render identically. |
| 26 | `src/View/Components/Ui/Button.php` | 🟡 Medium | Only 3 of 9 variants defined in Tailwind config. `success`, `warning`, `info`, `light`, `dark`, `link` silently fall back to `primary`. |
| 27 | `src/View/Components/RendersWithFallback.php` | 🟡 Medium | Error boundary catches exceptions and calls `view('cube::components.error-boundary')` — if *that* view is missing it throws an uncaught exception, defeating the error boundary. |
| 28 | `src/View/Components/Navigation/NavLink.php` | 🔵 Low | `config('cube.tailwind.navigation.link')` can be `null` after publishing; `null . ' '` is a deprecation warning in PHP 8 producing malformed class strings. |

---

## laravel-jodit

| # | File | Severity | Issue |
|---|------|----------|-------|
| 29 | `routes/web.php` | 🔴 Critical | Route registered as `POST` only. Jodit file browser sends `GET` requests → `405 Method Not Allowed`. Must be `Route::any()`. |
| 30 | `src/Http/Controllers/JoditConnectorController.php` | 🔴 Critical | URL generation hardcodes `/storage/` prefix. Any non-`public` disk (S3, R2, etc.) produces broken file URLs. Should use `Storage::disk($this->disk)->url($path)`. |
| 31 | `src/Http/Controllers/JoditConnectorController.php` | 🟠 High | `Storage::disk($this->disk)->path($storedPath)` throws `RuntimeException` on S3/non-local disks during image sanitization after upload. |
| 32 | `src/Http/Controllers/JoditConnectorController.php` | 🟡 Medium | `actionResize()` with both dimensions `0` silently reads and re-saves the file unchanged, returning HTTP 200. No validation that at least one dimension is provided. |
