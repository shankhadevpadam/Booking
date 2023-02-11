<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class AddonDetail extends Component
{
    public UserPackage $userPackage;

    public string $name = '';

    public int $count = 1;

    public float $price = 0;

    protected $listeners = ['deleteAddon'];

    protected $rules = [
        'name' => ['required'],
    ];

    public function setAddonPrice()
    {
        collect($this->userPackage->package->addons)->each(function ($item) {
            if ($item['name'] === $this->name) {
                $this->price = $item['price'];
            }
        });
    }

    public function update()
    {
        $this->validate();

        if ($this->prevCount() > $this->count) {
            $addonTotal = ($this->prevCount() - $this->count) * $this->price;

            $this->userPackage->decrement('total_amount', $addonTotal);
        } else {
            $addonTotal = ($this->count - $this->prevCount()) * $this->price;

            $this->userPackage->increment('total_amount', $addonTotal);
        }

        $this->userPackage
            ->addons()
            ->updateOrCreate(['name' => $this->name], [
                'count' => $this->count,
                'price' => $this->price,
            ]);

        $this->userPackage = $this->userPackage->fresh();

        $this->emitTo('user.payment-detail', 'updateAmount');

        $this->reset(['name', 'count']);

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'update-addon-detail',
            'message' => 'Addon detail added successfully.',
        ]);
    }

    public function deleteAddon(int $id)
    {
        $addon = $this->userPackage->addons->where('id', $id)->first();

        $addonTotal = $addon->count * $addon->price;

        $this->userPackage->decrement('total_amount', $addonTotal);

        $this->userPackage->addons()->where('id', $id)->delete();

        $this->userPackage = $this->userPackage->fresh();

        $this->emitTo('user.payment-detail', 'updateAmount');

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Addon detail deleted successfully.',
        ]);
    }

    private function prevCount()
    {
        return $this->userPackage
            ->addons
            ->where('name', $this->name)
            ->first()
            ->count ?? 0;
    }

    public function close()
    {
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.user.addon-detail');
    }
}
