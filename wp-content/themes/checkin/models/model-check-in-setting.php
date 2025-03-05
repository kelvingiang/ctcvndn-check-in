<?php

require_once DIR_CODES . 'my-list.php';
require_once DIR_MODEL . 'model-check-in-report.php';


class Model_Check_In_Setting
{

    private $_table;
    private $_table_detail;
    private $_report_model;


    public function __construct()
    {
        global $wpdb;
        $this->_table =  $wpdb->prefix . 'check_in_member';
        $this->_table_detail = $wpdb->prefix . 'check_in_detail';
        $this->_report_model = new Model_Check_In_Report();

        // $this->AttendDetail();

    }

    // private function CountryName($id)
    // {
    //     return $this->myList->get_country($id);
    // }


    //---------------------------------------------------------------------------------------------
    // them moi de kiem tra check trong ca hai table member va guests
    // lay barcode trong table check-in de lay data trong hai table
    //---------------------------------------------------------------------------------------------

    // public function AttendTime()
    // {
    //     global $wpdb;
    //     $sql = "SELECT member_id, time, date  FROM $this->_table_detail GROUP BY member_id ";
    //     $row = $wpdb->get_results($sql, ARRAY_A);
    //     return $row;
    // }

    // public function AttendDetail()
    // {
    //     global $wpdb;
    //     // $table_guests = $wpdb->prefix . $this->_table;
    //     $table_member = $wpdb->prefix . 'member';
    //     //$barcode = $this->AttendTime();
    //     $guestsList = array();
    //     $memberList = array();

    //     foreach ($this->AttendTime() as $val) {
    //         $sql = "SELECT full_name AS Name, country AS Country,  position AS Position, phone AS Phone, email AS Email, barcode AS Barcode  FROM $this->_table WHERE  qr_code =" . $val['qr_code'];
    //         $row = $wpdb->get_results($sql, ARRAY_A);
    //         array_push($row, array("Time" => $val['time'], "Date" => $val['date']));
    //         $guestsList[] = $row;
    //     }



    //     // PHAN SAP XEP LAI THU TU THEO THOI GIAN CHECK IN
    //     uasort($guestsList, function ($a, $b) {
    //         return $b[1]['Time'] - $a[1]['Time'];
    //     });

    //     $this->attenList = array_merge($guestsList, $memberList);

    //     // return array_merge($guestsList,$memberList);
    // }

