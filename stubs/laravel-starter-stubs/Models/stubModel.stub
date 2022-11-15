<?php

namespace {{namespace}}\{{moduleName}}\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class {{moduleName}} extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = '{{moduleNameLowerPlural}}';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \{{namespace}}\{{moduleName}}\database\factories\{{moduleName}}Factory::new();
    }
}
