<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cms;

class CmsController extends Controller
{
    public function show($slug)
    {
        $cms = Cms::where([
                'slug' => $slug,
                'is_active' => 1
            ])
            ->first();

        if (!$cms) {

            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $cms
        ]);
    }
}