    ////=================================================================  
    public function ReportView()
    {
        global $wpdb;
        // $table = $wpdb->prefix . $this->_table;
        $sql = "SELECT * FROM $this->_table WHERE check_in = 1 AND status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    public function ReportJoinView()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table AS A LEFT JOIN $this->_table_detail AS B ON A.ID = B.member_id
                  WHERE A.status = 1 AND A.check_in =1
                  GROUP BY B.guests_id
                  ORDER BY B.time DESC";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    //^^ add new at 14/03/2018
    // public function ReportBranchView()
    // {
    //     global $wpdb;
    //     $sql = "SELECT country AS code, Count(country) AS register, 
    //         (SELECT  Count(country) FROM $this->_table WHERE check_in = 1 AND status = 1 AND country = code) AS arrived
    //          FROM $this->_table WHERE status = 1 GROUP BY country ORDER BY arrived DESC ";
    //     $row = $wpdb->get_results($sql, ARRAY_A);

    //     $newBranchitem = array();
    //     $newBranch = array();
    //     foreach ($row as $val) {
    //         $newBranchitem['code'] = $val['code'];
    //         $newBranchitem['register'] = $val['register'];
    //         $newBranchitem['arrived'] = $val['arrived'];
    //         $newBranchitem['percent'] = round($val['arrived'] / $val['register'] * 100, 2);
    //         $newBranch[] = $newBranchitem;
    //     }
    //     return $newBranch;
    // }

    public function BarcodeInfo()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table WHERE  status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    // public function ReportDetailView($barcode)
    // {
    //     global $wpdb;
    //     $sql = "SELECT * FROM $this->_table WHERE barcode = $barcode";
    //     $row = $wpdb->get_results($sql, ARRAY_A);
    //     return $row;
    // }

    /// =============================================


    public function ExportMember()
    {
        require_once DIR_CLASS . 'PHPExcel.php';
        $exExport = new PHPExcel();
        $exExport->setActiveSheetIndex(0);
        $sheet = $exExport->getActiveSheet()->setTitle("check in");
        $sheet->setCellValue('A1', '會員編號');
        $sheet->setCellValue('B1', '姓名');
        $sheet->setCellValue('C1', '公司名稱(中文)');
        $sheet->setCellValue('D1', '公司名稱(越文)');
        $sheet->setCellValue('E1', '職稱');
        $sheet->setCellValue('F1', '電郵');
        $sheet->setCellValue('G1', '電話');

        // set do rong cua cot
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        // set chieu cao cua dong
        $sheet->getRowDimension('1')->setRowHeight(30);
        // set to dam chu
        $sheet->getStyle('A')->getFont()->setBold(TRUE);
        $sheet->getStyle('A1:D1')->getFont()->setBold(TRUE);
        // set nen backgroup cho dong
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
        // set chu canh giua
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //---------------------------------------------------------------------------------------------
        // PHAN LAY CHICK IN 2 TABLE GUESTS VA MEMBER NHU CHI LAY 1 DONG TRONG BANG CHECK IN
        //---------------------------------------------------------------------------------------------
        // global $wpdb;
        // $sql = "SELECT * FROM $this->_table WHERE status = 1 ";
        // $row = $wpdb->get_results($sql, ARRAY_A);

        $row = $this->_report_model->getAllMember();
        $i = 2;

        if (!empty($row)) {
            foreach ($row as $key => $val) {
                // $sql2 = "SELECT * FROM $this->_table_detail  WHERE member_ID = " . $val['ID'] . " GROUP BY member_id";
                // $rowDetail = $wpdb->get_row($sql2, ARRAY_A);
                $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val['member_code'])
                    ->setCellValue('B' . $i, $val['contact'])
                    ->setCellValue('C' . $i, $val['company_cn'])
                    ->setCellValue('D' . $i, $val['company_vn'])
                    ->setCellValue('E' . $i, $val['position'])
                    ->setCellValue('F' . $i, $val['email'])
                    ->setCellValueExplicit('G' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING);

                $i++;
            }
        }
        // phan set border 
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //cho tat ca 
        $sheet->getStyle('A1:' . 'G' . ($i - 1))->applyFromArray($styleArray);
        //   chi dong title
        //$sheet->getStyle('A1:' . 'G1')->applyFromArray($styleArray);
        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
        // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = 'member-list_' . date("ymdHis") . '.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        //        ob_start();
        $objWriter->save('php://output');
    }


    public function ExCheckInToExcel()
    {
        require_once DIR_CLASS . 'PHPExcel.php';
        $exExport = new PHPExcel();
        $exExport->setActiveSheetIndex(0);
        $sheet = $exExport->getActiveSheet()->setTitle("check in");
        $sheet->setCellValue('A1', '會員編號');
        $sheet->setCellValue('B1', '姓名');
        $sheet->setCellValue('C1', '公司名稱(中文)');
        $sheet->setCellValue('D1', '公司名稱(越文)');
        $sheet->setCellValue('E1', '職稱');
        $sheet->setCellValue('F1', '電郵');
        $sheet->setCellValue('G1', '電話');
        $sheet->setCellValue('H1', '日期');
        $sheet->setCellValue('I1', '時間');
        // set do rong cua cot
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
        // set nen backgroup cho dong
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
        // set chu canh giua
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //---------------------------------------------------------------------------------------------
        // PHAN LAY CHICK IN 2 TABLE GUESTS VA MEMBER NHU CHI LAY 1 DONG TRONG BANG CHECK IN
        //---------------------------------------------------------------------------------------------
        // global $wpdb;
        // $sql = "SELECT * FROM $this->_table WHERE status = 1 ";
        // $row = $wpdb->get_results($sql, ARRAY_A);

        $row = $this->_report_model->ReportJoinView();
        $i = 2;

        if (!empty($row)) {
            foreach ($row as $key => $val) {
                // $sql2 = "SELECT * FROM $this->_table_detail  WHERE member_ID = " . $val['ID'] . " GROUP BY member_id";
                // $rowDetail = $wpdb->get_row($sql2, ARRAY_A);
                $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val['member_code'])
                    ->setCellValue('B' . $i, $val['contact'])
                    ->setCellValue('C' . $i, $val['company_cn'])
                    ->setCellValue('D' . $i, $val['company_vn'])
                    ->setCellValue('E' . $i, $val['position'])
                    ->setCellValue('F' . $i, $val['email'])
                    ->setCellValueExplicit('G' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('H' . $i, $val['date'])
                    ->setCellValue('I' . $i, $val['time']);

                //            $checkInAll ="";
                if ($row[1]['Kind'] == "m") {
                    //$objPHPExcel->setActiveSheetIndex(0)->getStyle( $cell )->getFont()->setSize( 10 );
                    $exExport->setActiveSheetIndex(0)->getStyle("A$i:G$i")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00e9ebed');
                }
                $i++;
            }
        }
        // phan set border 
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //cho tat ca 
        $sheet->getStyle('A1:' . 'I' . ($i - 1))->applyFromArray($styleArray);
        //   chi dong title
        //$sheet->getStyle('A1:' . 'G1')->applyFromArray($styleArray);
        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
        // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = 'checkin_' . date("ymdHis") . '.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        //        ob_start();
        $objWriter->save('php://output');
    }

