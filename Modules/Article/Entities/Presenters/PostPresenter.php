<?php

namespace Modules\Article\Entities\Presenters;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait PostPresenter
{
    public function getFeaturedImageAttribute($value)
    {
        $featured_image = $value;

        if (Str::startsWith($featured_image, 'https://picsum.photos')) {
            $return_text = $featured_image.'?random='.$this->id;
        } else {
            $return_text = $featured_image;
        }
        return $return_text;
    }

    public function getPublishedAtFormattedAttribute()
    {
        $diff = Carbon::now()->diffInHours($this->published_at);

        if ($diff < 24) {
            return $this->published_at->diffForHumans();
        } else {
            return $this->published_at->toDayDateTimeString();
        }
    }

    public function getPublishedAtFormattedBengaliAttribute()
    {
        $diff = Carbon::now()->diffInHours($this->published_at);

        if ($diff < 24) {
            return $this->published_at->diffForHumans();
        } else {
            $date_string = $this->published_at->toDayDateTimeString();
        }

        $return_string = en2bnDate($date_string);

        return $return_string;
    }

    public function getStatusFormattedAttribute()
    {
        switch ($this->status) {
            case '0':
                return '<span class="badge badge-danger">Unpublished</span>';
                break;

            case '1':
                if ($this->published_at >= Carbon::now()) {
                    return '<span class="badge badge-warning">Scheduled ('.$this->published_at_formatted.')</span>';
                }

                return '<span class="badge badge-success">Pubished</span>';
                break;

            case '2':
                return '<span class="badge badge-info">Draft</span>';
                break;

            default:
                return '<span class="badge badge-primary">Status:'.$this->status.'</span>';
                break;
        }
    }
}
