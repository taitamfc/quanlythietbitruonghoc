<?php

namespace Modules\System\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('system::install.index');
    }
    public function doInstall()
    {
        $step = request()->step ?? 1;
        return view('system::install.step-'.$step);
    }
}
