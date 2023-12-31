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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminimport::create');
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
        return view('adminimport::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('adminimport::edit');
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
