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
    }

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

    public function BarcodeInfo()
    {
        global $wpdb;
        $sql = "SELECT * FROM $this->_table WHERE  status = 1";
        $row = $wpdb->get_results($sql, ARRAY_A);
        return $row;
    }

    /// =============================================


    public function ExportMember()
    {
        $data = $this->_report_model->getAllMember();
        export_excel_guests($data);
    }

    public function ExCheckInToExcel()
    {
        $data = $this->_report_model->ReportJoinView();
        export_excel_check_in($data);
    }

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
        foreach ($row as $item) {
            create_QRCode_Img($item['qr_code'], $item['member_code']);
        }
    }


    //=================================================================================
    // thêm mới danh sách thành viên xóa hết các dữ liệu thành viên cũ 
    public function ImportGuests($filename)
    {
        $data = import_excel_guests($filename);
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE $this->_table");

        // bat doc du lieu tu dong thu 2
        foreach (array_slice($data, 1) as $item) {
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

    // thêm bổ xung thành viên không xóa thành viên cũ
    public function ImportGuestsUpdateInfo($filename)
    {
        $data = import_excel_guests($filename);
        global $wpdb;
        // bat doc du lieu tu dong thu 2
        foreach (array_slice($data, 1) as $item) {
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
}
