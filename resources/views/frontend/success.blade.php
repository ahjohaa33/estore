{{-- resources/views/checkout/success.blade.php --}}
@extends('frontend.layout') {{-- change to your layout --}}

@section('title', 'Order Successful')

@section('pages')
<div class="page-content-wrapper py-4">
  <div class="container">
    <div class="card mb-4">
      <div class="card-body text-center">
        <div class="mb-3">
          <span class="badge bg-success px-3 py-2">Order Placed</span>
        </div>
        <h3 class="mb-2">Thank you for your order! 🎉</h3>
        <p class="mb-0">Your order has been placed successfully.</p>
        <p class="mt-2 mb-0">
          Order No:
          <strong>#{{ $order->id }}</strong>
        </p>
      </div>
    </div>

    {{-- Order Info --}}
    <div class="row">
      <div class="col-lg-7">
        {{-- customer and shipping --}}
        <div class="card mb-3">
          <div class="card-header">
            <h6 class="mb-0">Customer & Shipping</h6>
          </div>
          <div class="card-body">
            <p class="mb-1"><strong>Name:</strong> {{ $order->customer_name }}</p>
            @if($order->phone)
              <p class="mb-1"><strong>Phone:</strong> {{ $order->phone }}</p>
            @endif
            @if($order->email)
              <p class="mb-1"><strong>Email:</strong> {{ $order->email }}</p>
            @endif
            @if($order->address)
              <p class="mb-1"><strong>Address:</strong> {{ $order->address }}</p>
            @endif
            @if($order->shipping_address && $order->shipping_address !== $order->address)
              <p class="mb-0"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
            @endif
          </div>
        </div>

        {{-- items --}}
        <div class="card mb-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Order Items</h6>
            <small class="text-muted">({{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }})</small>
          </div>
          <div class="card-body p-0">
            @if($order->items->count())
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th class="text-center">Qty</th>
                      <th class="text-end">Price</th>
                      <th class="text-end">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order->items as $item)
                      <tr>
                        <td>
                          {{ $item->product->name ?? 'Product' }}
                          @if($item->size)
                            <small class="d-block text-muted">Size: {{ $item->size }}</small>
                          @endif
                        </td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-end">{{ number_format($item->product_price, 2) }} BDT</td>
                        <td class="text-end">{{ number_format($item->total, 2) }} BDT</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <p class="p-3 mb-0 text-muted">No items found in this order.</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        {{-- order summary --}}
        <div class="card mb-3">
          <div class="card-header">
            <h6 class="mb-0">Order Summary</h6>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal</span>
              <span>{{ number_format($order->subtotal, 2) }} BDT</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Shipping</span>
              <span>{{ number_format($order->delivery_charge, 2) }} BDT</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <strong>Total</strong>
              <strong>{{ number_format($order->total, 2) }} BDT</strong>
            </div>
            <p class="mb-0"><strong>Status:</strong> <span class="text-capitalize">{{ $order->status }}</span></p>
          </div>
        </div>

        <div class="d-grid">
          <a href="{{ url('/') }}" class="btn btn-primary">Back to Shop</a>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
