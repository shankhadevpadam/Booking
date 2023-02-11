<?php

namespace App\Actions\Media;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteMedia
{
    public function __invoke(Request $request)
    {
        Media::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully',
        ]);
    }
}
