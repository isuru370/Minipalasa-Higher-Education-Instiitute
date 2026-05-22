<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuickPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class QuickPhotoController extends Controller
{
    public function uploadQuickPhoto(Request $request): JsonResponse
    {
        $uploadedPath = null;

        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $uploadedPath = $validated['image']->store('quick-photos', 'public');

            $quickPhoto = DB::transaction(function () use ($uploadedPath) {
                $customId = $this->generateCustomId();

                return QuickPhoto::create([
                    'custom_id' => $customId,
                    'image_path' => $uploadedPath,
                    'is_active' => true,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Image upload success',
                'data' => [
                    'custom_id' => $quickPhoto->custom_id,
                    'image_path' => $quickPhoto->image_path,
                    'image_url' => asset('storage/' . $quickPhoto->image_path),
                ],
            ], 201);
        } catch (Throwable $e) {
            if ($uploadedPath && Storage::disk('public')->exists($uploadedPath)) {
                Storage::disk('public')->delete($uploadedPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image upload failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function generateCustomId(): string
    {
        $lastPhoto = QuickPhoto::where('custom_id', 'like', 'QP-%')
            ->orderByDesc('id')
            ->lockForUpdate()
            ->first();

        $lastNumber = 0;

        if (
            $lastPhoto &&
            preg_match('/^QP-(\d+)$/', $lastPhoto->custom_id, $matches)
        ) {
            $lastNumber = (int) $matches[1];
        }

        do {
            $lastNumber++;

            $customId = 'QP-' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
        } while (
            QuickPhoto::where('custom_id', $customId)->exists()
        );

        return $customId;
    }
}
