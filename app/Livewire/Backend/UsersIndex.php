<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        $users = User::where('name', 'like', $searchTerm)->orWhere('email', 'like', $searchTerm)->orderBy('id', 'desc')->with(['permissions', 'roles.permissions', 'providers'])->paginate();

        return view('livewire.backend.users-index', compact('users'));
    }
}
