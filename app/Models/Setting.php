<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends BaseModel
{
    use SoftDeletes;

    protected $table = 'settings';

    /**
     * Add a settings value.
     *
     * @param $key
     * @param $val
     * @param string $type
     *
     * @return bool
     */
    public static function add($key, $val, $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a settings value.
     *
     * @param $key
     * @param null $default
     *
     * @return bool|int|mixed
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
     * Set a value for setting.
     *
     * @param $key
     * @param $val
     * @param string $type
     *
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'val'  => $val,
                'type' => $type, ]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting.
     *
     * @param $key
     *
     * @return bool
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists.
     *
     * @param $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return (bool) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get the validation rules for setting fields.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get the data type of a setting.
     *
     * @param $field
     *
     * @return mixed
     */
    public static function getDataType($field)
    {
        $type = self::getDefinedSettingFields()
                ->pluck('data', 'name')
                ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get default value for a setting.
     *
     * @param $field
     *
     * @return mixed
     */
    public static function getDefaultValueForField($field)
    {
        return self::getDefinedSettingFields()
                ->pluck('value', 'name')
                ->get($field);
    }

    /**
     * Get default value from config if no value passed.
     *
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    private static function getDefaultValue($key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Get all the settings fields from config.
     *
     * @return Collection
     */
    private static function getDefinedSettingFields()
    {
        return collect(config('setting_fields'))->pluck('elements')->flatten(1);
    }

    /**
     * caste value into respective type.
     *
     * @param $val
     * @param $castTo
     *
     * @return bool|int
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

    /**
     * Get all the settings.
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
        return \Cache::rememberForever('settings.all', function () {
            return self::all();
        });
    }

    /**
     * Flush the cache.
     */
    public static function flushCache()
    {
        \Cache::forget('settings.all');
    }

    /**
     * The "booting" method of the model.
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
}
