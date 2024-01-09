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
            'start_date' => 'required',
            'end_date' => 'required',
            'lab_id' => 'required',
        ];
        return $rules;
    }
    public $messages = [
        'required' => 'Trường là bắt buộc',
    ];
    public function handle($request = null){
        $type = request()->type;
        $query = BorrowDevice::query();
        
        // Điều kiện phòng 
        $query->where('lab_id', request()->lab_id);
        
        // Điều kiện thời gian
        $startDate = request()->start_date;
        $endDate = request()->end_date;
        $query->whereBetween('borrow_date', [$startDate, $endDate]);

        $borrowdevices = $query->orderBy('borrow_date','DESC')->get();
        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.strtolower($type).'.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', \App\Models\Lab::find(request()->lab_id)->name ?? '');
        
        // Duyệt qua danh sách mượn thiết bị
        // $stt = 1; // Khởi tạo biến STT
        $index = 5; // Bắt đầu từ hàng 10
        foreach ($borrowdevices as $borrow) {
            // $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            // $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('A' . $index+2, $borrow->borrow_date);
            $sheet->setCellValue('H' . $index+2, $borrow->borrow_date);
            if ($borrow->tiet <=5 ) {
                $position = $borrow->tiet-1;
                $sheet->setCellValue('C' . $index+$position, $borrow->room->name ?? '');
                $sheet->setCellValue('D' . $index+$position, $borrow->lecture_number?? '');
                $sheet->setCellValue('E' . $index+$position, $borrow->lesson_name ?? '');
                $sheet->setCellValue('F' . $index+$position, $borrow->borrow->user->name ?? '');
            } else {
                $position = $borrow->tiet-6;
                $sheet->setCellValue('J' . $index+$position, $borrow->room->name ?? '');
                $sheet->setCellValue('K' . $index+$position, $borrow->lecture_number ?? '');
                $sheet->setCellValue('L' . $index+$position, $borrow->lesson_name ?? '');
                $sheet->setCellValue('M' . $index+$position, $borrow->borrow->user->name ?? '');
            }
            $index += 5;
            // $stt++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/tmp/'.$type.'.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
    }
}