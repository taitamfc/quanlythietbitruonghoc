<?php

namespace Modules\Lab\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Lab;
use App\Models\Room;
use App\Models\Department;
class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $view_path    = 'lab::';
    protected $route_prefix = 'lab.';
    protected $model        = Lab::class;
    public function index(Request $request)
    {
        $departments    = Department::getAll();
        $rooms          = Room::getAll();

        $limit = $request->limit ? $request->limit : 20;
        $query = $this->model::orderBy('name','ASC');
        if($request->name){
            $query->where('name','LIKE','%'.$request->name.'%');
        }
        if($request->lab_type_id){
            $query->where('lab_type_id',$request->lab_type_id);
        }
        if($request->department_id){
            $query->where('department_id',$request->department_id);
        }
        $items = $query->paginate($limit);
        $param = [
            'items' => $items,
            'rooms' => $rooms,
            'departments' => $departments
        ];
        if( $request->ajax() ){
            return view('lab::index-ajax',$param);
        }
        return view('lab::index',$param);
    }
}