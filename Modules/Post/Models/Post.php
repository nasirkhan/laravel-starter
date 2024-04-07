<?php

namespace Modules\Post\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posts';

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
