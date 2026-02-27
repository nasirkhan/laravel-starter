# Gallery Module

A flexible, polymorphic image gallery management system for Laravel Starter. Create and manage image galleries that can be attached to any model (Posts, Pages, Products, etc.).

## Features

- ✅ **Polymorphic Galleries** - Attach galleries to any model
- ✅ **Multiple Images** - Upload and manage multiple images per gallery
- ✅ **Image Ordering** - Drag-and-drop image reordering
- ✅ **Featured Images** - Set primary/featured image for each gallery
- ✅ **Soft Deletes** - Recover accidentally deleted galleries and images
- ✅ **User Tracking** - Audit trail for who created/updated galleries
- ✅ **Activity Logging** - Full activity log integration
- ✅ **Permission-Based** - Role-based access control
- ✅ **SEO Friendly** - Auto-generated slugs, alt text, and metadata
- ✅ **Responsive UI** - Mobile-friendly admin interface


## Installation

### Prerequisites

- Laravel 12.x 
- PHP 8.2 
- MySQL 5.7+ or MariaDB 10.3+
- GD or Imagick PHP extension (for image processing)

### Step 1: Install the Module

If using the modular Laravel Starter:

```bash
php artisan module:build Gallery
```

Or manually copy the Gallery module to `Modules/Gallery/`

### Step 2: Run Migrations

```bash
php artisan migrate
```

This creates two tables:
- `galleries` - Stores gallery information
- `gallery_images` - Stores individual images

### Step 3: Create Permissions

```bash
php artisan auth:permissions galleries
```

This creates:
- `view_galleries`
- `add_galleries`
- `edit_galleries`
- `delete_galleries`
- `restore_galleries`

### Step 4: Clear Cache

```bash
php artisan cache:forget spatie.permission.cache
php artisan route:clear
php artisan view:clear
```

### Step 5: Assign Permissions

1. Go to **Admin → Roles**
2. Edit your role (e.g., "Administrator")
3. Check all gallery permissions
4. Save

## Configuration

### Image Storage

By default, images are stored in `storage/app/public/galleries`. To customize:

**File:** `config/filesystems.php`

```php
'disks' => [
    'galleries' => [
        'driver' => 'local',
        'root' => storage_path('app/public/galleries'),
        'url' => env('APP_URL').'/storage/galleries',
        'visibility' => 'public',
    ],
],
```

### Image Processing

Configure image driver in `config/image.php`:

```php
'driver' => 'gd', 
```

### Thumbnail Sizes

Customize thumbnail dimensions in `GalleryImagesController`:

```php
$thumbnail = Image::make($image)
    ->fit(300, 300)
    ->save($thumbnailPath);
```

## Usage

### Creating Galleries

#### Via Admin Panel

1. Navigate to **Admin → Galleries**
2. Click **"Create New Gallery"**
3. Fill in:
   - **Name** (required) - Gallery title
   - **Description** (optional) - Gallery description
   - **Order** (optional) - Display order
   - **Active** - Enable/disable gallery
4. Click **"Save"**

#### Programmatically

```php
use Modules\Gallery\Models\Gallery;

$gallery = Gallery::create([
    'name' => 'Product Photos',
    'description' => 'Main product image gallery',
    'order' => 1,
    'is_active' => true,
]);
```

### Managing Images

#### Upload Images

```php
use Modules\Gallery\Models\GalleryImage;

$image = GalleryImage::create([
    'gallery_id' => $gallery->id,
    'image_path' => '/storage/galleries/photo.jpg',
    'thumbnail_path' => '/storage/galleries/thumbs/photo.jpg',
    'title' => 'Product Front View',
    'alt_text' => 'Red widget front view',
    'order' => 1,
    'is_featured' => true,
]);
```

#### Set Featured Image

```php
// Mark as featured
$image->update(['is_featured' => true]);

// Get featured image
$featuredImage = $gallery->featuredImage;
```

#### Reorder Images

```php
// Update order
$image->update(['order' => 5]);

// Or bulk update
GalleryImage::where('gallery_id', $gallery->id)
    ->update(['order' => DB::raw('order + 1')]);
```

### Attaching to Models

#### Step 1: Add Relationship to Your Model

**Example:** Attach galleries to Posts

**File:** `app/Models/Post.php`

```php
use Modules\Gallery\Models\Gallery;

class Post extends Model
{
    /**
     * Get all galleries for this post
     */
    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'galleryable');
    }
    
    /**
     * Get all images across all galleries
     */
    public function galleryImages()
    {
        return $this->hasManyThrough(
            GalleryImage::class,
            Gallery::class,
            'galleryable_id',
            'gallery_id',
            'id',
            'id'
        )->where('galleries.galleryable_type', Post::class);
    }
}
```

#### Step 2: Attach Gallery to Model

```php
$post = Post::find(1);

// Create new gallery for post
$gallery = $post->galleries()->create([
    'name' => 'Post Images',
    'description' => 'Images for this blog post',
    'is_active' => true,
]);

// Or attach existing gallery
$gallery->update([
    'galleryable_id' => $post->id,
    'galleryable_type' => Post::class,
]);
```

#### Step 3: Display in Views

**Backend (Admin):**

```blade
@foreach($post->galleries as $gallery)
    <h3>{{ $gallery->name }}</h3>
    <div class="gallery-images">
        @foreach($gallery->images as $image)
            <img src="{{ $image->thumbnail_url }}" alt="{{ $image->alt_text }}">
        @endforeach
    </div>
@endforeach
```

**Frontend:**

