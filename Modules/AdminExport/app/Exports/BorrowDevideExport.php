<?php

namespace Modules\AdminExport\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

use App\Models\Borrow;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowDevideExport {
    protected $templateFile = '';
    public function rules(): array
    {
        $rules = [
            'week' => 'required',
            'school_years' => 'required',
        ];
        // nếu đã chọn school_years thì không yêu cầu week
        if(request()->school_years){
            unset($rules['week']);
        }
        // nếu đã chọn week thì không yêu cầu school_years
        if(request()->week){
            unset($rules['school_years']);
        }
        if(request()->school_years && request()->week){
            unset($rules['school_years']);
        }
        return $rules;
    }
    public $messages = [
        'required' => 'Trường yêu cầu',
    ];
    public function handle($request = null){
        $type = request()->type;
        // Lấy thông tin người dùng và mượn thiết bị
        $query = \App\Models\Borrow::query();

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.$type.'.xlsx');

        if (request()->week && request()->school_years) {
            $startDateEndDate = \App\Models\Borrow::getStartEndDateFromWeek(request()->week);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }elseif( request()->week ){
            $startDateEndDate = \App\Models\Borrow::getStartEndDateFromWeek(request()->week);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }elseif(request()->school_years){
            $startDateEndDate = \App\Models\Borrow::getStartEndDateFromYear(request()->school_years);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }
        $query->select('user_id');
        $query->groupBy('user_id');
        $items = $query->get();
        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);
        
        // Lấy sheet hiện tại
        $dateStart = date('d/m/Y',strtotime($startDateEndDate[0]));
        $dateEnd = date('d/m/Y',strtotime($startDateEndDate[1]));
        $date = Carbon::createFromFormat('d/m/Y', $dateEnd);
        $year = $date->year;
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('D6',$dateStart);
        $sheet->setCellValue('F6',$dateEnd);
        $sheet->setCellValue('E7',$year);

        // Duyệt qua danh sách mượn thiết bị
        $index = 10; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT
        foreach ($items as $item) {
            $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('B' . $index, $item->user->name ?? '');
            $sheet->setCellValue('C' . $index, $item->user->nest->name ?? '');
            $sheet->setCellValue('D' . $index, '');
            $sheet->setCellValue('E' . $index, '');
            $sheet->setCellValue('F' . $index, '');
            $sheet->setCellValue('G' . $index, '');
            $sheet->setCellValue('H' . $index, '');
            $index++;
            $stt++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/tmp/'.$type.'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
    }
}