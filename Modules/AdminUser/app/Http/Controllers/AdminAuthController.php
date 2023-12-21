<?php

namespace Modules\AdminUser\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('adminuser::auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('adminuser.index');
        }
    }

    public function register()
    {
    }

    public function postRegister(Request $request)
    {
    }

    public function postForgotPass(Request $request)
    {
    }

    public function resetPass()
    {
    }

    public function postResetPass(Request $request)
    {
    }
    
}
