<?php

namespace App\Utils;

use App\Http\Controllers\BaseController;
use Maatwebsite\Excel\Facades\Excel;

class OutputFile extends BaseController {


	/**
	 *  调用实例如下
	 *  $data = xxx;
        $rowTitle = [1,2,3,4,5,6,7,8,9,10];
        $width = ['A' => 30,'B' => 30,'C' => 30,'D' => 30,'E' => 30,'F' => 30,'G' => 30,'H' => 30,'I' => 30,'J' => 30,'K' => 30,'L' => 30,'M' => 30];
        return OutputFile::outputFile($rowTitle,$data,'test','xls');
	 * @author StubbornGrass
	 * @dateTime 2017-11-10
	 * @param    [type]     $rowTitle [description]
	 * @param    [type]     $param    [description]
	 * @param    [type]     $width    [description]
	 * @param    [type]     $fileName [description]
	 * @param    string     $type     [支持xls和xlsx]
	 * @return   [type]               [description]
	 */
	public static function downloadXls($rowTitle, $param, $width,
                                       $fileName, $type = 'xlsx') {

        $cellData[] = (array) $rowTitle;
        $i = 1;
        foreach(json_decode( json_encode( $param),true) as $value) {
            array_unshift($value,$i++);
            $cellData[] = $value;
        }
        Excel::create($fileName, function($excel) use ($cellData, $width) {
            $excel->sheet('score', function($sheet) use ($cellData, $width) {
                $sheet->fromArray($cellData, '', 'A2');
                $sheet->setWidth($width);
                $sheet->mergeCells('A1:F1');

            });
        })->export($type);
	}
}