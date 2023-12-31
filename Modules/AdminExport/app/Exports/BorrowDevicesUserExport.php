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

class BorrowDevicesUserExport {
    protected $templateFile = '';
    public function rules(): array
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'user_id' => 'required',
        ];
        return $rules;
    }

    public $messages = [
        'required' => 'Trường bắt buộc'
    ];
    public function handle($request = null){
        // $id = request()->id;
        $type = request()->type;
        // Lấy thông tin người dùng và mượn thiết bị
        // $borrow = Borrow::find($id);
        $user = User::find(request()->user_id);
        $query = Borrow::query();
        $query = $query->where('user_id', request()->user_id);

        // lấy ra theo ngày
        $startDate = request()->start_date;
        $endDate = request()->end_date;
        $query->whereBetween('borrow_date', [$startDate, $endDate]);
        
        $borrows = $query->get();
        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.strtolower($type).'.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('E2', $user->name ?? '');
        $sheet->setCellValue('I2', $user->nest->name ?? '');
        $sheet->setCellValue('L2', $user->nest->name ?? '');

        // Duyệt qua danh sách mượn thiết bị
        $index = 6; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT
        foreach ($borrows as $borrow) {
            foreach ($borrow->the_devices as $device) {
                $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
                $sheet->setCellValue('B' . $index, $device->borrow_date);
                $sheet->setCellValue('C' . $index, $device->return_date);
                $sheet->setCellValue('D' . $index, $borrow->id);
                $sheet->setCellValue('E' . $index, $borrow->borrow_date);
                $sheet->setCellValue('F' . $index, $device->device->name ?? '');
                $sheet->setCellValue('G' . $index, $device->quantity);
                $sheet->setCellValue('H' . $index, $device->lecture_number);
                $sheet->setCellValue('I' . $index, $device->lesson_name);
                $sheet->setCellValue('J' . $index, $device->room->name ?? '');
                $sheet->setCellValue('K' . $index, $borrow->borrow_note ?? '');
                $sheet->setCellValue('L' . $index, $user->name);
                $index++;
                $stt++;
            }
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/tmp/'.$type.$user->id.'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
    }
}