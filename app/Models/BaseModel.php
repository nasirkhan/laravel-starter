<?php

namespace App\Models;

use App\Models\Traits\HasHashedMediaTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BaseModel extends Model implements HasMedia
{
    use HasHashedMediaTrait;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Create Converted copies of uploaded images.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->quality(70);

        $this->addMediaConversion('thumb300')
            ->width(300)
            ->height(300)
            ->quality(70);
    }

    /**
     * Get the list of all the Columns of the table.
     *
     * @return array Column names array
     */
    public function getTableColumns()
    {
        $table_name = DB::getTablePrefix().$this->getTable();

        return DB::select('SHOW COLUMNS FROM '.$table_name);
    }

    /**
     * Get Status Label.
     */
    public function getStatusLabelAttribute()
    {
        $return_string = '';

        switch ($this->attributes['status']) {
            case '0':
                $return_string = '<span class="badge bg-danger">Inactive</span>';
                break;

            case '1':
                $return_string = '<span class="badge bg-success">Active</span>';
                break;

            case '2':
                $return_string = '<span class="badge bg-warning text-dark">Pending</span>';
                break;

            default:
                $return_string = '<span class="badge bg-primary">Status:'.$this->status.'</span>';
                break;
        }

        return $return_string;
    }

    /**
     * Get Status Label.
     */
    public function getStatusLabelTextAttribute()
    {
        $return_string = '';

        switch ($this->attributes['status']) {
            case '0':
                $return_string = 'Inactive';
                break;

            case '1':
                $return_string = 'Active';
                break;

            case '2':
                $return_string = 'Pending';
                break;

            default:
                $return_string = $this->status;
                break;
        }

        return $return_string;
    }

    /**
     *  Set 'Name' attribute value.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    /**
     * Set the 'Slug'.
     * If no value submitted 'Name' will be used as slug
     * str_slug helper method was used to format the text.
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = slug_format(trim($value));

        if (empty($value)) {
            $this->attributes['slug'] = slug_format(trim($this->attributes['name']));
        }
    }

    protected static function boot()
    {
        parent::boot();

        // create a event to happen on creating
        static::creating(function ($table) {
            $table->created_by = Auth::id();
            $table->created_at = Carbon::now();
        });

        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on saving
        static::saving(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on deleting
        static::deleting(function ($table) {
            $table->deleted_by = Auth::id();
            $table->save();
        });
    }

    /**
     * Set the 'meta title'.
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaTitleAttribute($value)
    {
        $this->attributes['meta_title'] = $value;

        if (empty($value)) {
            $this->attributes['meta_title'] = $this->attributes['name'];
        }
    }

    /**
     * Set the 'meta description'
     * If no value submitted use the default 'meta_description'.
     *
     * @param [type]
     */
    public function setMetaDescriptionAttribute($value)
    {
        $this->attributes['meta_description'] = $value;

        if (empty($value)) {
            $this->attributes['meta_description'] = setting('meta_description');
        }
    }

    /**
     * Set the 'meta description'
     * If no value submitted use the default 'meta_description'.
     *
     * @param [type]
     */
    public function setMetaKeywordAttribute($value)
    {
        $this->attributes['meta_keyword'] = $value;

        if (empty($value)) {
            $this->attributes['meta_keyword'] = setting('meta_keyword');
        }
    }

    /**
     * Set the meta meta_og_image
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaOgImageAttribute($value)
    {
        $this->attributes['meta_og_image'] = $value;

        if (empty($value)) {
            if (isset($this->attributes['image'])) {
                $this->attributes['meta_og_image'] = $this->attributes['image'];
            } else {
                $this->attributes['meta_og_image'] = setting('meta_image');
            }
        }
    }
}
