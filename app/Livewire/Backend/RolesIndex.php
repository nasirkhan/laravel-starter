<?php

namespace App\Livewire\Backend;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Nasirkhan\LaravelCube\Livewire\LwTable;

#[Title('Roles')]
class RolesIndex extends LwTable
{
    public string $sortCol = 'name';

    public string $sortDir = 'asc';

    protected function baseQuery(): Builder
    {
        return Role::query()
            ->when(
                $this->search,
                fn (Builder $q) => $q->where('name', 'like', '%'.$this->search.'%')
            )
            ->withCount('permissions', 'users')
            ->orderBy($this->sortCol, $this->sortDir);
    }

    public function render()
    {
        return view('livewire.backend.roles-index', [
            'roles' => $this->rows(),
        ]);
    }
}
