<?php

namespace Modules\System\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateController extends Controller
{
    protected $lastVersion = '2.0';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $option = \App\Models\Option::where('option_name','app_verison')->first();
        $lastVersion    = $this->lastVersion;
        $currentVersion = $option->option_value ?? '1.0';
        $params = [
            'currentVersion' => $currentVersion,
            'lastVersion' => $this->lastVersion,
        ];
        return view('system::update.index',$params);
    }
    public function doUpdate()
    {
        switch ($this->lastVersion) {
            case '2.0':
                $updated = \Modules\System\app\Models\Versions\Ver20::doUpdate();
                break;
            default:
                # code...
                break;
        }

        if($updated){
            \App\Models\Option::where('option_name','app_verison')->delete();
            $option = \App\Models\Option::where('option_name','app_verison')->first();
            if($option){
                $option->option_value = $this->lastVersion;
                $option->save();
            }else{
                \App\Models\Option::create([
                    'option_value' => $this->lastVersion,
                    'option_name' => 'app_verison',
                    'option_label' => 'Phiên bản phần mềm',
                    'option_group' => 'system',
                    'option_group_name' => 'Hệ Thống',
                ]);
            }
            return redirect()->back()->with('success','Cập nhật thành công !');
        }else{
            return redirect()->back()->with('error','Cập nhật không thành công !');
        }
        
    }
}
