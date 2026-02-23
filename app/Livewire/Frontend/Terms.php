<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Terms and Conditions')]
class Terms extends Component
{
    public function render()
    {
        $title = 'Terms and Conditions';
        $company_name = app_name();
        $app_email = setting('email');

        return view(view: 'livewire.frontend.terms', data: compact('title', 'company_name', 'app_email'));
    }
}
