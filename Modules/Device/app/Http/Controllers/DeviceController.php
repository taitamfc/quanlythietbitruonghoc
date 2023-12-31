<?php

namespace Modules\Device\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Department;
class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $view_path    = 'device::';
    protected $route_prefix = 'device.';
    protected $model        = Device::class;
    public function index(Request $request)
    {
        $device_types = DeviceType::getAll();
        $departments = Department::getAll();
        $limit = $request->limit ? $request->limit : 20;
        $query = $this->model::orderBy('name','ASC');
        if($request->name){
            $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->device_type_id){
            $query->where('device_type_id',$request->device_type_id);
        }
        if($request->department_id){
            $query->where('department_id',$request->department_id);
        }
        $items = $query->paginate($limit);
        $param = [
            'items' => $items,
            'device_types' => $device_types,
            'departments' => $departments,
            'request' => $request
        ];
        if( $request->ajax() ){
            return view('device::index-ajax',$param);
        }
        return view('device::index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('device::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('device::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('device::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}