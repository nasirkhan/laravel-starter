<?php

namespace Modules\Category\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Enums\CategoryStatus;

class Category extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => CategoryStatus::class,
        ]);
    }

    /**
     * Override the active scope to work with CategoryStatus enum.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', CategoryStatus::Active->value);
    }

    /**
     * Categories has Many posts.
     */
    public function posts()
    {
        return $this->hasMany('Modules\Post\Models\Post');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Category\database\factories\CategoryFactory::new();
    }
}
