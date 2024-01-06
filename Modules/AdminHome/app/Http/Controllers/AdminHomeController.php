<?php

namespace Modules\AdminHome\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\AdminHome\App\Models\AdminHome;

class AdminHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $view_path    = 'adminhome::';
    protected $route_prefix = 'adminhome.';
    protected $model = AdminHome::class;
    public function index()
    {
        $count_statis = $this->model::getApprovedOnWeek('Borrow');
        return view($this->view_path.'index',$count_statis);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view_path.'create');
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
        return view($this->view_path.'show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view($this->view_path.'edit');
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