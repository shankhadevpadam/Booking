<?php

namespace App\Concerns;

use App\Models\PackageDeparture;
use App\Models\User;
use Illuminate\Validation\ValidationException;

trait InteractsWithBooking
{
    public function filterDeparture(int $id, ?string $step = null)
    {
        try {
            $departure = PackageDeparture::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw ValidationException::withMessages(['Departure with given id doesn\'t exists.']);
        }

        if ($departure->isExpired()) {
            throw ValidationException::withMessages(['Departure with given id already expired.']);
        }

        if ($step === 'first' && ! $departure->isAvailable()) {
            throw ValidationException::withMessages(['The stock level of departure is already out of stock.']);
        }
    }

    public function getUserByToken(string $token): User
    {
        try {
            return User::whereToken($token)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw ValidationException::withMessages(['User not found with given token.']);
        }
    }
}