    public function ExCheckInToExcelByID($id)
    {
        require_once DIR_CLASS . 'PHPExcel.php';
        $exExport = new PHPExcel();
        // $exExport->setActiveSheetIndex(0)
        // ->setCellValue('A1', '公司名稱')
        // ->setCellValue('B1', '地址')
        // ->setCellValue('C1', '稅碼')
        // ->setCellValue('D1', '姓名')
        // ->setCellValue('E1', '職稱')
        // ->setCellValue('F1', '電郵')
        // ->setCellValue('G1', '電話')
        // ->setCellValue('H1', '出席');
        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0);
        $sheet = $exExport->getActiveSheet()->setTitle("check in");
        $sheet->setCellValue('A1', '會員編號');
        $sheet->setCellValue('B1', '姓名');
        $sheet->setCellValue('C1', '公司名稱(中文)');
        $sheet->setCellValue('D1', '公司名稱(越文)');
        $sheet->setCellValue('E1', '職稱');
        $sheet->setCellValue('F1', '電郵');
        $sheet->setCellValue('G1', '電話');
        $sheet->setCellValue('H1', '日期');
        $sheet->setCellValue('I1', '時間');
        // set do rong cua cot
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
        // set nen backgroup cho dong
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0008bdf8');
        // set chu canh giua
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $row = $this->_report_model->ReportJoinViewByID($id);
        $i = 2;

        if (!empty($row)) {
            foreach ($row as $key => $val) {
                // $sql2 = "SELECT * FROM $this->_table_detail  WHERE member_ID = " . $val['ID'] . " GROUP BY member_id";
                // $rowDetail = $wpdb->get_row($sql2, ARRAY_A);
                $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val['member_code'])
                    ->setCellValue('B' . $i, $val['contact'])
                    ->setCellValue('C' . $i, $val['company_cn'])
                    ->setCellValue('D' . $i, $val['company_vn'])
                    ->setCellValue('E' . $i, $val['position'])
                    ->setCellValue('F' . $i, $val['email'])
                    ->setCellValueExplicit('G' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('H' . $i, $val['date'])
                    ->setCellValue('I' . $i, $val['time']);

                //            $checkInAll ="";
                if ($row[1]['Kind'] == "m") {
                    //$objPHPExcel->setActiveSheetIndex(0)->getStyle( $cell )->getFont()->setSize( 10 );
                    $exExport->setActiveSheetIndex(0)->getStyle("A$i:G$i")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00e9ebed');
                }
                $i++;
            }
        }
        // phan set border 
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        //cho tat ca 
        $sheet->getStyle('A1:' . 'I' . ($i - 1))->applyFromArray($styleArray);

