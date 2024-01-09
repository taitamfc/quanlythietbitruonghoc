<?php

namespace Modules\Borrow\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Borrow\app\Http\Requests\StoreBorrowRequest;
use Illuminate\Http\Response;
use Modules\Borrow\app\Models\Borrow;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    protected $view_path    = 'borrow::';
    protected $route_prefix = 'borrows.';
    protected $model        = Borrow::class;
    public function index(Request $request)
    {
        $items = $this->model::getItems($request,Auth::id());
        
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'items'         => $items
        ];
        return view($this->view_path.'index', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $saved = $this->model::create([
                'user_id' => Auth::id(),
                'borrow_date' => date('Y-m-d',strtotime('+1day')),
                'status' => $this->model::DRAFT
            ]);
            return redirect()->route($this->route_prefix.'edit',$saved->id)->with('success', __('sys.store_item_success'));
        } catch (QueryException $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.store_item_error'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $rooms = \App\Models\Room::getAll();
            $item = $this->model::findItem($id);
            if( $item->user_id != Auth::id() ){
                abort(403);
            }
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item'          => $item,
                'rooms'         => $rooms,
            ];
            return view($this->view_path.'show', $params);
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->route($route_prefix.'index')->with('error', __('sys.item_not_found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $rooms = \App\Models\Room::getAll();
            $item = $this->model::findItem($id);
            if( $item->user_id != Auth::id() ){
                abort(403);
            }
            if( !$item->can_edit  ){
                abort(403);
            }

            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item'          => $item,
                'rooms'         => $rooms
            ];
            return view($this->view_path.'edit', $params);
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBorrowRequest $request, $id)
    {
        try {
            $this->model::updateItem($id,$request);
            if( $request->ajax() ){
                return response()->json([
                    'success' => true,
                    'msg' => __('sys.update_item_success'),
                ]);
            }
            return redirect()->route($this->route_prefix.'index')->with('success', __('sys.update_item_success'));
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            if( $request->ajax() ){
                return response()->json([
                    'success' => false,
                    'msg' => __('sys.item_not_found'),
                ]);
            }
            // return redirect()->back()->with('error', __('sys.item_not_found'));
        } catch (QueryException $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            if( $request->ajax() ){
                return response()->json([
                    'success' => false,
                    'msg' => __('sys.update_item_error'),
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->model::deleteItem($id);
            return redirect()->route($this->route_prefix.'index')->with('success', __('sys.destroy_item_success'));
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
        } catch (QueryException $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.destroy_item_error'));
        }
    }
}