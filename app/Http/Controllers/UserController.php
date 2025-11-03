<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){
        return view('login');
    }


    public function login(Request $request)
    {
        $wantsJson = $request->expectsJson() || $request->wantsJson() || $request->ajax();

        $respond = function (int $status, array $payload, $redirect = null) use ($wantsJson) {
            return $wantsJson
                ? response()->json($payload, $status)
                : ($redirect ?? back()->withErrors(['login' => $payload['message'] ?? 'Error'])->withInput());
        };

        // 1) Validate (light but safe)
        $request->validate([
            'login'         => ['required','string','min:3','max:191'],
            'password'      => ['required','string','min:6','max:191'],
            'remember'      => ['nullable','boolean'],
            'expected_role' => ['nullable','in:admin,moderator,customer,advisor'],
        ]);

        // 2) Normalize (defend against tricky Unicode & messy phones)
        $rawLogin = trim((string) $request->input('login'));
        if (class_exists(\Normalizer::class)) {
            $rawLogin = \Normalizer::normalize($rawLogin, \Normalizer::FORM_KC) ?? $rawLogin;
        }
        $isEmail = filter_var($rawLogin, FILTER_VALIDATE_EMAIL);
        $login   = $isEmail
            ? Str::lower($rawLogin)
            : preg_replace('/(?!^\+)[^\d]/', '', $rawLogin); // keep a leading '+', strip other non-digits
        $field   = $isEmail ? 'email' : 'phone';

        // 3) Concurrency-safe throttle (atomic)
        $throttleKey = Str::lower($login).'|'.$request->ip();
        $maxAttempts = 5;     // tune as needed
        $decaySecs   = 60;    // per attempt window

        $result = RateLimiter::attempt($throttleKey, $maxAttempts, function () use (
            $request, $field, $login
        ) {
            // 4) Single, tight lookup (only columns we need)
            $user = \App\Models\User::query()
                ->select('id','name','email','password','role','status')
                ->where($field, $login)
                ->first();

            // 5) Constant-time user enumeration defense
            // Always perform a hash check (real or fake) to equalize timing.
            // Precomputed bcrypt for the string 'fake-password-do-not-use'
            static $FAKE_HASH = '$2y$10$XfKq1/3bY7v0A0P7tZr3Xu8y0h1mJ0TT4dQ4e2c8w8c2g0vQwXo0e';
            $password = (string) $request->input('password');
            $validPwd = $user ? Hash::check($password, $user->password) : Hash::check($password, $FAKE_HASH);

            if (!$user || !$validPwd) {
                // fail this attempt (RateLimiter will count one)
                return false;
            }

            // 6) Post-auth gates (status/role) AFTER password check to avoid enumeration
            if (Str::lower((string) $user->status) !== 'active') {
                // Soft-fail: behave like invalid credentials to avoid leaking state
                return false;
            }
            if ($request->filled('expected_role') &&
                Str::lower((string) $user->role) !== Str::lower($request->input('expected_role'))) {
                // Soft-fail: same reason
                return false;
            }

            // 7) Login, rotate session
            Auth::guard($this->guard)->loginUsingId($user->id, $request->boolean('remember', false));
            $request->session()->regenerate();

            // 8) Silent audit (optional fields)
            try {
                $user->forceFill([
                    'last_login_at'   => now(),
                    'last_login_ip'   => $request->ip(),
                    'last_user_agent' => Str::limit((string) $request->userAgent(), 500, ''),
                ])->saveQuietly();
            } catch (\Throwable $e) {
                // ignore audit failures to keep auth path hot
            }

            return $user;
        }, $decaySecs);

        // 9) Unified responses (fast path vs slow path)
        if ($result === false) {
            $available = RateLimiter::availableIn($throttleKey);
            if ($available > 0 && RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
                return $respond(429, ['message' => "Too many attempts. Try again in {$available} seconds."]);
            }
            return $respond(401, ['message' => 'Invalid credentials.']);
        }

        // Success: optional cleanup (not strictly needed with attempt())
        RateLimiter::clear($throttleKey);

        $user       = $result; // The actual User instance returned above
        $redirectTo = route($this->redirectRoute);

        return $respond(200, [
            'message'  => 'Logged in successfully.',
            'user'     => [
                'id'     => $user->id,
                'name'   => $user->name,
                'email'  => $user->email,
                'role'   => $user->role,
                'status' => $user->status,
            ],
            'redirect' => $redirectTo,
        ], redirect()->intended($redirectTo));
    }

    public function logout(Request $request)
    {
        $wantsJson = $request->expectsJson() || $request->wantsJson() || $request->ajax();
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::debug('LOGOUT done', ['guard' => $this->guard]);

        return $this->respond(
            $wantsJson, 200,
            ['message' => 'Logged out.'],
            redirect()->route('login')
        );
    }

    protected function respond(bool $wantsJson, int $status, array $payload, $redirectResponse)
    {
        return $wantsJson ? response()->json($payload, $status) : $redirectResponse;
    }


}
