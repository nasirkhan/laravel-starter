<?php

namespace App\Models;

class Userprofile extends BaseModel
{
    protected $dates = [
        'date_of_birth',
        'last_login',
        'email_verified_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
