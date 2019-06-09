<?php

namespace Modules\Article\Entities;

use App\Models\BaseModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Entities\Post;

class Comment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'comments';

    public function post()
    {
        return $this->belongsTo('Modules\Article\Entities\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function setPostIdAttribute($value)
    {
        $this->attributes['post_id'] = $value;

        $this->attributes['post_name'] = Post::findOrFail($value)->title;
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;

        $this->attributes['user_name'] = User::findOrFail($value)->name;
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
            $this->attributes['slug'] = str_slug(trim($this->attributes['name']));
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
                        ->whereDate('published_at', '<=', Carbon::today()->toDateString());
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
