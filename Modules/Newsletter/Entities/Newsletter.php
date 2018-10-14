<?php

namespace Modules\Article\Entities;

use App\Models\BaseModel;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends BaseModel
{
    use SoftDeletes;

    protected $table = 'newsletters';

    protected $dates = [
        'deleted_at',
        'published_at',
        'delivered_at',
    ];

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
     * Set the 'meta title'.
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaTitleAttribute($value)
    {
        $this->attributes['meta_title'] = $value;

        if (empty($value)) {
            $this->attributes['meta_title'] = $this->attributes['name'];
        }
    }

    /**
     * Set the 'meta description'
     * If no value submitted use the default 'meta_description'.
     *
     * @param [type]
     */
    public function setMetaDescriptionAttribute($value)
    {
        $this->attributes['meta_description'] = $value;

        if (empty($value)) {
            $this->attributes['meta_description'] = config('settings.meta_description');
        }
    }

    /**
     * Set the meta meta_og_image
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setMetaOgImageAttribute($value)
    {
        $this->attributes['meta_og_image'] = $value;

        if (empty($value)) {
            $this->attributes['meta_og_image'] = config('settings.meta_og_image');
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
     * Set the published at
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function setRoleIdAttribute($value)
    {
        if ($value == 0) {
        } else {
            $this->attributes['role_id'] = $value;

            $this->attributes['role_name'] = Role::findOrFail($value)->name;
        }
    }

    /**
     * Get the list of Published Newsletters.
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
     * Newsletters which are have not dispatched yet.
     *
     * @param [type] $query [description]
     *
     * @return [type] [description]
     */
    public function scopeNotDelivered($query)
    {
        return $query->whereNull('delivered_at')
                        ->where('status', '=', '1')
                        ->whereDate('published_at', '<=', Carbon::today()->toDateString());
    }
}
