<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

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
     * Get the list of all the Columns of the table.
     *
     * @return array Column names array
     */
    public function getTableColumns()
    {
        return $this->getConnection()->select(
            (new \Illuminate\Database\Schema\Grammars\MySqlGrammar())->compileColumnListing()
            .' order by ordinal_position',
            [$this->getConnection()->getDatabaseName(), $this->getTable()]
        );
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
