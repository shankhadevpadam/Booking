<?php

namespace App\Http\Livewire\User;

use App\Models\UserPackage;
use App\Models\UserPackageTraveler;
use Livewire\Component;
use Livewire\WithFileUploads;

class TravelerDetail extends Component
{
    use WithFileUploads;

    public UserPackage $userPackage;

    public UserPackageTraveler $traveler;

    public string $name = '';

    public string $email = '';

    public ?string $insuranceCompany = null;

    public ?string $policyNumber = null;

    public ?string $assistanceHotline = null;

    public $passport;

    public string $mode = 'add';

    protected $listeners = ['deleteTraveler'];

    protected array $rules = [
        'name' => ['required'],
        'email' => ['required', 'email'],
        'insuranceCompany' => ['required'],
        'policyNumber' => ['required'],
        'assistanceHotline' => ['required'],
    ];

    public function create()
    {
        $this->mode = 'add';

        $this->resetFields();
    }

    public function store()
    {
        $this->rules['passport'] = ['required', 'mimes:jpg,bmp,png,pdf', 'max:2048'];

        $this->validate();

        $traveler = $this->userPackage->travelers()->create([
            'name' => $this->name,
            'email' => $this->email,
            'insurance_company' => $this->insuranceCompany,
            'policy_number' => $this->policyNumber,
            'assistance_hotline' => $this->assistanceHotline,
        ]);

        $traveler->addMedia($this->passport)->toMediaCollection();

        $this->resetFields();

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'traveler-detail',
            'message' => 'Traveler detail added successfully.',
        ]);
    }

    public function edit(int $id)
    {
        $this->mode = 'edit';

        $this->traveler = UserPackageTraveler::find($id);

        $this->name = $this->traveler->name;

        $this->email = $this->traveler->email;

        $this->insuranceCompany = $this->traveler->insurance_company;

        $this->policyNumber = $this->traveler->policy_number;

        $this->assistanceHotline = $this->traveler->assistance_hotline;
    }

    public function update()
    {
        if ($this->passport) {
            $this->rules['passport'] = ['required', 'mimes:jpg,bmp,png,pdf', 'max:2048'];
        }

        $this->validate();

        $this->traveler->update([
            'name' => $this->name,
            'email' => $this->email,
            'insurance_company' => $this->insuranceCompany,
            'policy_number' => $this->policyNumber,
            'assistance_hotline' => $this->assistanceHotline,
        ]);

        if ($this->passport) {
            $this->traveler->clearMediaCollection();

            $this->traveler->addMedia($this->passport)->toMediaCollection();
        }

        $this->dispatchBrowserEvent('component-event', [
            'modal' => 'traveler-detail',
            'message' => 'Traveler detail updated successfully.',
        ]);
    }

    public function deleteTraveler(int $id)
    {
        UserPackageTraveler::destroy($id);

        $this->dispatchBrowserEvent('component-event', [
            'message' => 'Traveler detail deleted successfully.',
        ]);
    }

    public function close()
    {
        $this->resetErrorBag();

        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['name', 'email', 'insuranceCompany', 'policyNumber', 'assistanceHotline', 'passport']);
    }

    public function render()
    {
        return view('livewire.user.traveler-detail', [
            'travelers' => UserPackageTraveler::with('media')->where('user_package_id', $this->userPackage->id)->get(),
        ]);
    }
}
