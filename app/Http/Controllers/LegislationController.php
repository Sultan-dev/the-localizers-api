<?php

namespace App\Http\Controllers;

use App\Models\Legislation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LegislationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Legislation::query();

        // Filter by rate if provided
        if ($request->has('rate')) {
            $query->where('rate', $request->rate);
        }

        // Filter by minimum rate if provided
        if ($request->has('min_rate')) {
            $query->where('rate', '>=', $request->min_rate);
        }

        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $review = Legislation::create($validated);

        return response()->json($review, 201);
    }

    public function show(Legislation $legislation): JsonResponse
    {
        return response()->json($legislation);
    }

    public function update(Request $request, Legislation $legislation): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);

        $legislation->update($validated);

        return response()->json($legislation);
    }

    public function destroy(Legislation $legislation): JsonResponse
    {
        $legislation->delete();

        return response()->json(['message' => 'تم حذف التقييم بنجاح']);
    }
}

