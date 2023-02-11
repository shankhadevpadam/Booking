<?php

namespace App\Http\Controllers\Admin\Review;

use App\Concerns\Authorizable;
use App\Concerns\InteractsWithModule;
use App\DataTables\ReviewDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewCreateRequest;
use App\Http\Requests\Review\ReviewUpdateRequest;
use App\Models\Package;
use App\Models\Review;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ReviewController extends Controller
{
    use Authorizable, InteractsWithModule;

    public function __construct(
        protected ReviewDataTable $dataTable,
        protected Review $model,
    ) {
    }

    public function index()
    {
        return view('admin.reviews.index', [
            'title' => 'Reviews',
        ]);
    }

    public function create()
    {
        if (Role::where('name', 'Guide')->exists()) {
            $guides = User::role('Guide')->toBase()->get();
        }

        return view('admin.reviews.create', [
            'title' => 'Add Review',
            'guides' => $guides ?? collect([]),
            'packages' => Package::orderBy('name')->toBase()->get(),
        ]);
    }

    public function store(ReviewCreateRequest $request)
    {
        $review = Review::create([
            'package_id' => $request->package_id,
            'title' => $request->title,
            'review' => $request->review,
            'review_date' => $request->review_date,
            'user_id' => $request->user_id,
            'guide_id' => $request->guide_id ?? NULL,
            'rating' => $request->rating,
            'is_published' => $request->is_published,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $review->addMedia($photo)->toMediaCollection();
            }
        }

        return to_route('admin.reviews.index')->with(['success' => 'Review submit sucessfully.']);
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', [
            'title' => 'Edit Review',
            'guides' => User::role('Guide')->toBase()->get(),
            'packages' => Package::orderBy('name')->toBase()->get(),
            'review' => $review,
        ]);
    }

    public function update(ReviewUpdateRequest $request, Review $review)
    {
        $review->update([
            'package_id' => $request->package_id,
            'title' => $request->title,
            'review' => $request->review,
            'review_date' => $request->review_date,
            'user_id' => $request->user_id,
            'guide_id' => $request->guide_id ?? NULL,
            'rating' => $request->rating,
            'is_published' => $request->is_published,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $review->addMedia($photo)->toMediaCollection();
            }
        }

        return to_route('admin.reviews.index')->with(['success' => 'Review updated successfully.']);
    }

    public function destroy(int $id)
    {
        Review::destroy($id);

        return response()->noContent();
    }
}
