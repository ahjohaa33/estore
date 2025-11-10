<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){
        return view('login');
    }
    
    // REGISTER
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar'   => ['nullable'],             // we’ll handle file or string below
        ]);

        $avatarPath = null;

        // if avatar is uploaded as file
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // store in /storage/app/public/avatars
            $stored = $request->file('avatar')->store('avatars', 'public');
            $avatarPath =  $stored;
        } elseif (!empty($data['avatar']) && is_string($data['avatar'])) {
            // if user sent a direct string/path
            $avatarPath = $data['avatar'];
        }

        $user = User::create([
            'name'             => $data['name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'password'         => Hash::make($data['password']),
            'role'             => 'customer',
            'status'           => 'active',
            'avatar'           => $avatarPath, // 👈 new
            'email_verified_at'=> null,
            'last_login_at'    => now()->toDateTimeString(),
            'last_login_ip'    => $request->ip(),
            'last_user_agent'  => $request->userAgent(),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    // LOGIN
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // try login
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->withInput();
        }

        // ✅ very important: persist the login
        $request->session()->regenerate();

        $user = Auth::user();

        // if you have "status" column
        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Your account is not active.',
            ]);
        }

        return redirect()->intended(route('cart.show'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function show(Request $request){
        return view('frontend.profile');
    }
}
