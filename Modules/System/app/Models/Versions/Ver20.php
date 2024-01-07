<?php

namespace Modules\System\app\Models\Versions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class Ver20 extends Model
{
    public static function doUpdate(){
        
        try {
            self::createLabTable();
            self::createNotificationTable();
            self::updateBorrowDeviceTable();
            self::updateBorrowDeviceData();
            self::updateBorrowData();
            self::insertDataForLabTable();
            self::updateBorrowDeviceLabData();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function createLabTable(){
        if( !Schema::hasTable('labs') ){
            Schema::create('labs', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->integer('quantity')->default(1);
                $table->string('image')->nullable();
                $table->text('note')->nullable();
                $table->unsignedBigInteger('department_id');
                $table->foreign('department_id')->references('id')->on('departments');
                $table->softDeletes();
                $table->timestamps();
            });
        }
        
    }
    public static function createNotificationTable(){
        if( !Schema::hasTable('notifications') ){
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('type')->nullable();
                $table->string('action')->nullable();
                $table->boolean('is_read')->default(false);
                $table->unsignedBigInteger('item_id')->nullable();
                $table->timestamps();
            });
        }
        
    }

    public static function updateBorrowDeviceTable(){
        if( !Schema::hasColumn('borrow_devices','lab_id') ){
            Schema::table('borrow_devices', function (Blueprint $table) {
                $table->integer('tiet')->default(0);
                $table->unsignedBigInteger('lab_id')->default(0);
                $table->unsignedBigInteger('device_id')->default(0)->change();
                $table->unsignedBigInteger('room_id')->default(0)->change();
            });
        }else{
            Schema::table('borrow_devices', function (Blueprint $table) {
                $table->unsignedBigInteger('borrow_id')->default(0)->change();
                $table->unsignedBigInteger('device_id')->default(0)->change();
                $table->unsignedBigInteger('room_id')->default(0)->change();
            });
        }
    }
    public static function updateBorrowDeviceData(){
        $searchBorrowDevices = \App\Models\BorrowDevice::whereNull('borrow_date')->get();
        if( $searchBorrowDevices ){
            foreach($searchBorrowDevices as $borrowDevice){
                if($borrowDevice->borrow && $borrowDevice->borrow->borrow_date){
                    $borrowDevice->borrow_date = $borrowDevice->borrow->borrow_date;
                    $borrowDevice->save();
                }
            }
        }
    }
    public static function updateBorrowDeviceLabData(){
        $searchLabs = \App\Models\Device::select(['id'])->where('name','LIKE','%phòng%');
        if($searchLabs){
            $labs = \App\Models\Lab::pluck('id','name')->toArray();
            $lab_ids = $searchLabs->pluck('id')->toArray();

            $searchBorrowDevices = \App\Models\BorrowDevice::whereIn('device_id',$lab_ids)->get();
            if( $searchBorrowDevices ){
                foreach($searchBorrowDevices as $borrowDevice){
                    $deviceName = $borrowDevice->device->name;
                    $lab_name = strtolower($deviceName);
                    if( strpos($lab_name,'phòng') !== false ){
                        $lab_id = @$labs[$deviceName];
                        if($lab_id){
                            $borrowDevice->lab_id = $lab_id;
                            $borrowDevice->save();
                        }
                    }
                }
            }
        }
        
    }

    public static function insertDataForLabTable(){
        $searchLabs = \App\Models\Device::where('name','LIKE','%phòng%')->get();
        if($searchLabs){
            foreach($searchLabs as $searchLab){
                $lab_name = strtolower($searchLab->name);
                if( strpos($lab_name,'phòng') !== false ){
                    $labData = [
                        'name' => $searchLab->name,
                        'department_id' => $searchLab->department_id,
                    ];
                    \App\Models\Lab::updateOrCreate([
                        'name' => $searchLab->name
                    ],$labData);
                    // remove old
                    // $searchLab->delete();
                }
                
            }
        }
    }

    public static function updateBorrowData(){
        \App\Models\Borrow::where('status',0)->update([
            'status' => 1
        ]);
    }
}
