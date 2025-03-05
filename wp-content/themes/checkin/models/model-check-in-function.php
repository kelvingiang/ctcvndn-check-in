<?php
class Model_Check_In_Function
{
    private $_table = null;
    private $_table_detail = null;
    private $_table_event = null;

    public function __construct($args = array())
    {
        global $wpdb;
        $this->_table =  $wpdb->prefix . 'check_in_member';
        $this->_table_detail = $wpdb->prefix . 'check_in_detail';
        $this->_table_event = $wpdb->prefix . 'check_in_event';
    }

    public function get_item($arrData = array(), $option = array())
    {
        global $wpdb;
        $id = absint($arrData['id']);
        $sql = "SELECT * FROM $this->_table WHERE ID = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);
        return $row;
    }

    public function trashItem($arrData = array(), $option = array())
    {
        global $wpdb;
        // KIEM TRA PHAN  CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('trash' => 1);
            $where = array('ID' => absint($arrData['id']));
            $wpdb->update($this->_table, $data, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table SET `trash` =  '1'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function restoreItem($arrData = array(), $option = array())
    {
        global $wpdb;
        // KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('trash' => 0);
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($this->_table, $data, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "UPDATE $this->_table SET `trash` =  '0'   WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    //---------------------------------------------------------------------------------------------
    // chuyen ID co 2 phan id-barcode, khi nhan value se tach 2 phan id va barcode de su dung 
    // phan chinh sua data trong table guests_check_in phai sua dung barcode ko the dung guests_id 
    // vi guests_id duoc luu vao tu 2 table member va guests cho nen co kha nang trung ID 
    // vi vay dung barcode lam chuan khi thao tac voi table guests_check_in
    //---------------------------------------------------------------------------------------------
    public function un_checkin($arrData = array(), $option = array())
    {
        global $wpdb;
        // if (!is_array($arrData['id'])) {
        //     $data = array('status' => '0');
        //     $where = array('ID' => absint($arrData['id']));
        //     $wpdb->update($this->_table, $data, $where);
        //     // XOA GUESTS CHECK IN
        $where2 = array('member_id' => absint($arrData['id']), 'event_id' => $arrData['event_id']);
        $wpdb->delete($this->_table_detail, $where2);
        // } else {
        // neu dung absin no se tu dong lay gia tri la so den ky tu thi thoi lay
        //            $arrData['id'] = array_map('absint', $arrData['id']);
        // neu dung null array_map se lay het tat ca so va chu
        //$arrData['id'] = array_map(NULL, $arrData['id']);
        // $barCodeList = '';

        // foreach ($arrData['id'] as $val) {
        //     $ss = explode("-", $val);
        //     $barCodeList .= ',' . $ss['0'];
        // }
        // $ids = substr($barCodeList, 1);
        // $sql = "UPDATE $this->_table SET `status` = '0'  WHERE ID IN ($ids)";
        // $wpdb->query($sql);
        // XOA GUESTS CHECK IN
        // $sql2 = "DELETE FROM $this->_table_detail WHERE member_ID IN ($ids)";
        // $wpdb->query($sql2);
        //}
    }

    public function checkin($arrData = array(), $option = array())
    {
        global $wpdb;
        // $sql = "SELECT * FROM $this->_table_event WHERE status = '1' AND trash = '0'";
        // $event = $wpdb->get_row($sql, ARRAY_A);
        // echo '<pre>';
        // print_r($arrData);
        // echo '</pre>';
        // die();
        // CHECK IN
        // if ($arrData['event_id'] == 0) {
        // $data = array('status' => $event['ID']);
        // $where = array('ID' => $arrData['id']);
        // $wpdb->update($this->_table, $data, $where);

        $data2 = array(
            'member_id' => $arrData['id'],
            'event_id' => $arrData['event_id'],
            'date' => date('m-d-Y'),
            'time' => date('H:i:s'),
        );
        $wpdb->insert($this->_table_detail, $data2);
        // }
    }

    public function deleteItem($arrData = array(), $option = array())
    {
        global $wpdb;

        // $table = $wpdb->prefix . 'guests';
        $this->deleteImg($arrData['id']);
        if (!is_array($arrData['id'])) {
            $where = array('ID' => absint($arrData['id']));
            $wpdb->delete($this->_table, $where);
        } else {
            // $arrData['id] chuyen qua ID-barcode  vidu : 1111-22222222
            // do su dung array_map('absint) no chi lay so cho nen khi lay de dau '-' khong tiep tuc lay
            // vay la no chi lay phan dau la ID dung voi gi muon
            // khong can tach chuoi
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            $sql = "DELETE FROM $this->_table WHERE ID IN ($ids)";
            $wpdb->query($sql);
        }
    }

    private function deleteImg($arrID)
    {
        global $wpdb;
        // $table = $wpdb->prefix . 'guests';
        if (!is_array($arrID)) {
            $sql = "SELECT * FROM $this->_table WHERE ID =" . $arrID;
            $row = $wpdb->get_row($sql, ARRAY_A);
            //            XOA HINH TRONG FOLDER
            unlink(DIR_IMAGES_GUESTS  . $row['img']);
            unlink(DIR_IMAGES_QRCODE . $row['barcode'] . '.png');
        } else {
            foreach ($arrID as $key) {
                $sql = "SELECT * FROM $this->_table WHERE ID =" . $key;
                $row = $wpdb->get_row($sql, ARRAY_A);
                // XOA HINH CUA GUESTS
                unlink(DIR_IMAGES_GUESTS . $row['img']);
                unlink(DIR_IMAGES_QRCODE . $row['barcode'] . '.png');
            }
        }
    }

    public function saveItem($arrData = array(), $option = array())
    {
        global $wpdb;

        $data = array(
            'member_code' => $arrData['txt_member_code'],
            'contact' => $arrData['txt_contact'],
            'position' => $arrData['txt_position'],
            'company_cn' => $arrData['txt_company_cn'],
            'company_vn' => $arrData['txt_company_vn'],
            'address' => $arrData['txt_address'],
            'email' => $arrData['txt_email'],
            'phone' => $arrData['txt_phone'],
            'career' => $arrData['txt_career'],
        );

        if ($option == 'edit') {
            // thêm phần tử vào array 
            $data['update_date'] = date('Y-m-d');

            $where = array('ID' => absint($arrData['hidden_ID']));
            $wpdb->update($this->_table,  $data, $where);

            if ($arrData['hidden_member_code'] != $arrData['txt_member_code']) {


                $code = create_qrcode();
                $qrCode = $arrData['txt_member_code'] . $code;

                require_once(DIR_CLASS . 'qrcode' . DS . 'qrlib.php');
                $filePath = DIR_IMAGES_QRCODE . $qrCode . '.png';
                $errorCorrectionLevel = "L";
                $matrixPointSize = 3;
                QRcode::png($code, $filePath, $errorCorrectionLevel, $matrixPointSize, 2);

                unlink(DIR_IMAGES_QRCODE . $arrData['hidden_qr_code'] . '.png');


                $where = array('ID' => absint($arrData['hidden_ID']));
                $wpdb->update($this->_table, array('qr_code' => $qrCode), $where);
            }
        } else if ($option == 'add') {
            // tạo mã QRcode mã ngẫu nhiên
            $code = create_qrcode();
            $qrCode = $arrData['txt_member_code'] ."-". $code;
            // thêm phần tử vào array 
            $data['qr_code'] = $qrCode;
            $data['create_date'] = date('Y-m-d');

            $wpdb->insert($this->_table, $data);
            // tao QRCode ============
            require_once(DIR_CLASS . 'qrcode' . DS . 'qrlib.php');
            $filePath = DIR_IMAGES_QRCODE . $qrCode . '.png';
            $errorCorrectionLevel = "L";
            $matrixPointSize = 3;
            QRcode::png($code, $filePath, $errorCorrectionLevel, $matrixPointSize, 2);

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
            $box = imagettfbbox($fontSize, 0, $fontPath, $arrData['txt_member_code']);
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
            imagettftext($finalImage, $fontSize, 0, $textX, $textY, $black, $fontPath, $arrData['txt_member_code']);

            // **儲存最終圖片**
            imagepng($finalImage, $filePath);

            // **釋放記憶體**
            imagedestroy($qrImage);
            imagedestroy($finalImage);
            // end *********************************************************/


        }
    }


    //TAO QRCODE
    public function createQRcode($code, $name)
    {


        // $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        require_once(DIR_CLASS . 'qrcode' . DS . 'qrlib.php');
        //   if (!file_exists($PNG_TEMP_DIR))
        //   mkdir($PNG_TEMP_DIR);
        $t = time();
        $cc = substr($t, -8);
        $filename = $code . $cc;
        //     $pattern = " ";
        //     $replacement = "-";
        //    $name = str_replace($pattern, $replacement, $subject);


        $filepath = DIR_IMAGES_QRCODE  . $filename . '.png';
        // L M Q H
        $errorCorrectionLevel = "L";
        // size 1 - 10
        $matrixPointSize = 3;
        QRcode::png($filename, $filepath, $errorCorrectionLevel, $matrixPointSize, 2);

        // DOI TEN FILE THEO KIEU CHU HOA
        // $newName =  iconv('UTF-8','BIG5', DIR_IMAGES_QRCODE .$name.'-'.$filename .'.png');
        // $oldName  =  iconv('UTF-8','BIG5', $filepath);
        // rename($oldName , $newName);     

        return $filename;
    }
}
