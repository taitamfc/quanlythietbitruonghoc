<?php

namespace Modules\AdminExport\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AdminExportController extends Controller
{
    protected $view_path    = 'adminexport::';
    protected $route_prefix = 'adminexport.';
    public function index(Request $request)
    {
        $type = $request->type ?? '';
        $type_slug = Str::slug($type);
        $params = [
            'route_prefix'  => $this->route_prefix,
            'templateFile'  => $type_slug.'.xlsx',
        ];
        return view($this->view_path.'types.'.$type_slug, $params);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $type = $request->type ?? '';
        $modelClass = '\Modules\AdminExport\app\Exports\\' . $type.'Export';
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
