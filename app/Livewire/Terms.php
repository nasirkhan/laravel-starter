<?php

namespace App\Livewire;

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

        return view('livewire.terms', compact('title', 'company_name', 'app_email'));
    }
}
