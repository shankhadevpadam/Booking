<?php

namespace App\DataTables;

use App\Models\Review;
use Yajra\DataTables\Facades\DataTables;

class ReviewDataTable
{
    public function __invoke()
    {
        $reviews = Review::with(['user:id,name', 'package:id,name', 'guide'])->select('reviews.*');

        return DataTables::eloquent($reviews)
            ->addColumn('name', fn ($review) => $review->user->name)

            ->addColumn('package', fn ($review) => $review->package->name)

            ->addColumn('guide', fn ($review) => $review->guide->name)

            ->addColumn('action', function ($review) {
                $html = '';

                if (auth()->user()->can('edit_reviews')) {
                    $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.reviews.edit', $review).'"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_reviews')) {
                    $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.reviews.delete', $review).'\', \'reviews\')"><i class="far fa-trash-alt"></i></a>';
                } else {
                    $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
