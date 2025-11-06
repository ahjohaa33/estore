<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. validate incoming data
        $validated = $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'nullable|email',
            'phone'           => 'required|string|max:50',
            'address'         => 'required|string',
            'shipping_method' => 'nullable|string',
            'shipping_cost'   => 'nullable|numeric',
            'items'           => 'required|array|min:1',
            'items.*.id'      => 'required|integer|exists:products,id',
            'items.*.price'   => 'required|numeric',
            'items.*.qty'     => 'required|integer|min:1',
            'items.*.name'    => 'nullable|string',
            'items.*.size'    => 'nullable|string',
        ], [
            'full_name.required' => 'Customer name is required.',
            'phone.required'     => 'Phone number is required.',
            'address.required'   => 'Shipping address is required.',
            'items.required'     => 'Cart is empty.',
        ]);

        $items          = $validated['items'];
        $deliveryCharge = (float) ($validated['shipping_cost'] ?? 0);

        // detect who owns this cart
        $userId    = Auth::id();
        $cartToken = $request->cookie('cart_token');

        // log incoming context
        Log::info('Checkout start', [
            'user_id'    => $userId,
            'cart_token' => $cartToken,
            'items_count'=> count($items),
        ]);

        try {
            $order = DB::transaction(function () use ($validated, $items, $deliveryCharge, $userId, $cartToken) {

                Log::info('TXN: started', [
                    'user_id'    => $userId,
                    'cart_token' => $cartToken,
                ]);

                // collect product IDs
                $productIds = collect($items)->pluck('id')->all();

                // lock products
                $products = Products::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // stock check
                foreach ($items as $row) {
                    $pid = (int) $row['id'];
                    $qty = (int) $row['qty'];

                    $product = $products->get($pid);
                    if (!$product) {
                        Log::warning('TXN: product missing', ['product_id' => $pid]);
                        throw new \Exception("Product not found (ID: {$pid}).");
                    }

                    if ((int) $product->in_stock < $qty) {
                        Log::warning('TXN: not enough stock', [
                            'product_id' => $pid,
                            'have'       => $product->in_stock,
                            'want'       => $qty,
                        ]);
                        throw new \Exception("Not enough stock for {$product->name}. Available: {$product->in_stock}, requested: {$qty}.");
                    }
                }

                // calculate subtotal
                $subtotal = 0;
                foreach ($items as $row) {
                    $lineTotal = ((float) $row['price']) * ((int) $row['qty']);
                    $subtotal += $lineTotal;
                }
                $total = $subtotal + $deliveryCharge;

                // create order
                $order = Orders::create([
                    'customer_name'    => $validated['full_name'],
                    'phone'            => $validated['phone'],
                    'email'            => $validated['email'] ?? null,
                    'address'          => $validated['address'],
                    'shipping_address' => $validated['address'],
                    'delivery_charge'  => $deliveryCharge,
                    'subtotal'         => $subtotal,
                    'total'            => $total,
                    'status'           => 'pending',
                ]);

                Log::info('TXN: order created', [
                    'order_id' => $order->id,
                    'subtotal' => $subtotal,
                    'total'    => $total,
                ]);

                // create order items + deduct stock
                foreach ($items as $row) {
                    $productId    = (int) $row['id'];
                    $productPrice = (float) $row['price'];
                    $qty          = (int) $row['qty'];
                    $size         = $row['size'] ?? null;

                    $product = $products->get($productId);

                    OrderItems::create([
                        'order_id'      => $order->id,
                        'product_id'    => $productId,
                        'product_price' => $productPrice,
                        'qty'           => $qty,
                        'size'          => $size,
                        'total'         => $productPrice * $qty,
                    ]);

                    // deduct inventory
                    $product->in_stock = (int) $product->in_stock - $qty;
                    $product->save();
                }

                // === CLEAR CART HERE ===
                // we log how many rows we are about to delete
                if ($userId) {
                    $beforeUser = Cart::where('user_id', $userId)->count();
                    Log::info('TXN: cart rows for user before delete', [
                        'user_id' => $userId,
                        'count'   => $beforeUser,
                    ]);
                    $deletedUser = Cart::where('user_id', $userId)->delete();
                    Log::info('TXN: cart rows deleted for user', [
                        'user_id' => $userId,
                        'deleted' => $deletedUser,
                    ]);
                }

                if ($cartToken) {
                    $beforeToken = Cart::where('token', $cartToken)->count();
                    Log::info('TXN: cart rows for token before delete', [
                        'cart_token' => $cartToken,
                        'count'      => $beforeToken,
                    ]);
                    $deletedToken = Cart::where('token', $cartToken)->delete();
                    Log::info('TXN: cart rows deleted for token', [
                        'cart_token' => $cartToken,
                        'deleted'    => $deletedToken,
                    ]);
                }

                Log::info('TXN: completed OK', [
                    'order_id' => $order->id,
                ]);

                return $order;
            });

            Log::info('Checkout success', [
                'order_id' => $order->id,
            ]);

            // success response
            if ($request->expectsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Order placed successfully.',
                    'order_id' => $order->id,
                ]);
            }

            return redirect()
                ->route('ordersuccess', $order->id)
                ->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {

            Log::error('Checkout failed', [
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
                'user_id'  => $userId,
                'cart_token' => $cartToken,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Failed to place order.',
                ], 422);
            }

            return back()
                ->withErrors($e->getMessage() ?: 'Failed to place order. Please try again.')
                ->withInput();
        }
    }


    public function success($id)
    {
        $order = Orders::with('items.product')->findOrFail($id);
        return view('frontend.success', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
