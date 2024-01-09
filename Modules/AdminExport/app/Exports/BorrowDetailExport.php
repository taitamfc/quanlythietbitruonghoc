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

class BorrowDetailExport {
    protected $templateFile = '';
    public function rules() : array{
        $rules = [
            'id' => 'required|exists:borrows,id'
        ];
        return $rules;
    }
    public $messages = [
        'required' => 'Trường yêu cầu',
        'exists' => 'ID không tồn tại',
    ];
    public function handle($request = null){
        $id = request()->id;
        $type = request()->type;
        // Lấy thông tin người dùng và mượn thiết bị
        $borrow = Borrow::find($id);
        $user = $borrow->user;

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.$type.'.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy ngày, tháng và năm hiện tại
        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');
        $newValue = 'Gio Linh, ngày ' . $currentDay . ' tháng ' . $currentMonth . ' năm ' . $currentYear;
       
        // Lấy đơn vị tạo
        $auto_approved = \App\Models\Option::get_option('general','company_name');
        $title = 'SỞ GD VÀ ĐT QUẢNG TRỊ TRƯỜNG '.mb_strtoupper($auto_approved,'UTF-8');      
        

        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $title ?? '');
        $sheet->setCellValue('C7', $user->name ?? '');
        $sheet->setCellValue('C8', $user->nest->name ?? '');
        $sheet->setCellValue('D25', $user->name ?? '');
        $sheet->setCellValue('C21', $newValue ?? '');
        $sheet->setCellValue('C5', date('d/m/Y',strtotime($borrow->borrow_date)));

        // Duyệt qua danh sách mượn thiết bị
        $index = 10; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT
        foreach ($borrow->the_devices as $device) {
            $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('B' . $index, $device->device->name ?? '');
            $sheet->setCellValue('C' . $index, $device->lesson_name);
            $sheet->setCellValue('D' . $index, Carbon::parse($borrow->borrow_date)->format('d/m/Y'));
            $sheet->setCellValue('E' . $index, $device->lecture_name);
            $sheet->setCellValue('F' . $index, $device->quantity);
            $sheet->setCellValue('H' . $index, $device->room->name ?? '');
            $sheet->setCellValue('G' . $index, $device->lecture_number);
            $index++;
            $stt++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/tmp/'.$type.$borrow->id.'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
    }
}