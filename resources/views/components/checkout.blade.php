
<div class="page-content-wrapper">
  <div class="container">
    <form id="checkout-form" method="POST" action="">
      @csrf
      <div class="checkout-wrapper-area py-3">

        {{-- BILLING --}}
        <div class="billing-information-card mb-3">
          <div class="card billing-information-title-card">
            <div class="card-body">
              <h6 class="text-center mb-0">Billing Information</h6>
            </div>
          </div>
          <div class="card user-data-card">
            <div class="card-body">
              <div class="mb-2">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->name ?? '') }}" required>
              </div>
              <div class="mb-2">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
              </div>
              <div class="mb-2">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" required>
              </div>
              <div class="mb-2">
                <label class="form-label">Shipping / Address</label>
                <textarea name="address" class="form-control" required>{{ old('address', $user->address ?? '') }}</textarea>
              </div>
            </div>
          </div>
        </div>

        {{-- CART ITEMS --}}
        <div class="mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-center mb-3">Your Products</h6>

@forelse($items as $index => $item)
    @php
        // $item is App\Models\CartItems
        $product = $item->product; // because you did ->load('items.product')
        $price   = $item->unit_price; // snapshot from DB
        $qty     = $item->qty;
    @endphp

    <div class="single-cart-item d-flex align-items-center justify-content-between mb-3" data-index="{{ $index }}">
      <div class="d-flex align-items-center gap-2">
        @if($product && $product->images)
            @php
              $imgs = is_array($product->images) ? $product->images : json_decode($product->images, true);
              $firstImg = $imgs[0] ?? null;
            @endphp
            @if($firstImg)
              <img src="{{ asset($firstImg) }}" style="width:50px;height:50px;object-fit:cover" alt="">
            @endif
        @endif
        <div>
          <h6 class="mb-1">{{ $product->name ?? 'Product' }}</h6>
          <p class="mb-0 small">
            Unit:
            <span class="item-price" data-price="{{ $price }}">
              {{ number_format($price,2) }}
            </span> BDT
          </p>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary qty-minus">-</button>
        <input type="number" class="form-control form-control-sm qty-input" value="{{ $qty }}" min="1" style="width:60px">
        <button type="button" class="btn btn-sm btn-outline-secondary qty-plus">+</button>
      </div>

      <div class="text-end">
        <p class="mb-0 small">Subtotal</p>
        <p class="mb-0 fw-bold item-subtotal">0.00</p>
      </div>

      {{-- hidden inputs to send to backend --}}
      <input type="hidden" name="items[{{ $index }}][id]"   value="{{ $item->product_id }}">
      <input type="hidden" name="items[{{ $index }}][name]" value="{{ $product->name ?? 'Product' }}">
      <input type="hidden" name="items[{{ $index }}][price]" class="price-hidden" value="{{ $item->unit_price }}">
      <input type="hidden" name="items[{{ $index }}][qty]"   class="qty-hidden"  value="{{ $item->qty }}">
    </div>
@empty
    <p class="text-center mb-0">Your cart is empty.</p>
@endforelse


            </div>
          </div>
        </div>

        {{-- SHIPPING METHOD --}}
        <div class="shipping-method-choose mb-3">
          <div class="card shipping-method-choose-title-card">
            <div class="card-body">
              <h6 class="text-center mb-0">Shipping Method</h6>
            </div>
          </div>
          <div class="card shipping-method-choose-card">
            <div class="card-body">
              <div class="shipping-method-choose">
                <ul class="ps-0">
                  <li>
                    <input id="fastShipping" type="radio" name="shipping_method" value="fast" data-cost="100" checked>
                    <label for="fastShipping">Fast Shipping<span>1 day delivery for 100 BDT</span></label>
                    <div class="check"></div>
                  </li>
                  <li>
                    <input id="normalShipping" type="radio" name="shipping_method" value="regular" data-cost="60">
                    <label for="normalShipping">Regular<span>3-7 days delivery for 60 BDT</span></label>
                    <div class="check"></div>
                  </li>
                  <li>
                    <input id="courier" type="radio" name="shipping_method" value="courier" data-cost="50">
                    <label for="courier">Courier<span>5-8 days delivery for 50 BDT</span></label>
                    <div class="check"></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <input type="hidden" name="shipping_cost" id="shipping_cost" value="100">
        </div>

        {{-- TOTAL --}}
        <div class="card cart-amount-area mb-3">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1">Subtotal: <span id="subtotal-amount">0</span> BDT</p>
              <p class="mb-1">Shipping: <span id="shipping-amount">100</span> BDT</p>
              <h5 class="total-price mb-0">Total: <span id="total-amount">0</span> BDT</h5>
            </div>
            <button type="submit" class="btn btn-primary">Confirm &amp; Pay</button>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemRows = document.querySelectorAll('.single-cart-item');
    const subtotalEl = document.getElementById('subtotal-amount');
    const shippingEl = document.getElementById('shipping-amount');
    const totalEl = document.getElementById('total-amount');
    const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
    const shippingCostInput = document.getElementById('shipping_cost');

    function recalc() {
        let subtotal = 0;
        itemRows.forEach(function (row) {
            const price = parseFloat(row.querySelector('.item-price').dataset.price);
            const qtyInput = row.querySelector('.qty-input');
            const qty = parseInt(qtyInput.value) || 1;
            const itemSubtotal = price * qty;
            row.querySelector('.item-subtotal').innerText = itemSubtotal.toFixed(2);
            // update hidden qty
            row.querySelector('.qty-hidden').value = qty;
            subtotal += itemSubtotal;
        });

        // shipping
        let shippingCost = parseFloat(shippingCostInput.value) || 0;

        subtotalEl.innerText = subtotal.toFixed(2);
        shippingEl.innerText = shippingCost.toFixed(2);
        totalEl.innerText = (subtotal + shippingCost).toFixed(2);
    }

    // qty + -
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.parentElement.querySelector('.qty-input');
            input.value = parseInt(input.value || 1) + 1;
            recalc();
        });
    });
    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.parentElement.querySelector('.qty-input');
            let current = parseInt(input.value || 1);
            if (current > 1) {
                input.value = current - 1;
                recalc();
            }
        });
    });
    document.querySelectorAll('.qty-input').forEach(inp => {
        inp.addEventListener('change', recalc);
    });

    // shipping change
    shippingInputs.forEach(inp => {
        inp.addEventListener('change', function () {
            const cost = parseFloat(this.dataset.cost);
            shippingCostInput.value = cost;
            recalc();
        });
    });

    // init
    recalc();
});
</script>
@endpush
