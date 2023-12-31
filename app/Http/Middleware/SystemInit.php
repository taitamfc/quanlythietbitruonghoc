<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SystemInit
{
    protected $lastVersion = '2.0';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installed = $this->checkAppInstalled();
        if(!$installed){
            return redirect()->route('system.install.index');
        }
        $isLastVersion = $this->checkIsLastVersion();
        if(!$isLastVersion){
            return redirect()->route('system.update.index');
        }
        return $next($request);
    }
    public function checkIsLastVersion(){
        $option = \App\Models\Option::where('option_name','app_verison')->first();
        $lastVersion    = $this->lastVersion;
        $currentVersion = $option->option_value ?? '1.0';

        $isLastVersion = true;
        if($lastVersion != $currentVersion){
            $isLastVersion = false;
        }
        return $isLastVersion;
    }
    public function checkAppInstalled(){
        $tables = [
            'assets',
            'borrow_devices',
            'borrows',
            'departments',
            'device_types',
            'devices',
            'failed_jobs',
            'groups',
            'groups_roles',
            'migrations',
            'nests',
            'options',
            'password_reset_tokens',
            'personal_access_tokens',
            'roles',
            'rooms',
            'users'
        ];
        $current_tables = DB::select('SHOW TABLES');
        if( !count($current_tables) ){
            return false;
        }
        $installed = true;
        foreach( $current_tables as $current_table ){
            if( !in_array($current_table,$tables) ){
                $installed = false;
            }
        }
        return $installed;
    }
}
