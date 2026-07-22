<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ImageUploadController extends Controller
{
    public function __construct(private MediaService $media) {}

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|max:10240',
        ]);

        try {
            $path = $this->media->upload($request->file('file'), 'content');
            return response()->json(['url' => asset('storage/' . $path), 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
