<?php

namespace Modules\Borrow\app\Models;

use App\Models\WebsiteModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'borrow_date',
        'status'
    ];

    // Ovrride
    public static function findItem($id){
        $item = self::findOrFail($id);
        return $item;
    }
    public static function updateItem($id,$request){
        $item = self::findItem($id);
        if($request->borrow_date){
            $item->borrow_date = $request->borrow_date;
        }
        $item->save();

        if( $request->task == 'add-tiet' ){

        }
        // Remove all borrow_devices
        if( $request->devices ){
            foreach( $request->devices as $tiet => $device ){
                $device['borrow_date'] = $item->borrow_date;
                if(!empty($device['device_id'])){
                    $device['tiet'] = $tiet;
                    $item->borrow_devices()
                    ->where('device_id',$device['device_id'])
                    ->where('tiet',$tiet)
                    ->where('borrow_id',$id)
                    ->delete();
                    $item->borrow_devices()->create($device);
                }
            }
        }
        return $item;
    }

    // Relationships
    public function borrow_devices(){
        return $this->hasMany(BorrowDevice::class);
    }

    public function getBorrowItemsAttribute(){
        $item = self::findItem($this->id);
        
        $results = [];
        if( count($item->borrow_devices) ){
            foreach( $item->borrow_devices as $borrow_device ){
                $results[$borrow_device->tiet][] = $borrow_device;
            }
        }
        return $results;
    }

    // Attributes
    
}
