<?php

namespace App\Models;

class Userprofile extends BaseModel
{
    protected $casts = [
        'date_of_birth' => 'datetime',
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

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
