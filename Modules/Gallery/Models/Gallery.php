<?php

namespace Modules\Gallery\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Gallery extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'description',
        'slug',
        'galleryable_id',
        'galleryable_type',
        'order',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->table);
    }

    /**
     * Get the parent galleryable model (Post, Page, etc.)
     */
    public function galleryable()
    {
        return $this->morphTo();
    }

    /**
     * Get all images in this gallery
     */
    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('order');
    }

    /**
     * Get the featured/primary image
     */
    public function featuredImage()
    {
        return $this->hasOne(GalleryImage::class)->where('is_featured', true);
    }

    /**
     * Get the user who created this gallery
     */
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    /**
     * Get the user who last updated this gallery
     */
    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

    /**
     * Get active galleries only
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Auto-generate slug when name is set
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->slug)) {
                $gallery->slug = \Illuminate\Support\Str::slug($gallery->name);
            }
        });
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Gallery\database\factories\GalleryFactory::new();
    }
}
