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
use App\Models\Lab;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowLabsExport {
    public $rules = [
        // 'week' => 'required_without_all:school_years|nullable',
        // 'school_years' => 'required_without_all:week|nullable',
        // 'user_id' => 'required',
    ];
    public $messages = [
        // 'week.required_without_all' => 'Trường tuần dạy là bắt buộc nếu không có năm dạy',
        // 'school_years.required_without_all' => 'Trường năm dạy là bắt buộc nếu không có tuần dạy',
        // 'user_id.required' => 'Trường tổ là bắt buộc',
    ];
    public function handle($request = null){
        // $id = request()->id;
        $type = request()->type;
        // Lấy thông tin người dùng và mượn thiết bị
        // $borrow = Borrow::find($id);
        $lab = Lab::all();
        $query = Borrow::query();
        // $query = $query->where('user_id', request()->user_id);
        // if (request()->week) {
        //     $startWeek = Carbon::parse(request()->week)->startOfWeek()->format('Y-m-d');
        //     $endWeek = Carbon::parse(request()->week)->endOfWeek()->format('Y-m-d');
        //     $query = $query->whereBetween('borrow_date', [$startWeek, $endWeek]);
        // }
        // if(request()->school_years){
        //     // Lấy giá trị năm bắt đầu và kết thúc từ chuỗi '2022-2023'
        //     $yearRange = explode('-', request()->school_years);
        //     $startYear = $yearRange[0].'-1-1';
        //     $endYear = $yearRange[1].'-1-1';
            
        //     $query->whereDate('borrow_date', '>', $startYear)
        //     ->whereDate('borrow_date', '<=', $endYear);
        // }
        $borrows = $query->get();
        // Đường dẫn đến mẫu Excel đã có sẵn
        dd($lab);
        $templatePath = public_path('system/export/'.$type.'.xlsx');

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