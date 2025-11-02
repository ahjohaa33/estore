<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Ensures we always have a cart & cookie
    protected function getCart(Request $request): Cart
    {
        $token = $request->cookie('cart_token');

        if ($token) {
            $cart = Cart::firstOrCreate(['token' => $token], ['currency' => 'BDT']);
        } else {
            $cart = Cart::create(['currency' => 'BDT']);
            cookie()->queue(cookie()->forever(
                name: 'cart_token',
                value: $cart->token,
                path: '/',
                domain: null,
                secure: app()->environment('production'),
                httpOnly: true,
                raw: false,
                sameSite: 'Lax'
            ));
        }

        // Attach user if logged in
        if (auth()->check() && !$cart->user_id) {
            $cart->user_id = auth()->id();
            $cart->save();
        }

        return $cart;
    }

    // Decide effective price from your product schema
    protected function resolvePrice(Product $p): float
    {
        $now = now();
        if ($p->offer_price && $p->offer_duration && $now->lte($p->offer_duration)) {
            return (float) $p->offer_price;
        }
        return (float) $p->price;
    }

    // GET /cart
    public function show(Request $request)
    {
        $cart = $this->getCart($request)->load('items.product');
        return view('cart.show', [
            'cart' => $cart,
            'totals' => $cart->totals(),
        ]);
    }

    // POST /cart/add
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['nullable','integer','min:1'],
            'color'      => ['nullable','string','max:100'],
            'size'       => ['nullable','string','max:100'],
        ]);

        $cart = $this->getCart($request);
        $product = Product::findOrFail($data['product_id']);

        $qty = $data['qty'] ?? 1;
        if ($qty < 1) $qty = 1;

        $price = $this->resolvePrice($product);

        // Merge line if same product+options exists
        $item = CartItem::where([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
            'color'      => $data['color'] ?? null,
            'size'       => $data['size'] ?? null,
        ])->first();

        if ($item) {
            $item->qty += $qty;
            $item->unit_price = $price; // refresh snapshot
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'color'      => $data['color'] ?? null,
                'size'       => $data['size'] ?? null,
                'qty'        => $qty,
                'unit_price' => $price,
            ]);
        }

        return response()->json([
            'message' => 'Added to cart',
            'cart_id' => $cart->id,
            'item_id' => $item->id,
            'totals'  => $cart->refresh()->totals(),
        ]);
    }

    // POST /cart/update/{item}
    public function updateQty(Request $request, CartItem $item)
    {
        $data = $request->validate(['qty' => ['required','integer','min:0']]);
        if ($data['qty'] == 0) {
            $item->delete();
        } else {
            $item->qty = $data['qty'];
            // optional: refresh price snapshot
            $item->unit_price = $this->resolvePrice($item->product);
            $item->save();
        }
        $cart = $item->cart()->with('items')->first();
        return response()->json(['message'=>'Updated','totals'=>$cart->totals()]);
    }

    // DELETE /cart/item/{item}
    public function remove(Request $request, CartItem $item)
    {
        $item->delete();
        $cart = $this->getCart($request)->load('items');
        return response()->json(['message'=>'Removed','totals'=>$cart->totals()]);
    }

    // DELETE /cart/clear
    public function clear(Request $request)
    {
        $cart = $this->getCart($request);
        $cart->items()->delete();
        return response()->json(['message'=>'Cleared','totals'=>$cart->refresh()->totals()]);
    }
}
