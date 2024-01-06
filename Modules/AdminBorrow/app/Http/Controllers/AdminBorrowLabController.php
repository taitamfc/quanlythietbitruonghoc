<?php

namespace Modules\AdminBorrow\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AdminBorrow\app\Models\BorrowLab;
use Carbon\Carbon;

class AdminBorrowLabController extends Controller
{
    protected $view_path    = 'adminborrow::borrowlabs.';
    protected $route_prefix = 'adminborrow.';
    protected $model        = BorrowLab::class;
    public function labs(Request $request)
    {
        
        if( !$request->week ){
            $currentWeek    = Carbon::now()->format('Y-\WW');
            $startDateEndDate = $this->model::getStartEndDateFromWeek($currentWeek);
            $request->merge([
                'week' => $currentWeek
            ]);
        }else{
            $startDateEndDate = $this->model::getStartEndDateFromWeek($request->week);
        }
        $items = $this->model::getItems($request);
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'items'         => $items
        ];
        $params = array_merge($params,$startDateEndDate);
        return view($this->view_path.'labs', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminborrow::create');
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
        return view('adminborrow::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('adminborrow::edit');
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
