<?php

namespace Modules\AdminExport\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
        if($type){
            return view($this->view_path.'types.'.$type_slug, $params);
        }
        return view($this->view_path.'index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $request->type ?? '';
        $modelClass = '\Modules\AdminExport\app\Exports\\' . $type.'Export';
        $export = new $modelClass();
        $rules = $export->rules();
        $messages = $export->messages;
        if($rules){
            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->with('error','Vui lòng nhập các trường bắt buộc')
                            ->withErrors($validator)
                            ->withInput();
            }
        }
        try {
            $newFilePath = $export->handle($request);
            return response()->download($newFilePath)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Xuất dữ liệu thất bại');
        }
    }
}