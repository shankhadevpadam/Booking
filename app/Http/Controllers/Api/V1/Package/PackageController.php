<?php

namespace App\Http\Controllers\Api\V1\Package;

use App\Http\Controllers\Controller;
use App\Http\Resources\Package\PackageAddonCollection;
use App\Http\Resources\Package\PackageCollection;
use App\Http\Resources\Package\PackageDeparture as PackageDepartureResource;
use App\Models\Package;
use App\Models\PackageAddon;
use App\Models\PackageDeparture;
use App\Models\PackageGroupDiscount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['departures', 'discounts'])
            ->latest()
            ->paginate(10);

        return (new PackageCollection($packages))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function review(string $slug)
    {
        $package = Package::select('id', 'name', 'slug', 'default_booked')
            ->withCount(['reviews' => function ($query) {
                $query->where('is_published', true);
            }])
            ->withAvg(['reviews as avg_rating' => function ($query) {
                $query->where('is_published', true);
            }], 'rating')
            ->withCount(['userPackages as paid_booked' => function ($query) {
                $query->where('is_paid', true);
            }])
            ->where('slug', $slug)
            ->first();

        return response()->json([
            'data' => $package,
        ]);
    }

    public function departures(Package $package)
    {
        $departures = PackageDeparture::where('package_id', $package->id)
            ->select('id', 'package_id', 'start_date', 'end_date', 'price', 'discount_type', 'discount_amount', 'sold_quantity', 'total_quantity')
            ->where('start_date', '>', today())
            ->orderBy('start_date', 'asc')
            ->withCasts([
                'discount_amount' => 'float',
                'price' => 'float',
            ])
            ->get();

        return response()->json([
            'data' => $departures,
        ]);
    }

    public function dates(Package $package)
    {
        $months = PackageDeparture::where('package_id', $package->id)
            ->whereDate('start_date', '>', date('Y-m-d'))
            ->select(\DB::raw("distinct(DATE_FORMAT(start_date,'%Y-%m')) as start_date"))
            ->orderBy('start_date', 'asc')
            ->get();

        return response()->json([
            'data' => $months,
        ]);
    }

    public function groupPrice(Request $request, int $id)
    {
        if (! $request->has('number_of_people')) {
            return response()->json([
                'error' => __('Resource not found.'),
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $package = PackageGroupDiscount::where('package_id', $id)
                ->where(function ($query) use ($request) {
                    $query->where('min_number_of_people', '<=', $request->number_of_people);
                    $query->where('max_number_of_people', '>=', $request->number_of_people);
                })
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()
                ->json([
                    'error' => __('Resource not found.'),
                ], Response::HTTP_NOT_FOUND);
        }

        return response()
            ->json([
                'data' => [
                    'price' => (float) $package->price,
                ],
            ]);
    }

    public function departureById(PackageDeparture $departure)
    {
        $departure = $departure->load('package', 'package.discounts');

        return (new PackageDepartureResource($departure))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function addonPackages(int $packageId)
    {
        $addons = PackageAddon::with(['package:id,name', 'media'])
            ->where('package_id', $packageId)
            ->select('id', 'addon_package_id', 'number_of_days', 'price', 'discount_type', 'discount_amount', 'url')
            ->get();

        return (new PackageAddonCollection($addons))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
