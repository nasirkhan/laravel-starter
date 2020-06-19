<?php

namespace App\Models\Traits;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

trait HasHashedMediaTrait
{
    use HasMediaTrait {
        HasMediaTrait::addMedia as parentAddMedia;
    }

    public function addMedia($file)
    {
        return $this->parentAddMedia($file)->usingFileName($file->hashName());
    }
}
