  <form action="{{ route('search.index') }}" method="get" class="product-search-form position-relative w-75"
      onsubmit="return handleSearchSubmit(event)">

      <div class="product-search-input-wrapper d-flex align-items-center">
          <input id="search-input" name="q" class="form-control shadow-none product-search-input " type="search"
              autocomplete="off" placeholder="Search in store..." aria-autocomplete="list"
              aria-controls="search-suggestions" aria-expanded="false" aria-haspopup="listbox" role="combobox">
          <button type="submit" class="btn product-search-btn d-flex align-items-center justify-content-center">
              <i class="ti ti-search"></i>
          </button>
      </div>

      <!-- Suggestions dropdown -->
      <ul id="search-suggestions" class="search-suggestions list-unstyled shadow-sm rounded-3" role="listbox"
          aria-label="Search suggestions">
          <!-- suggestions inserted here by JS -->
      </ul>
  </form>

  

  @push('styles')
      <style>
          /* small styles to make suggestions look decent */
          #search-suggestions li {
              padding: 8px;
              cursor: pointer;
              display: flex;
              gap: 10px;
              align-items: center;
              border-bottom: 1px solid #eee;
          }

          #search-suggestions li:last-child {
              border-bottom: none;
          }

          #search-suggestions li:hover,
          #search-suggestions li[aria-selected="true"] {
              background: #f3f3f3;
          }

          #search-suggestions img {
              width: 48px;
              height: 48px;
              object-fit: cover;
              border-radius: 6px;
          }

          #search-suggestions .meta {
              display: flex;
              flex-direction: column;
          }

          #search-suggestions .name {
              font-weight: 600;
              font-size: 0.95rem;
          }

          #search-suggestions .price {
              font-size: 0.85rem;
              opacity: 0.85;
              margin-top: 4px;
          }
      </style>
  @endpush


  @push('scripts')
      <script>
          (function() {
              const input = document.getElementById('search-input');
              const list = document.getElementById('search-suggestions');
              const endpoint = '{{ route('search.suggestions') }}';
              let currentIndex = -1;
              let suggestions = [];
              let controller = null; // for aborting previous fetches

              function debounce(fn, wait) {
                  let t;
                  return function(...args) {
                      clearTimeout(t);
                      t = setTimeout(() => fn.apply(this, args), wait);
                  };
              }

              async function fetchSuggestions(q) {
                  if (controller) controller.abort();
                  controller = new AbortController();

                  try {
                      const res = await fetch(endpoint + '?q=' + encodeURIComponent(q), {
                          signal: controller.signal
                      });
                      if (!res.ok) return [];
                      const data = await res.json();
                      return data;
                  } catch (e) {
                      if (e.name === 'AbortError') return [];
                      console.error('Suggestion fetch error', e);
                      return [];
                  } finally {
                      controller = null;
                  }
              }

              function positionSuggestionPanel() {
                  const rect = input.getBoundingClientRect();

                  // Beautiful overlay panel style
                  list.style.position      = 'fixed';
                  list.style.left          = rect.left + 'px';
                  list.style.top           = (rect.bottom + 8) + 'px'; // input-এর নিচে একটু gap
                  list.style.width         = rect.width + 'px';
                  list.style.maxHeight     = '420px';
                  list.style.overflowY     = 'auto';
                  list.style.zIndex        = '1050';

                  list.style.background    = 'rgba(255,255,255,0.98)';
                  list.style.borderRadius  = '14px';
                  list.style.border        = '1px solid rgba(148,163,184,0.5)';
                  list.style.boxShadow     = '0 18px 45px rgba(15,23,42,0.25)';
                  list.style.padding       = '6px 0';
                  list.style.backdropFilter = 'blur(14px)'; // supported browsers এ nice glass effect
              }

              function renderSuggestions(items) {
                  suggestions = items;
                  currentIndex = -1;
                  list.innerHTML = '';

                  if (!items.length) {
                      list.style.display = 'none';
                      input.setAttribute('aria-expanded', 'false');
                      return;
                  }

                  const fragment = document.createDocumentFragment();

                  items.forEach((it, i) => {
                      const li = document.createElement('li');
                      li.setAttribute('role', 'option');
                      li.setAttribute('data-index', i);
                      li.tabIndex = -1;
                      li.innerHTML = `
                      <a href="${it.url}" class="suggestion-item" style="display:flex;align-items:center;gap:10px;text-decoration:none;color:inherit;padding:8px 12px;">
                          <div class="thumb-wrapper">
                            <img src="${it.image}" alt="${escapeHtml(it.name)}"
                                class="thumb"
                                style="width:60px;height:60px;object-fit:cover;border-radius:10px;">
                          </div>
                          <div class="meta" style="display:flex;flex-direction:column;">
                            <div class="name" style="font-weight:600;font-size:0.95rem;">${escapeHtml(it.name)}</div>
                            ${it.price ? `<div class="price" style="font-size:0.85rem;opacity:0.8;margin-top:2px;">${formatPrice(it.price)}</div>` : ''}
                          </div>
                      </a>
                      `;

                      li.addEventListener('click', () => {
                          window.location.href = it.url;
                      });
                      li.addEventListener('mousemove', () => {
                          setActiveIndex(i);
                      });
                      fragment.appendChild(li);
                  });

                  list.appendChild(fragment);

                  // Position & show as overlay
                  positionSuggestionPanel();
                  list.style.display = 'block';
                  input.setAttribute('aria-expanded', 'true');
              }


              function setActiveIndex(i) {
                  const items = Array.from(list.children);
                  if (items.length === 0) return;
                  items.forEach((el, idx) => {
                      if (idx === i) {
                          el.setAttribute('aria-selected', 'true');
                          el.scrollIntoView({
                              block: 'nearest',
                              inline: 'nearest'
                          });
                      } else {
                          el.removeAttribute('aria-selected');
                      }
                  });
                  currentIndex = i;
              }

              function escapeHtml(s) {
                  return String(s).replace(/[&<>"']/g, function(m) {
                      return ({
                          '&': '&amp;',
                          '<': '&lt;',
                          '>': '&gt;',
                          '"': '&quot;',
                          "'": "&#39;"
                      })[m];
                  });
              }

              function formatPrice(p) {
                  // tries to format price nicely; adapt to your currency
                  try {
                      return new Intl.NumberFormat(undefined, {
                          style: 'currency',
                          currency: '{{ config('app.currency', 'BDT') }}'
                      }).format(p);
                  } catch (e) {
                      return p;
                  }
              }

              const onInput = debounce(async function(e) {
                  const q = e.target.value.trim();
                  if (!q) {
                      renderSuggestions([]);
                      return;
                  }
                  const data = await fetchSuggestions(q);
                  renderSuggestions(data);
              }, 220);

              input.addEventListener('input', onInput);

              // keyboard nav
              input.addEventListener('keydown', function(e) {
                  const items = Array.from(list.children);
                  if (!items.length) return;

                  if (e.key === 'ArrowDown') {
                      e.preventDefault();
                      setActiveIndex(Math.min(currentIndex + 1, items.length - 1));
                  } else if (e.key === 'ArrowUp') {
                      e.preventDefault();
                      setActiveIndex(Math.max(currentIndex - 1, 0));
                  } else if (e.key === 'Enter') {
                      const indexToOpen = currentIndex >= 0 ? currentIndex : null;
                      if (indexToOpen !== null) {
                          e.preventDefault();
                          const chosen = suggestions[indexToOpen];
                          if (chosen && chosen.url) window.location.href = chosen.url;
                      } // else let the form submit to the search results page
                  } else if (e.key === 'Escape') {
                      renderSuggestions([]);
                  }
              });

              // click outside closes the list
              document.addEventListener('click', (ev) => {
                  if (!document.getElementById('product-search').contains(ev.target)) {
                      renderSuggestions([]);
                  }
              });

              // optional: when form submitted, redirect to search results page
              window.handleSearchSubmit = function(ev) {
                  // allow default submission (GET) - if you prefer to use JS redirect, return false and do it here
                  return true;
              };

          })();
      </script>
  @endpush
