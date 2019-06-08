<?php

namespace Modules\Article\Entities\Presenters;

use Carbon\Carbon;

/**
 * Presenter Class for Book Module.
 */
trait PostPresenter
{

    public function getPublishedAtFormattedAttribute()
    {
        $diff = Carbon::now()->diffInHours($this->published_at);

        if ($diff < 25) {
            return $this->published_at->diffForHumans();
        } else {
            return $this->published_at->toCookieString();
        }
    }

}
