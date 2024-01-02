<?php

namespace Modules\AdminExport\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BorrowDetailExport {
    protected $templateFile = '';
    public $rules = [
        'id' => 'required'
    ];
    public $messages = [
        'required' => 'Trường yêu cầu'
    ];
    public function handle($request = null){
        echo __METHOD__;
        echo '<pre>';
        print_r($request->toArray());
        die();
    }

    protected function loadTemplateFile(){

    }
}