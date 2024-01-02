<?php

namespace Modules\AdminImport\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminImportController extends Controller
{
    protected $view_path    = 'adminimport::';
    protected $route_prefix = 'adminimport.';
    public function index(Request $request)
    {
        $type = $request->type;
        $params = [
            'route_prefix'  => $this->route_prefix,
        ];
        return view($this->view_path.'index', $params);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $type = $request->type ?? '';
        $modelClass = '\Modules\AdminImport\app\Imports\\' . $type.'Import';
        try {
            $import = new $modelClass();
            dd($import);
            // Excel::import($import, request()->file('file'));
            return redirect()->back()->with('success', 'Nhập dữ liệu thành công');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Nhập dữ liệu thất bại');
        }
        
    }
}
