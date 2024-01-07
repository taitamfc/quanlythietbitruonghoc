<?php

namespace Modules\AdminUser\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AdminUser\app\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Modules\AdminUser\app\Http\Requests\StoreAdminUserRequest;
use Illuminate\Support\Facades\Log;
use App\Models\Group;
use App\Models\Nest;

class AdminUserController extends Controller
{
    protected $view_path    = 'adminuser::adminuser.';
    protected $route_prefix = 'adminuser.';
    protected $model        = AdminUser::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->type ?? '';
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
            return redirect()->route( $this->route_prefix.'index' )->with('error',  __('sys.get_items_error'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->type ?? '';
        $group_model = Group::class;
        $nest_model = Nest::class;
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'item'=> '',
            'group_model' => $group_model,
            'nest_model' => $nest_model,
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.create', $params);
        }
        return view($this->view_path.'create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        // dd($request);
        $type = $request->type;
        try {
            $item = $this->model::saveItem($request,$type);
            \App\Events\UserCreated::dispatch($item);
            return redirect()->route($this->route_prefix.'index',['type'=>$type])->with('success', __('sys.store_item_success'));
        } catch (QueryException $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', __('sys.item_not_found'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = $request->type ?? '';
        $item = $this->model::findItem($id,'User');
        $group_model = Group::class;
        $nest_model = Nest::class;
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'item'=> $item,
            'group_model' => $group_model,
            'nest_model' => $nest_model,
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.edit', $params);
        }
        return view($this->view_path.'edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdminUserRequest $request, $id): RedirectResponse
    {
        $type = $request->type;
        try {
            $this->model::updateItem($id,$request,$type);
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