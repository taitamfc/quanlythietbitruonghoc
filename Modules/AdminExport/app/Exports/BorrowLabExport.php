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

use App\Models\BorrowDevice;
use App\Models\Lab;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowLabExport {
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
        'required' => 'Trường là bắt buộc',
    ];
    public function handle($request = null){
        $type = request()->type;
        $query = BorrowDevice::query();
        $labs = Lab::pluck('id','name')->all(); 
        if (request()->lab_id) {
            $query->where('lab_id', request()->lab_id);
        }
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
        $borrows = $query->get();
        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.strtolower($type).'.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        if (request()->lab_id) {
            $labId = request()->lab_id;
            $key = array_search($labId, $labs);     
            $sheet->setCellValue('A2', $key);
            $sheet->setCellValue('B3', request()->week ?? '');
            $sheet->setCellValue('D3', $startWeek ?? '');
            $sheet->setCellValue('G3',  $endWeek ?? '');
        }elseif(empty(request()->lab_id)){
            $nameLab= 'A';
            foreach ($labs as $key => $value) {
                $cellCoordinate = $nameLab . '2';
                $sheet->setCellValue($cellCoordinate, $key);
                $sheet->setCellValue('B3', request()->week ?? '');
                $sheet->setCellValue('D3', $startWeek ?? '');
                $sheet->setCellValue('G3',  $endWeek ?? '');
                $columnIndex = ord($nameLab) - 65; // Lấy chỉ số cột dựa trên mã ASCII của chữ cái
                $columnIndex += 14; // Cộng thêm 14 để di chuyển cách cột hiện tại 14 cột
                $newNameLab = chr($columnIndex + 65); // Chuyển đổi lại thành chữ cái bằng cách cộng 65
                $cellCoordinate = $newNameLab . '2';
            }
        }
        
        // Duyệt qua danh sách mượn thiết bị
        $index = 6; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT
        // foreach ($borrows as $borrow) {
        //     foreach ($borrow->the_devices as $device) {
        //         $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        //         $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
        //         $sheet->setCellValue('B' . $index, $device->borrow_date);
        //         $sheet->setCellValue('C' . $index, $device->return_date);
        //         $sheet->setCellValue('D' . $index, $borrow->id);
        //         $sheet->setCellValue('E' . $index, $borrow->borrow_date);
        //         $sheet->setCellValue('F' . $index, $device->device->name ?? '');
        //         $sheet->setCellValue('G' . $index, $device->quantity);
        //         $sheet->setCellValue('H' . $index, $device->lecture_number);
        //         $sheet->setCellValue('I' . $index, $device->lesson_name);
        //         $sheet->setCellValue('J' . $index, $device->room->name ?? '');
        //         $sheet->setCellValue('K' . $index, $borrow->borrow_note ?? '');
        //         $sheet->setCellValue('L' . $index, $user->name);
        //         $index++;
        //         $stt++;
        //     }
        // }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/tmp/'.$type.'.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
    }
}