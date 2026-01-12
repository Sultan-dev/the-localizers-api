<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::where('is_active', true)
            ->orderByRaw('link IS NOT NULL DESC, created_at ASC')
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
            // accept either a URL or an uploaded file
             'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:government,company,all',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // if an image file was uploaded, move it to public/storage/cards and set preview_url
        if ($request->hasFile('preview_image')) {
            $file = $request->file('preview_image');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid('card_') . '.' . $ext;
            $destination = public_path('storage/cards');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['preview_url'] = url('storage/cards/' . $filename);
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
            'preview_url' => 'nullable|url|max:255',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:government,company,all',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // handle uploaded new image: delete old local file if present, then save new
        if ($request->hasFile('preview_image')) {
            // delete old file if it is in storage/cards
            if ($card->preview_url && strpos($card->preview_url, '/storage/cards/') !== false) {
                $oldName = basename($card->preview_url);
                $oldPath = public_path('storage/cards/' . $oldName);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('preview_image');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = uniqid('card_') . '.' . $ext;
            $destination = public_path('storage/cards');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $validated['preview_url'] = url('storage/cards/' . $filename);
        }

        $card->update($validated);

        return response()->json($card);
    }

    public function destroy($id)   
    {
        $card = Card::findOrFail($id);
        $card->delete();

        return response()->json(['message' => 'تم حذف الكارد بنجاح']);
    }
}

