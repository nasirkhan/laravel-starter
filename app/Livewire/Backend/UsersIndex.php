<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Users')]
class UsersIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $searchTerm = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';

        $users = User::query()
            ->where('name', 'like', $searchTerm)
            ->orWhere('email', 'like', $searchTerm)
            ->orderBy('id', 'desc')
            ->with(['permissions', 'roles.permissions', 'providers'])
            ->paginate();

        return view('livewire.backend.users-index', [
            'users' => $users,
        ]);
    }
}
