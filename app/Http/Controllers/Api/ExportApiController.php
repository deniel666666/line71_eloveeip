<?php
namespace App\Http\Controllers\Api;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class ExportApiController extends StringValueBinder implements FromView, WithCustomValueBinder
{
    public function __construct($excel_data=false)
    {
        if($excel_data===false){
            abort('404', "請提要供匯出的資料");
        }
        $this->excel_data = $excel_data;
    }

    public function view(): View
    {
        $viewData['head'] = isset($this->excel_data['head']) ? $this->excel_data['head'] : [];
        $viewData['data'] = isset($this->excel_data['data']) ? $this->excel_data['data'] : $this->excel_data;

        // dump($viewData);exit;
        return view("excel.excel",$viewData);
    }
}