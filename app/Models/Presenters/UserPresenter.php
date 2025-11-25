<?php

namespace App\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;

/**
 * Presenter Class for Book Module.
 */
trait UserPresenter
{
    /**
     * Get User Avatar.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value == '') ? '/img/default-avatar.jpg' : $value,
        );
    }

    /**
     * Get Status Label.
     */
    public function getStatusLabelAttribute()
    {
        $return_string = '';
        switch ($this->status) {
            case '1':
                $return_string = '<span class="badge text-bg-success">Active</span>';
                break;

            case '2':
                $return_string = '<span class="badge text-bg-danger">Blocked</span>';
                break;

            default:
                $return_string = '<span class="badge text-bg-primary">Status:'.$this->status.'</span>';
                break;
        }

        return $return_string;
    }

    /**
     * Retrieves the label for the "confirmed" attribute.
     *
     * @return string The HTML label for the "confirmed" attribute.
     */
    public function getConfirmedLabelAttribute()
    {
        if ($this->email_verified_at !== null) {
            return '<span class="badge text-bg-primary">Confirmed</span>';
        }

        return '<span class="badge text-bg-danger">Not Confirmed</span>';
    }

    /**
     * Cache Permissions Query.
     */
    public function getPermissionsAttribute()
    {
        $lastUpdated = \Illuminate\Support\Facades\Cache::get('spatie_permissions_last_updated', 'never');
        $cacheKey = 'permissions_user_'.$this->id.'_'.$lastUpdated;

        // Check cache first
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // If relation is loaded (via eager loading), cache it and return
        if ($this->relationLoaded('permissions')) {
            $permissions = $this->getRelation('permissions');
            Cache::forever($cacheKey, $permissions);

            return $permissions;
        }

        // Otherwise, query and cache
        return Cache::rememberForever($cacheKey, function () {
            return $this->permissions()->get();
        });
    }

    /**
     * Get the user's roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRolesAttribute()
    {
        $lastUpdated = \Illuminate\Support\Facades\Cache::get('spatie_permissions_last_updated', 'never');
        $cacheKey = 'roles_user_'.$this->id.'_'.$lastUpdated;

        // Check cache first
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // If relation is loaded (via eager loading), cache it and return
        if ($this->relationLoaded('roles')) {
            $roles = $this->getRelation('roles');
            Cache::forever($cacheKey, $roles);

            return $roles;
        }

        // Otherwise, query and cache
        return Cache::rememberForever($cacheKey, function () {
            return $this->roles()->with('permissions')->get();
        });
    }

    /**
     * Get the list of users related to the current User.
     */
    public function getRolesListAttribute(): array
    {
        return $this->roles->pluck('id')->map(fn ($id) => (int) $id)->toArray();
    }

    public function setNameAttribute($value)
    {
        $value = ucwords(strtolower($value));
        $this->attributes['name'] = $value;

        $name_parts = split_name($value);
        $this->attributes['first_name'] = $name_parts[0];
        $this->attributes['last_name'] = $name_parts[1];
    }

    /**
     * Array keys for social_profiles field.
     */
    public static function socialFieldsNames()
    {
        return [
            'website_url',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'youtube_url',
            'linkedin_url',
        ];
    }

    public function getUrlWebsiteAttribute()
    {
        return $this->social_profiles['website_url'] ?? null;
    }

    public function getUrlFacebookAttribute()
    {
        return $this->social_profiles['facebook_url'] ?? null;
    }

    public function getUrlTwitterAttribute()
    {
        return $this->social_profiles['twitter_url'] ?? null;
    }

    public function getUrlInstagramAttribute()
    {
        return $this->social_profiles['instagram_url'] ?? null;
    }

    public function getUrlLinkedinAttribute()
    {
        return $this->social_profiles['linkedin_url'] ?? null;
    }

    public function getUrlYoutubeAttribute()
    {
        return $this->social_profiles['youtube_url'] ?? null;
    }
}
