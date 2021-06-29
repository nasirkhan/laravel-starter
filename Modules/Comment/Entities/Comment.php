<?php

namespace Modules\Comment\Entities;

use App\Models\BaseModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Comment\Entities\Presenters\CommentPresenter;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use CommentPresenter;
    use SoftDeletes;

    protected $table = 'comments';

    protected static $logName = 'comments';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['parent_id', 'user_id', 'name', 'comment', 'published_at', 'moderated_at', 'moderated_by', 'status'];

    protected $dates = [
        'deleted_at',
        'published_at',
        'moderated_at',
    ];

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getPostAttribute()
    {
        if ($this->commentable_type == 'Modules\Article\Entities\Post') {
            return $this->commentable;
        } else {
            return [];
        }
    }

    public function getModuleNameAttribute()
    {
        if ($this->commentable_type == 'Modules\Article\Entities\Post') {
            return 'posts';
        } else {
            return '';
        }
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Comment\Entities\Comment', 'parent_id');
    }

    /**
     * Purifiy Comment field value.
     */
    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = clean($value);
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;

        if ($value) {
            $this->attributes['user_name'] = User::findOrFail($value)->name;
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
                        ->whereDate('published_at', '<=', Carbon::today()
                        ->toDateString());
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

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Comment\Database\Factories\CommentFactory::new();
    }
}
