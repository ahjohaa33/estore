<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Support\HandlesCart;

class CartController extends Controller
{

    use HandlesCart;

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

        $cart    = $this->getCart($request);
        $product = Products::findOrFail($data['product_id']);

        $qty = $data['qty'] ?? 1;
        if ($qty < 1) {
            $qty = 1;
        }

        // price per unit (snapshot)
        $price = $this->resolvePrice($product);

        // check if same line exists
        $item = \App\Models\CartItems::where([
            'cart_id'    => $cart->id,
            'product_id' => $product->id,
            'color'      => $data['color'] ?? null,
            'size'       => $data['size'] ?? null,
        ])->first();

        if ($item) {
            // update qty
            $item->qty += $qty;
            $item->unit_price = $price; // refresh snapshot
            $item->total_price = $item->qty * $item->unit_price;  // 🔴 save line total
            $item->save();
        } else {
            $item = \App\Models\CartItems::create([
                'cart_id'     => $cart->id,
                'product_id'  => $product->id,
                'color'       => $data['color'] ?? null,
                'size'        => $data['size'] ?? null,
                'qty'         => $qty,
                'unit_price'  => $price,
                'total_price' => $qty * $price,                    // 🔴 save line total
            ]);
        }

        return response()->json([
            'status'   => 'success',
            'message' => 'Added to cart',
            'cart_id' => $cart->id,
            'item_id' => $item->id,
            'item'    => [
                'product_id'  => $item->product_id,
                'qty'         => $item->qty,
                'unit_price'  => (float) $item->unit_price,
                'total_price' => (float) $item->total_price,
                'color'       => $item->color,
                'size'        => $item->size,
            ],
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
    public function remove(Request $request, CartItems $item)
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
