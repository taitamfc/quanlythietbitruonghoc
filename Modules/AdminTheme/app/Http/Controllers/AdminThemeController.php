<?php

namespace Modules\AdminTheme\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminThemeController extends Controller
{
    public function index()
    {
        var_dump(Auth::id());
        return view('admintheme::index');
    }
    public function create()
    {
        return view('admintheme::create');
    }
    public function login()
    {
        return view('admintheme::login');
    }
    public function settings()
    {
        return view('admintheme::settings');
    }
}
