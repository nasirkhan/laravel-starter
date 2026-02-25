# Contributing to Laravel Starter

Thank you for considering contributing to Laravel Starter! This document provides guidelines for contributing to the project.

## Table of Contents
- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Pull Request Process](#pull-request-process)
- [Commit Message Guidelines](#commit-message-guidelines)

---

## Code of Conduct

### Our Pledge

We pledge to make participation in our project a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

### Our Standards

**Examples of behavior that contributes to a positive environment:**
- Using welcoming and inclusive language
- Being respectful of differing viewpoints and experiences
- Gracefully accepting constructive criticism
- Focusing on what is best for the community
- Showing empathy towards other community members

**Examples of unacceptable behavior:**
- The use of sexualized language or imagery
- Trolling, insulting/derogatory comments, and personal or political attacks
- Public or private harassment
- Publishing others' private information without explicit permission
- Other conduct which could reasonably be considered inappropriate

---

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates.

**When submitting a bug report, include:**
- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected vs actual behavior**
- **Environment details:**
  - Laravel Starter version
  - Laravel version
  - PHP version
  - Operating system
  - Database (MySQL, PostgreSQL, SQLite)
- **Screenshots** (if applicable)
- **Error messages** or logs

**Example:**
```markdown
## Bug: User profile update fails

**Environment:**
- Laravel Starter: 12.20.0
- Laravel: 12.0
- PHP: 8.3.4
- OS: Windows 11
- DB: MySQL 8.0

**Steps to reproduce:**
1. Go to profile page
2. Update email field
3. Click save
4. Observe error

**Expected:** Profile updates successfully
**Actual:** Error 500, see logs below

**Logs:**
```
[error] ...
```
```

### Suggesting Enhancements

We welcome feature suggestions! Use GitHub Discussions for ideas and feature requests.

**Include:**
- **Clear description** of the feature
- **Use cases** - why it's needed
- **Examples** from other projects (if applicable)
- **Implementation ideas** (optional)

### Improving Documentation

Documentation improvements are always welcome:
- Fix typos or unclear explanations
- Add missing documentation
- Translate documentation
- Add code examples
- Update outdated information

### Submitting Pull Requests

See [Pull Request Process](#pull-request-process) below.

---

## Development Setup

### Prerequisites

- PHP 8.3 or higher
- Composer 2.0+
- Node.js 18+ and NPM 9+
- Database (MySQL 8.0+, PostgreSQL 13+, or SQLite)
- Git

### Initial Setup

1. **Fork the repository**
   ```bash
   # Fork on GitHub, then clone your fork
   git clone https://github.com/YOUR_USERNAME/laravel-starter.git
   cd laravel-starter
   ```

2. **Install dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies
   npm install
   ```

3. **Environment configuration**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   
   # Configure database in .env
   # For quick start, use SQLite:
   touch database/database.sqlite
   # Set DB_CONNECTION=sqlite in .env
   ```

4. **Database setup**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed database with sample data
   php artisan db:seed
   ```

5. **Build frontend assets**
   ```bash
   npm run dev
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

7. **Visit application**
   - Open http://localhost:8000
   - Login: admin@admin.com / secret

### Working with Module-Manager Package (Optional)

If you need to work on both laravel-starter and module-manager:

```bash
# Clone module-manager in parent directory
cd ..
git clone https://github.com/nasirkhan/module-manager.git

# Link local package
cd laravel-starter
composer config repositories.module-manager path "../module-manager"
composer require nasirkhan/module-manager:@dev
```

---

## Coding Standards

### PHP Code Style

We follow **PSR-12** coding standards enforced by **Laravel Pint**.

**Run Pint before committing:**
```bash
# Fix all files
composer pint

# Or use artisan
php artisan pint

# Check specific file
./vendor/bin/pint app/Models/User.php
```

### Laravel Best Practices

- **Follow Laravel conventions**
  - Use Eloquent over raw queries
  - Use relationships over manual joins
  - Use Form Requests for validation
  - Use resource controllers
  - Use route model binding

- **Use type hints**
  ```php
  // ✓ Good
  public function store(StorePostRequest $request): RedirectResponse
  {
      $post = Post::create($request->validated());
      return redirect()->route('posts.show', $post);
  }
  
  // ✗ Bad
  public function store($request)
  {
      $post = Post::create($request->all());
      return redirect('/posts/' . $post->id);
  }
  ```

- **Add PHPDoc blocks**
  ```php
  /**
   * Store a newly created post.
   *
   * @param  \App\Http\Requests\StorePostRequest  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(StorePostRequest $request): RedirectResponse
  {
      // ...
  }
  ```

- **Use resource classes** for API responses

- **Avoid N+1 queries** - use eager loading
  ```php
  // ✓ Good
  $posts = Post::with('user', 'category')->get();
  
  // ✗ Bad  
  $posts = Post::all(); // N+1 when accessing $post->user
  ```

### Livewire 4 Standards

When creating/updating Livewire components:

```php
use Livewire\Component;
use Livewire\Attributes\{Layout, Title, Validate, Locked};

#[Layout('components.layouts.app')]
#[Title('Posts')]
class PostsIndex extends Component
{
    #[Validate('required|min:3')]
    public string $search = '';
    
    #[Locked]
    public int $userId;
    
    public function mount(int $userId): void
    {
        $this->userId = $userId;
    }
    
    public function render()
    {
        $posts = Post::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(15);
            
        return view('livewire.posts-index', compact('posts'));
    }
}
```

**Rules:**
- Always add `#[Layout]` attribute
- Always add `#[Title]` attribute
- Use `#[Validate]` for validation
- Use `#[Locked]` for read-only properties
- Add type hints to all properties
- Use `mount()` for initialization
- Avoid `compact()` in `render()` - pass data directly

### JavaScript/Vue/Alpine

- Follow standard JavaScript conventions
- Use ES6+ features
- Add comments for complex logic
- Format with Prettier (if configured)

### Blade Templates

- Use Blade components over includes
- Follow consistent indentation
- Use slots for flexible components
- Add component documentation

---

## Testing Guidelines

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PostTest.php

# Run specific test method
php artisan test --filter test_user_can_create_post

# Run with coverage (requires Xdebug)
php artisan test --coverage
```

### Writing Tests

**Feature tests** for user-facing functionality:
```php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_post(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'user_id' => $user->id,
        ]);
    }
}
```

**Unit tests** for isolated logic:
```php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\PostService;

