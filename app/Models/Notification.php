<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the list of all the Columns of the table.
     *
     * @return array Column names array
     */
    public function getTableColumns()
    {
        return DB::select(strval(DB::raw('SHOW COLUMNS FROM '.$this->getTable())));
    }
}
