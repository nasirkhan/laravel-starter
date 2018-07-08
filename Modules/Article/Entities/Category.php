<?php

namespace Modules\Article\Entities;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes;

    protected $table = 'categories';

    /**
     * Caegories has Many posts.
     */
    public function posts()
    {
        return $this->hasMany('Modules\Article\Entities\Post');
    }

    /**
     * Set the 'Slug'.
     * If no value submitted 'Title' will be used as slug
     * str_slug helper method was used to format the text.
     *
     * @param [type]
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_slug(trim($value));

        if (empty($value)) {
            $this->attributes['code'] = str_slug(trim($this->attributes['name']));
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
}
