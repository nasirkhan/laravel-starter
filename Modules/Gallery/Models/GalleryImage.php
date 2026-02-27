<?php

namespace Modules\Gallery\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'gallery_images';

    protected $fillable = [
        'gallery_id',
        'image_path',
        'thumbnail_path',
        'title',
        'description',
        'alt_text',
        'order',
        'is_featured',
        'width',
        'height',
        'file_size',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Get the gallery that owns the image
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        return asset($this->image_path);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset($this->thumbnail_path) : $this->image_url;
    }
}
