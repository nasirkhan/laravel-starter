<?php

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_url')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_url()
    {
        return config('app.url');
    }
}

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('user_registration')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function user_registration()
    {
        $user_registration = config('app.user_registration');

        if (env('USER_REGISTRATION') === true) {
            $user_registration = true;
        }

        return $user_registration;
    }
}

/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('label_case')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));

        return preg_replace('!\s+!', ' ', $new_text);
    }
}

/*
 *
 * show_column_value
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('show_column_value')) {
    /**
     * Generates the function comment for the given function.
     *
     * @param  string  $valueObject  Model Object
     * @param  string  $column  Column Name
     * @param  string  $return_format  Return Type
     * @param  mixed  $valueObject  The value object.
     * @param  mixed  $column  The column.
     * @param  string  $return_format  The return format. Default is empty string.
     * @return string Raw/Formatted Column Value
     * @return mixed The column value or formatted value.
     */
    function show_column_value($valueObject, $column, $return_format = '')
    {
        $column_name = $column->name;
        $column_type = $column->type;

        $value = $valueObject->$column_name;

        if (! $value) {
            return $value;
        }

        if ($return_format === 'raw') {
            return $value;
        }

        if (($column_type === 'date') && $value !== '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LL');
        }
        if (($column_type === 'datetime' || $column_type === 'timestamp') && $value !== '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LLLL');
        }
        if ($column_type === 'json') {
            $return_text = json_encode($value);
        } elseif ($column_type !== 'json' && \Illuminate\Support\Str::endsWith(strtolower($value), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $img_path = asset($value);

            $return_text = '<figure class="figure">
                                <a href="'.$img_path.'" data-lightbox="image-set" data-title="Path: '.$value.'">
                                    <img src="'.$img_path.'" style="max-width:200px;" class="figure-img img-fluid rounded img-thumbnail" alt="">
                                </a>
                                <figcaption class="figure-caption">Path: '.$value.'</figcaption>
                            </figure>';
        } else {
            $return_text = $value;
        }

        return $return_text;
    }
}

/*
 *
 * field_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('field_required')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function field_required($required)
    {
        $return_text = '';

        if ($required !== '') {
            $return_text = '&nbsp;<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}

/**
 * Get or Set the Settings Values.
 */
if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new App\Models\Setting;
        }

        if (is_array($key)) {
            return App\Models\Setting::set($key[0], $key[1]);
        }

        $value = App\Models\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

/*
 * Show Human readable file size
 */
if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;

        while ($size / $step > 0.9) {
            $size /= $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}

/*
 *
 * Encode Id to a Hashids / Sqids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('encode_id')) {
    /**
     * Encode Id to a Hashids / Sqids.
     */
    function encode_id($id)
    {
        $sqids = new Sqids\Sqids(alphabet: 'abcdefghijklmnopqrstuvwxyz123456789');

        return $sqids->encode([$id]);
    }
}

/*
 *
 * Decode Id from Hashids / Sqids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('decode_id')) {
    /**
     * Decode Id from Hashids / Sqids.
     */
    function decode_id($hashid)
    {
        $sqids = new Sqids\Sqids(alphabet: 'abcdefghijklmnopqrstuvwxyz123456789');
        $id = $sqids->decode($hashid);

        if (count($id)) {
            return $id[0];
        }
        abort(404);
    }
}

/*
 *
 * Prepare a Slug for a given string
 * Laravel default str_slug does not work for Unicode
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('slug_format')) {
    /**
     * Format a string to Slug.
     */
    function slug_format($string)
    {
        $base_string = $string;

        $string = preg_replace('/\s+/u', '-', trim($string));
        $string = str_replace('/', '-', $string);
        $string = str_replace('\\', '-', $string);
        $string = strtolower($string);

        return substr($string, 0, 190);
    }
}

/*
 *
 * icon
 * A short and easy way to show icon fornts
 * Default value will be check icon from FontAwesome (https://fontawesome.com)
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('icon')) {
    /**
     * Format a string to Slug.
     */
    function icon($string = 'fa-regular fa-circle-check')
    {
        return "<i class='".$string."'></i>&nbsp;";
    }
}

/*
 *
 * logUserAccess
 * Get current user's `name` and `id` and
 * log as debug data. Additional text can be added too.
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('logUserAccess')) {
    /**
     * Format a string to Slug.
     */
    function logUserAccess($text = '')
    {
        $auth_text = '';

        if (\Auth::check()) {
            $auth_text = 'User:'.\Auth::user()->name.' (ID:'.\Auth::user()->id.')';
        }

        \Log::debug(label_case($text)." | {$auth_text}");
    }
}

