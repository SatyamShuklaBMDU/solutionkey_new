<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Models\User;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function mylogin(Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email',
            'password'=> 'required',
        ]);
        if (auth()->guard('web')->attempt(['email'=> $request->email, 'password'=>$request->password])) {
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login');
        }   
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();
    //     Session::flash('login_message', 'Login Successfully');
    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Session::flash('logout_message', 'Logout Successfully');
        return redirect('/');
    }
}
