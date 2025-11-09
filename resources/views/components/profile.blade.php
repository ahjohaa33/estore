  {{-- resources/views/components/profile-card.blade.php --}}

@php
    $user = auth()->user();
@endphp

<div class="page-content-wrapper">
  <div class="container">
    <div class="profile-wrapper-area py-3">

      {{-- User Information --}}
      <div class="card user-info-card">
        <div class="card-body p-4 d-flex align-items-center">
          <div class="user-profile me-3">
            @if($user && $user->avatar)
              <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
            @else
              <img src="{{ asset('img/avatar-placeholder.png') }}" alt="Avatar" style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
            @endif
          </div>
          <div class="user-info">
            @if($user)
              <p class="mb-0 text-white">
                {{ $user->email ?? $user->phone ?? '—' }}
              </p>
              <h5 class="mb-0 text-white">{{ $user->name }}</h5>
            @else
              <p class="mb-0 text-white">Guest</p>
              <h5 class="mb-0 text-white">Please log in</h5>
            @endif
          </div>
        </div>
      </div>

      {{-- User Meta Data --}}
      <div class="card user-data-card">
        <div class="card-body">

          {{-- Username (we'll use email as username) --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-at"></i><span>Username</span>
            </div>
            <div class="data-content">
              {{ $user ? ($user->email ?? '—') : 'Not logged in' }}
            </div>
          </div>

          {{-- Full Name --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-user"></i><span>Full Name</span>
            </div>
            <div class="data-content">
              {{ $user ? $user->name : '—' }}
            </div>
          </div>

          {{-- Phone --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-phone"></i><span>Phone</span>
            </div>
            <div class="data-content">
              {{ $user ? ($user->phone ?? 'Not set') : '—' }}
            </div>
          </div>

          {{-- Email --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-mail"></i><span>Email</span>
            </div>
            <div class="data-content">
              {{ $user ? ($user->email ?? 'Not set') : '—' }}
            </div>
          </div>

          {{-- Role --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-shield"></i><span>Role</span>
            </div>
            <div class="data-content">
              {{ $user ? ucfirst($user->role) : '—' }}
            </div>
          </div>

          {{-- Status --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-badge"></i><span>Status</span>
            </div>
            <div class="data-content">
              @if($user)
                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">
                  {{ ucfirst($user->status) }}
                </span>
              @else
                —
              @endif
            </div>
          </div>

          {{-- Last Login --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-clock"></i><span>Last Login</span>
            </div>
            <div class="data-content">
              {{ $user && $user->last_login_at ? $user->last_login_at : '—' }}
            </div>
          </div>

          {{-- Orders / action --}}
          <div class="single-profile-data d-flex align-items-center justify-content-between">
            <div class="title d-flex align-items-center">
              <i class="ti ti-star-filled"></i><span>My Orders</span>
            </div>
            <div class="data-content">
              <a class="btn btn-primary btn-sm" href="">View Status</a>
            </div>
          </div>

          {{-- Edit Profile --}}
          <div class="edit-profile-btn mt-3">
            @if($user)
              <a class="btn btn-primary btn-lg w-100" href="{{ route('userprofile') }}">
                <i class="ti ti-pencil me-2"></i>Edit Profile
              </a>
            @else
              <a class="btn btn-primary btn-lg w-100" href="{{ route('userlogin') }}">
                <i class="ti ti-login me-2"></i>Login to manage profile
              </a>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
