<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    /**
     * Name should be lowercase.
     *
     * @param string $value Name value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
