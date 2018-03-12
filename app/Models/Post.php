<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $guarded = [
        'id',
        'updated_at',
    ];

    protected $dates = [
        'published_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on deleting
        static::deleting(function ($table) {
            $table->deleted_by = Auth::id();
        });

        // create a event to happen on saving
        // static::saving(function($table) {
        //     $table->created_by = Auth::id();
        // });

        // create a event to happen on creating
        static::creating(function ($table) {
            $table->created_by = Auth::id();
        });
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category');
    }

    /**
     * Show the Status in a more readable way.
     *
     * @param type $value
     *
     * @return type
     */
    // public function getStatusAttribute($value)
    // {
    //     switch ($value){
    //         case 0:
    //             $return_value = "Unpublished";
    //             break;
    //         case 1:
    //             $return_value = "Published";
    //             break;
    //         case 2:
    //             $return_value = "Draft";
    //             break;
    //         default:
    //             $return_value = $value;
    //     }
    //
    //     return $return_value;
    // }

    /**
     *  set post 'Title' and update the 'slug'.
     *
     * @param [type]
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = $value;

        try {
            $category = Category::findOrFail($value);
            $this->attributes['category'] = $category->name;
        } catch (\Exception $e) {
            $this->attributes['category'] = null;
        }
    }

    /**
     * Set the 'Slug'.
     * If no value submitted 'Title' will be used as slug
     * str_slug helper method was used to format the text.
     *
     * @param [type]
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug(trim($value));

        if (empty($value)) {
            $this->attributes['slug'] = str_slug(trim($this->attributes['title']));
        }
    }

    /**
     * Set the 'meta title'.
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaTitleAttribute($value)
    {
        $this->attributes['meta_title'] = trim(title_case($value));

        if (empty($value)) {
            $this->attributes['meta_title'] = trim(title_case($this->attributes['title']));
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
            $this->attributes['meta_description'] = config('settings.meta_description');
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
            $this->attributes['meta_og_image'] = config('settings.meta_og_image');
        }
    }

    /**
     * Set the published at
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value;

        if (empty($value) && $this->attributes['status'] == 1) {
            $this->attributes['published_at'] = Carbon::now();
        }
    }

    public function scopePublished($query)
    {
        return $query->where('status', '=', '1')
                        ->whereDate('published_at', '<=', Carbon::today()->toDateString());
    }

    public function scopeRecentlyPublished($query)
    {
        return $query->where('status', '=', '1')
                        ->whereDate('published_at', '<=', Carbon::today()->toDateString())
                        ->orderBy('published_at', 'desc');
    }

    /**
     * Get the list of all the Columns of the table.
     *
     * @return array Column names array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