        $filename = 'checkin_' . date("ymdHis") . '.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        //        ob_start();
        $objWriter->save('php://output');
    }

    // public function ExportBarcode()
    // {
    //     require_once DIR_CLASS . 'PHPExcel.php';
    //     $exExport = new PHPExcel();

    //     // TAO COT TITLE
    //     $exExport->setActiveSheetIndex(0)
    //         ->setCellValue('A1', '姓名')
    //         ->setCellValue('B1', '職稱')
    //         ->setCellValue('C1', '分會')
    //         ->setCellValue('D1', '條碼');

    //     // TAO NOI DUNG CHEN TU DONG 2
    //     $i = 2;
    //     $list = $this->BarcodeInfo();

    //     foreach ($list as $row) {
    //         $exExport->setActiveSheetIndex(0)
    //             ->setCellValue('A' . $i, $row['full_name'])
    //             ->setCellValue('B' . $i, $row['position'])
    //             ->setCellValue('C' . $i, $this->CountryName($row['country']))
    //             ->setCellValueExplicit('D' . $i, $row['barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
    //         $i++;
    //     }
    //     // TAO FILE EXCEL VA SAVE LAI THEO PATH
    //     //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
    //     //$objWriter->save($full_path);
    //     //
    //     // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
    //     $filename = date("YmdHis") . '_barcode.xlsx';
    //     $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header("Content-Disposition: attachment;filename=$filename");
    //     header('Cache-Control: max-age=0');
    //     ob_end_clean();
    //     //        ob_start();
    //     $objWriter->save('php://output');
    // }

    public function ExportMemberPost()
    {

        global $wpdb;
        require_once DIR_CLASS . 'PHPExcel.php';
        $exExport = new PHPExcel();
        // TAO COT TITLE
        $exExport->setActiveSheetIndex(0)
            ->setCellValue('A1', '公司名稱')
            ->setCellValue('B1', '地址')
            ->setCellValue('C1', '稅碼')
            ->setCellValue('D1', '姓名')
            ->setCellValue('E1', '職稱')
            ->setCellValue('F1', '電郵')
            ->setCellValue('G1', '電話')
            ->setCellValue('H1', '出席');

        // TAO NOI DUNG CHEN TU DONG 2
        $sql = "SELECT * FROM $this->_table ";
        $row = $wpdb->get_results($sql, ARRAY_A);
        $i = 2;
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $sql2 = "SELECT * FROM $this->_table_detail  WHERE check_in_ID = " . $val['ID'] . " GROUP BY check_in_ID";
                $rowDetail = $wpdb->get_row($sql2, ARRAY_A);

                $exExport->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $val['company'])
                    ->setCellValue('B' . $i, $val['address'])
                    ->setCellValueExplicit('C' . $i, $val['tax'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('D' . $i, $val['full_name'])
                    ->setCellValue('E' . $i, $val['position'])
                    ->setCellValue('F' . $i, $val['email'])
                    ->setCellValueExplicit('G' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('H' . $i, $rowDetail['date'] . ' / ' . $rowDetail['time']);
                $i++;
            }
        }
        // TAO FILE EXCEL VA SAVE LAI THEO PATH
        //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
        //$objWriter->save($full_path);
        // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
        $filename = date("YmdHis") . '_checkin.xlsx';
        $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        ob_end_clean();
        //        ob_start();
        $objWriter->save('php://output');
    }

    // public function ExportMemberTable()
    // {
    //     require_once DIR_CLASS . 'PHPExcel.php';
    //     $exExport = new PHPExcel();

    //     // TAO COT TITLE
    //     $exExport->setActiveSheetIndex(0)
    //         ->setCellValue('A1', 'ID')
    //         ->setCellValue('B1', 'Full Name')
    //         ->setCellValue('C1', 'Country')
    //         ->setCellValue('D1', 'Position')
    //         ->setCellValue('E1', 'Email')
    //         ->setCellValue('F1', 'Phone')
    //         ->setCellValue('G1', 'Barcode')
    //         ->setCellValue('H1', 'Img')
    //         ->setCellValue('I1', 'Check In')
    //         ->setCellValue('J1', 'Create Date')
    //         ->setCellValue('K1', 'Stauts')
    //         ->setCellValue('L1', 'Note');

    //     // TAO NOI DUNG CHEN TU DONG 2
    //     global $wpdb;
    //     $table = $wpdb->prefix . 'member';
    //     $sql = "SELECT * FROM $table";
    //     $row = $wpdb->get_results($sql, ARRAY_A);
    //     if (!empty($row)) {
    //         $i = 2;
    //         foreach ($row as $val) {
    //             $exExport->setActiveSheetIndex(0)
    //                 ->setCellValueExplicit('A' . $i, $val['ID'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('B' . $i, $val['full_name'])
    //                 ->setCellValueExplicit('C' . $i, $val['country'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('D' . $i, $val['position'])
    //                 ->setCellValue('E' . $i, $val['email'])
    //                 ->setCellValueExplicit('F' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValueExplicit('G' . $i, $val['barcode'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('H' . $i, $val['img'])
    //                 ->setCellValue('I' . $i, $val['check_in'])
    //                 ->setCellValue('j' . $i, $val['create_date'])
    //                 ->setCellValue('K' . $i, $val['status'])
    //                 ->setCellValue('L' . $i, $val['note']);
    //             $i++;
    //         }
    //     }


    //     // TAO FILE EXCEL VA SAVE LAI THEO PATH
    //     //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
    //     //$objWriter->save($full_path);
    //     // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
    //     $filename = date("YmdHis") . '_memberlist.xlsx';
    //     $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header("Content-Disposition: attachment;filename=$filename");
    //     header('Cache-Control: max-age=0');
    //     ob_end_clean();
    //     //        ob_start();
    //     $objWriter->save('php://output');
    // }

    // public function ExportGuests()
    // {
    //     require_once DIR_CLASS . 'PHPExcel.php';
    //     $exExport = new PHPExcel();

    //     // TAO COT TITLE
    //     $exExport->setActiveSheetIndex(0)
    //         ->setCellValue('A1', 'ID')
    //         ->setCellValue('B1', 'Full Name')
    //         ->setCellValue('C1', 'Country')
    //         ->setCellValue('D1', 'Position')
    //         ->setCellValue('E1', 'Email')
    //         ->setCellValue('F1', 'Phone')
    //         ->setCellValue('G1', 'Barcode')
    //         ->setCellValue('H1', 'Img')
    //         ->setCellValue('I1', 'Check In')
    //         ->setCellValue('J1', 'Create Date')
    //         ->setCellValue('K1', 'Stauts')
    //         ->setCellValue('L1', 'Note');

    //     // TAO NOI DUNG CHEN TU DONG 2
    //     global $wpdb;
    //     // $table = $wpdb->prefix . $this->_table;
    //     $sql = "SELECT * FROM $this->_table";
    //     $row = $wpdb->get_results($sql, ARRAY_A);

    //     if (!empty($row)) {
    //         $i = 2;
    //         foreach ($row as $val) {
    //             $exExport->setActiveSheetIndex(0)
    //                 ->setCellValueExplicit('A' . $i, $val['ID'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('B' . $i, $val['full_name'])
    //                 ->setCellValueExplicit('C' . $i, $this->CountryName($val['country']), PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('D' . $i, $val['position'])
    //                 ->setCellValue('E' . $i, $val['email'])
    //                 ->setCellValueExplicit('F' . $i, $val['phone'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValueExplicit('G' . $i, $val['barcode'], PHPExcel_Cell_DataType::TYPE_STRING)
    //                 ->setCellValue('H' . $i, $val['img'])
    //                 ->setCellValue('I' . $i, $val['check_in'])
    //                 ->setCellValue('j' . $i, $val['create_date'])
    //                 ->setCellValue('K' . $i, $val['status'])
    //                 ->setCellValue('L' . $i, $val['note']);
    //             $i++;
    //         }
    //     }


    //     // TAO FILE EXCEL VA SAVE LAI THEO PATH
    //     //$objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     //$full_path = EXPORT_DIR . date("YmdHis") . '_report.xlsx'; //duong dan file
    //     //$objWriter->save($full_path);
    //     // TAO FILE EXCEL VA DOWN TRUC TIEP XUONG CLINET
    //     $filename = date("YmdHis") . '_guests.xlsx';
    //     $objWriter = PHPExcel_IOFactory::createWriter($exExport, 'Excel2007');
    //     header('Content-Type: application/vnd.ms-excel');
    //     header("Content-Disposition: attachment;filename=$filename");
    //     header('Cache-Control: max-age=0');
    //     ob_end_clean();
    //     //        ob_start();
    //     $objWriter->save('php://output');
    // }

    //===================================================================================


    public function ResetCheckIn()
    {
        global $wpdb;
        //RESET ALL CHECK 
        $updateSql = "UPDATE $this->_table SET status = 0 WHERE 1=1";
        $wpdb->query($updateSql);

        // XOA GUESTS CHECK IN
        $deleteSql = "DELETE FROM $this->_table_detail";
        $wpdb->query($deleteSql);
        // TRA ID LAI MUT BAT DAU BAT DAU BANG 1
        $sql = "ALTER TABLE $this->_table_detail AUTO_INCREMENT = 1";
        $wpdb->query($sql);
    }

    public function create_QRCode()
    {
        global $wpdb;
        $sql = "SELECT member_code, contact, qr_code FROM $this->_table";
        $row = $wpdb->get_results($sql, ARRAY_A);

        // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
        $files = glob(DIR_IMAGES_QRCODE . '*.png'); //get all file names
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file); //delete file
        }

        // TAO TAT CA CAC FILE QRCODE MOI
        require_once(DIR_CLASS . 'qrcode' . DS . 'qrlib.php');
        foreach ($row as $item) {
            $filePath = DIR_IMAGES_QRCODE . $item['qr_code'] . '.png';
            $errorCorrectionLevel = "L";
            $matrixPointSize = 3;
            QRcode::png($item['qr_code'], $filePath, $errorCorrectionLevel, $matrixPointSize, 2);

            //********************************************************* */
            //=== tạo thêm chữ trên file QRCode /   28/02/2025 
            // them font NotoSansTC-Regular.ttf vào mục font tạo thêm define DIR_FONTS
            //start  *********************************************************/
            // 讀取 QR Code 圖片
            $qrImage = imagecreatefrompng($filePath);
            $qrWidth = imagesx($qrImage);
            $qrHeight = imagesy($qrImage);

            // **設定中文字型**
            $fontPath = DIR_FONT . 'NotoSansTC-Regular.ttf'; // 確保字型路徑正確
            $fontSize = 9; // 字體大小
            $textPadding = 5; // 文字與 QR Code 之間的距離

            // **計算文字寬度**
            $box = imagettfbbox($fontSize, 0, $fontPath, $item['member_code']);
            $textWidth = abs($box[2] - $box[0]);
            $textHeight = abs($box[7] - $box[1]);

            // **建立新圖片（比 QR Code 高一點來放文字）**
            $finalImage = imagecreatetruecolor($qrWidth, $qrHeight + $textHeight + $textPadding);
            $white = imagecolorallocate($finalImage, 255, 255, 255);
            $black = imagecolorallocate($finalImage, 0, 0, 0);

            // **填充背景為白色**
            imagefilledrectangle($finalImage, 0, 0, $qrWidth, $qrHeight + $textHeight + $textPadding, $white);
            imagecopy($finalImage, $qrImage, 0, 0, 0, 0, $qrWidth, $qrHeight);

            // **在 QR Code 下方添加中文文字**
            $textX = ($qrWidth - $textWidth) / 2;
            $textY = $qrHeight + $textHeight; // 文字放在 QR Code 下方
            imagettftext($finalImage, $fontSize, 0, $textX, $textY, $black, $fontPath, $item['member_code']);

            // **儲存最終圖片**
            imagepng($finalImage, $filePath);

            // **釋放記憶體**
            imagedestroy($qrImage);
            imagedestroy($finalImage);
            // end *********************************************************/

            // DOI TEN FILE THEO KIEU CHU HOA
            // $newName = iconv('UTF-8', 'BIG5', DIR_IMAGES_BARCODE . $item['full_name'] . '-' . $item['barcode'] . '.png');
            // $oldName = iconv('UTF-8', 'BIG5', $filePath);
            // rename($oldName, $newName);

        }
    }

    public function create_QRCode_Name()
    {
        global $wpdb;
        // xoa cac file cu
        $files = glob(rtrim(DIR_IMAGES_QRCODE_NAME . '*.png')); //get all file names
        foreach ($files as $file) {
            unlink($file); //delete file
        }
        // rmdir( THEME_URL . DS . 'images' . DS . 'name_barcode');
        //  copy tat ca file trong thu muc barcode den thu muc name_barcode  
        $copyfiles = glob(trim(DIR_IMAGES_QRCODE . '*.png')); //get all file names

        foreach ($copyfiles as $item) {

            if (is_file($item)) {
                $ff = explode(DS, $item);
                $lastItem = end($ff); // lay phan tu cuoi cung trong array
                $newfile = DIR_IMAGES_QRCODE_NAME . $lastItem;
                copy($item, $newfile); // chuyen sang folden moi;
            }
        }
        // doi ten them ten thanh vien vao ten file
        // $table = $wpdb->prefix . $this->_table;
        $sql = "SELECT contact, qr_code FROM $this->_table";
        $rows = $wpdb->get_results($sql, ARRAY_A);
        // echo '<pre>'; print_r($rows); echo '</pre>';
        // die();

        foreach ($rows as $row) {
            // DOI TEN FILE THEO KIEU CHU HOA
            $oldName = DIR_IMAGES_QRCODE_NAME . $row['qr_code'] . '.png';
            // chuyen ten tieng trung bi loan ma ==== 
            // $newName = iconv('UTF-8', 'BIG5', DIR_IMAGES_QRCODE_NAME . vn_to_str($row['contact']) . '-' . $row['qr_code'] . '.png');
            $newName =  DIR_IMAGES_QRCODE_NAME . $row['contact'] . '-' . $row['qr_code'] . '.png';
            rename($oldName, $newName);
            // echo $oldName; 
            // echo $newName;
            // die();
        }
    }

    // public function create_registered_QRCode()
    // {
    //     global $wpdb;
    //     $sql = "SELECT full_name, barcode FROM $this->_table WHERE status = 1";
    //     $row = $wpdb->get_results($sql, ARRAY_A);

    //     // XOA HET CAC FILE QRCODE .png CO TRONG FOLDER
    //     $files = glob(DIR_IMAGES_QRCODE_REGISTER . '*.png'); //get all file names
    //     foreach ($files as $file) {
    //         if (is_file($file))
    //             unlink($file); //delete file
    //     }

    //     // TAO TAT CA CAC FILE QRCODE MOI
    //     require_once(DIR_CLASS . 'qrcode' . DS . 'qrlib.php');
    //     foreach ($row as $item) {
    //         $filePath = DIR_IMAGES_QRCODE_REGISTER . $item['barcode'] . '-' . $item['full_name'] . '.png';
    //         $errorCorrectionLevel = "L";
    //         $matrixPointSize = 3;
    //         QRcode::png($item['barcode'], $filePath, $errorCorrectionLevel, $matrixPointSize, 2);

    //         // DOI TEN FILE THEO KIEU CHU HOA
    //         // $newName = iconv('UTF-8', 'BIG5', DIR_IMAGES_BARCODE . $item['full_name'] . '-' . $item['barcode'] . '.png');
    //         // $oldName = iconv('UTF-8', 'BIG5', $filePath);
    //         // rename($oldName, $newName);
    //     }
    // }

    //=================================================================================
    public function ImportGuests($filename)
    {

        // echo $filename;
        // die();
        require_once DIR_CLASS . 'PHPExcel.php';
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        // $objReader->setReadDataOnly(true);

        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load("$filename");

        $total_sheets = $objPHPExcel->getSheetCount();

        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $arraydata = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $arraydata[$row - 2][$col] = $value;
            }
        }
        global $wpdb;

        $wpdb->query("TRUNCATE TABLE $this->_table");

        foreach ($arraydata as $item) {
            $qrcode = $item[0] . '-' . create_qrcode();
            $company_cn = $item[1] == null ? "" : trim($item[1]);
            $company_vn = $item[2] == null ? "" : trim($item[2]);
            $contact = $item[3] == null ? "" : trim($item[3]);
            $position = $item[4] == null ? "" : $item[4];
            $address = $item[5] == null ? "" : $item[5];
            $phone = $item[6] == null ? "00000" : $item[6];
            $email = $item[7] == null ? "" : $item[7];
            $career = $item[8] == null ? "" : $item[8];
            // echo $career;
            $data = array(
                'member_code' => $item[0],
                'qr_code' => $qrcode,
                'company_cn' => $company_cn,
                'company_vn' => $company_vn,
                'contact' => $contact,
                'position' => $position,
                'address' => $address,
                'phone' => $phone,
                'email' => strtolower($email),
                'career' => $career,
                'create_date' => date('Y-m-d')
            );
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die();

            $wpdb->insert($this->_table, $data);
        }
    }


    public function ImportGuestsUpdateInfo($filename)
    {
        require_once DIR_CLASS . 'PHPExcel.php';
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        // $objReader->setReadDataOnly(true);

        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load("$filename");

        $total_sheets = $objPHPExcel->getSheetCount();

        $allSheetName = $objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $arraydata = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            for ($col = 0; $col < $highestColumnIndex; ++$col) {
                $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $arraydata[$row - 2][$col] = $value;
            }
        }
        global $wpdb;

        foreach ($arraydata as $item) {
            $qrcode = $item[0] . '-' . create_qrcode();
            $company_cn = $item[1] == null ? "" : trim($item[1]);
            $company_vn = $item[2] == null ? "" : trim($item[2]);
            $contact = $item[3] == null ? "" : trim($item[3]);
            $position = $item[4] == null ? "" : $item[4];
            $address = $item[5] == null ? "" : $item[5];
            $phone = $item[6] == null ? "00000" : $item[6];
            $email = $item[7] == null ? "" : $item[7];
            $career = $item[8] == null ? "" : $item[8];
            $data = array(
                'member_code' => $item[0],
                'qr_code' => $qrcode,
                'company_cn' => $company_cn,
                'company_vn' => $company_vn,
                'contact' => $contact,
                'position' => $position,
                'address' => $address,
                'phone' => $phone,
                'email' => strtolower($email),
                'career' => $career,
                'create_date' => date('Y-m-d')
            );

            $wpdb->insert($this->_table, $data);
        }
    }



    // ===== add 13-12-2021 =========================================
    // public function ImportFace($filename)
    // {
    //     require_once DIR_CLASS . 'PHPExcel.php';
    //     $inputFileType = PHPExcel_IOFactory::identify($filename);
    //     $objReader = PHPExcel_IOFactory::createReader($inputFileType);

    //     //$objReader->setReadDataOnly(true);

    //     /**  Load $inputFileName to a PHPExcel Object  * */
    //     $objPHPExcel = $objReader->load("$filename");

    //     $total_sheets = $objPHPExcel->getSheetCount();

    //     $allSheetName = $objPHPExcel->getSheetNames();
    //     $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    //     $highestRow = $objWorksheet->getHighestRow();
    //     $highestColumn = $objWorksheet->getHighestColumn();
    //     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    //     $arraydata = array();
    //     for ($row = 2; $row <= $highestRow; ++$row) {
    //         for ($col = 0; $col < $highestColumnIndex; ++$col) {
    //             $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
    //             $arraydata[$row - 2][$col] = $value;
    //         }
    //     }

    //     global $wpdb;
    //     // $table = $wpdb->prefix . $this->_table;
    //     // $table_check_in = $wpdb->prefix . $this->_table_detail;


    //     foreach ($arraydata as $item) {

    //         $id_len = strlen($item[1]);
    //         if ($id_len == 10) {
    //             $memberID = "00" . $item[1];
    //         } elseif ($id_len == 11) {
    //             $memberID = "0" . $item[1];
    //         }
    //         $sql = "SELECT ID FROM $this->_table WHERE `barcode`= '$memberID' ";
    //         $row = $wpdb->get_results($sql, ARRAY_A);
    //         foreach ($row as $val) {


    //             //CAP NHAT TABLE THANH VIEN DA CHECK IN =================
    //             $updateSql = "UPDATE $this->_table SET `check_in`= 1 WHERE `barcode`= $memberID";
    //             $wpdb->query($updateSql);

    //             // KIEM TRA MA ID VI BANG EXCEL XUAT LA KIEU SO NEN CAC SO KHONG TRUOC SE BI MAT 
    //             // NEU LA 10 SO THEM 2 SO 00 O PHIA TRUOC
    //             // NEU LA 11 SO THEM 1 SO 0 O PHIA TRUOC
    //             // LAM DU 12 TRONG MA


    //             // THEM MOI THONG TIN CHECK IN CUA THANH VIEN =================
    //             $data = array(
    //                 'guests_id' => $val['ID'],
    //                 'barcode' => $memberID,
    //                 'date' => $item[8],
    //                 'time' => $item[9],
    //             );

    //             $wpdb->insert($table_check_in, $data);

    //             // INSERT DATA THEO KIEU SQL
    //             //           $sql = "INSERT INTO $table (barcode,full_name,country,position,email,phone,check_in,img,note,create_date,status) "
    //             //                    . "VALUES ('$item[0]','$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','$item[8]','$item[9]','$item[10]')";
    //             //           $wpdb->query($sql);
    //         }
    //     }
    // }
}
