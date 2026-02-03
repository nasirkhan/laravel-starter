# Security Best Practices

**Last Updated:** February 3, 2026

This document outlines security best practices implemented in Laravel Starter and recommendations for maintaining secure applications.

---

## 🔒 Table of Contents

1. [Authentication & Authorization](#authentication--authorization)
2. [Input Validation & Sanitization](#input-validation--sanitization)
3. [CSRF Protection](#csrf-protection)
4. [XSS Protection](#xss-protection)
5. [SQL Injection Prevention](#sql-injection-prevention)
6. [Password Security](#password-security)
7. [Rate Limiting](#rate-limiting)
8. [Session Security](#session-security)
9. [File Upload Security](#file-upload-security)
10. [API Security](#api-security)
11. [Deployment Security](#deployment-security)
12. [Monitoring & Auditing](#monitoring--auditing)

---

## 1. Authentication & Authorization

### ✅ Implemented

**Laravel Breeze Integration**
- Secure authentication scaffolding with Livewire
- Email verification system
- Password reset functionality
- Remember me functionality

**Role-Based Access Control (Spatie Permission)**
```php
// Check permissions in controllers
$this->authorize('edit_posts');

// Check in Blade templates
@can('edit_posts')
    <!-- Content -->
@endcan

// Check in routes
Route::middleware('can:edit_posts')->group(function () {
    // Protected routes
});
```

**Multi-Factor Authentication**
- ⏳ Planned for v3.2
- Will support TOTP (Time-based One-Time Password)
- Backup codes for account recovery

### 📋 Best Practices

1. **Always use middleware for route protection:**
```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes
});
```

2. **Use gates and policies for fine-grained control:**
```php
// Define gates in AuthServiceProvider
Gate::define('update-post', function (User $user, Post $post) {
    return $user->id === $post->user_id;
});

// Use in controllers
if (Gate::denies('update-post', $post)) {
    abort(403);
}
```

3. **Implement session timeouts:**
```dotenv
SESSION_LIFETIME=120  # 2 hours
```

---

## 2. Input Validation & Sanitization

### ✅ Implemented

**Form Request Validation**
All forms use dedicated Form Request classes:
```php
// Example: app/Http/Requests/StorePostRequest.php
public function rules(): array
{
    return [
        'title' => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
        'status' => ['required', 'in:draft,published'],
    ];
}
```

**Livewire Validation**
```php
use Livewire\Attributes\Validate;

#[Validate('required|email|unique:users')]
public string $email = '';

#[Validate('required|min:8')]
public string $password = '';
```

### 📋 Best Practices

1. **Never trust user input:**
```php
// ❌ BAD
$post->title = request('title');

// ✅ GOOD
$validated = $request->validated();
$post->title = $validated['title'];
```

2. **Use strict validation rules:**
```php
'email' => ['required', 'email:strict', 'max:255'],
'url' => ['required', 'url', 'active_url'],
'ip' => ['required', 'ip'],
```

3. **Sanitize HTML input:**
```php
// Use strip_tags or HTMLPurifier
$clean = strip_tags($input, '<p><a><strong><em>');
```

4. **Validate file uploads:**
```php
'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
```

---

## 3. CSRF Protection

### ✅ Implemented

**Automatic CSRF Protection**
- Laravel's VerifyCsrfToken middleware enabled by default
- All POST, PUT, PATCH, DELETE requests require CSRF token

**In Blade Templates:**
```blade
<form method="POST" action="/profile">
    @csrf
    <!-- Form fields -->
</form>
```

**In Livewire Components:**
```blade
<!-- CSRF token automatically handled by Livewire -->
<form wire:submit="save">
    <!-- Form fields -->
</form>
```

**In JavaScript (Axios):**
```javascript
// CSRF token automatically included via meta tag
axios.post('/api/data', formData);
```

### 📋 Best Practices

1. **Always include @csrf in forms:**
```blade
<form method="POST">
    @csrf
    <!-- Never forget this! -->
</form>
```

2. **Exclude routes carefully:**
```php
// Only exclude if absolutely necessary (e.g., webhooks)
protected $except = [
    'webhook/stripe',
];
```

---

## 4. XSS Protection

### ✅ Implemented

**Automatic Escaping**
- Blade templates escape output by default using `{{ }}`
- Livewire components use safe rendering

**Content Security Policy Headers**
```php
// config/secure-headers.php
'csp' => [
    'default-src' => ["'self'"],
    'script-src' => ["'self'", "'unsafe-inline'", 'cdn.jsdelivr.net'],
    'style-src' => ["'self'", "'unsafe-inline'"],
],
```

### 📋 Best Practices

1. **Always escape user-generated content:**
```blade
<!-- ✅ GOOD - Automatically escaped -->
{{ $user->bio }}

<!-- ⚠️ DANGEROUS - Only use for trusted content -->
{!! $trustedHtml !!}
```

2. **Sanitize HTML content:**
```php
use Mews\Purifier\Facades\Purifier;

$clean = Purifier::clean($userInput);
```

3. **Use CSP headers:**
```dotenv
SECURE_HEADERS=true
CSP_ENABLED=true
```

---

## 5. SQL Injection Prevention

### ✅ Implemented

**Eloquent ORM**
- All database queries use parameter binding
- Protection against SQL injection by default

**Query Builder**
```php
// ✅ SAFE - Uses parameter binding
DB::table('users')->where('email', $email)->get();

// ❌ DANGEROUS - Never do this
DB::select("SELECT * FROM users WHERE email = '$email'");
```

### 📋 Best Practices

1. **Always use Eloquent or Query Builder:**
```php
// ✅ GOOD
User::where('email', $request->email)->first();

// ✅ GOOD
DB::table('users')->where('email', $request->email)->get();
```

2. **Use named bindings for raw queries:**
```php
DB::select('SELECT * FROM users WHERE email = :email', [
    'email' => $request->email
]);
```

3. **Validate all inputs before queries:**
```php
$validated = $request->validate([
    'email' => ['required', 'email'],
]);

User::where('email', $validated['email'])->first();
```

---

## 6. Password Security

### ✅ Implemented

**bcrypt Hashing**
- All passwords hashed using bcrypt (cost factor: 12)
- Automatic hashing via Laravel's authentication

**Password Requirements**
```php
// Minimum requirements enforced
Password::min(8)
    ->mixedCase()
    ->numbers()
    ->symbols()
    ->uncompromised()
```

**Password Reset**
- Secure token-based password reset
- Tokens expire after 1 hour
- Single-use tokens

### 📋 Best Practices

1. **Enforce strong passwords:**
```php
'password' => [
    'required',
    'confirmed',
    Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ->uncompromised(),
],
```

2. **Never store or log passwords:**
```php
// ❌ NEVER
Log::info('Password: ' . $request->password);

// ✅ GOOD
Log::info('User logged in', ['user_id' => $user->id]);
```

3. **Use password confirmation for sensitive actions:**
```php
Route::post('/settings/critical', function () {
    // Requires password confirmation
})->middleware('password.confirm');
```

---

## 7. Rate Limiting

### ✅ Implemented

**Default Rate Limits**
```php
// routes/web.php
Route::middleware(['throttle:60,1'])->group(function () {
    // 60 requests per minute
});

// API routes
Route::middleware(['throttle:api'])->group(function () {
    // Configurable in RouteServiceProvider
});
```

**Login Rate Limiting**
```php
// Breeze includes login throttling
// Max 5 attempts per minute per email
```

### 📋 Best Practices

1. **Apply rate limiting to sensitive endpoints:**
```php
Route::post('/login')->middleware('throttle:5,1');
Route::post('/register')->middleware('throttle:3,1');
Route::post('/password/email')->middleware('throttle:3,10');
```

2. **Use custom rate limiters:**
```php
// bootstrap/app.php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

3. **Monitor for abuse:**
```php
// Log excessive requests
RateLimiter::for('strict', function (Request $request) {
    if (RateLimiter::tooManyAttempts('strict:'.$request->ip(), 100)) {
        Log::warning('Possible DDoS', ['ip' => $request->ip()]);
    }
    return Limit::perMinute(100)->by($request->ip());
});
```

---

## 8. Session Security

### ✅ Implemented

**Secure Session Configuration**
```dotenv
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

**Session Regeneration**
- Automatic regeneration on login
- Invalidation on logout

### 📋 Best Practices

1. **Use secure session drivers in production:**
```dotenv
# Development
SESSION_DRIVER=file

# Production
SESSION_DRIVER=database
# or
SESSION_DRIVER=redis
```

2. **Regenerate session on privilege escalation:**
```php
public function promoteToAdmin(User $user)
{
    $user->assignRole('admin');
    request()->session()->regenerate();
}
```

3. **Implement session timeout:**
```php
// Middleware to check last activity
if (time() - session('last_activity') > config('session.lifetime') * 60) {
    Auth::logout();
    session()->flush();
}
session(['last_activity' => time()]);
```

---

## 9. File Upload Security

### ✅ Implemented

**File Validation**
```php
'file' => [
    'required',
    'file',
    'mimes:pdf,doc,docx,txt',
    'max:10240', // 10MB
],
```

**Secure Storage**
- Files stored outside public directory by default
- Unique filenames to prevent overwriting

### 📋 Best Practices

1. **Validate file types strictly:**
```php
'image' => [
    'required',
    'image',
    'mimes:jpeg,png,jpg,gif',
    'max:2048',
    'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000',
],
```

2. **Scan uploads for malware:**
```php
// Use ClamAV or similar
if (! $this->isClean($file)) {
    throw new \Exception('File failed security scan');
}
```

3. **Generate unique filenames:**
```php
$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
$file->storeAs('uploads', $filename, 'private');
```

4. **Serve files through controllers:**
```php
public function download(string $filename)
{
    $this->authorize('download-file', $filename);
    
    return Storage::download('uploads/' . $filename);
}
```

---

## 10. API Security

### ⏳ Planned Features

**Laravel Sanctum**
- Token-based authentication
- SPA authentication
- Mobile app authentication

**API Rate Limiting**
```php
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // API routes
});
```

### 📋 Best Practices

1. **Use API tokens for authentication:**
```php
// Generate tokens
$token = $user->createToken('mobile-app')->plainTextToken;

// Protect routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
```

2. **Implement API versioning:**
```php
Route::prefix('api/v1')->group(function () {
    // Version 1 routes
});

Route::prefix('api/v2')->group(function () {
    // Version 2 routes
});
```

3. **Return appropriate HTTP status codes:**
```php
return response()->json(['error' => 'Unauthorized'], 401);
return response()->json(['error' => 'Forbidden'], 403);
return response()->json(['error' => 'Not Found'], 404);
```

---

## 11. Deployment Security

### ✅ Implemented

**Environment Security**
```dotenv
APP_DEBUG=false
APP_ENV=production
```

**HTTPS Enforcement**
```php
// Force HTTPS in production
if (app()->environment('production')) {
    URL::forceScheme('https');
}
```

### 📋 Best Practices

1. **Secure .env file:**
```bash
# Set proper permissions
chmod 600 .env

# Add to .gitignore
echo ".env" >> .gitignore
```

2. **Disable debug mode:**
```dotenv
APP_DEBUG=false
APP_ENV=production
```

3. **Run optimization commands:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

4. **Keep dependencies updated:**
```bash
composer update --with-dependencies
npm audit fix
```

5. **Configure security headers:**
```nginx
# nginx
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
add_header X-XSS-Protection "1; mode=block";
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
```

---

## 12. Monitoring & Auditing

### ✅ Implemented

**Activity Logging (Spatie Activity Log)**
```php
activity()
    ->performedOn($post)
    ->causedBy($user)
    ->log('Post was updated');
```

**Laravel Log Viewer**
- View application logs through web interface
- Filter by level, date, and content

### 📋 Best Practices

1. **Log security events:**
```php
// Failed login attempts
Log::warning('Failed login attempt', [
    'email' => $request->email,
    'ip' => $request->ip(),
]);

// Suspicious activity
Log::alert('Multiple failed 2FA attempts', [
    'user_id' => $user->id,
    'ip' => $request->ip(),
]);
```

2. **Monitor for anomalies:**
```php
// Track unusual patterns
if ($user->login_count > 100 && $user->created_at->isToday()) {
    Log::warning('Unusual activity detected', ['user_id' => $user->id]);
}
```

3. **Implement audit trails:**
```php
// Track all sensitive changes
AuditLog::create([
    'user_id' => auth()->id(),
    'action' => 'updated_user_role',
    'subject_type' => User::class,
    'subject_id' => $user->id,
    'old_values' => $user->getOriginal(),
    'new_values' => $user->getChanges(),
]);
```

---

## Security Checklist

### Before Deployment

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Use strong `APP_KEY`
- [ ] Enable HTTPS
- [ ] Configure secure session settings
- [ ] Set proper file permissions (755 directories, 644 files)
- [ ] Remove unnecessary files (tests, docs from public)
- [ ] Configure CORS properly
- [ ] Enable rate limiting
- [ ] Set up error monitoring (Sentry, Flare)
- [ ] Configure backups
- [ ] Review .gitignore
- [ ] Update all dependencies
- [ ] Run security audit: `composer audit`
- [ ] Run vulnerability scan: `npm audit`
- [ ] Configure firewall rules
- [ ] Set up SSL/TLS certificates
- [ ] Enable security headers
- [ ] Test password reset flow
- [ ] Test email verification
- [ ] Review database permissions
- [ ] Configure queue workers with proper limits

### Regular Maintenance

- [ ] Weekly: Review logs for suspicious activity
- [ ] Weekly: Check for failed login attempts
- [ ] Monthly: Update dependencies
- [ ] Monthly: Review user permissions
- [ ] Monthly: Test backup restoration
- [ ] Quarterly: Security audit
- [ ] Quarterly: Penetration testing
- [ ] Yearly: Review all security policies

---

## Resources

### Laravel Security Documentation
- [Laravel Security](https://laravel.com/docs/11.x/security)
- [Laravel Authentication](https://laravel.com/docs/11.x/authentication)
- [Laravel Authorization](https://laravel.com/docs/11.x/authorization)

### OWASP Resources
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [OWASP PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)

### Tools
- [Laravel Security Checker](https://github.com/enlightn/enlightn)
- [PHP Security Checker](https://github.com/fabpot/local-php-security-checker)
- [Snyk](https://snyk.io/) - Dependency vulnerability scanning

---

## Reporting Security Issues

If you discover a security vulnerability in Laravel Starter, please email:

**nasir8891@gmail.com**

Do not create public GitHub issues for security vulnerabilities.

---

*This document is maintained as part of the Laravel Starter project. Last updated: February 3, 2026*
