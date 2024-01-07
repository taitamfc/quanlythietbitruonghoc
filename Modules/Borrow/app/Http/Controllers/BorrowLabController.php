<?php

namespace Modules\Borrow\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Borrow\app\Models\Borrow;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowLabController extends Controller
{
    protected $view_path    = 'borrow::labs.';
    protected $route_prefix = 'borrows.';
    protected $model        = Borrow::class;
    public function index(Request $request)
    {
        if( !$request->week ){
            $currentWeek    = Carbon::now()->format('Y-\WW');
            $request->merge([
                'week' => $currentWeek
            ]);
        }

        $items = $this->model::getBorrowedLabs($request);
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'items'         => $items
        ];
        return view($this->view_path.'index', $params);
    }
}