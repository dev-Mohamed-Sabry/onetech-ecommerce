<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index(WishlistService $wishlistService)
    {
        return
            response()->json(
                [
                    'success' => true,
                    'wishlist' => $wishlistService->get(),
                ]
            );
    }

    public function add(Request $request, WishlistService $wishlistService)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlistService->add(
            $request->product_id,
        );

        return response()->json([
            'success' => true,
            'wishlist' => $wishlistService->get(),
            'message' => 'Added to Wishlist successfully',
        ]);
    }

    public function remove(Request $request, WishlistService $wishlistService)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlistService->remove(
            $request->product_id
        );

        return response()->json([
            'success' => true,
            'wishlist' => $wishlistService->get(),
            'message' => 'Removed from Wishlist successfully',
        ]);
    }
}
