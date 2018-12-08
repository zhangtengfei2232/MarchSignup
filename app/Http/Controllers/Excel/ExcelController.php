<?php
namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use App\Model\StudentDatabase;
use Maatwebsite\Excel\Facades\Excel;
class ExcelController extends Controller
{
    public function export(){
        $sex      = config('studentinfor.sex');
        $faculty  = config('studentinfor.faculty');
        $cellData = config('studentinfor.cell_data');
        $pay_ways = config('studentinfor.pay_ways');
        $Data = StudentDatabase::seallstudent();
        foreach ($Data as $student ){
              ($student->pay_ways == 0) ? $student->pay_ways = $pay_ways[0] : $student->pay_ways = $pay_ways[1];
              $cellData[] = [
                  $student->id,
                  $student->name,
                  $sex[$student->sex],
                  $faculty[$student->faculty],
                  $student->profession,
                  $student->class,
                  $student->student_id,
                  $student->phone,
                  $student->QQ,
                  date('Y-m-d', $student->create_time / 1000),
                  $student->pay_ways,
              ];
        }
        Excel::create('三月报名'.date('Y-m-d-h'),function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}