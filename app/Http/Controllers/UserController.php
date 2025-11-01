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

class UserController extends Controller
{

    public function index(){
        return view('login');
    }

        // Make sure this guard matches your protected routes (e.g., 'web' or 'admin')
    protected string $guard = 'web';
    protected string $redirectRoute = 'admindashboard'; // change if needed

    public function login(Request $request)
    {
        $wantsJson = $request->expectsJson() || $request->wantsJson() || $request->ajax();

        Log::debug('LOGIN start', [
            'ip'      => $request->ip(),
            'ua'      => substr((string) $request->userAgent(), 0, 200),
            'guard'   => $this->guard,
            'accepts' => $wantsJson ? 'json' : 'redirect',
            'url'     => $request->fullUrl(),
        ]);

        // 1) Validate: single "login" (email or phone)
        $v = Validator::make($request->all(), [
            'login'    => ['required', 'string', 'min:3', 'max:191'],
            'password' => ['required', 'string', 'min:6', 'max:191'],
            'remember' => ['nullable', 'boolean'],
            'expected_role' => ['nullable', 'in:admin,moderator,customer,advisor'],
        ]);

        if ($v->fails()) {
            Log::debug('LOGIN validation failed', ['errors' => $v->errors()->toArray()]);
            return $this->respond(
                $wantsJson, 422,
                ['message' => 'Validation failed.', 'errors' => $v->errors()],
                back()->withErrors($v)->withInput()
            );
        }

        $login        = trim((string) $request->input('login'));
        $password     = (string) $request->input('password');
        $remember     = (bool) $request->boolean('remember', false);
        $expectedRole = $request->input('expected_role');

        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);
        if ($isEmail) $login = strtolower($login);
        else          $login = preg_replace('/\s+/', '', $login); // phone: strip spaces

        // 2) Rate limit
        $throttleKey = Str::lower($login) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            Log::warning('LOGIN throttled', ['key' => $throttleKey, 'wait' => $seconds]);
            return $this->respond(
                $wantsJson, 429,
                ['message' => "Too many attempts. Try again in {$seconds} seconds."],
                back()->withErrors(['login' => "Too many attempts. Try again in {$seconds} seconds."])
                    ->withInput()
            );
        }

        // 3) Find user
        $field = $isEmail ? 'email' : 'phone';
        $user = User::query()
            ->where($field, $login)
            ->first();

        if (!$user) {
            RateLimiter::hit($throttleKey, 60);
            Log::debug('LOGIN no user found', ['field' => $field, 'login' => $login]);
            return $this->respond(
                $wantsJson, 401,
                ['message' => 'These credentials do not match our records.'],
                back()->withErrors(['login' => 'These credentials do not match our records.'])->withInput()
            );
        }

        // 4) Gates: status must be active
        $status = Str::lower((string) $user->status); // active|blocked|suspended|inactive
        if ($status !== 'active') {
            Log::debug('LOGIN blocked by status', ['status' => $status, 'user_id' => $user->id]);
            return $this->respond(
                $wantsJson, 403,
                ['message' => 'Your account is not active. Please contact support.'],
                back()->withErrors(['login' => 'Your account is not active. Please contact support.'])->withInput()
            );
        }

        // OPTIONAL: email verification (temporarily disabled for diagnostics)
        // if (is_null($user->email_verified_at)) {
        //     Log::debug('LOGIN blocked: email not verified', ['user_id' => $user->id]);
        //     return $this->respond(
        //         $wantsJson, 403,
        //         ['message' => 'Please verify your email before logging in.'],
        //         back()->withErrors(['login' => 'Please verify your email before logging in.'])->withInput()
        //     );
        // }

        // Optional portal role restriction
        if (!empty($expectedRole)) {
            $role = Str::lower((string) $user->role); // admin|moderator|customer|advisor
            if ($role !== $expectedRole) {
                Log::debug('LOGIN blocked: role mismatch', ['role' => $role, 'expected' => $expectedRole, 'user_id' => $user->id]);
                return $this->respond(
                    $wantsJson, 403,
                    ['message' => 'You do not have permission to access this area.'],
                    back()->withErrors(['login' => 'You do not have permission to access this area.'])->withInput()
                );
            }
        }

        // 5) Attempt login on the correct guard
        $credentials = [$field => $login, 'password' => $password];

        Log::debug('LOGIN attempting', ['guard' => $this->guard, 'field' => $field, 'login' => $login]);
        $ok = Auth::guard($this->guard)->attempt($credentials, $remember);

        if (!$ok) {
            RateLimiter::hit($throttleKey, 60);
            Log::debug('LOGIN invalid password', ['user_id' => $user->id]);
            return $this->respond(
                $wantsJson, 401,
                ['message' => 'Invalid credentials.'],
                back()->withErrors(['login' => 'Invalid credentials.'])->withInput()
            );
        }

        // 6) Verify session & user on guard, then rotate session
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        $guardCheck = Auth::guard($this->guard)->check();
        $authedId   = optional(Auth::guard($this->guard)->user())->id;

        Log::debug('LOGIN success', [
            'guard_check' => $guardCheck,
            'authed_id'   => $authedId,
            'session_id'  => $request->session()->getId(),
        ]);

        if (!$guardCheck) {
            // If this fires, it’s a session problem (cookie/domain/https)
            Log::error('LOGIN session not sticking after attempt()', [
                'driver' => config('session.driver'),
                'domain' => config('session.domain'),
                'secure' => config('session.secure'),
                'sameSite' => config('session.same_site'),
            ]);
        }

        // 7) Audit
        $user->forceFill([
            'last_login_at'   => now(),
            'last_login_ip'   => $request->ip(),
            'last_user_agent' => substr((string) $request->userAgent(), 0, 500),
        ])->saveQuietly();

        $redirectTo = route($this->redirectRoute);

        return $this->respond(
            $wantsJson, 200,
            [
                'message'  => 'Logged in successfully.',
                'user'     => [
                    'id'     => $user->id,
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'role'   => $user->role,
                    'status' => $user->status,
                ],
                'redirect' => $redirectTo,
            ],
            redirect()->intended($redirectTo)
        );
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
