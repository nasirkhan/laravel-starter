<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Setting extends BaseModel
{
    use SoftDeletes;

    protected $table = 'settings';

    /**
     * Adds a key-value pair to the data store.
     *
     * @param  mixed  $key  The key to add.
     * @param  mixed  $val  The value to associate with the key.
     * @param  string  $type  (optional) The data type of the value. Default is 'string'.
     * @return mixed The added value if successful, false otherwise.
     */
    public static function add($key, $val, $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Retrieves the value of a setting based on the provided key.
     *
     * @param  string  $key  The key of the setting to retrieve.
     * @param  mixed  $default  The default value to return if the setting does not exist.
     * @return mixed The value of the setting.
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)) {
            $setting = self::getAllSettings()->where('name', $key)->first();

            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($key, $default);
    }

    /**
     * Updates or adds a setting value in the database.
     *
     * @param  string  $key  The name of the setting.
     * @param  mixed  $val  The value to be set for the setting.
     * @param  string  $type  The data type of the setting.
     * @return mixed The updated or added value if successful, false otherwise.
     */
    public static function set($key, $val, $type = 'string')
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'val' => $val,
                'type' => $type,
            ]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Removes an item from the collection if it exists.
     *
     * @param  string  $key  the key of the item to be removed
     * @return bool true if the item was successfully removed, false otherwise
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Checks if a key exists in the settings.
     *
     * @param  mixed  $key  The key to check.
     * @return bool Returns true if the key exists, false otherwise.
     */
    public static function has($key)
    {
        return (bool) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Retrieves the validation rules for the defined setting fields.
     *
     * @return array An array of validation rules, where the keys are the field names and the values are the rules.
     */
    public static function getValidationRules()
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Retrieves the data type of a given field.
     *
     * @param  mixed  $field  The name of the field.
     * @return string The data type of the field. It returns 'string' if the data type is not defined.
     *
     * @throws None
     */
    public static function getDataType($field)
    {
        $type = self::getDefinedSettingFields()
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get the default value for a given field.
     *
     * @param  string  $field  The name of the field.
     * @return mixed|null The default value of the field, or null if not found.
     */
    public static function getDefaultValueForField($field)
    {
        return self::getDefinedSettingFields()
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * Get all settings from the cache or fetch them from the database.
     *
     * @return array an array of all the settings.
     *
     * @throws \Exception if there is an error retrieving the settings.
     */
    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function () {
            return self::all();
        });
    }

    /**
     * Flushes the cache for the specified key.
     *
     * @param  string  $key  The cache key to be flushed.
     * @return void
     *
     * @throws \Exception If an error occurs while flushing the cache.
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }

    /**
     * Get the default value for a given key.
     *
     * @param  mixed  $key  The key to get the default value for.
     * @param  mixed  $default  The default value to return if the key has no value.
     * @return mixed The default value or the value of the key.
     */
    private static function getDefaultValue($key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Retrieves the defined setting fields.
     *
     * @return Collection The collection of defined setting fields.
     */
    private static function getDefinedSettingFields()
    {
        return collect(config('setting_fields'))->pluck('elements')->flatten(1);
    }

    /**
     * Casts a value to a specified data type.
     *
     * @param  mixed  $val  the value to cast
     * @param  string  $castTo  the data type to cast the value to
     * @return mixed the casted value
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }
}
