<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * User Provider Model.
 */
class UserProvider extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     */
    protected $table = 'user_providers';

    /**
     * The attributes that are not mass assignable.
     */
    protected $guarded = ['id'];

    /**
     * Retrieves the associated User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
