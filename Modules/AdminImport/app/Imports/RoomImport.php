<?php

namespace Modules\AdminImport\app\Imports;

use App\Models\Room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class RoomImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
        $rows->shift();
        Validator::make($rows->toArray(), [
            '*.1' => 'required',
        ],[
            '*.1.required' => 'Tên lớp học hàng :attribute là bắt buộc.',
        ])->validate();
        
        foreach ($rows as $row) {
            foreach( $row as $k => $v ){
                $row[$k] = trim($v);
            }
            $data = [
                'name' => $row[1],
            ];
            $item = Room::withTrashed()->where('name',$data['name'])->first();
            if ($item) {
                $item->restore();
                $item->update($data);
            }else {
                Room::create($data);
            }
        }
    }
}