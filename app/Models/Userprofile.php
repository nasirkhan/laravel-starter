<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Userprofile extends BaseModel
{
    protected $dates = [
        'date_of_birth',
        'last_login',
        'confirmed_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
