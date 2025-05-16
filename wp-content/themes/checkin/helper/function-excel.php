<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
// đọc file excel ==================================================
use PhpOffice\PhpSpreadsheet\IOFactory;

function export_excel_check_in($data)
{
    require_once __DIR__ . '/../../../vendor/autoload.php';

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('CHECK IN');  // 設定工作表名稱為 "我的工作表"
    $sheet->setCellValue('A1', '會員編號');
    $sheet->setCellValue('B1', '姓名');
    $sheet->setCellValue('C1', '公司名稱(中文)');
    $sheet->setCellValue('D1', '公司名稱(越文)');
    $sheet->setCellValue('E1', '職稱');
    $sheet->setCellValue('F1', '電郵');
    $sheet->setCellValue('G1', '電話');
    $sheet->setCellValue('H1', '日期');
    $sheet->setCellValue('I1', '時間');
    // // set do rong cua cot
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setWidth(35);
    $sheet->getColumnDimension('G')->setAutoSize(true);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    
    // set chieu cao cua dong
    $sheet->getRowDimension('1')->setRowHeight(30);
    // set to dam chu
    $sheet->getStyle('A')->getFont()->setBold(TRUE);
    $sheet->getStyle('A1:I1')->getFont()->setBold(TRUE);

    // 設定 A1 儲存格的背景顏色 (使用 RGB 色碼)
    $sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF999999'); // 設定為黃色 (RGB:rgb(162, 199, 247))

    // 設定 A1 儲存格的框線 (黑色)
    $sheet->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color("FF333333"));
    // set chu canh giua
    $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $i = 2;
    if (!empty($data)) {
        foreach ($data as $key => $val) {
            $sheet->setCellValue('A' . $i, $val['member_code']);
            $sheet->setCellValue('B' . $i, $val['contact']);
            $sheet->setCellValue('C' . $i, $val['company_cn']);
            $sheet->setCellValue('D' . $i, $val['company_cn']);
            $sheet->setCellValue('E' . $i, $val['position']);
            $sheet->setCellValue('F' . $i, $val['email']);
            $sheet->setCellValue('G' . $i, $val['phone']);
            $sheet->setCellValue('H' . $i, $val['date']);
            $sheet->setCellValue('I' . $i, $val['time']);
            $i++;
        }
    }

    $filename = 'check_in_ctcvndn_' . date('dmYHis') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // 清空之前的所有輸出緩衝
    if (ob_get_length()) {
        ob_end_clean();
    }

    // 設定 HTTP 標頭
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

function export_excel_guests($data)
{
    require_once __DIR__ . '/../../../vendor/autoload.php';

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('CHECK IN');  // 設定工作表名稱為 "我的工作表"
    $sheet->setCellValue('A1', '會員編號');
    $sheet->setCellValue('B1', '姓名');
    $sheet->setCellValue('C1', '公司名稱(中文)');
    $sheet->setCellValue('D1', '公司名稱(越文)');
    $sheet->setCellValue('E1', '職稱');
    $sheet->setCellValue('F1', '電郵');
    $sheet->setCellValue('G1', '電話');
    // // set do rong cua cot
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setAutoSize(true);;
    $sheet->getColumnDimension('D')->setAutoSize(true);;
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->getColumnDimension('F')->setWidth(30);
    $sheet->getColumnDimension('G')->setWidth(30);

    // set chieu cao cua dong
    $sheet->getRowDimension('1')->setRowHeight(30);
    // set to dam chu
    $sheet->getStyle('A')->getFont()->setBold(TRUE);
    $sheet->getStyle('A1:G1')->getFont()->setBold(TRUE);

    // 設定 A1 儲存格的背景顏色 (使用 RGB 色碼)
    $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FF999999'); // 設定為黃色 (RGB:rgb(162, 199, 247))

    // 設定 A1 儲存格的框線 (黑色)
    $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
        ->setColor(new Color("FF333333"));
    // set chu canh giua
    $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:G1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $i = 2;
    if (!empty($data)) {
        foreach ($data as $key => $val) {

            require_once DIR_CODES . 'my-list.php';
            $myList = new Codes_My_List();
            $country = $myList->get_country($val['country']);

            $sheet->setCellValue('A' . $i, $val['member_code']);
            $sheet->setCellValue('B' . $i, $val['contact']);
            $sheet->setCellValue('C' . $i, $val['company_cn']);
            $sheet->setCellValue('D' . $i, $val['company_vn']);
            $sheet->setCellValue('E' . $i, $val['position']);
            $sheet->setCellValue('F' . $i, $val['email']);
            $sheet->setCellValue('G' . $i, $val['phone']);
            $i++;
        }
    }



    $filename = 'member_ctcvndn_' . date('dmYHis') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    // 清空之前的所有輸出緩衝
    if (ob_get_length()) {
        ob_end_clean();
    }

    // 設定 HTTP 標頭
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

function import_excel_guests($filePart)
{
    require_once __DIR__ . '/../../../vendor/autoload.php';
    $spreadsheet = IOFactory::load($filePart);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();
    return $data;
}
