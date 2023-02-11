<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\UserReviewCreateRequest;
use App\Models\Package;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create()
    {
        abort_unless(auth()->user()->unreadNotifications->count(), 403);

        $packages = Package::select('id', 'name')->get();

        $filterData = auth()->user()->unreadNotifications->map(function ($item) use ($packages) {
            if ($packages->contains('id', $item->data['package_id'])) {
                return [
                    'notification_id' => $item->id,
                    'package_name' => $packages->where('id', $item->data['package_id'])->first()->name,
                ];
            }
        });

        return view('users.review', [
            'title' => 'Write your review',
            'filterData' => $filterData,
        ]);
    }

    public function store(UserReviewCreateRequest $request)
    {
        $notification = auth()->user()
            ->unreadNotifications
            ->where('id', $request->notification_id)
            ->first();

        $review = Review::create([
            'user_id' => auth()->id(),
            'package_id' => $notification->data['package_id'],
            'guide_id' => $notification->data['guide_id'] ? $notification->data['guide_id'] : null,
            'title' => $request->title,
            'review' => $request->review,
            'review_date' => now(),
            'rating' => $request->float('rating'),
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $review->addMedia($photo)->toMediaCollection();
            }
        }

        $notification->markAsRead();

        return to_route('home')->with(['success' => 'Review submit successfully.']);
    }
}
