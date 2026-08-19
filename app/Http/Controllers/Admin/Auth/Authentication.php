<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Authentication
{
    public function showLogin(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate('admin');

        if (! Auth::guard('student')->check()){

            $request->session()->regenerate();
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        if (! Auth::guard('student')->check()){

            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }
}
