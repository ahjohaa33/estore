<div class="page-content-wrapper">
  <div class="container">
    <form id="checkout-form" method="POST" action="{{ route('placeorder') }}">
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
              {{-- Full Name --}}
              <div class="mb-2">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input
                  type="text"
                  name="full_name"
                  class="form-control @error('full_name') is-invalid @enderror"
                  value="{{ old('full_name', $user->name ?? '') }}"
                  required
                >
                @error('full_name')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
                <small class="text-danger d-none" id="err-full_name">Full name is required.</small>
              </div>

              {{-- Email --}}
              <div class="mb-2">
                <label class="form-label">Email Address </label>
                <input
                  type="email"
                  name="email"
                  class="form-control"
                  value="{{ old('email', $user->email ?? '') }}"
                >
              </div>

              {{-- Phone --}}
              <div class="mb-2">
                <label class="form-label">Phone <span class="text-danger">*</span></label>
                <input
                  type="text"
                  name="phone"
                  class="form-control @error('phone') is-invalid @enderror"
                  value="{{ old('phone', $user->phone ?? '') }}"
                  required
                >
                @error('phone')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
                <small class="text-danger d-none" id="err-phone">Phone number is required.</small>
              </div>

              {{-- Address --}}
              <div class="mb-2">
                <label class="form-label">Shipping / Address <span class="text-danger">*</span></label>
                <textarea
                  name="address"
                  class="form-control @error('address') is-invalid @enderror"
                  required>{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
                <small class="text-danger d-none" id="err-address">Address is required.</small>
              </div>
            </div>
          </div>
        </div>

        {{-- CART ITEMS --}}
        <div class="mb-3">
          <div class="card">
            <div class="card-body">
              <h6 class="text-center mb-3">Your Products</h6>

              {{-- empty message --}}
              <p class="text-center mb-0 cart-empty-msg {{ count($items) ? 'd-none' : '' }}">Your cart is empty.</p>

              @forelse($items as $index => $item)
                  @php
                      $product = $item->product;
                      $price   = $item->unit_price;
                      $qty     = $item->qty;
                  @endphp

                  <div class="single-cart-item d-flex align-items-center justify-content-between mb-3 gap-2"
                       data-index="{{ $index }}"
                       data-item-id="{{ $item->id }}"
                       data-remove-url="{{ route('cart.remove', $item->id) }}">
                    <div class="d-flex align-items-center gap-2">
                      @if($product && $product->images)
                          @php
                            $imgs = is_array($product->images) ? $product->images : json_decode($product->images, true);
                            $firstImg = $imgs[0] ?? null;
                          @endphp
                          @if($firstImg)
                            <img src="{{ asset('storage').'/'.$firstImg }}" style="width:50px;height:50px;object-fit:cover" alt="">
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

                    {{-- delete icon --}}
                    <button type="button" class="btn btn-sm btn-danger remove-item" aria-label="Remove">
                      &times;
                    </button>

                    {{-- hidden inputs --}}
                    <input type="hidden" name="items[{{ $index }}][id]"   value="{{ $item->product_id }}" class="item-id">
                    <input type="hidden" name="items[{{ $index }}][name]" value="{{ $product->name ?? 'Product' }}" class="item-name">
                    <input type="hidden" name="items[{{ $index }}][price]" class="price-hidden" value="{{ $item->unit_price }}">
                    <input type="hidden" name="items[{{ $index }}][qty]"   class="qty-hidden"  value="{{ $item->qty }}">
                  </div>
              @empty
                  {{-- handled above --}}
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
                    <input id="fastShipping" type="radio" name="shipping_method" value="fast" data-cost="100" checked required>
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
            <button type="submit" class="btn btn-primary" id="order-now-btn">
              Order Now
            </button>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const subtotalEl = document.getElementById('subtotal-amount');
    const shippingEl = document.getElementById('shipping-amount');
    const totalEl = document.getElementById('total-amount');
    const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
    const shippingCostInput = document.getElementById('shipping_cost');
    const form = document.getElementById('checkout-form');
    const orderBtn = document.getElementById('order-now-btn');
    const emptyMsg = document.querySelector('.cart-empty-msg');

    const csrfToken = form.querySelector('input[name="_token"]').value;

    function getItemRows() {
        return document.querySelectorAll('.single-cart-item');
    }

    function toggleEmptyMsg() {
        if (getItemRows().length === 0) {
            emptyMsg.classList.remove('d-none');
            // reset totals
            subtotalEl.innerText = '0.00';
            // shipping stays as selected
            const shipCost = parseFloat(shippingCostInput.value) || 0;
            shippingEl.innerText = shipCost.toFixed(2);
            totalEl.innerText = shipCost.toFixed(2);
        } else {
            emptyMsg.classList.add('d-none');
        }
    }

    function recalc() {
        let subtotal = 0;
        getItemRows().forEach(function (row) {
            const price = parseFloat(row.querySelector('.item-price').dataset.price);
            const qtyInput = row.querySelector('.qty-input');
            const qty = parseInt(qtyInput.value) || 1;
            const itemSubtotal = price * qty;
            row.querySelector('.item-subtotal').innerText = itemSubtotal.toFixed(2);
            row.querySelector('.qty-hidden').value = qty;
            subtotal += itemSubtotal;
        });

        let shippingCost = parseFloat(shippingCostInput.value) || 0;

        subtotalEl.innerText = subtotal.toFixed(2);
        shippingEl.innerText = shippingCost.toFixed(2);
        totalEl.innerText = (subtotal + shippingCost).toFixed(2);
    }

    function reindexItems() {
        getItemRows().forEach(function (row, idx) {
            const idInput    = row.querySelector('.item-id');
            const nameInput  = row.querySelector('.item-name');
            const priceInput = row.querySelector('.price-hidden');
            const qtyHidden  = row.querySelector('.qty-hidden');

            if (idInput)    idInput.name    = `items[${idx}][id]`;
            if (nameInput)  nameInput.name  = `items[${idx}][name]`;
            if (priceInput) priceInput.name = `items[${idx}][price]`;
            if (qtyHidden)  qtyHidden.name  = `items[${idx}][qty]`;
        });
    }

    // event delegation
    document.addEventListener('click', function (e) {
        // qty plus
        if (e.target.classList.contains('qty-plus')) {
            const input = e.target.parentElement.querySelector('.qty-input');
            input.value = parseInt(input.value || 1) + 1;
            recalc();
        }
        // qty minus
        if (e.target.classList.contains('qty-minus')) {
            const input = e.target.parentElement.querySelector('.qty-input');
            let current = parseInt(input.value || 1);
            if (current > 1) {
                input.value = current - 1;
                recalc();
            }
        }

        // remove item (AJAX DELETE)
        if (e.target.classList.contains('remove-item')) {
            const row = e.target.closest('.single-cart-item');
            const removeUrl = row.dataset.removeUrl;

            // if somehow no url, just remove from DOM
            if (!removeUrl) {
                row.remove();
                reindexItems();
                recalc();
                toggleEmptyMsg();
                return;
            }

            e.target.disabled = true;

            fetch(removeUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // backend returns ['message'=>'Removed','totals'=>$cart->totals()]
                row.remove();
                reindexItems();
                // if you want to trust backend totals:
                if (data.totals && typeof data.totals.subtotal !== 'undefined') {
                    subtotalEl.innerText = parseFloat(data.totals.subtotal).toFixed(2);
                    // we still use current shipping
                    const ship = parseFloat(shippingCostInput.value) || 0;
                    shippingEl.innerText = ship.toFixed(2);
                    totalEl.innerText = (parseFloat(data.totals.subtotal) + ship).toFixed(2);
                } else {
                    recalc();
                }
                toggleEmptyMsg();
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong while removing the item.');
                e.target.disabled = false;
            });
        }
    });

    // qty direct change
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('qty-input')) {
            if (parseInt(e.target.value) < 1 || isNaN(parseInt(e.target.value))) {
                e.target.value = 1;
            }
            recalc();
        }
    });

    // shipping change
    shippingInputs.forEach(inp => {
        inp.addEventListener('change', function () {
            const cost = parseFloat(this.dataset.cost);
            shippingCostInput.value = cost;
            recalc();
        });
    });

    // initial
    recalc();
    toggleEmptyMsg();

    // form submit = disable btn + spinner
    form.addEventListener('submit', function(e) {
        let hasError = false;

        const fullName = form.querySelector('[name="full_name"]');
        const phone    = form.querySelector('[name="phone"]');
        const address  = form.querySelector('[name="address"]');

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('#err-full_name,#err-phone,#err-address').forEach(el => el.classList.add('d-none'));

        if (!fullName.value.trim()) {
            fullName.classList.add('is-invalid');
            document.getElementById('err-full_name').classList.remove('d-none');
            hasError = true;
        }
        if (!phone.value.trim()) {
            phone.classList.add('is-invalid');
            document.getElementById('err-phone').classList.remove('d-none');
            hasError = true;
        }
        if (!address.value.trim()) {
            address.classList.add('is-invalid');
            document.getElementById('err-address').classList.remove('d-none');
            hasError = true;
        }

        if (getItemRows().length === 0) {
            alert('Your cart is empty.');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            form.scrollIntoView({behavior: 'smooth'});
            return;
        }

        orderBtn.disabled = true;
        orderBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Placing...`;
    });
});
</script>
@endpush
