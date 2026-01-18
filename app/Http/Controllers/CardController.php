<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Services\CloudStorageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    protected $cloudStorage;

    public function __construct(CloudStorageService $cloudStorage)
    {
        $this->cloudStorage = $cloudStorage;
    }
    public function index()
    {
        $cards = Card::where('is_active', true)
            ->orderByRaw('NULLIF(link, "") IS NOT NULL DESC, created_at ASC')
            ->get();

        return response()->json($cards);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'badge' => 'nullable|string|max:255',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:government,company,all',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Upload image to Google Cloud Storage if provided
        if ($request->hasFile('preview_image')) {
            try {
                $uploadResult = $this->cloudStorage->uploadFile(
                    $request->file('preview_image'),
                    'cards'
                );
                $validated['preview_url'] = $uploadResult['public_url'];
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to upload image',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        $card = Card::create($validated);

        return response()->json($card, 201);
    }

    public function show($id)
    {
        $card = Card::findOrFail($id);
        return response()->json($card);
    }

    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'badge' => 'nullable|string|max:255',
            'preview_url' => 'nullable|url',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'type' => 'required|in:government,company,all',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle new image upload
        if ($request->hasFile('preview_image')) {
            try {
                // Delete old file from GCS if it exists
                if ($card->preview_url) {
                    // Extract path from URL (e.g., cards/filename.jpg)
                    $oldPath = $this->extractPathFromUrl($card->preview_url);
                    if ($oldPath) {
                        $this->cloudStorage->deleteFile($oldPath);
                    }
                }

                // Upload new image
                $uploadResult = $this->cloudStorage->uploadFile(
                    $request->file('preview_image'),
                    'cards'
                );
                $validated['preview_url'] = $uploadResult['public_url'];
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to upload image',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        $card->update($validated);

        return response()->json($card);
    }

    public function destroy($id)   
    {
        $card = Card::findOrFail($id);
        
        // Delete image from GCS if it exists
        if ($card->preview_url) {
            try {
                // Extract path from URL (e.g., cards/filename.jpg)
                $path = $this->extractPathFromUrl($card->preview_url);
                if ($path) {
                    $this->cloudStorage->deleteFile($path);
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to delete GCS file: ' . $e->getMessage());
                // Continue with card deletion even if image deletion fails
            }
        }

        $card->delete();

        return response()->json(['message' => 'تم حذف الكارد بنجاح']);
    }

    /**
     * Extract path from GCS URL
     * Example: https://storage.googleapis.com/bucket-name/cards/file.jpg -> cards/file.jpg
     */
    private function extractPathFromUrl(string $url): ?string
    {
        // Match pattern: https://storage.googleapis.com/{bucket}/{path}
        if (preg_match('#storage\.googleapis\.com/[^/]+/(.+)$#', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}

