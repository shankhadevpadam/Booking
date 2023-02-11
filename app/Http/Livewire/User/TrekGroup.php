<?php

namespace App\Http\Livewire\User;

use App\Enums\TrekGroupType;
use App\Models\UserPackage;
use Livewire\Component;

class TrekGroup extends Component
{
    public UserPackage $userPackage;

    public ?string $trekGroup = null;

    public function mount()
    {
        $this->trekGroup = $this->userPackage->trek_group;
    }

    public function update()
    {
        $this->userPackage->update([
            'trek_group' => $this->trekGroup ? $this->trekGroup : null,
        ]);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Trek group update successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.user.trek-group', [
            'types' => TrekGroupType::cases(),
        ]);
    }
}
