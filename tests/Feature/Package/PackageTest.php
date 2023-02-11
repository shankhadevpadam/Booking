<?php

namespace Tests\Feature\Package;

use App\Http\Livewire\Package\Package as PackageComponent;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->artisan('db:seed --class=PermissionTableSeeder');

        $this->signIn();
    }

    /** @test */
    public function it_can_list_a_package(): void
    {
        $this->get('/admin/packages')
            ->assertSee('Packages');
    }

    /** @test */
    public function it_fields_is_required(): void
    {
        Livewire::test(PackageComponent::class)
            ->set('name', '')
            ->set('defaultBooked', '')
            ->call('store')
            ->assertHasErrors([
                'name' => 'required',
                'defaultBooked' => ['required'],
            ]);
    }

    /** @test */
    public function it_package_creation_page_contain_livewire_component(): void
    {
        $this->get('/admin/packages/create')
            ->assertSeeLivewire('package.package');
    }

    /** @test */
    public function it_can_create_a_package(): void
    {
        Livewire::test(PackageComponent::class)
            ->set('name', 'Everest Base Camp Trek')
            ->set('slug', Str::slug('Everest Base Camp Trek'))
            ->set('paymentType', 'percentage')
            ->set('amount', 1)
            ->set('defaultBooked', 10)
            ->set('addons', [])
            ->call('store')
            ->assertRedirect('/admin/packages');

        $this->assertTrue(Package::whereName('Everest Base Camp Trek')->exists());
    }

    /** @test */
    public function it_package_edit_page_contain_livewire_component(): void
    {
        $package = Package::factory()->create();

        $this->get('/admin/packages/'.$package->id.'/edit')
            ->assertSeeLivewire('package.package');
    }

    /** @test */
    public function it_can_update_a_package(): void
    {
        $package = Package::factory()->create();

        $package->name = 'Update Title';

        Livewire::test(PackageComponent::class, ['packageId' => $package->id])
            ->set('name', $package->name)
            ->set('slug', Str::slug($package->name))
            ->set('paymentType', 'percentage')
            ->set('amount', 1)
            ->set('defaultBooked', 10)
            ->set('addons', [])
            ->call('update')
            ->assertRedirect('/admin/packages');

        $this->assertTrue(Package::whereName('Update Title')->exists());
    }

    /** @test */
    public function it_can_delete_a_package(): void
    {
        $package = Package::factory()->create();

        $this->get('/admin/packages/delete/'.$package->id)
            ->assertStatus(204);
    }
}
