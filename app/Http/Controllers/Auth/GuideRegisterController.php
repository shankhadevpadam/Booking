<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GuideCreateRequest;
use App\Models\User;
use App\Notifications\AdminGuideApprovalNotification;
use App\Notifications\GuideApprovalConfirmationNotification;

class GuideRegisterController extends Controller
{
    public function store(GuideCreateRequest $request)
    {
        $guide = User::create($request->validated() + ['is_admin' => false, 'country_id' => 149]);

        $guide->assignRole('Guide');

        $admin = User::role('Super Admin')->first();

        $admin->notify(new AdminGuideApprovalNotification($guide->toArray()));

        return redirect()
            ->route('guide.register')
            ->with(['success' => 'Congratulations, your account has been successfully created.']);
    }

    public function approval()
    {
        if (! request()->hasValidSignature()) {
            abort(401);
        }

        $user = User::find(request('id'));

        $user->update([
            'approved_at' => now(),
        ]);

        $user->notify(new GuideApprovalConfirmationNotification());

        return view('auth.guide-approval');
    }
}
