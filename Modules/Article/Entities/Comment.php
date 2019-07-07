<?php

namespace Modules\Article\Entities;

use App\Models\BaseModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends BaseModel
{
    use LogsActivity, SoftDeletes;

    protected $table = 'comments';

    protected static $logName = 'comments';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['post_id', 'user_id', 'name', 'comment', 'published_at', 'moderated_at', 'moderated_by', 'status'];

    protected $dates = [
        'deleted_at',
        'published_at',
        'moderated_at',
    ];

    public function post()
    {
        return $this->belongsTo('Modules\Article\Entities\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Purifiy Name field value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = clean($value);
    }

    /**
     * Purifiy Comment field value
     */
    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = clean($value);
    }

    public function setPostIdAttribute($value)
    {
        $this->attributes['post_id'] = $value;

        $this->attributes['post_name'] = Post::findOrFail($value)->name;
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;

        $this->attributes['user_name'] = User::findOrFail($value)->name;
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

    public function setModeratedAtAttribute($value)
    {
        $this->attributes['moderated_at'] = $value;

        if (empty($value)) {
            $this->attributes['moderated_at'] = Carbon::now();
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
