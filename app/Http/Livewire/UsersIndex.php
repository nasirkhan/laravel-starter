<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::orderBy('id', 'desc')->with(['permissions', 'roles', 'providers'])->paginate();

        return view('livewire.users-index', compact('users'));
    }
}
