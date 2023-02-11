<?php

namespace App\Http\Livewire\Service;

use App\Exports\UserPackagesExport;
use Livewire\Component;

class Exporter extends Component
{
    protected $listeners = ['exportByDate'];

    public function exportByFilter($filter)
    {
        return (new UserPackagesExport)
            ->filterBy($filter)
            ->download('Client.xlsx');
    }

    public function exportByDate($param)
    {
        $filter = json_decode($param);

        $export = new UserPackagesExport();

        if (isset($filter->trip)) {
            $export->trip($filter->trip);
        }

        if (isset($filter->dates)) {
            $export->date($filter->dates);
        }

        if (isset($filter->pickup)) {
            $export->pickUp($filter->pickup);
        }

        if (isset($filter->guide)) {
            $export->guide($filter->guide);
        }

        return $export->download('Client.xlsx');
    }

    public function render()
    {
        return view('livewire.service.exporter');
    }
}
