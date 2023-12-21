<?php

namespace Modules\Auth\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        } else {
            return view('auth::login');
        }
    }

    public function postLogin(StoreLoginRequest $request)
    {
        $dataUser = $request->only('email', 'password');
        if (Auth::attempt($dataUser, $request->remember)) {
            return redirect()->route('home.index'); 
        } else {
            return redirect()->route('website.login')->with('error', 'Account or password is incorrect');
        }
    }
    public function Logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('website.login');
    }
    public function register($type = ''){
        if (Auth::check()) {
            // return redirect()->route('website.register',['site_name'=>$this->site_name]);
            return view('auth::register');
        } else {
            return view('auth::register');
        }
    }
    public function postRegister(StoreRegisterRequest $request){
        try {
            // dd($request->all());
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->phone = $request->phone;
            $user->year_of_birth = $request->year_of_birth;
            $user->save(); 
            $message = "Successfully registered";
            return redirect()->route('website.login')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Bug occurred: ' . $e->getMessage());
            return view('auth::register')->with('error', 'Registration failed');
        }
    }

    function forgot(Request $request)
    {
        return view('auth::forgot');
    }
    public function postForgot(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found');
        }

        // Generate a random token
        $token = strtoupper(Str::random(10));

        // Save the token in the database
        $user->token = $token;
        $user->save();

        // Data to be passed to the email view
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ];

        // Send the reset password email
        Mail::send('auth::mail', compact('data'), function ($email) use ($user) {
            $email->subject('Forgot Password');
            $email->to($user->email, $user->name);
        });

        return redirect()->route('website.login')->with('success', 'Please check your email to reset the password');
    }

    public function getReset(Request $request)
    {
        $item = User::findOrFail($request->user);

        if ($item->token === $request->token) {
            $data = [
                'user' => $request->user,
                'token' => $request->token,
            ];

            return view('auth::resetpassword', compact('data'));
        } else {
            return redirect()->route('website.login')->with('error', 'There was a problem. Please try again.');
        }
    }

    public function postReset(ResetPasswordRequest $request)
    {
        $item = User::findOrFail($request->user);

        if ($item && $item->token === $request->token) {
            $item->password = bcrypt($request->password);
            $item->token = '';
            $item->save();

            return redirect()->route('website.login')->with('success', 'Password reset successful.');
        } else {
            return redirect()->route('website.login')->with('error', 'There was a problem. Please try again.');
        }
    }
}
