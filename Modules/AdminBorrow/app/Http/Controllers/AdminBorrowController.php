<?php

namespace Modules\AdminBorrow\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AdminBorrow\app\Models\Borrow;


class AdminBorrowController extends Controller
{
    protected $view_path    = 'adminborrow::';
    protected $route_prefix = 'adminborrow.';
    protected $model        = Borrow::class;
    public function index(Request $request)
    {
        try {
            $items = $this->model::getItems($request);
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'items'         => $items
            ];
            return view($this->view_path.'index', $params);
        } catch (QueryException $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            return redirect()->back()->with('error',  __('sys.get_items_error'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $item = $this->model::findItem($id);
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item' => $item
            ];
            return view($this->view_path.'show', $params);
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
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
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item'          => $item,
                'rooms'         => $rooms,
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
    public function update(Request $request, $id)
    {
        try {
            $this->model::updateItem($id,$request);
            return redirect()->route($this->route_prefix.'index')->with('success', __('sys.update_item_success'));
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            if( $request->ajax() ){
                return response()->json([
                    'success' => false,
                    'msg' => __('sys.item_not_found'),
                ]);
            }
            return redirect()->back()->with('error', __('sys.item_not_found'));
        } catch (QueryException $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            if( $request->ajax() ){
                return response()->json([
                    'success' => false,
                    'msg' => __('sys.update_item_error'),
                ]);
            }
            return redirect()->back()->with('error', __('sys.update_item_error'));
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
