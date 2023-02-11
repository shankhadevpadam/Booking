<?php

namespace App\Http\Controllers\Api\V1\Booking;

use App\Actions\Booking\CompleteBooking;
use App\Actions\Booking\UpdateArrivalAndPickup;
use App\Concerns\InteractsWithBooking;
use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\ArrivalDateRequest;
use App\Http\Requests\Booking\BookingCompleteRequest;
use App\Http\Requests\Booking\BookingRequest;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    use InteractsWithBooking;

    public function payment(BookingRequest $request)
    {
        $this->filterDeparture($request->departure_id, 'first');

        $token = Str::uuid();

        Cache::put($token, $request->all(), now()->addMinutes(30));

        return response()->json([
            'data' => [
                'url' => route('payment'),
                'token' => $token,
            ],
        ], Response::HTTP_OK);
    }

    public function dates(ArrivalDateRequest $request, UpdateArrivalAndPickup $updateArrivalAndPickup)
    {
        $this->filterDeparture($request->departure_id);

        $user = $this->getUserByToken($request->token);

        $response = $updateArrivalAndPickup->setRequest($request, $user)->execute();

        return response()->json([
            'data' => $response,
        ], Response::HTTP_OK);
    }

    public function complete(BookingCompleteRequest $request, CompleteBooking $completeBooking)
    {
        $this->filterDeparture($request->departure_id);

        $user = $this->getUserByToken($request->token);

        $userPackageId = $completeBooking->setRequest($request, $user)->execute();

        Registered::dispatch($user);

        return response()->json([
            'success' => true,
            'user_package_id' => $userPackageId,
        ], Response::HTTP_OK);
    }

    public function booker()
    {
        $user = $this->getUserByToken(request('token'));

        return response()->json([
            'data' => $user->name ?? '',
        ], Response::HTTP_OK);
    }

    public function paymentIntent(Request $request)
    {
        $payment = (new User)->pay($request->amount * 100);

        return response()->json([
            'secret' => $payment->client_secret, 
        ], Response::HTTP_OK);
    }

    public function confirmation(int $id)
    {
        try {
            $userPackage = UserPackage::findOrFail($id);

            $userPackage->load(['package', 'departure', 'coupon']);

            return response()->json([
                'data' => $userPackage,
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw ValidationException::withMessages(['Confirmation package not found with given id.']);
        }
        
    }
}
