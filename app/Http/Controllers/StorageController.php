<?php

namespace App\Http\Controllers;

use App\Services\CloudStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    protected $cloudStorage;

    public function __construct(CloudStorageService $cloudStorage)
    {
        $this->cloudStorage = $cloudStorage;
    }

    /**
     * List all images in the cards folder
     */
    public function listCardImages(): JsonResponse
    {
        try {
            $files = $this->cloudStorage->listFiles('cards');
            return response()->json([
                'success' => true,
                'data' => $files,
                'count' => count($files),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to list images',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get signed URL for an image
     */
    public function getSignedUrl(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'path' => 'required|string',
            'duration' => 'nullable|integer|min:60|max:604800', // 1 minute to 1 week
        ]);

        try {
            $duration = $validated['duration'] ?? 3600; // Default 1 hour
            $signedUrl = $this->cloudStorage->getSignedUrl($validated['path'], $duration);

            return response()->json([
                'success' => true,
                'url' => $signedUrl,
                'expires_in' => $duration,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate signed URL',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete an image from cloud storage
     */
    public function deleteImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        try {
            $this->cloudStorage->deleteFile($validated['path']);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete image',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get file info and renew signed URL
     */
    public function getImageInfo(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        try {
            if (!$this->cloudStorage->fileExists($validated['path'])) {
                return response()->json([
                    'error' => 'File not found',
                ], 404);
            }

            $signedUrl = $this->cloudStorage->getSignedUrl($validated['path']);
            $publicUrl = $this->cloudStorage->getPublicUrl($validated['path']);

            return response()->json([
                'success' => true,
                'path' => $validated['path'],
                'signed_url' => $signedUrl,
                'public_url' => $publicUrl,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get image info',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
