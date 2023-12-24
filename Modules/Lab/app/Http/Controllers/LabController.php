<?php

namespace Modules\Lab\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

use Modules\Lab\app\Models\Lab;
use App\Models\Department;

class LabController extends Controller
{
    protected $view_path    = 'lab::';
    protected $route_prefix = 'lab.';
    protected $model        = Lab::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $items = $this->model::getItems($request);
            $departments = Department::all();
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'departments'   => $departments,
                'items'         => $items,
            ];
            if( $request->ajax() ){
                return view($this->view_path.'index-ajax', $params);
            }
            return view($this->view_path.'index', $params);
        } catch (QueryException $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return redirect()->back()->with('error',  __('sys.get_items_error'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lab::create');
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
        return view('lab::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('lab::edit');
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
