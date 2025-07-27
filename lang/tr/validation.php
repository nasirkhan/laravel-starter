<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute kabul edilmelidir.',
    'accepted_if' => ':other :value olduğunda :attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL değil.',
    'after' => ':attribute :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute :date tarihinden sonra veya aynı tarih olmalıdır.',
    'alpha' => ':attribute sadece harfler içerebilir.',
    'alpha_dash' => ':attribute sadece harfler, rakamlar, tireler ve alt çizgiler içerebilir.',
    'alpha_num' => ':attribute sadece harfler ve rakamlar içerebilir.',
    'array' => ':attribute bir dizi olmalıdır.',
    'before' => ':attribute :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute :date tarihinden önce veya aynı tarih olmalıdır.',
    'between' => [
        'array' => ':attribute :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'string' => ':attribute :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed' => ':attribute onayı eşleşmiyor.',
    'current_password' => 'Şifre yanlış.',
    'date' => ':attribute geçerli bir tarih değil.',
    'date_equals' => ':attribute :date tarihine eşit bir tarih olmalıdır.',
    'date_format' => ':attribute :format formatına uymuyor.',
    'declined' => ':attribute reddedilmelidir.',
    'declined_if' => ':other :value olduğunda :attribute reddedilmelidir.',
    'different' => ':attribute ve :other birbirinden farklı olmalıdır.',
    'digits' => ':attribute :digits haneli olmalıdır.',
    'digits_between' => ':attribute :min ile :max arasında haneli olmalıdır.',
    'dimensions' => ':attribute geçersiz resim boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahip.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute şunlardan biriyle bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'file' => ':attribute bir dosya olmalıdır.',
    'filled' => ':attribute alanı bir değere sahip olmalıdır.',
    'gt' => [
        'array' => ':attribute :value öğeden fazla içermelidir.',
        'file' => ':attribute :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute :value değerinden büyük olmalıdır.',
        'string' => ':attribute :value karakterden uzun olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute :value öğe veya daha fazla içermelidir.',
        'file' => ':attribute :value kilobayt veya daha büyük olmalıdır.',
        'numeric' => ':attribute :value değerinden büyük veya eşit olmalıdır.',
        'string' => ':attribute :value karakter veya daha uzun olmalıdır.',
    ],
    'image' => ':attribute bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde mevcut değil.',
    'integer' => ':attribute bir tamsayı olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON dizesi olmalıdır.',
    'lt' => [
        'array' => ':attribute :value öğeden az içermelidir.',
        'file' => ':attribute :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük olmalıdır.',
        'string' => ':attribute :value karakterden kısa olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute :value öğeden fazla içermemelidir.',
        'file' => ':attribute :value kilobayt veya daha küçük olmalıdır.',
        'numeric' => ':attribute :value değerinden küçük veya eşit olmalıdır.',
        'string' => ':attribute :value karakter veya daha kısa olmalıdır.',
    ],
    'mac_address' => ':attribute geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute :max öğeden fazla içermemelidir.',
        'file' => ':attribute :max kilobayttan büyük olmamalıdır.',
        'numeric' => ':attribute :max değerinden büyük olmamalıdır.',
        'string' => ':attribute :max karakterden uzun olmamalıdır.',
    ],
    'mimes' => ':attribute şu türde bir dosya olmalıdır: :values.',
    'mimetypes' => ':attribute şu türde bir dosya olmalıdır: :values.',
    'min' => [
        'array' => ':attribute en az :min öğe içermelidir.',
        'file' => ':attribute en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute en az :min olmalıdır.',
        'string' => ':attribute en az :min karakter olmalıdır.',
    ],
    'multiple_of' => ':attribute :value değerinin katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute bir sayı olmalıdır.',
    'present' => ':attribute alanı mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaktır.',
    'prohibited_if' => ':other :value olduğunda :attribute alanı yasaktır.',
    'prohibited_unless' => ':other :values içinde olmadığı sürece :attribute alanı yasaktır.',
    'prohibits' => ':attribute alanı :other alanının mevcut olmasını yasaklar.',
    'regex' => ':attribute formatı geçersiz.',
    'required' => ':attribute alanı gereklidir.',
    'required_array_keys' => ':attribute alanı şunlar için girişler içermelidir: :values.',
    'required_if' => ':other :value olduğunda :attribute alanı gereklidir.',
    'required_unless' => ':other :values içinde olmadığı sürece :attribute alanı gereklidir.',
    'required_with' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_with_all' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_without' => ':values mevcut olmadığında :attribute alanı gereklidir.',
    'required_without_all' => ':values hiçbiri mevcut olmadığında :attribute alanı gereklidir.',
    'same' => ':attribute ve :other eşleşmelidir.',
    'size' => [
        'array' => ':attribute :size öğe içermelidir.',
        'file' => ':attribute :size kilobayt olmalıdır.',
        'numeric' => ':attribute :size olmalıdır.',
        'string' => ':attribute :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute şunlardan biriyle başlamalıdır: :values.',
    'string' => ':attribute bir metin olmalıdır.',
    'timezone' => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'url' => ':attribute geçerli bir URL olmalıdır.',
    'uuid' => ':attribute geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'ad',
        'username' => 'kullanıcı adı',
        'email' => 'e-posta',
        'first_name' => 'ad',
        'last_name' => 'soyad',
        'password' => 'şifre',
        'password_confirmation' => 'şifre onayı',
        'city' => 'şehir',
        'country' => 'ülke',
        'address' => 'adres',
        'phone' => 'telefon',
        'mobile' => 'cep telefonu',
        'age' => 'yaş',
        'sex' => 'cinsiyet',
        'gender' => 'cinsiyet',
        'day' => 'gün',
        'month' => 'ay',
        'year' => 'yıl',
        'hour' => 'saat',
        'minute' => 'dakika',
        'second' => 'saniye',
        'title' => 'başlık',
        'content' => 'içerik',
        'description' => 'açıklama',
        'excerpt' => 'özet',
        'date' => 'tarih',
        'time' => 'zaman',
        'available' => 'mevcut',
        'size' => 'boyut',
    ],

];
