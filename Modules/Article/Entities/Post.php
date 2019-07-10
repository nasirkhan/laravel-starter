<?php

namespace Modules\Article\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Entities\Presenters\PostPresenter;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends BaseModel
{
    use LogsActivity, SoftDeletes, PostPresenter;

    protected $table = 'posts';

    protected static $logName = 'posts';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'intro', 'content', 'type', 'category_id', 'category_name', 'is_featured', 'meta_title', 'meta_keywords', 'meta_description', 'published_at', 'moderated_at', 'moderated_by', 'status'];

    public function category()
    {
        return $this->belongsTo('Modules\Article\Entities\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('Modules\Article\Entities\Tag');
    }

    /**
     * All Published Comments.
     */
    public function comments()
    {
        return $this->hasMany('Modules\Article\Entities\Comment')->where('status', '=', 1);
    }

    /**
     * All the Published and Unpublished Comments.
     */
    public function comments_all()
    {
        return $this->hasMany('Modules\Article\Entities\Comment');
    }

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = $value;

        try {
            $category = Category::findOrFail($value);
            $this->attributes['category_name'] = $category->name;
        } catch (\Exception $e) {
            $this->attributes['category_name'] = null;
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
            $this->attributes['meta_title'] = trim(title_case($this->attributes['name']));
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
     * Get the list of Published Articles.
     *
     * @param [type] $query [description]
     *
     * @return [type] [description]
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', '1')
                        ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Get the list of Recently Published Articles.
     *
     * @param [type] $query [description]
     *
     * @return [type] [description]
     */
    public function scopeRecentlyPublished($query)
    {
        return $query->where('status', '=', '1')
                        ->whereDate('published_at', '<=', Carbon::today()->toDateString())
                        ->orderBy('published_at', 'desc');
    }
}
