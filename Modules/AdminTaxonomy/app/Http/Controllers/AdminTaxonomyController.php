<?php

namespace Modules\AdminTaxonomy\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\AdminTaxonomy\app\Http\Requests\StoreAdminTaxonomyRequest;
use Illuminate\Http\Response;
use Modules\AdminTaxonomy\app\Models\AdminTaxonomy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AdminTaxonomyController extends Controller
{
    protected $view_path    = 'admintaxonomy::';
    protected $route_prefix = 'admintaxonomy.';
    protected $model        = AdminTaxonomy::class;
    public function index(Request $request)
    {
        $type = $request->type;
        $items = $this->model::getItems($request,null,$type);
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
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'type'         => $request->type,
        ];
        return view($this->view_path.'create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminTaxonomyRequest $request): RedirectResponse
    {
        $type = $request->type;
        try {
            $this->model::saveItem($request,$type);
            return redirect()->route($this->route_prefix.'index',['type'=>$type])->with('success', __('sys.store_item_success'));
        } catch (QueryException $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id, Request $request)
    {
        $type = $request->type;
        try {
            $item = $this->model::findItem($id,$type);
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item' => $item
            ];
            return view($this->view_path.'show', $params);
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->route( $this->route_prefix.'index' )->with('error', __('sys.item_not_found'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        $type = $request->type;
        try {
            $item = $this->model::findItem($id,$type);
            $params = [
                'route_prefix'  => $this->route_prefix,
                'model'         => $this->model,
                'item' => $item
            ];
            return view($this->view_path.'edit', $params);
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->route( $this->route_prefix.'index' )->with('error', __('sys.item_not_found'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdminTaxonomyRequest $request, $id): RedirectResponse
    {
        $type = $request->type;
        try {
            $this->model::updateItem($id,$request,);
            return redirect()->route($this->route_prefix.'index',['type'=>$type])->with('success', __('sys.update_item_success'));
        } catch (ModelNotFoundException $e) {
            Log::error('Item not found: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
        } catch (QueryException $e) {
            Log::error('Error in update method: ' . $e->getMessage());
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
            return redirect()->route( $this->route_prefix.'index' )->with('error', __('sys.item_not_found'));
        } catch (QueryException $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return redirect()->route( $this->route_prefix.'index' )->with('error', __('sys.destroy_item_error'));
        }
    }
}