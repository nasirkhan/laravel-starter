<?php

namespace App\Models\Presenters;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

/**
 * Presenter Class for Book Module.
 */
trait UserPresenter
{
    /**
     * Get Status Label.
     *
     * @return [type] [description]
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
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

    /**
     * Get Status Label.
     *
     * @return [type] [description]
     */
    public function getConfirmedLabelAttribute()
    {
        if ($this->email_verified_at != null) {
            return '<span class="badge badge-success">Confirmed</span>';
        } else {
            return '<span class="badge badge-danger">Not Confirmed</span>';
        }
    }

    /**
     *
     * Cache Permissions Query
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
     * Cache Roles Query
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
}
