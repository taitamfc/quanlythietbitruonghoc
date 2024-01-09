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
        if( $request->lab_id ){
            return $this->show($request);
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

    public function show(Request $request){
        if( !$request->week ){
            $currentWeek    = Carbon::now()->format('Y-\WW');
            $startDateEndDate = $this->model::getStartEndDateFromWeek($currentWeek);
            $request->merge([
                'week' => $currentWeek
            ]);
        }else{
            $startDateEndDate = $this->model::getStartEndDateFromWeek($request->week);
        }
        $lab_id = $request->lab_id;
        $lab_name = \App\Models\Lab::find($lab_id)->name ?? '';

        $items = $this->model::getBorrowedLab($request);
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'lab_name'         => $lab_name,
            'items'         => $items
        ];
        $params = array_merge($params,$startDateEndDate);
        return view('borrow::labs.show', $params);
    }
}
