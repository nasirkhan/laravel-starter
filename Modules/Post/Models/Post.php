<?php

namespace Modules\Post\Models;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Modules\Post\Enums\PostStatus;
use Modules\Post\Models\Presenters\PostPresenter;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;
    use PostPresenter;
    use SoftDeletes;

    protected $table = 'posts';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->table);
    }

    public function category()
    {
        return $this->belongsTo('Modules\Category\Models\Category');
    }

    public function tags()
    {
        return $this->morphToMany('Modules\Tag\Models\Tag', 'taggable');
    }

    public function scopePublishedAndScheduled($query)
    {
        return $query->where('status', '=', PostStatus::Published->value);
    }

    /**
     * Get the list of Published Articles.
     *
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopePublished($query)
    {
        return $query->publishedAndScheduled()->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query)
    {
        return $query->publishedAndScheduled()->where('is_featured', '=', 'Yes');
    }

    /**
     * Get the list of Recently Published Articles.
     *
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopeRecentlyPublished($query)
    {
        return $query->publishedAndScheduled()->orderBy('published_at', 'desc');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Post\database\factories\PostFactory::new();
    }
}
