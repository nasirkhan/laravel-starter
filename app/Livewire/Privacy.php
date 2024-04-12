<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Privacy Policy')]
class Privacy extends Component
{
    public function render()
    {
        $title = 'Privacy Policy';
        $company_name = app_name();
        $app_email = setting('email');

        return view('livewire.privacy', compact('title', 'company_name', 'app_email'));
    }
}
