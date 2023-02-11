<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?? User::factory()
        ->state([
            'is_admin' => 1,
        ])
        ->create();

        $user->assignRole('Super Admin');

        $this->actingAs($user);

        return $this;
    }
}
