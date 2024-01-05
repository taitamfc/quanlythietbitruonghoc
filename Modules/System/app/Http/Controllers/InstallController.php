<?php

namespace Modules\System\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\Log;

class InstallController extends Controller
{
    protected $view_path    = 'system::';
    protected $route_prefix = 'system.install.';
    // protected $model        = Borrow::class;
    public function index()
    {
        return view($this->view_path.'install.index');
    }
    public function doInstall(Request $request)
    {
        $step = $request->step ?? '1';
        if( $request->ajax() ){
            switch ($step) {
                case '1':
                    return$this->doStep1();
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $params = [
            'route_prefix'  => $this->route_prefix,
            'step'  => $step,
        ];
        return view($this->view_path.'install.step-'.$step,$params);
    }

    // Cài đặt CSDL
    public function doStep1(){
        try {
            // Tạo bảng migrations

            Artisan::call('migrate:install');
            Artisan::call('migrate');
            return response()->json([
                'success' => true,
                'message' => 'Cài đặt cơ sở dữ liệu thành công',
                'redirect' => route($this->route_prefix."doInstall",['step'=>2])
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Cài đặt cơ sở dữ liệu thất bại'
            ]);
        }
    }
}
