<?php

namespace Modules\AdminExport\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use App\Models\BorrowDevice;

class BorrowDevicesNestExport
{
    public $rules = [
        'week' => 'required_without_all:school_years,nest_id',
        'school_years' => 'required_without_all:week,nest_id',
        'nest_id' => 'required_without_all:week,school_years',
    ];
    public $messages = [
        'week.required_without_all' => 'Trường tuần dạy là bắt buộc nếu không có năm dạy hoặc tổ',
        'school_years.required_without_all' => 'Trường năm dạy là bắt buộc nếu không có tuần dạy hoặc tổ',
        'nest_id.required_without_all' => 'Trường tổ là bắt buộc nếu không có tuần dạy hoặc năm dạy',
    ];
    
    public function handle()
    {
        $query = BorrowDevice::query();
        if (request()->week) {
            $startWeek = Carbon::parse(request()->week)->startOfWeek()->format('Y-m-d');
            $endWeek = Carbon::parse(request()->week)->endOfWeek()->format('Y-m-d');
            $query->whereBetween('borrow_date', [$startWeek, $endWeek]);
        }
        if(request()->school_years){
        }
        $items = $query->get();
        $type = request()->type;
        $templatePath = public_path('system/exports/'.$type.'Sample.xlsx');
        
        $reader = Excel::toArray([], $templatePath);
        $results = $reader[0];
        
        $exportData = collect($items);
        $filePath = public_path('system/exports/'.$type.'.xlsx');
        Excel::store(new $exportData, $filePath);
        
        return response()->download($filePath)->deleteFileAfterSend(true);
        }
}