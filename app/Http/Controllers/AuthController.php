<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* ───────────── Staff Login ───────────── */

    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return $this->redirectByRole(Auth::guard('web')->user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email');
        }

        if (!$user->is_active) {
            return back()->withErrors(['email' => 'Akun Anda tidak aktif.'])->onlyInput('email');
        }

        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            'admin'        => redirect()->route('admin.dashboard'),
            'branch_admin' => redirect()->route('branch.dashboard'),
            'courier'      => redirect()->route('courier.dashboard'),
            'manager'      => redirect()->route('manager.dashboard'),
            default        => redirect()->route('home'),
        };
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }

    /* ───────────── Customer Register / Login ───────────── */

    public function showCustomerLoginForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.customer-login');
    }

    public function customerLogin(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('customer')->attempt($validated, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email');
    }

    public function showCustomerRegisterForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('auth.customer-register');
    }

    public function customerRegister(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:customers,email'],
            'phone'                 => ['required', 'string', 'max:20'],
            'city'                  => ['required', 'string', 'max:100'],
            'address'               => ['required', 'string'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $customer = Customer::create($validated);
        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    public function customerLogout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.login')->with('success', 'Berhasil logout.');
    }
}