```blade
@foreach($post->galleries as $gallery)
    <div class="image-gallery">
        @foreach($gallery->images as $image)
            <a href="{{ $image->image_url }}" data-lightbox="gallery-{{ $gallery->id }}">
                <img src="{{ $image->thumbnail_url }}" 
                     alt="{{ $image->alt_text }}"
                     title="{{ $image->title }}">
            </a>
        @endforeach
    </div>
@endforeach
```

## API Reference

### Gallery Model

#### Properties

| Property            | Type    | Description                 |
|---------------------|---------|-----------------------------|
| `id`                | integer | Primary key                 |
| `name`              | string  | Gallery name (required)     |
| `description`       | text    | Gallery description         |
| `slug`              | string  | URL-friendly slug (auto-gen)|
| `galleryable_id`    | integer | Polymorphic foreign key     |
| `galleryable_type`  | string  | Polymorphic model type      |
| `order`             | integer | Display order               |
| `is_active`         | boolean | Active status               |
| `created_by`        | integer | Creator user ID             |
| `updated_by`        | integer | Last updater user ID        |
| `deleted_by`        | integer | Deleter user ID             |

#### Relationships

```php
// Get parent model (Post, Page, etc.)
$gallery->galleryable;

// Get all images
$gallery->images;

// Get featured image
$gallery->featuredImage;

// Get creator
$gallery->creator;

// Get updater
$gallery->updater;
```

#### Scopes

```php
// Get only active galleries
Gallery::active()->get();

// Get trashed galleries
Gallery::onlyTrashed()->get();

// Get with images
Gallery::with('images')->get();
```

### GalleryImage Model

#### Properties

| Property            | Type    | Description                 |
|---------------------|---------|-----------------------------|
| `id`                | integer | Primary key                 |
| `gallery_id`        | integer | Foreign key to galleries    |
| `image_path`        | string  | Full image path             |
| `thumbnail_path`    | string  | Thumbnail path              |
| `title`             | string  | Image title                 |
| `description`       | text    | Image description           |
| `alt_text`          | string  | Alt text for SEO            |
| `order`             | integer | Display order               |
| `is_featured`       | boolean | Featured flag               |
| `width`             | integer | Image width (px)            |
| `height`            | integer | Image height (px)           |
| `file_size`         | integer | File size (bytes)           |

---

## Permissions

| Permission            | Description                      |
|-----------------------|----------------------------------|
| `view_galleries`      | View galleries list and details  |
| `add_galleries`       | Create new galleries             |
| `edit_galleries`      | Edit existing galleries          |
| `delete_galleries`    | Delete galleries (soft delete)   |
| `restore_galleries`   | Restore deleted galleries        |

### Checking Permissions

```php
// In controller
if (auth()->user()->can('view_galleries')) {
    // User can view galleries
}

// In Blade
@can('add_galleries')
    <a href="{{ route('backend.galleries.create') }}">Create Gallery</a>
@endcan
```

## Database Schema

### galleries Table

```sql
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` text,
  `slug` varchar(191) NOT NULL,
  `galleryable_id` bigint unsigned DEFAULT NULL,
  `galleryable_type` varchar(191) DEFAULT NULL,
  `order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `deleted_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_galleryable_type_galleryable_id_index` (`galleryable_type`,`galleryable_id`)
);
```

### gallery_images Table

```sql
CREATE TABLE `gallery_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint unsigned NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `thumbnail_path` varchar(191) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `description` text,
  `alt_text` text,
  `order` int DEFAULT '0',
  `is_featured` tinyint(1) DEFAULT '0',
  `width` int DEFAULT NULL,
  `height` int DEFAULT NULL,
  `file_size` int DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `updated_by` int unsigned DEFAULT NULL,
  `deleted_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
);
```

## Customization

### Custom Validation Rules

**File:** `Modules/Gallery/Http/Controllers/Backend/GalleriesController.php`

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:191|unique:galleries,name',
        'description' => 'nullable|string|max:1000',
        'order' => 'nullable|integer|min:0|max:999',
    ]);
    
    // ... rest of method
}
```

### Custom Views

Override default views by creating files in:
`resources/views/vendor/gallery/`

### Custom Routes

Add custom routes in `Modules/Gallery/routes/web.php`:

```php
Route::get('galleries/{gallery}/download', [GalleriesController::class, 'download'])
    ->name('galleries.download');
```

## Troubleshooting

### Images Not Displaying

**Problem:** Images show broken link icon

**Solution:**
```bash
php artisan storage:link
```

### Permission Denied

**Problem:** "403 Forbidden" when accessing galleries

**Solution:**
1. Check user has `view_galleries` permission
2. Clear permission cache: `php artisan cache:forget spatie.permission.cache`

### GD Extension Error

**Problem:** "GD PHP extension must be installed"

**Solution:**
1. Edit `php.ini`
2. Uncomment: `extension=gd`
3. Restart Apache/Nginx

```

## License

Gallery module is part laravel-starter and follows the same license.

## Support

- **Documentation:** [Gallery Module Docs](https://github.com/nasirkhan/gallery)
- **Issues:** [GitHub Issues](https://github.com/nasirkhan/gallery/issues)
- **Discussions:** [GitHub Discussions](https://github.com/nasirkhan/gallery/discussions)

## Credits

- **Author:** [Nasir Khan](https://github.com/nasirkhan)
- **Project:** [Gallery Module](https://github.com/nasirkhan/gallery)
- **Maintainer:** [Nasir Khan](https://github.com/nasirkhan)
