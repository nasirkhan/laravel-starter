<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class BaseModel extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method',
    ];

    protected $dates = [
        'deleted_at',
        'published_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // create a event to happen on creating
        static::creating(function ($table) {
            $table->created_by = Auth::id();
            $table->created_at = Carbon::now()->toDateTimeString();
        });

        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on saving
        static::saving(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on deleting
        static::deleting(function ($table) {
            $table->deleted_by = Auth::id();
            $table->save();
        });
    }

    /**
     * Create Converted copies of uploaded images
     *
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(250)
              ->height(250)
              ->quality(70);

        $this->addMediaConversion('thumb300')
              ->width(300)
              ->height(300)
              ->quality(70);
    }

    /**
     * Get the list of all the Columns of the table.
     *
     * @return array Column names array
     */
    public function getTableColumns()
    {
        $table_info_columns = DB::select(DB::raw('SHOW COLUMNS FROM '.$this->getTable()));

        return $table_info_columns;
    }

    /**
     * Get Status Label.
     *
     * @return [type] [description]
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case '0':
                return '<span class="badge badge-danger">Inactive</span>';
                break;

            case '1':
                return '<span class="badge badge-success">Active</span>';
                break;

            case '2':
                return '<span class="badge badge-warning">Blocked</span>';
                break;

            default:
                return '<span class="badge badge-primary">Status:'.$this->status.'</span>';
                break;
        }
    }
}
