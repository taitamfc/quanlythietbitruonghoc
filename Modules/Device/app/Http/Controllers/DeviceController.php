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
    public function index(Request $request)
    {
        $device_types = DeviceType::all();
        $departments = Department::all();
        $query = Device::query();
        $query = Device::query();
        if($request->searchName){
            $query->where('name','LIKE','%'.$request->searchName.'%');
        }
        if($request->searchDeviceType){
            $query->where('device_type_id',$request->searchDeviceType);
        }
        if($request->searchDepartment){
            $query->where('department_id',$request->searchDepartment);
        }
        $items = $query->paginate(5);
        $param = [
            'items' => $items,
            'device_types' => $device_types,
            'departments' => $departments,
            'request' => $request
        ];
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