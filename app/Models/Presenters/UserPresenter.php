<?php

namespace App\Models\Presenters;

/**
 * Presenter Class for Book Module.
 */
trait UserPresenter
{
    /**
     * Get Status Label.
     *
     * @return [type] [description]
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case '1':
                return '<span class="badge badge-success">Active</span>';
                break;
            case '2':
                return '<span class="badge badge-warning">Blocked</span>';
                break;

            default:
                return '<span class="badge badge-primary">Status:'.$this->status.'</span>';
                break;
        }
    }

    /**
     * Get Status Label.
     *
     * @return [type] [description]
     */
    public function getConfirmedLabelAttribute()
    {
        if ($this->email_verified_at != null) {
            return '<span class="badge badge-success">Confirmed</span>';
        } else {
            return '<span class="badge badge-danger">Not Confirmed</span>';
        }
    }
}
