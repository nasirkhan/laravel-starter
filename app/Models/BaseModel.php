<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Access\User\User;

class BaseModel extends Model
{

    use SoftDeletes;

    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method'
    ];

    protected $dates = [
        'deleted_at',
        'published_at',
    ];

    protected static function boot() {
        parent::boot();

        // create a event to happen on creating
        static::creating(function($table) {
            $table->created_by = Auth::id();
            $table->created_at = Carbon::now()->toDateTimeString();
        });

        // create a event to happen on updating
        static::updating(function($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on saving
        static::saving(function($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on deleting
        static::deleting(function($table) {
            $table->deleted_by = Auth::id();
            $table->save();
        });
    }

    /**
     * Get the list of all the Columns of the table
     *
     * @return Array Column names array
     */
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}
