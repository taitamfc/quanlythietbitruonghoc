<?php

namespace Modules\AdminUser\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AdminUser\app\Models\Group;
use Modules\AdminUser\app\Models\Role;
use Modules\AdminUser\app\Http\Requests\GroupRequest;


class AdminGroupController extends Controller
{

    protected $view_path    = 'adminuser::admingroup.';
    protected $route_prefix = 'admingroup.';
    protected $model        = Group::class;
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
            return view($this->view_path.'index',$params);
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
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.create', $params);
        }
        return view($this->view_path.'create', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request): RedirectResponse
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
    public function show($id)
    {
        $type = $request->type ?? '';

        $item = $this->model::find($id);
        $roles = Role::all();
        $active_roles = $item->roles->pluck('id')->toArray();
        // dd($active_roles);
        $all_roles = [];
        foreach ($roles as $role) {
            $all_roles[$role['group_name']][] = $role;
        }
        // $params['all_roles'] = $all_roles;
        // $params['group'] = $item;
        // $params['active_roles'] = $active_roles;
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'all_roles'         => $all_roles,
            'group'         => $item,
            'active_roles'         => $active_roles,
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.show', $params);
        }
        return view($this->view_path.'show', $params);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $type = $request->type ?? '';
        $item = Group::findOrFail($id);
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'item'         => $item,
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.edit', $params);
        }
        return view($this->view_path.'edit', $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, $id): RedirectResponse
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

    public function saveRoles(Request $request)
    {
        $type = $request->type ?? '';
        $group = $this->model::find($request->id);
        $group->roles()->detach();
        $group->roles()->attach($request->roles);
        return redirect()->route($this->route_prefix.'index')->with('success', 'Cấp quyền thành công!');
        $params = [
            'route_prefix'  => $this->route_prefix,
            'model'         => $this->model,
            'item'         => $item,
        ];
        if ($type) {
            return view($this->view_path.'types.'.$type.'.index', $params);
        }
        return redirect()->route($this->route_prefix.'index', $params)->with('success', 'Cấp quyền thành công!');

    }
}

