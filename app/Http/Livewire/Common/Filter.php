<?php

namespace App\Http\Livewire\Common;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Filter extends Component
{
    public Model $model;

    public array $filter = [];

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
            'countTotalRecords' => $this->query()->count(),
            'countTotalTrashedRecords' => $this->query()->onlyTrashed()->count(),
        ];
    }

    private function query()
    {
        if ($this->filter) {
            return $this->model->where(function ($query) {
                foreach ($this->filter as $key => $value) {
                    $query->where($key, $value);
                }
            });
        }

        return $this->model;
    }

    public function render()
    {
        return view('livewire.common.filter');
    }
}