class PostServiceTest extends TestCase
{
    public function test_slug_is_generated_from_title(): void
    {
        $service = new PostService();
        $slug = $service->generateSlug('Hello World Test');
        
        $this->assertEquals('hello-world-test', $slug);
    }
}
```

**Livewire tests:**
```php
use Livewire\Livewire;
use App\Livewire\PostsIndex;

public function test_search_filters_posts(): void
{
    Post::factory()->create(['title' => 'Laravel Tutorial']);
    Post::factory()->create(['title' => 'Vue Guide']);
    
    Livewire::test(PostsIndex::class)
        ->set('search', 'Laravel')
        ->assertSee('Laravel Tutorial')
        ->assertDontSee('Vue Guide');
}
```

### Test Coverage Goals

- Aim for 70%+ code coverage
- All new features must include tests
- Bug fixes should include regression tests

---

## Pull Request Process

### Before Submitting

1. **Create a feature branch**
   ```bash
   git checkout -b feature/add-post-scheduling
   ```

2. **Make your changes**
   - Follow coding standards
   - Add tests
   - Update documentation

3. **Run quality checks**
   ```bash
   # Format code
   composer pint
   
   # Run tests
   php artisan test
   
   # Check for errors
   php artisan clear-all
   ```

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat: add post scheduling feature"
   ```

5. **Push to your fork**
   ```bash
   git push origin feature/add-post-scheduling
   ```

### Submitting Pull Request

1. **Create PR on GitHub**
   - Provide clear title and description
   - Reference related issues
   - Add screenshots for UI changes

2. **PR Template:**
   ```markdown
   ## Description
   Brief description of changes
   
   ## Type of Change
   - [ ] Bug fix
   - [ ] New feature
   - [ ] Breaking change
   - [ ] Documentation update
   
   ## Checklist
   - [ ] Code follows project style
   - [ ] Tests added/updated
   - [ ] Documentation updated
   - [ ] No breaking changes (or documented)
   - [ ] Pint passed
   - [ ] Tests pass
   
   ## Related Issues
   Closes #123
   
   ## Screenshots
   (if applicable)
   ```

3. **Respond to feedback**
   - Address review comments
   - Make requested changes
   - Re-request review

### What Happens Next?

- Maintainers will review your PR
- May request changes or clarifications
- Once approved, will be merged
- Your contribution will be in the next release!

---

## Commit Message Guidelines

We follow **Conventional Commits** specification.

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Type

- **feat:** New feature
- **fix:** Bug fix
- **docs:** Documentation changes
- **style:** Code style changes (formatting, no logic change)
- **refactor:** Code refactoring (no feature/bug change)
- **perf:** Performance improvements
- **test:** Adding or updating tests
- **chore:** Build process or auxiliary tool changes

### Examples

```bash
# Feature
git commit -m "feat(posts): add scheduled publishing"

# Bug fix
git commit -m "fix(auth): resolve login redirect issue"

# Documentation
git commit -m "docs(readme): update installation instructions"

# Breaking change
git commit -m "feat(api)!: change response format

BREAKING CHANGE: API responses now wrapped in data key"
```

---

## Module Development

### Creating a New Module

```bash
php artisan module:build MyModule
```

Follow the generated structure and examples from existing modules.

### Module Structure

```
Modules/MyModule/
├── Config/
├── Database/
│   ├── Migrations/
│   ├── Seeders/
│   └── Factories/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Resources/
│   └── views/
├── Routes/
│   └── web.php
└── Tests/
```

---

## Questions?

- **General questions:** Use [GitHub Discussions](https://github.com/nasirkhan/laravel-starter/discussions)
- **Bug reports:** Use [GitHub Issues](https://github.com/nasirkhan/laravel-starter/issues)
- **Security issues:** Email nasir8891@gmail.com

---

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- GitHub contributors graph

Thank you for making Laravel Starter better! 🙏
