<?php

namespace App\Models;

use App\Models\Presenters\UserPresenter;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use HasMediaTrait;
    use UserPresenter;
    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method',
        'password_confirmation',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providers()
    {
        return $this->hasMany('App\Models\UserProvider');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Userprofile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userprofile()
    {
        return $this->hasOne('App\Models\Userprofile');
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the list of users related to the current User.
     *
     * @return [array] roels
     */
    public function getRolesListAttribute()
    {
        return array_map('intval', $this->roles->pluck('id')->toArray());
    }

    /**
     *
     * Cache Permissions
     *
     */
    public function getPermissionsAttribute()
    {
        $permissions = Cache::rememberForever('permissions_cache', function () {
            return Permission::select('permissions.*', 'model_has_permissions.*')
            ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
            ->get();
        });

        return $permissions->where('model_id', $this->id);
    }

    /**
     *
     * Cache Roles
     *
     */
    public function getRolesAttribute()
    {
        $roles = Cache::rememberForever('roles_cache', function () {
            return Role::select('roles.*', 'model_has_roles.*')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->get();
        });

        return $roles->where('model_id', $this->id);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return env('SLACK_NOTIFICATION_WEBHOOK');
    }
}
