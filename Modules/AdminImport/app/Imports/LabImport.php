<?php

namespace Modules\AdminImport\app\Imports;

use App\Models\Lab;
use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class LabImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    function getDepartmant($name)
    {
        $department = Department::where('name', 'LIKE' , '%'.$name.'%')->first();
        if ($department) {
            return $department->id;
        }else {
            $data['name'] = $name;
            $item = Department::create($data);
            return $item->id;
        }
    }
    
    public function collection(Collection $rows)
    {
        $rows->shift();
        Validator::make($rows->toArray(), [
            '*.1' => 'required',
            '*.2' => 'required|numeric',
            '*.3' => 'required',
        ],[
            '*.1.required' => 'Tên phòng học hàng :attribute là bắt buộc.',
            '*.2.required' => 'Số lượng hàng :attribute là bắt buộc.',
            '*.2.numeric' => 'Số lượng hàng :attribute phải là một số.',
            '*.3.required' => 'Bộ môn hàng :attribute thiết bị là bắt buộc.',
        ])->validate();

        foreach ($rows as $row) {
            foreach( $row as $k => $v ){
                $row[$k] = trim($v);
            }
            $data = [
                'name' => $row[1],
                'quantity'=>$row[2],
                'department_id'=>$this->getDepartmant($row[3]),
                'note'=>$row[4],
            ];
            $item = Lab::withTrashed()->where('name',$data['name'])->first();
            if ($item) {
                $item->restore();
                $item->update($data);
            }else {
                Lab::create($data);
            }
        }
    }
}