<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use Livewire\Component;

class ReviewNotification extends Component
{
    public UserPackage $userPackage;

    public bool $status;

    public function mount()
    {
        $this->status = $this->userPackage->send_review_email;
    }

    public function updating($name, $value)
    {
        $this->userPackage->update([
            'send_review_email' => $value,
        ]);

        $this->dispatchBrowserEvent('component-event', [
            'message' => $value ? 'Review notification turn on' : 'Review notification turn off',
        ]);
    }

    public function render()
    {
        return view('livewire.user.review-notification');
    }
}
