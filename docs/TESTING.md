# Testing Guide

**Created:** February 4, 2026  
**Last Updated:** February 4, 2026

## Table of Contents

- [Overview](#overview)
- [Test Types](#test-types)
- [Running Tests](#running-tests)
- [PHPUnit Tests](#phpunit-tests)
- [Browser Tests (Dusk)](#browser-tests-dusk)
- [API Testing](#api-testing)
- [Test Data Builders](#test-data-builders)
- [Mutation Testing](#mutation-testing)
- [Best Practices](#best-practices)
- [Code Coverage](#code-coverage)
- [Continuous Integration](#continuous-integration)

---

## Overview

This application uses PHPUnit as its primary testing framework with additional testing tools:

- **PHPUnit v11** - Primary testing framework for unit and feature tests
- **Laravel Dusk v8** - Browser automation testing
- **Test Data Builders** - Fluent interfaces for creating test data

### Test Statistics

- **Total Tests:** 125+ tests
- **Test Suites:** Unit, Feature, Browser, API
- **Coverage Goal:** 70-80%
- **Mutation Score Goal:** 70% MSI, 80% Covered MSI

---

## Test Types

### Unit Tests (`tests/Unit/`)

Test individual classes and methods in isolation.

```php
// Example: tests/Unit/MenuTest.php
public function test_menu_has_correct_table_name(): void
{
    $menu = new Menu();
    $this->assertEquals('menus', $menu->getTable());
}
```

### Feature Tests (`tests/Feature/`)

Test application features with database interactions.

```php
// Example: tests/Feature/Auth/AuthenticationTest.php
public function test_users_can_authenticate(): void
{
    $user = User::factory()->create();
    
    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    $this->assertAuthenticated();
}
```

### Browser Tests (`tests/Browser/`)

Test full user workflows in a real browser.

```php
// Example: tests/Browser/LoginTest.php
public function test_user_can_login(): void
{
    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/dashboard');
    });
}
```

### API Tests (`tests/Feature/Api/`)

Test REST API endpoints with proper authentication and validation.

```php
// Example: tests/Feature/Api/ExampleApiTest.php
public function test_api_requires_authentication(): void
{
    $response = $this->getJson('/api/user');
    $response->assertStatus(401);
}
```

---

## Running Tests

### Run All Tests

```bash
# PHPUnit
php artisan test

# Pest
./vendor/bin/pest

# With coverage
php artisan test --coverage

# Parallel execution
php artisan test --parallel
```

### Run Specific Test Suites

```bash
# Unit tests only
php artisan test --testsuite=Unit

# Feature tests only
php artisan test --testsuite=Feature

# Browser tests
php artisan dusk

# Specific browser test
php artisan dusk tests/Browser/LoginTest.php
```

### Run Specific Tests

```bash
# By filter
php artisan test --filter=AuthenticationTest

# By method name
php artisan test --filter=test_user_can_login

# Single file
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

### Run Tests in Parallel

```bash
# Automatically determine processes
php artisan test --parallel

# Specify number of processes
php artisan test --parallel --processes=4
```

---

## PHPUnit Tests

### Creating PHPUnit Tests

```bash
# Feature test
php artisan make:test UserTest

# Unit test
php artisan make:test UserTest --unit
```

### Example PHPUnit Test

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ];

        $user = User::create($userData);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
        
        $this->assertEquals('John Doe', $user->name);
    }
}
```

---

## Browser Tests (Dusk)

### Setup

Dusk is already installed and configured. ChromeDriver is automatically downloaded.

### Creating Dusk Tests

```bash
php artisan dusk:make RegistrationTest
```

### Example Dusk Test

```php
<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Builders\UserBuilder;

class RegistrationTest extends DuskTestCase
{
    public function test_user_can_register(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'John Doe')
                    ->type('email', 'john@example.com')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->press('Create account')
                    ->waitForLocation('/dashboard', 10)
                    ->assertPathIs('/dashboard')
                    ->assertAuthenticated();
        });
    }
}
```

### Running Dusk Tests

```bash
# All browser tests
php artisan dusk

# Specific test
php artisan dusk tests/Browser/LoginTest.php

# With specific browser
php artisan dusk --without-tty

# In headless mode
php artisan dusk --headless
```

### Dusk Selectors

```php
// By ID
$browser->click('#submit-button');

// By class
$browser->type('.email-input', 'test@example.com');

// By name
$browser->select('country', 'US');

// Dusk selector
$browser->click('@submit-button');

// XPath
$browser->driver->findElement(
    WebDriverBy::xpath('//button[@type="submit"]')
)->click();
```

### Waiting in Dusk

```php
// Wait for element
$browser->waitFor('.alert');

// Wait for text
$browser->waitForText('Success');

// Wait for location
$browser->waitForLocation('/dashboard');

// Wait for reload
$browser->waitForReload();

// Custom wait
$browser->waitUsing(10, 100, function () use ($browser) {
    return $browser->driver->getCurrentURL() === 'http://example.com/dashboard';
});
```

---

## API Testing

### Example API Test Structure

```php
<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Tests\Builders\UserBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_posts_list(): void
    {
        $user = UserBuilder::make()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson('/api/posts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'content', 'created_at']
                ],
                'meta' => ['current_page', 'total'],
                'links' => ['first', 'last', 'prev', 'next'],
            ]);
    }

    public function test_api_validates_post_creation(): void
    {
        $user = UserBuilder::make()->asAdmin()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/posts', [
            'title' => '', // Empty title should fail
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }
}
```

### API Test Best Practices

1. **Always set Accept header** to `application/json`
2. **Use proper HTTP methods** (GET, POST, PUT, DELETE)
3. **Test authentication** for protected endpoints
4. **Test authorization** for role-based endpoints
5. **Test validation** for all input fields
6. **Test pagination** for list endpoints
7. **Test error responses** (404, 422, 500)
8. **Test rate limiting** if implemented

---

## Test Data Builders

### Using the Builder Pattern

The Builder pattern provides a fluent, readable way to create test data.

### UserBuilder Example

```php
use Tests\Builders\UserBuilder;

// Simple user
$user = UserBuilder::make()->create();

// Admin user
$admin = UserBuilder::make()
    ->asAdmin()
    ->verified()
    ->create();

// Custom user
$user = UserBuilder::make()
    ->withName('John Doe')
    ->withEmail('john@example.com')
    ->withRole('manager')
    ->withPermission('edit posts')
    ->active()
    ->verified()
    ->create();

// Multiple users
$users = UserBuilder::make()
    ->withRole('user')
    ->count(10);

// Make without persisting
$user = UserBuilder::make()
    ->withEmail('test@example.com')
    ->make();
```

### Creating New Builders

```php
<?php

namespace Tests\Builders;

use App\Models\Post;

class PostBuilder
{
    private array $attributes = [];

    public static function make(): self
    {
        return new self();
    }

    public function withTitle(string $title): self
    {
        $this->attributes['title'] = $title;
        return $this;
    }

    public function withContent(string $content): self
    {
        $this->attributes['content'] = $content;
        return $this;
    }

    public function published(): self
    {
        $this->attributes['published_at'] = now();
        $this->attributes['status'] = 1;
        return $this;
    }

    public function draft(): self
    {
        $this->attributes['published_at'] = null;
        $this->attributes['status'] = 0;
        return $this;
    }

    public function create(): Post
    {
        return Post::factory()->create($this->attributes);
    }

    public function make(): Post
    {
        return Post::factory()->make($this->attributes);
    }
}
```

---

## Mutation Testing

### What is Mutation Testing?

Mutation testing modifies your source code in small ways (mutations) and runs your tests to see if they catch the changes. This tests the quality of your tests themselves.

### Running Mutation Tests

```bash
# Run mutation testing
./vendor/bin/infection

# With specific mutators
./vendor/bin/infection --mutators=@default

# Show mutations
./vendor/bin/infection --show-mutations

# Generate report
./vendor/bin/infection --logger-html=infection.html
```

### Understanding Results

- **MSI (Mutation Score Indicator)** - Percentage of mutations killed
- **Covered MSI** - Percentage of mutations killed in covered code
- **Goal:** MSI ≥ 70%, Covered MSI ≥ 80%

### Example Output

```
125 mutations were generated:
      75 mutants were killed
      25 mutants survived
      20 mutants were not covered by tests
       5 errors were encountered

Metrics:
    Mutation Score Indicator (MSI): 60%
    Mutation Code Coverage: 84%
    Covered Code MSI: 75%
```

### Improving Mutation Score

1. **Add edge case tests**
2. **Test return values explicitly**
3. **Test all conditional branches**
4. **Add assertion messages**
5. **Test error conditions**

---

## Best Practices

### General Testing

1. **Follow AAA Pattern**
   ```php
   // Arrange - Set up test data
   $user = User::factory()->create();
   
   // Act - Perform the action
   $response = $this->post('/login', [...]);
   
   // Assert - Verify the result
   $this->assertAuthenticated();
   ```

2. **Use Descriptive Test Names**
   ```php
   // Good
   test_user_can_login_with_valid_credentials()
   
   // Bad
   test_login()
   ```

3. **One Assertion Focus Per Test**
   ```php
   // Good - focused test
   public function test_user_name_is_required(): void
   {
       $response = $this->post('/users', ['name' => '']);
       $response->assertSessionHasErrors('name');
   }
   ```

4. **Use Database Transactions**
   ```php
   use RefreshDatabase; // Rolls back after each test
   ```

5. **Avoid Test Interdependencies**
   - Each test should be independent
   - Tests should pass in any order
   - Use setUp() and tearDown() properly

### Laravel-Specific

1. **Use Factories** instead of creating models manually
2. **Use Route Names** instead of hardcoded URLs
3. **Test Middleware** explicitly when needed
4. **Test Validation Rules** separately
5. **Mock External Services** (APIs, queues, etc.)

### Pest-Specific

1. **Use datasets** for testing multiple scenarios
2. **Use expectations** for readable assertions
3. **Group related tests** with `describe()`
4. **Use beforeEach/afterEach** for setup/teardown

---

## Code Coverage

### Generating Coverage Reports

```bash
# HTML report (opens in browser)
php artisan test --coverage --coverage-html=coverage

# Text report
php artisan test --coverage --coverage-text

# XML report (for CI)
php artisan test --coverage --coverage-clover=coverage.xml
```

### Coverage Goals

- **Overall:** 70-80%
- **Critical Paths:** 90%+
- **Models:** 80%+
- **Controllers:** 70%+
- **Services:** 85%+

### Viewing Coverage

```bash
# After generating HTML report
open coverage/index.html
```

---

## Continuous Integration

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.3
          extensions: mbstring, pdo, pdo_sqlite
          coverage: xdebug
      
      - name: Install Dependencies
        run: composer install --no-interaction --prefer-dist
      
      - name: Copy Environment
        run: cp .env.example .env
      
      - name: Generate Key
        run: php artisan key:generate
      
      - name: Run Tests
        run: php artisan test --coverage --min=70
      
      - name: Run Pest
        run: ./vendor/bin/pest
      
      - name: Run Mutation Tests
        run: ./vendor/bin/infection --min-msi=70 --min-covered-msi=80
```

---

## Quick Reference

### Common Commands

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage --min=70

# Run Pest tests
./vendor/bin/pest

# Run browser tests
php artisan dusk

# Run mutation tests
./vendor/bin/infection

# Run specific test
php artisan test --filter=UserTest

# Run in parallel
php artisan test --parallel

# Generate coverage HTML
php artisan test --coverage-html=coverage
```

### Test Traits

- `RefreshDatabase` - Rolls back database after each test
- `DatabaseMigrations` - Runs migrations before each test
- `WithFaker` - Provides Faker instance
- `WithoutMiddleware` - Disables middleware
- `WithoutEvents` - Disables events

### Assertions

```php
// HTTP
$response->assertStatus(200);
$response->assertRedirect('/dashboard');
$response->assertJson(['key' => 'value']);

// Database
$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
$this->assertDatabaseMissing('users', ['email' => 'deleted@example.com']);

// Authentication
$this->assertAuthenticated();
$this->assertGuest();

// Expectations (Pest)
expect($value)->toBe(10);
expect($user)->toBeInstanceOf(User::class);
expect($collection)->toHaveCount(5);
```

---

## Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Pest Documentation](https://pestphp.com)
- [Dusk Documentation](https://laravel.com/docs/dusk)
- [Infection Documentation](https://infection.github.io)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)

---

**Last Updated:** February 4, 2026
