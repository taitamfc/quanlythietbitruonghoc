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
        $need_tables = [
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
        $current_tables = [];
        $all_tables = DB::select('SHOW TABLES');
        if($all_tables){
            foreach($all_tables as $all_table){
                $all_table = (array)$all_table;
                $all_table = array_values($all_table);
                $current_tables[] = current($all_table);
            }
        }
        if( !count($current_tables) ){
            return false;
        }
        $installed = true;
        // Ver 1.0 number tables smaller than new 
        if( count($current_tables) >= count($need_tables)  ){

        }else{
            foreach( $current_tables as $current_table ){
                if( !in_array($current_table,$need_tables) ){
                    $installed = false;
                }
            }
        }
        return $installed;
    }
}
