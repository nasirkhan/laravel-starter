<?php

namespace App\Models\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

trait HasHashedMediaTrait
{
    use InteractsWithMedia {
        InteractsWithMedia::addMedia as parentAddMedia;
    }

    public function addMedia($file): FileAdder
    {
        if (is_string($file)) {
            $file = $this->pathToUploadedFile($file);
        }

        return $this->parentAddMedia($file)->usingFileName($file->hashName());
    }

    /**
     * Reduce a media URL to a host-relative path for storage, so a domain
     * change never invalidates stored media URLs.
     *
     * Media Library's getUrl() always returns an absolute URL (scheme + host)
     * via its URL generator; keeping only the path lets the browser resolve it
     * against the current host when used directly as a src attribute.
     */
    public static function imagePathFromUrl(string $url): string
    {
        return parse_url($url, PHP_URL_PATH) ?: $url;
    }

    /**
     * Create an UploadedFile object from absolute path.
     *
     * @param  string  $path
     * @param  bool  $test  default true
     * @return object(Illuminate\Http\UploadedFile)
     *
     * Based of Alexandre Thebaldi answer here:
     * https://stackoverflow.com/a/32258317/6411540
     */
    public function pathToUploadedFile($path, $test = true)
    {
        $filesystem = new Filesystem;

        $name = $filesystem->name($path);
        $extension = $filesystem->extension($path);
        $originalName = $name.'.'.$extension;
        $mimeType = $filesystem->mimeType($path);
        $error = null;

        return new UploadedFile($path, $originalName, $mimeType, $error, $test);
    }
}
