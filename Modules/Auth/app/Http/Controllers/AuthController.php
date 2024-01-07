<?php

namespace Modules\Auth\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Modules\Auth\app\Http\Requests\StoreLoginRequest;
use Modules\Auth\app\Http\Requests\StoreRegisterRequest;
use Modules\Auth\app\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\app\Http\Requests\ResetPasswordRequest;
use Mail;
use Modules\Auth\app\Jobs\SendEmail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $view_path    = 'auth::';
    protected $route_prefix = 'auth.';
    protected $model        = User::class;
    public function login()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('home');
            } else {
                return view($this->view_path.'login');
            }
        } catch (\Exception $e) {
            Log::error('Bug login : '.$e->getMessage());
            return back()->with('error','Vui lòng thử lại');
        }
    }

    public function postLogin(StoreLoginRequest $request)
    {
        try {
            $dataUser = $request->only('email', 'password');
            if (Auth::attempt($dataUser, $request->remember)) {
                // Đã vào được
                return redirect()->route('home');
            } else {
                return redirect()->route($this->route_prefix.'login')->with('error', 'Tài khoản hoặc mật khẩu không chính xác!');
            }
        } catch (\Exception $e) {
            Log::error('Bug login : '.$e->getMessage());
            return redirect()->route($this->route_prefix.'login')->with('error','Vui lòng thử lại');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route($this->route_prefix.'login');
    }
    function forgot(Request $request)
    {
        return view($this->view_path.'forgot');
    }
    public function postForgot(ForgotPasswordRequest $request)
    {
        try {
            $item = $this->model::where('email', $request->email)->first();
            if (!$item) {
                return back()->with('error', 'Email not found');
            }
            $token = strtoupper(Str::random(10));
            $item->token = $token;
            $item->save();
            $data = [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'token' => $token
            ];
            SendEmail::dispatch($item,$data,'forgot_pass');
            return redirect()->route($this->route_prefix.'login')->with('success', 'Kiểm tra email của bạn dể đặt lại mặt khẩu');
        } catch (\Exception $e) {
            Log::error('Bug reset password : '.$e->getMessage());
            return redirect()->route($this->route_prefix.'forgot')->with('error', 'Vui lòng thử lại!');
        }
    }

    public function getReset(Request $request)
    {
        try {
            $item = $this->model::findOrFail($request->user);
            if ($item->token === $request->token) {
                $data = [
                    'user' => $request->user,
                    'token' => $request->token,
                ];
                return view($this->view_path.'resetpassword', $data);
            } else {
                return redirect()->route($this->route_prefix.'login')->with('error', 'Vui lòng thử lại!');
            }
        } catch (\Exception $e) {
            Log::error('Bug reset password : '.$e->getMessages());
            return redirect()->route($this->route_prefix.'login')->with('error', 'Vui lòng thử lại!');
        }
    }

    public function postReset(ResetPasswordRequest $request)
    {
        try {
            $item = $this->model::findOrFail($request->user);
            if ($item && $item->token === $request->token) {
                $item->password = bcrypt($request->password);
                $item->token = '';
                $item->save();
                return redirect()->route($this->route_prefix.'login')->with('success', 'Đặt lại mật khẳu thành công.');
            } else {
                return back()->with('error', 'Vui lòng thử lại');
            }
        } catch (\Exception $e) {
            Log::error('Bug reset password : '.$e->getMessages());
            return redirect()->route($this->route_prefix.'login')->with('error', 'Vui lòng thử lại!');
        }
    }
}