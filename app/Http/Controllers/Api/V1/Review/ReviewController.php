<?php

namespace App\Http\Controllers\Api\V1\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\Review\ReviewCollection;
use App\Models\Package;
use App\Models\Review;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function package(Package $package)
    {
        $aggregate = $package->loadCount(['userPackages' => function ($query) {
            $query->where('is_paid', true);
        }])
        ->loadAvg(['reviews' => function ($query) {
            $query->where('is_published', true);
        }], 'rating');

        $reviews = Review::with(['user:id,country_id,name', 'user.country:id,name', 'package:id,name', 'guide:id,name', 'user.media', 'media'])
            ->publishedByPackageId($package->id)
            ->latest('review_date')
            ->paginate(10);

        return (new ReviewCollection($reviews))
            ->additional(['meta' => [
                'average_rating' => $aggregate->reviews_avg_rating,
                'total_booked' => $aggregate->user_packages_count > 0
                    ? $package->default_booked + $aggregate->user_packages_count
                    : $package->default_booked,
            ]])
        ->response()
        ->setStatusCode(Response::HTTP_OK);
    }

    public function popular(int $limit = 3)
    {
        $reviews = Review::with([
            'user:id,country_id,name',
            'user.country:id,name',
            'user.media',
            'package:id,name',
            'guide:id,name',
            'media',
        ])
        ->popular()
        ->latest('id')
        ->limit($limit)
        ->get();

        return (new ReviewCollection($reviews))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
