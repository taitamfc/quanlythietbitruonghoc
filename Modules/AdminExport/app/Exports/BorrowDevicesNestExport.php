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

use Carbon\Carbon;
use App\Models\Borrow;
use App\Models\User;

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
        $type = request()->type;
        $query = Borrow::query();
        if(request()->nest_id){
            $users = User::where('nest_id', request()->nest_id)->pluck('id');
            $query->whereIn('user_id', $users);
        }
        if (request()->week) {
            $startWeek = Carbon::parse(request()->week)->startOfWeek()->format('Y-m-d');
            $endWeek = Carbon::parse(request()->week)->endOfWeek()->format('Y-m-d');
            $query->whereBetween('borrow_date', [$startWeek, $endWeek]);
        }
        if(request()->school_years){
            // Lấy giá trị năm bắt đầu và kết thúc từ chuỗi '2022-2023'
            $yearRange = explode('-', request()->school_years);
            $startYear = $yearRange[0].'-1-1';
            $endYear = $yearRange[1].'-1-1';
            
            $query->whereDate('borrow_date', '>', $startYear)
            ->whereDate('borrow_date', '<=', $endYear);
        }
        $borrows = $query->get();
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
    
        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B2', \App\Models\Nest::find(request()->nest_id)->name ?? '');
        $sheet->setCellValue('F4', isset($startYear) ? $startYear : ( isset($startWeek) ? $startWeek : ''));
        $sheet->setCellValue('I4', isset($endYear) ? $endYear : ( isset($endWeek) ? $endWeek : ''));

        // Duyệt qua danh sách mượn thiết bị
        $index = 8; // Bắt đầu từ hàng 10
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
                $sheet->setCellValue('H' . $index, $device->tiet);
                $sheet->setCellValue('I' . $index, $device->lesson_name);
                $sheet->setCellValue('J' . $index, $device->room->name ?? '');
                $sheet->setCellValue('K' . $index, $device->lecture_number);
                $sheet->setCellValue('L' . $index, $borrow->borrow_note ?? '');
                $sheet->setCellValue('M' . $index, $borrow->user->name);
                $index++;
                $stt++;
            }
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('system/uploads/'.$type.'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return $newFilePath;
        }
}