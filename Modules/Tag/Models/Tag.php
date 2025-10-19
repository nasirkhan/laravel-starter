<?php

namespace Modules\Tag\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tag\Enums\TagStatus;

class Tag extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags';

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => TagStatus::class,
        ]);
    }

    /**
     * Override the active scope to work with TagStatus enum.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', TagStatus::Active->value);
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany('Modules\Post\Models\Post', 'taggable');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tag\database\factories\TagFactory::new();
    }
}
