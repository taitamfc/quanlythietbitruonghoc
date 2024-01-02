<?php

namespace Modules\AdminImport\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
class AdminImportController extends Controller
{
    protected $view_path    = 'adminimport::';
    protected $route_prefix = 'adminimport.';
    public function index(Request $request)
    {
        $type = $request->type ?? '';
        $type_slug = strtolower($type);
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
    public function store(Request $request): RedirectResponse
    {
        $type = $request->type ?? '';
        $modelClass = '\Modules\AdminImport\app\Imports\\' . $type.'Import';
        $import = new $modelClass();
        $rules = $import->rules ?? [];
        $messages = $import->messages ?? [];
        $rules = array_merge($rules,[
            'file' => 'required|mimes:xlsx, xls'
        ]);
        $messages = array_merge($messages,[
            'required' => 'Trường yêu cầu',
            'mimes' => 'Định dạng tệp không hỗ trợ',
        ]);
        if( count($rules) ){
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
            Excel::import($import, request()->file('file'));
            return redirect()->back()->with('success', 'Nhập dữ liệu thành công');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Nhập dữ liệu thất bại');
        }
    }
}