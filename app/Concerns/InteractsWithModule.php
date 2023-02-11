<?php

namespace App\Concerns;

trait InteractsWithModule
{
    public function dataTable(...$params)
    {
        return ($this->dataTable)($params ? implode(',', $params) : null);
    }

    public function destroySelected()
    {
        $this->model->destroy(request('ids'));

        return response()->noContent();
    }

    public function destroySelectedPermanently()
    {
        $this->model->onlyTrashed()
            ->whereIn('id', request('ids'))
            ->forceDelete();

        return response()->noContent();
    }

    public function destroyCompletely()
    {
        if ($this->model->hasGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope')) {
            $this->model->onlyTrashed()->forceDelete();
        } else {
            $this->model->whereNotNull('id')->delete();
        }

        return response()->noContent();
    }

    public function restore()
    {
        $this->model->whereIn('id', request('ids'))
            ->onlyTrashed()
            ->restore();

        return response()->noContent();
    }
}
