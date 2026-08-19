<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Auth\StudentLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Authentication extends Controller
{
    public function showLogin(): View
    {
        return view('student.auth.login');
    }

    public function login(StudentLoginRequest $request): RedirectResponse
    {
        $request->authenticate('student');

        if (! Auth::guard('admin')->check()) {
            $request->session()->regenerate();
        }

        return redirect()->intended(route('student.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('student')->logout();

        if (! Auth::guard('admin')->check()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('student.login');
    }
}