/*
 *
 * bn2enNumber
 * Convert a Bengali number to English
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('bn2enNumber')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function bn2enNumber($number)
    {
        $search_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $replace_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        return str_replace($search_array, $replace_array, $number);
    }
}

/*
 *
 * bn2enNumber
 * Convert a English number to Bengali
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('en2bnNumber')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function en2bnNumber($number)
    {
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];

        return str_replace($search_array, $replace_array, $number);
    }
}

/*
 *
 * bn2enNumber
 * Convert a English number to Bengali
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('en2bnDate')) {
    /**
     * Convert a English number to Bengali.
     */
    function en2bnDate($date)
    {
        // Convert numbers
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];
        $bn_date = str_replace($search_array, $replace_array, $date);

        // Convert Short Week Day Names
        $search_array = ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'];
        $replace_array = ['শুক্র', 'শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহঃ'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert Month Names
        $search_array = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $replace_array = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert Short Month Names
        $search_array = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $replace_array = ['জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        $bn_date = str_replace($search_array, $replace_array, $bn_date);

        // Convert AM-PM
        $search_array = ['am', 'pm', 'AM', 'PM'];
        $replace_array = ['পূর্বাহ্ন', 'অপরাহ্ন', 'পূর্বাহ্ন', 'অপরাহ্ন'];

        return str_replace($search_array, $replace_array, $bn_date);
    }
}

/*
 *
 * banglaDate
 * Get the Date of Bengali Calendar from the Gregorian Calendar
 * By default is will return the Today's Date
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('banglaDate')) {
    function banglaDate($date_input = '')
    {
        if ($date_input === '') {
            $date_input = date('Y-m-d');
        }

        $date_input = strtotime($date_input);

        $en_day = intval(date('j', $date_input));
        $en_month = intval(date('n', $date_input));
        $en_year = intval(date('Y', $date_input));

        $bn_month_days = [30, 30, 30, 30, 31, 31, 31, 31, 31, 31, 29, 30];
        $bn_month_middate = [13, 12, 14, 13, 14, 14, 15, 15, 15, 16, 14, 14];
        $bn_months = ['পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র', 'বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ'];

        // Day & Month
        if ($en_day <= $bn_month_middate[$en_month - 1]) {
            $bn_day = $en_day + $bn_month_days[$en_month - 1] - $bn_month_middate[$en_month - 1];
            $bn_month = $bn_months[$en_month - 1];

            // Leap Year
            if (($en_year % 400 === 0 || ($en_year % 100 !== 0 && $en_year % 4 === 0)) && $en_month === 3) {
                $bn_day += 1;
            }
        } else {
            $bn_day = $en_day - $bn_month_middate[$en_month - 1];
            $bn_month = $bn_months[$en_month % 12];
        }

        // Year
        $bn_year = $en_year - 593;
        if (($en_year < 4) || (($en_year === 4) && (($en_day < 14) || ($en_day === 14)))) {
            $bn_year -= 1;
        }

        $return_bn_date = $bn_day.' '.$bn_month.' '.$bn_year;

        return en2bnNumber($return_bn_date);
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('generate_rgb_code')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function generate_rgb_code($opacity = '0.9')
    {
        $str = '';
        for ($i = 1; $i <= 3; $i++) {
            $num = mt_rand(0, 255);
            $str .= "{$num},";
        }
        $str .= "{$opacity},";

        return substr($str, 0, -1);
    }
}

/*
 *
 * Return Date with weekday
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('date_today')) {
    /**
     * Return Date with weekday.
     *
     * Carbon Locale will be considered here
     * Example:
     * শুক্রবার, ২৪ জুলাই ২০২০
     * Friday, July 24, 2020
     */
    function date_today()
    {
        return \Carbon\Carbon::now()->isoFormat('dddd, LL');
    }
}

if (! function_exists('language_direction')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function language_direction($language = null)
    {
        if (empty($language)) {
            $language = app()->getLocale();
        }
        $language = strtolower(substr($language, 0, 2));
        $rtlLanguages = [
            'ar', //  'العربية', Arabic
            'arc', //  'ܐܪܡܝܐ', Aramaic
            'bcc', //  'بلوچی مکرانی', Southern Balochi
            'bqi', //  'بختياري', Bakthiari
            'ckb', //  'Soranî / کوردی', Sorani Kurdish
            'dv', //  'ދިވެހިބަސް', Dhivehi
            'fa', //  'فارسی', Persian
            'glk', //  'گیلکی', Gilaki
            'he', //  'עברית', Hebrew
            'lrc', //- 'لوری', Northern Luri
            'mzn', //  'مازِرونی', Mazanderani
            'pnb', //  'پنجابی', Western Punjabi
            'ps', //  'پښتو', Pashto
            'sd', //  'سنڌي', Sindhi
            'ug', //  'Uyghurche / ئۇيغۇرچە', Uyghur
            'ur', //  'اردو', Urdu
            'yi', //  'ייִדיש', Yiddish
        ];
        if (in_array($language, $rtlLanguages)) {
            return 'rtl';
        }

        return 'ltr';
    }
}

/*
 * Application Demo Mode check
 */
if (! function_exists('demo_mode')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function demo_mode()
    {
        $return_string = false;

        if (env('DEMO_MODE') === true) {
            $return_string = true;
        }

        return $return_string;
    }
}

/*
 * Split Name to First Name and Last Name
 */
if (! function_exists('split_name')) {
    /**
     * Split Name to First Name and Last Name.
     *
     * @return mixed
     */
    function split_name($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#'.preg_quote($last_name, '#').'#', '', $name));

        return [$first_name, $last_name];
    }
}
