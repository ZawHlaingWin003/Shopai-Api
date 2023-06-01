<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart;

        if (!$cart) {
            return response()->json([
                'cart' => $cart
            ]);
        }

        return new CartResource($cart);
    }

    public function store(StoreCartRequest $request)
    {
        try {
            DB::beginTransaction();

            $cart = auth()->user()->cart;

            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = auth()->user()->id;
                $cart->save();
            }

            // Check product is already in cart or not
            $product = Product::find($request->id);
            $cardProduct = $cart->products()->find($product->id);

            if (!$cardProduct) {
                $cart->products()->attach(
                    $product,
                    [
                        'total_price' => $product->actual_price
                    ]
                );
            } else {
                return response()->json([
                    'message' => 'Product already in cart'
                ]);
            }

            $cart = Cart::find($cart->id);
            $cart->total_price += $product->actual_price;
            $cart->update();

            DB::commit();

            return new CartResource($cart);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        $cart = auth()->user()->cart;
        $cartProduct = $cart->products()->find($product->id);

        $cart->total_price = $cart->total_price + ($request->quantity * $cartProduct->actual_price) - $cartProduct->pivot->total_price;

        $cart->update();

        $cart->products()->updateExistingPivot($cartProduct->id, [
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $cartProduct->actual_price
        ]);

        return new CartResource($cart);
    }

    public function destroy(Product $product)
    {
        $cart = auth()->user()->cart;
        $cartProduct = $cart->products()->find($product->id);

        $cart->update([
            'total_price' => $cart->total_price - $cartProduct->pivot->total_price
        ]);

        $cart->products()->detach(
            $product->id,
        );

        return response()->noContent();
    }

    public function clearCart()
    {
        $cart = auth()->user()->cart;

        $cart->total_price = 0;
        $cart->update();

        $cart->products()->detach();

        return response()->noContent();
    }
}
