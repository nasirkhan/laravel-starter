<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Nasirkhan\LaravelCube\Livewire\LwTable;

#[Title('Users')]
class UsersIndex extends LwTable
{
    public string $sortCol = 'name';

    public string $sortDir = 'asc';

    protected function baseQuery(): Builder
    {
        return User::query()
            ->when(
                $this->search,
                fn (Builder $q) => $q->where(
                    fn (Builder $inner) => $inner
                        ->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                )
            )
            ->orderBy($this->sortCol, $this->sortDir)
            ->with(['roles', 'providers']);
    }

    public function render()
    {
        return view('livewire.backend.users-index', [
            'users' => $this->rows(),
        ]);
    }
}
