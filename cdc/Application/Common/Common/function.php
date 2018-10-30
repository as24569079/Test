<?php
function getpage($count, $pagesize = 5) {
    $p = new Think\Page($count, $pagesize);
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
//    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $p->lastSuffix = false;//最后一页不显示为总页数
    return $p;
}


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/12
 * Time: 17:24
 */
function exportExcel($expTitle,$expCellName,$expTableData){
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);// ļ     
    $fileName = $_SESSION['loginAccount'] . date('_YmdHis');//or $xlsTitle  ļ    ƿɸ    Լ     趨
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor("PHPExcel.PHPExcel");
    $objPHPExcel = new PHPExcel();
    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
    $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');// ϲ   Ԫ  
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));
    for ($i = 0; $i < $cellNum; $i++) {
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($cellName[$i] . '2', $expCellName[$i][1],PHPExcel_Cell_DataType::TYPE_STRING);
    }
    // Miscellaneous glyphs, UTF-8
    for ($i = 0; $i < $dataNum; $i++) {
        for ($j = 0; $j < $cellNum; $j++) {
            $objPHPExcel->getActiveSheet(0)->setCellValueExplicit($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]],PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }
    ob_end_clean();
    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xls");//attachment ´  ڴ ӡinline     ڴ ӡ
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    return true;
}
function check_verify($code, $id = ""){  
    $verify = new \Think\Verify();  
    return $verify->check($code, $id);  
}  

