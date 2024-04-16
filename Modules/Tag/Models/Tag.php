<?php

namespace Modules\Tag\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tags';

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
