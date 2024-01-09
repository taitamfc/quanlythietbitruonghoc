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

class BorrowDeviceExport {
    protected $templateFile = '';
    public function rules(): array
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        return $rules;
    }
    public $messages = [
        'required' => 'Trường yêu cầu',
    ];
    public function handle($request = null){
        $type = request()->type;
        // Lấy thông tin người dùng và mượn thiết bị
        $query = DB::table('borrows');
        
        // Lấy điều kiện thời gian
        $startDate = request()->start_date;
        $endDate = request()->end_date;
        $query->whereBetween('borrow_date', [$startDate, $endDate]);

        $query->join('users','users.id', '=','borrows.user_id');
        $query->join('nests','nests.id', '=','users.nest_id');
        $query->select('users.name as user_name','nests.name as nest_name');
        $query->groupBy('users.name','nests.name');
        $items = $query->get();
        
        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('system/export/'.$type.'.xlsx');
        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);
        
        // Lấy ngày tạo phiếu
        $startDate = date('d/m/Y',strtotime($startDate));
        $endDate = date('d/m/Y',strtotime($endDate));
        $date = Carbon::createFromFormat('d/m/Y', $endDate);
        $year = $date->year;
        

        // Lấy đơn vị tạo
        $auto_approved = \App\Models\Option::get_option('general','company_name');
        $title = 'SỞ GD VÀ ĐT QUẢNG TRỊ TRƯỜNG '.mb_strtoupper($auto_approved,'UTF-8');        
        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1',$title);
        $sheet->setCellValue('D6',$startDate);
        $sheet->setCellValue('F6',$endDate);
        $sheet->setCellValue('E7',$year);

        // Duyệt qua danh sách mượn thiết bị
        $index = 10; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT
        foreach ($items as $item) {
            $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('B' . $index, $item->user_name ?? '');
            $sheet->setCellValue('C' . $index, $item->nest_name ?? '');
            $sheet->setCellValue('D' . $index, '0');
            $sheet->setCellValue('E' . $index, '0');
            $sheet->setCellValue('F' . $index, '0');
            $sheet->setCellValue('G' . $index, '0');
            $sheet->setCellValue('H' . $index, '0');
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