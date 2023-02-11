<?php

namespace App\Http\Livewire\Common;

use App\Models\User;
use Livewire\Component;

class UserFilter extends Component
{
    public string | bool $role;

    public string $route;

    public string $trashRoute;

    public array $data;

    protected $listeners = ['dataFilter'];

    public function mount()
    {
        $this->data = $this->countRecords();
    }

    public function dataFilter()
    {
        $this->data = $this->countRecords();
    }

    private function countRecords()
    {
        return [
            'countTotalRecords' => is_bool($this->role)
                ? User::where('is_admin', true)->count()
                : User::role($this->role)->count(),
            'countTotalTrashedRecords' => is_bool($this->role)
                ? User::where('is_admin', true)->onlyTrashed()->count()
                : User::role($this->role)->onlyTrashed()->count(),
        ];
    }

    public function render()
    {
        return view('livewire.common.user-filter');
    }
}
