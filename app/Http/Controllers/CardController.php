<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    public function index(): JsonResponse
    {
        $cards = Card::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json($cards);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'badge' => 'nullable|string|max:255',
            'preview_url' => 'nullable|url|max:255',
            'type' => 'required|in:government,company',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $card = Card::create($validated);

        return response()->json($card, 201);
    }

    public function show(Card $card): JsonResponse
    {
        return response()->json($card);
    }

    public function update(Request $request, Card $card): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'badge' => 'nullable|string|max:255',
            'preview_url' => 'nullable|url|max:255',
            'type' => 'required|in:government,company',
            'is_coming_soon' => 'boolean',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $card->update($validated);

        return response()->json($card);
    }

    public function destroy(Card $card): JsonResponse
    {
        $card->delete();

        return response()->json(['message' => 'تم حذف الكارد بنجاح']);
    }
}

