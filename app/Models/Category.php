<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

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

    /**
     * Caegories has Many posts.
     *
     * @return [type] [description]
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Show the Status in a more readable way.
     *
     * @param type $value
     *
     * @return type
     */
    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 0:
            $return_value = 'Inactive';
            break;
            case 1:
            $return_value = 'Active';
            break;
            case 2:
            $return_value = 'Submitted';
            break;
            default:
            $return_value = $value;
        }

        return $return_value;
    }

    /**
     *  set post 'Title' and update the 'slug'.
     *
     * @param [type]
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim(title_case($value));
    }

    /**
     * Set the 'Slug'.
     * If no value submitted 'Title' will be used as slug
     * str_slug helper method was used to format the text.
     *
     * @param [type]
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_slug(trim($value));

        if (empty($value)) {
            $this->attributes['code'] = str_slug(trim($this->attributes['name']));
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

    /**
     * a post is belongs to an user.
     *
     * @return type
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
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
