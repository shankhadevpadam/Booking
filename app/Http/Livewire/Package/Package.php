<?php

namespace App\Http\Livewire\Package;

use App\Enums\PaymentType;
use App\Models\Package as PackageModel;
use Illuminate\Support\Str;
use Livewire\Component;

class Package extends Component
{
    public ?string $name = null;

    public ?string $slug = null;

    public ?string $paymentType = null;

    public ?string $amount = null;

    public ?string $defaultBooked = null;

    public ?int $packageId = null;

    public array $inputs = [];

    public array $addons = [];

    public bool $update = false;

    protected $rules = [
        'name' => ['required'],
        'paymentType' => ['required'],
        'amount' => ['required', 'integer'],
        'defaultBooked' => ['required', 'integer'],
    ];

    protected array $messages = [];

    protected array $attributes = [];

    public function mount(?int $packageId = null)
    {
        if ($packageId) {
            $this->packageId = $packageId;

            $this->update = true;

            $package = PackageModel::find($packageId);

            $this->name = $package->name;
            $this->slug = $package->slug;
            $this->paymentType = $package->payment_type->value;
            $this->amount = $package->amount;
            $this->defaultBooked = $package->default_booked;

            if ($package->addons) {
                foreach ($package->addons as $value) {
                    $this->inputs[] = [
                        'name' => $value['name'],
                        'price' => $value['price'],
                    ];
                }
            }
        }
    }

    public function add()
    {
        $this->inputs[] = ['name' => '', 'price' => ''];
    }

    public function remove(int $i)
    {
        unset($this->inputs[$i]);

        $this->inputs = array_values($this->inputs);
    }

    public function mergeValidationRules()
    {
        $this->rules['inputs'] = ['array'];

        foreach ($this->inputs as $key => $value) {
            $this->rules['inputs.'.$key.'.name'] = ['required'];
            $this->rules['inputs.'.$key.'.price'] = ['required'];
            $this->messages['inputs.'.$key.'.name.required'] = 'The :attribute field is required.';
            $this->messages['inputs.'.$key.'.price.required'] = 'The :attribute field is required.';
            $this->attributes['inputs.'.$key.'.name'] = 'name';
            $this->attributes['inputs.'.$key.'.price'] = 'price';
        }
    }

    public function hydrateInputFields()
    {
        if ($this->inputs) {
            $this->mergeValidationRules();
        }

        $this->validate($this->rules, $this->messages, $this->attributes);

        if ($this->inputs) {
            foreach ($this->inputs as $key => $value) {
                $this->addons[$key]['name'] = $value['name'];
                $this->addons[$key]['price'] = (float) $value['price'];
            }
        }
    }

    public function store()
    {
        $this->hydrateInputFields();

        $package = PackageModel::create([
            'name' => $this->name,
            'payment_type' => $this->paymentType,
            'amount' => $this->amount,
            'default_booked' => $this->defaultBooked,
            'addons' => $this->addons,
        ]);

        if ($this->slug) {
            $package->slug = Str::slug($this->slug);
            $package->save();
        }

        return to_route('admin.packages.index')->with(['success' => 'Package created successfully.']);
    }

    public function update()
    {
        $this->hydrateInputFields();

        PackageModel::find($this->packageId)
            ->update([
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
                'payment_type' => $this->paymentType,
                'amount' => $this->amount,
                'default_booked' => $this->defaultBooked,
                'addons' => $this->addons,
            ]);

        return to_route('admin.packages.index')->with(['success' => 'Package updated successfully.']);
    }

    public function render()
    {
        return view('livewire.package.package', [
            'paymentTypes' => PaymentType::cases(),
        ]);
    }
}
