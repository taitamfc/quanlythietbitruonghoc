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
        DB::beginTransaction();
        try {
            self::createLabTable();
            self::updateBorrowDeviceTable();
            self::insertDataForLabTable();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
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

    public static function updateBorrowDeviceTable(){
        if( !Schema::hasColumn('borrow_devices','lab_id') ){
            Schema::table('borrow_devices', function (Blueprint $table) {
                $table->integer('tiet')->default(0);
                $table->unsignedBigInteger('lab_id');
            });
        }
    }

    public static function insertDataForLabTable(){
        $searchLabs = \App\Models\Device::where('name','LIKE','%phòng%')->get();
        if($searchLabs){
            foreach($searchLabs as $searchLab){
                $labData = [
                    'name' => $searchLab->name,
                    'name' => $searchLab->name,
                    'department_id' => $searchLab->department_id,
                ];

                \App\Models\Lab::updateOrCreate($labData,[
                    'name' => $searchLab->name
                ]);
            }
        }
    }
}
